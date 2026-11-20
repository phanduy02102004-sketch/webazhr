<?php

namespace App\Http\Controllers\AZMedia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\TestQuestion;
use App\Models\CandidateTest;
use App\Models\EmailTemplate;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Log;
use PDF;

class CandidatePortalController extends Controller
{
    /**
     * Trang tra cứu tiến độ ứng tuyển dành cho ứng viên
     */
    public function trackPage(Request $request)
    {
        $application = null;
        $searchKey = $request->query('code') ?? $request->query('email');

        if ($searchKey) {
            $application = Application::with(['candidate', 'position', 'testResult', 'evaluations', 'emailLogs'])
                ->where('application_code', trim($searchKey))
                ->orWhereHas('candidate', function ($q) use ($searchKey) {
                    $q->where('email', trim($searchKey));
                })
                ->latest()
                ->first();
        }

        return view('azmedia.candidate.track', compact('application', 'searchKey'));
    }

    /**
     * Xử lý tìm kiếm hồ sơ qua Form Tra cứu
     */
    public function trackSubmit(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
        ], [
            'keyword.required' => 'Vui lòng nhập Mã hồ sơ (VD: AZ-2026-0732) hoặc Địa chỉ Email của bạn.',
        ]);

        $keyword = trim($request->keyword);

        $application = Application::with(['candidate', 'position', 'testResult', 'evaluations', 'emailLogs'])
            ->where('application_code', $keyword)
            ->orWhereHas('candidate', function ($q) use ($keyword) {
                $q->where('email', $keyword);
            })
            ->latest()
            ->first();

        if (!$application) {
            return redirect()->route('azmedia.candidate.track')
                ->with('error', "Không tìm thấy hồ sơ ứng tuyển nào khớp với thông tin '{$keyword}'. Vui lòng kiểm tra lại Mã hồ sơ hoặc Email.");
        }

        return redirect()->route('azmedia.candidate.track', ['code' => $application->application_code]);
    }

    /**
     * Mở giao diện làm bài Test Online trắc nghiệm kỹ thuật
     */
    public function takeTest($code)
    {
        $application = Application::with(['candidate', 'position', 'testResult'])
            ->where('application_code', $code)
            ->firstOrFail();

        // Kiểm tra xem ứng viên đã làm bài test chưa
        if ($application->testResult && $application->testResult->completed_at) {
            return view('azmedia.candidate.test_completed', compact('application'));
        }

        // Lấy danh sách câu hỏi cơ bản về AZ Media (loại bỏ hoàn toàn câu hỏi chuyên môn)
        $allQuestions = TestQuestion::where('position_category', 'azmedia')
            ->orderBy('id', 'asc')
            ->get();

        if ($allQuestions->isEmpty()) {
            $allQuestions = TestQuestion::whereIn('id', [9, 10, 11])->get();
        }

        return view('azmedia.candidate.take_test', compact('application', 'allQuestions'));
    }

    /**
     * Nộp bài Test Online & Tự động chấm điểm (Tích hợp NLP, Bánh xe cuộc đời & Khảo sát động cơ)
     */
    public function submitTest(Request $request, $code)
    {
        $application = Application::with(['candidate', 'position', 'testResult'])
            ->where('application_code', $code)
            ->firstOrFail();

        // 1. Xử lý Trắc nghiệm Chuyên môn & Văn hóa
        $answers = $request->input('answers', []);
        $timeSpent = (int) $request->input('time_spent', 600); // số giây

        $totalQuestions = 0;
        $correctCount = 0;
        $quizDetails = [];

        foreach ($answers as $qId => $selectedOption) {
            $totalQuestions++;
            $q = TestQuestion::find($qId);
            $isCorrect = false;

            if ($q && strtoupper(trim($selectedOption)) === strtoupper(trim($q->correct_option))) {
                $correctCount++;
                $isCorrect = true;
            }

            $quizDetails[] = [
                'question_id' => $qId,
                'question_text' => $q ? $q->question : '',
                'selected_option' => $selectedOption,
                'correct_option' => $q ? $q->correct_option : '',
                'is_correct' => $isCorrect,
            ];
        }

        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 2) : 100;
        $passed = ($score >= 60);

        // 2. Xử lý Bài test nhận diện tính cách NLP (V-A-K-Ad) - File 2
        $nlpInput = $request->input('nlp', []);
        // Ánh xạ đáp án V-A-K-Ad theo mẫu chuẩn AZ Media
        // Câu 1: K, A, V, Ad
        // Câu 2: A, V, Ad, K
        // Câu 3: V, K, Ad, A
        // Câu 4: A, Ad, K, V
        // Câu 5: A, Ad, K, V
        $vTotal  = (int)($nlpInput[1]['V'] ?? 0) + (int)($nlpInput[2]['V'] ?? 0) + (int)($nlpInput[3]['V'] ?? 0) + (int)($nlpInput[4]['V'] ?? 0) + (int)($nlpInput[5]['V'] ?? 0);
        $aTotal  = (int)($nlpInput[1]['A'] ?? 0) + (int)($nlpInput[2]['A'] ?? 0) + (int)($nlpInput[3]['A'] ?? 0) + (int)($nlpInput[4]['A'] ?? 0) + (int)($nlpInput[5]['A'] ?? 0);
        $kTotal  = (int)($nlpInput[1]['K'] ?? 0) + (int)($nlpInput[2]['K'] ?? 0) + (int)($nlpInput[3]['K'] ?? 0) + (int)($nlpInput[4]['K'] ?? 0) + (int)($nlpInput[5]['K'] ?? 0);
        $adTotal = (int)($nlpInput[1]['Ad'] ?? 0) + (int)($nlpInput[2]['Ad'] ?? 0) + (int)($nlpInput[3]['Ad'] ?? 0) + (int)($nlpInput[4]['Ad'] ?? 0) + (int)($nlpInput[5]['Ad'] ?? 0);

        $nlpScores = [
            'V'  => $vTotal,
            'A'  => $aTotal,
            'K'  => $kTotal,
            'Ad' => $adTotal,
        ];

        // Xác định tuýp nổi bật nhất
        arsort($nlpScores);
        $dominantKey = array_key_first($nlpScores);

        $nlpProfiles = [
            'V' => [
                'type' => 'Visual (Nhìn / Thị giác)',
                'summary' => 'Bạn tiếp nhận thông tin tốt nhất qua hình ảnh, sơ đồ và màu sắc. Thích phong cách làm việc trực quan, ngăn nắp và nhạy bén với giao diện người dùng.',
                'color' => '#f97316'
            ],
            'A' => [
                'type' => 'Auditory (Nghe / Thính giác)',
                'summary' => 'Bạn có khả năng lắng nghe và giao tiếp xuất sắc. Tiếp thu nhanh qua thảo luận, giải thích lời nói và nhạy cảm với âm điệu, giọng nói.',
                'color' => '#3b82f6'
            ],
            'K' => [
                'type' => 'Kinesthetic (Cảm xúc / Trải nghiệm)',
                'summary' => 'Bạn học hỏi và làm việc hiệu quả nhất qua hành động và trải nghiệm thực tế. Giàu cảm xúc, chân thành và coi trọng sự kết nối giữa các thành viên.',
                'color' => '#10b981'
            ],
            'Ad' => [
                'type' => 'Auditory Digital (Nội tâm / Tư duy Logic)',
                'summary' => 'Bạn có tư duy phân tích hệ thống sắc sảo, cẩn trọng và luôn dựa trên số liệu, dẫn chứng logic. Phù hợp xuất sắc với vị trí kỹ thuật, giải thuật và dữ liệu.',
                'color' => '#8b5cf6'
            ],
        ];

        $nlpResult = [
            'scores' => [
                'Visual' => $vTotal,
                'Auditory' => $aTotal,
                'Kinesthetic' => $kTotal,
                'Auditory_Digital' => $adTotal,
            ],
            'dominant_code' => $dominantKey,
            'dominant_title' => $nlpProfiles[$dominantKey]['type'] ?? 'Toàn diện',
            'dominant_summary' => $nlpProfiles[$dominantKey]['summary'] ?? '',
            'dominant_color' => $nlpProfiles[$dominantKey]['color'] ?? '#ea580c',
            'raw_input' => $nlpInput,
        ];

        // 2.1 Xử lý DISC, MBTI & Nhân số học (bổ sung từ Báo cáo thu hoạch NLB - DISC - MBTI)
        $discChoice = $request->input('disc_choice', 'C');
        $discDescriptions = [
            'D' => ['title' => 'Nhóm D – Quyết đoán (Dominance)', 'summary' => 'Hành động quyết liệt, tập trung vào kết quả nhanh nhất, tự tin và sẵn sàng chấp nhận thử thách.'],
            'I' => ['title' => 'Nhóm I – Hòa đồng (Influence)', 'summary' => 'Nhiệt huyết, truyền cảm hứng, cởi mở trong giao tiếp và tạo không khí tích cực cho tập thể.'],
            'S' => ['title' => 'Nhóm S – Điềm tĩnh (Steadiness)', 'summary' => 'Kiên định, chân thành, biết lắng nghe và luôn là điểm tựa đáng tin cậy của đồng đội.'],
            'C' => ['title' => 'Nhóm C – Cẩn trọng (Conscientiousness)', 'summary' => 'Chú ý đến chi tiết, yêu cầu sự chính xác cao, chu đáo và luôn muốn hiểu rõ bản chất vấn đề trước khi thực hiện.'],
        ];

        $discProfile = [
            'group' => $discChoice,
            'title' => $discDescriptions[$discChoice]['title'] ?? 'Nhóm C – Cẩn trọng',
            'summary' => $discDescriptions[$discChoice]['summary'] ?? '',
            'answers' => $request->input('disc', []),
        ];

        $mbtiEnergy = $request->input('mbti_energy', 'I');
        $mbtiDecision = $request->input('mbti_decision', 'F');
        $mbtiCode = $mbtiEnergy . $mbtiDecision;
        $mbtiProfile = [
            'code' => $mbtiCode,
            'energy' => $mbtiEnergy === 'I' ? 'I - Hướng nội (Introversion)' : 'E - Hướng ngoại (Extraversion)',
            'decision' => $mbtiDecision === 'F' ? 'F - Cảm xúc (Feeling)' : 'T - Lý trí (Thinking)',
            'title' => ($mbtiEnergy === 'I' ? 'I (Hướng nội)' : 'E (Hướng ngoại)') . ' & ' . ($mbtiDecision === 'F' ? 'F (Cảm xúc)' : 'T (Lý trí)'),
            'summary' => 'Coi trọng sự hài hòa, thực tế kết hợp sáng tạo; bản tính trầm tính, khả năng quan sát thầm lặng và nhìn nhận vấn đề sâu sắc hơn.',
            'answers' => $request->input('mbti', []),
        ];

        $dob = $request->input('numerology_dob', $application->candidate->birth_date ?? '2004-10-02');
        $digits = preg_replace('/[^0-9]/', '', (string)$dob);
        $lifePathSum = !empty($digits) ? array_sum(str_split($digits)) : 9;
        while ($lifePathSum > 9 && !in_array($lifePathSum, [11, 22, 33])) {
            $lifePathSum = array_sum(str_split((string)$lifePathSum));
        }

        $numerologyDescriptions = [
            9 => 'Đường đời số 9: Gắn với lòng trắc ẩn, tính bao dung, trực giác tốt, tinh thần trách nhiệm cao và mong muốn mang lại những giá trị tích cực cho cộng đồng.',
            1 => 'Đường đời số 1: Tinh thần tiên phong, độc lập và khả năng dẫn dắt xuất sắc.',
            2 => 'Đường đời số 2: Khả năng ngoại giao, hòa giải và gắn kết đồng đội tuyệt vời.',
            3 => 'Đường đời số 3: Tư duy sáng tạo, hoạt ngôn và lan tỏa năng lượng tích cực.',
            4 => 'Đường đời số 4: Tính kỷ luật, thực tế, vững chắc và có quy chuẩn rõ ràng.',
            5 => 'Đường đời số 5: Thích nghi nhanh, linh hoạt và đam mê khám phá điều mới.',
            6 => 'Đường đời số 6: Tinh thần phụng sự, yêu thương, quan tâm chăm sóc gia đình và tập thể.',
            7 => 'Đường đời số 7: Tư duy phân tích sâu sắc, tìm tòi chân lý và học hỏi không ngừng.',
            8 => 'Đường đời số 8: Bản lĩnh quản trị, tư duy tài chính và điều hành hiệu quả.',
        ];

        $numerologyProfile = [
            'dob' => $dob,
            'life_path_number' => $lifePathSum,
            'title' => "Con số đường đời {$lifePathSum}",
            'summary' => $numerologyDescriptions[$lifePathSum] ?? $numerologyDescriptions[9],
        ];

        $personalityResult = [
            'nlb' => $nlpResult,
            'disc' => $discProfile,
            'mbti' => $mbtiProfile,
            'numerology' => $numerologyProfile,
        ];

        // 3. Xử lý Bánh xe cuộc đời (Wheel of Life) - File 3
        $wheelInput = $request->input('wheel', []);
        $wheelLabels = [
            'finance'         => 'Tài chính (Finance)',
            'personal_growth' => 'Phát triển bản thân (Personal Growth)',
            'health'          => 'Sức khỏe (Health)',
            'family'          => 'Gia đình (Family)',
            'relationships'   => 'Các mối quan hệ (Relationships)',
            'social_life'     => 'Đời sống xã hội (Social Life)',
            'spirituality'    => 'Đời sống tinh thần (Spirituality)',
            'career'          => 'Sự nghiệp (Career)',
        ];

        $wheelScores = [];
        foreach ($wheelLabels as $k => $label) {
            $wheelScores[$k] = [
                'label' => $label,
                'score' => (int)($wheelInput[$k] ?? 5),
            ];
        }

        $wheelResult = [
            'dimensions' => $wheelScores,
            'lesson' => (string) $request->input('wheel_lesson', ''),
        ];

        // 4. Xử lý Phiếu khảo sát Hoài bão, Động cơ & Tự đánh giá - File 1
        $surveyResult = [
            'goal_short' => (string) $request->input('goal_short', ''),
            'goal_long'  => (string) $request->input('goal_long', ''),
            'biggest_success' => (string) $request->input('biggest_success', ''),
            'why_apply' => (string) $request->input('why_apply', ''),
            'work_organization' => (string) $request->input('work_organization', ''),
            'failure_lesson' => (string) $request->input('failure_lesson', ''),
            'why_choose_you' => (string) $request->input('why_choose_you', ''),
        ];

        // 5. Xử lý Khảo sát tìm hiểu về AZ Media & Tự trả lời
        $azChannels = $request->input('az_channels', []);
        $azChannelOther = (string) $request->input('az_channel_other', '');
        $azImpression = (string) $request->input('az_impression', '');

        $azSurveyResult = [
            'channels' => $azChannels,
            'channel_other' => $azChannelOther,
            'impression' => $azImpression,
        ];

        // Đóng gói toàn bộ cấu trúc bài test
        $fullAnswersData = [
            'quiz' => [
                'total' => $totalQuestions,
                'correct' => $correctCount,
                'details' => $quizDetails,
            ],
            'nlp' => $nlpResult,
            'personality' => $personalityResult,
            'wheel_of_life' => $wheelResult,
            'survey' => $surveyResult,
            'az_survey' => $azSurveyResult,
        ];

        // Lưu kết quả bài test vào CSDL
        $candidateTest = CandidateTest::updateOrCreate(
            ['application_id' => $application->id],
            [
                'total_questions' => $totalQuestions > 0 ? $totalQuestions : 10,
                'correct_answers' => $correctCount,
                'score' => $score,
                'time_spent_seconds' => $timeSpent,
                'passed' => $passed,
                'answers_data' => $fullAnswersData,
                'completed_at' => now(),
            ]
        );

        // Cập nhật trạng thái hồ sơ ứng viên
        $application->status = 'tested';
        $application->stage_step = 3;
        $application->save();

        // Tự động chuyển toàn bộ câu trả lời Phần 1, 2, 3, 4 thành file PDF lưu trữ cho Admin & TTS
        try {
            $dir = public_path('uploads/test_results');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $pdfFilename = "Bai_Test_AZ_{$application->application_code}.pdf";
            $pdfPath = "{$dir}/{$pdfFilename}";

            // Tải lại quan hệ để view PDF nhận đầy đủ dữ liệu
            $application->load(['candidate', 'position', 'testResult']);

            $pdf = PDF::loadView('azmedia.pdf.test_result_pdf', compact('application'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'tempDir' => public_path(),
                    'chroot'  => public_path(),
                    'isRemoteEnabled' => true,
                ]);
            $pdf->save($pdfPath);

            $fullAnswersData['pdf_file'] = "uploads/test_results/{$pdfFilename}";
            $candidateTest->answers_data = $fullAnswersData;
            $candidateTest->save();
        } catch (\Exception $e) {
            Log::error("[Candidate Test PDF] Lỗi tạo file PDF bài test {$application->application_code}: " . $e->getMessage());
        }

        return redirect()->route('azmedia.candidate.test', ['code' => $application->application_code])
            ->with('success', "Chúc mừng bạn đã hoàn thành trọn vẹn Bài Đánh Giá Toàn Diện AZHR! Toàn bộ câu trả lời Phần 1, 2, 3, 4 đã được hệ thống xuất thành file PDF lưu trữ thành công.");
    }

    /**
     * Tải xuống hoặc xem file PDF kết quả bài test Phần 1, 2, 3, 4 (Dành cho Ứng viên)
     */
    public function downloadTestPDF($code, Request $request)
    {
        $application = Application::with(['candidate', 'position', 'testResult'])
            ->where('application_code', $code)
            ->firstOrFail();

        if (!$application->testResult || !$application->testResult->completed_at) {
            return back()->with('error', 'Ứng viên chưa hoàn thành bài test.');
        }

        $filename = "Bai_Test_AZ_{$application->application_code}.pdf";
        $filePath = public_path("uploads/test_results/{$filename}");

        // Nếu file chưa tồn tại trên đĩa, tự động tạo mới ngay lập tức
        if (!file_exists($filePath)) {
            $dir = public_path('uploads/test_results');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $pdf = PDF::loadView('azmedia.pdf.test_result_pdf', compact('application'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'tempDir' => public_path(),
                    'chroot'  => public_path(),
                    'isRemoteEnabled' => true,
                ]);
            $pdf->save($filePath);
        }

        $isDownload = $request->has('download');
        if ($isDownload) {
            return response()->download($filePath, "Ket_Qua_Danh_Gia_AZHR_{$application->application_code}.pdf", [
                'Content-Type' => 'application/pdf',
            ]);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
