<?php

namespace App\Http\Controllers\AZMedia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\InternshipPosition;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\Evaluation;
use App\Models\CandidateTest;
use App\Models\TestQuestion;
use App\Models\EmailTemplate;
use App\Models\EmailLog;
use App\Models\Role;
use App\Mail\AZMediaEmail;
use PDF;

class AZMediaATSController extends Controller
{
    /**
     * Trang đăng nhập Portal nội bộ
     */
    public function loginPage()
    {
        return view('azmedia.portal.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ Email / Gmail.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $account = Admin::where('email', $request->email)->first();

        if (!$account) {
            $userObj = \App\Models\User::where('email', $request->email)->first();
            if ($userObj && Hash::check($request->password, $userObj->password)) {
                $account = Admin::updateOrCreate(
                    ['email' => $userObj->email],
                    [
                        'name' => $userObj->name,
                        'password' => $userObj->password,
                        'role' => 'admin',
                        'status' => 'active',
                    ]
                );
            }
        }

        if ($account && Hash::check($request->password, $account->password)) {
            Session::put('portal_user', [
                'id' => $account->id,
                'name' => $account->name,
                'email' => $account->email,
                'role' => $account->role ?? 'admin',
            ]);
            return redirect()->route('azmedia.portal.dashboard')->with('success', "Chào mừng {$account->name} đăng nhập thành công!");
        }

        return back()->withInput($request->only('email'))->with('error', 'Email hoặc mật khẩu không chính xác.');
    }



    /**
     * Tải xuống báo cáo công việc tuần theo mẫu chuẩn
     */
    public function downloadWeeklyReport(Request $request)
    {
        $week = (int) $request->get('week', 5);
        $filename = ($week === 4) ? "Bao_Cao_Tuan_AZHR_Tuan4.docx" : "Bao_Cao_Tuan_AZHR_Tuan5.docx";
        $downloadName = ($week === 4) ? "Bao_Cao_Cong_Viec_Tuan_4_AZHR.docx" : "Bao_Cao_Cong_Viec_Tuan_5_AZHR.docx";
        $filePath = public_path("downloads/{$filename}");

        if (!file_exists($filePath)) {
            $scriptName = ($week === 4) ? 'generate_report.py' : 'generate_report_tuan5.py';
            $scriptPath = base_path($scriptName);
            exec("python " . escapeshellarg($scriptPath));
        }

        if (!file_exists($filePath)) {
            return back()->with('error', 'Không tìm thấy file báo cáo. Vui lòng thử lại.');
        }

        return response()->download($filePath, $downloadName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        Session::forget('portal_user');
        return redirect()->route('azmedia.login')->with('success', 'Bạn đã đăng xuất an toàn.');
    }

    /**
     * Helper kiểm tra phân quyền & lấy user hiện tại
     */
    private function getCurrentUser()
    {
        $user = Session::get('portal_user');
        if (!$user) {
            // Mặc định login tự động vai trò admin nếu chưa đăng nhập để trải nghiệm thuận tiện
            $admin = Admin::where('email', 'admin@azmedia.com.vn')->first() ?? Admin::first();
            $user = [
                'id' => $admin ? $admin->id : 1,
                'name' => $admin ? $admin->name : 'Lê Đình Quang (TGĐ)',
                'email' => $admin ? $admin->email : 'admin@azmedia.com.vn',
                'role' => 'admin',
            ];
            Session::put('portal_user', $user);
        }
        return $user;
    }

    /**
     * 1. Dashboard & Thống kê Phân tích Tuyển dụng
     */
    public function dashboard()
    {
        $user = $this->getCurrentUser();

        // Thống kê tổng số
        $totalPositions = InternshipPosition::count();
        $totalApplications = Application::count();
        $totalInterviews = Application::where('status', 'interviewing')->count();
        $totalOffers = Application::where('status', 'offered')->count();
        $totalTested = Application::where('status', 'tested')->count();

        // Thống kê Funnel Pipeline
        $pipelineStages = [
            'applied' => ['label' => 'Nộp đơn', 'count' => Application::where('status', 'applied')->count(), 'color' => '#3b82f6'],
            'screening' => ['label' => 'Duyệt CV', 'count' => Application::where('status', 'screening')->count(), 'color' => '#f59e0b'],
            'test_sent' => ['label' => 'Đã gửi Test', 'count' => Application::where('status', 'test_sent')->count(), 'color' => '#6366f1'],
            'tested' => ['label' => 'Đã làm Test', 'count' => Application::where('status', 'tested')->count(), 'color' => '#8b5cf6'],
            'interviewing' => ['label' => 'Phỏng vấn', 'count' => Application::where('status', 'interviewing')->count(), 'color' => '#ea580c'],
            'offered' => ['label' => 'Nhận TTS', 'count' => Application::where('status', 'offered')->count(), 'color' => '#10b981'],
            'rejected' => ['label' => 'Từ chối', 'count' => Application::where('status', 'rejected')->count(), 'color' => '#f43f5e'],
        ];

        // Thống kê số lượng CV theo vị trí
        $positionsData = InternshipPosition::withCount('applications')->get();

        // Thống kê nguồn ứng viên theo trường ĐH/CĐ
        $universitiesData = Candidate::select('university', \DB::raw('count(*) as count'))
            ->groupBy('university')
            ->orderBy('count', 'desc')
            ->get();

        // Ứng viên mới nộp gần đây
        $recentApplications = Application::with(['candidate', 'position', 'testResult'])
            ->latest()
            ->limit(10)
            ->get();

        return view('azmedia.portal.dashboard', compact(
            'user', 'totalPositions', 'totalApplications', 'totalInterviews',
            'totalOffers', 'totalTested', 'pipelineStages', 'positionsData',
            'universitiesData', 'recentApplications'
        ));
    }

    /**
     * 2. Quản lý Pipeline dạng Bảng Kanban
     */
    public function kanban()
    {
        $user = $this->getCurrentUser();

        $columns = [
            'applied' => [
                'title' => 'Nộp đơn (Applied)',
                'badge' => 'bg-blue-100 text-blue-800 border-blue-300',
                'items' => Application::with(['candidate', 'position', 'testResult'])->where('status', 'applied')->latest()->get(),
            ],
            'screening' => [
                'title' => 'Duyệt CV (Screening)',
                'badge' => 'bg-amber-100 text-amber-800 border-amber-300',
                'items' => Application::with(['candidate', 'position', 'testResult'])->where('status', 'screening')->latest()->get(),
            ],
            'test_sent' => [
                'title' => 'Bài Test (Testing)',
                'badge' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                'items' => Application::with(['candidate', 'position', 'testResult'])->whereIn('status', ['test_sent', 'tested'])->latest()->get(),
            ],
            'interviewing' => [
                'title' => 'Phỏng vấn (Interviewing)',
                'badge' => 'bg-orange-100 text-orange-800 border-orange-300',
                'items' => Application::with(['candidate', 'position', 'evaluations'])->where('status', 'interviewing')->latest()->get(),
            ],
            'offered' => [
                'title' => 'Nhận thực tập (Offered)',
                'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'items' => Application::with(['candidate', 'position', 'evaluations'])->where('status', 'offered')->latest()->get(),
            ],
            'rejected' => [
                'title' => 'Từ chối (Rejected)',
                'badge' => 'bg-rose-100 text-rose-800 border-rose-300',
                'items' => Application::with(['candidate', 'position'])->where('status', 'rejected')->latest()->get(),
            ],
        ];

        return view('azmedia.portal.kanban', compact('user', 'columns'));
    }

    /**
     * 3. Danh sách hồ sơ ứng viên dạng Bảng (Table View) & Bộ lọc nâng cao
     */
    public function applications(Request $request)
    {
        $user = $this->getCurrentUser();
        $query = Application::with(['candidate', 'position', 'testResult', 'evaluations']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('position_id') && $request->position_id !== 'all') {
            $query->where('position_id', $request->position_id);
        }

        if ($request->filled('university') && $request->university !== 'all') {
            $query->whereHas('candidate', function ($q) use ($request) {
                $q->where('university', 'like', '%' . $request->university . '%');
            });
        }

        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('application_code', 'like', "%{$keyword}%")
                  ->orWhereHas('candidate', function ($cq) use ($keyword) {
                      $cq->where('name', 'like', "%{$keyword}%")
                         ->orWhere('email', 'like', "%{$keyword}%")
                         ->orWhere('phone', 'like', "%{$keyword}%");
                  });
            });
        }

        // Mentor role RBAC: chỉ xem ứng viên thuộc chuyên môn nếu cần
        if ($user['role'] === 'mentor') {
            // Mentor có thể lọc xem các đơn CNTT / Kỹ thuật
        }

        $applications = $query->latest()->paginate(15);
        $positions = InternshipPosition::all();
        $universities = Candidate::select('university')->distinct()->pluck('university');

        return view('azmedia.portal.applications', compact('user', 'applications', 'positions', 'universities'));
    }

    /**
     * 4. Chi tiết ứng viên (Candidate Profile & Scorecard & PDF Preview)
     */
    public function candidateDetail($id)
    {
        $user = $this->getCurrentUser();
        $application = Application::with(['candidate', 'position', 'testResult', 'evaluations', 'emailLogs', 'assignedMentor'])
            ->findOrFail($id);

        $mentors = Admin::where('role', 'mentor')->orWhere('role', 'admin')->get();
        $templates = EmailTemplate::all();

        return view('azmedia.portal.candidate_detail', compact('user', 'application', 'mentors', 'templates'));
    }

    /**
     * Xem trực tiếp file PDF CV (Embedded PDF Viewer)
     */
    public function viewCV($id)
    {
        $application = Application::findOrFail($id);
        $path = public_path($application->cv_path);

        if (!file_exists($path)) {
            // Thử tìm trong uploads/cvs
            $fallback = public_path('uploads/cvs/CV_Nguyen_Nhat_Linh_An_24CNTT1A.pdf');
            if (file_exists($fallback)) {
                return response()->file($fallback, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $application->cv_filename . '"'
                ]);
            }
            abort(404, 'Không tìm thấy file CV trên máy chủ.');
        }

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $application->cv_filename . '"'
        ]);
    }

    /**
     * Xem trực tiếp hoặc tải file PDF kết quả bài test Phần 1, 2, 3, 4 (Dành cho Admin / HR / Mentor)
     */
    public function viewTestPDF($id, Request $request)
    {
        $application = Application::with(['candidate', 'position', 'testResult'])->findOrFail($id);

        if (!$application->testResult || !$application->testResult->completed_at) {
            return back()->with('error', 'Ứng viên này chưa hoàn thành bài test đánh giá năng lực.');
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

        if ($request->has('download')) {
            return response()->download($filePath, "Bai_Test_AZHR_{$application->application_code}_{$application->candidate->name}.pdf", [
                'Content-Type' => 'application/pdf',
            ]);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    /**
     * Cập nhật trạng thái ứng viên (Workflow)
     */
    public function updateStatus(Request $request, $id)
    {
        $application = Application::with(['candidate', 'position'])->findOrFail($id);
        $oldStatus = $application->status;
        $newStatus = $request->status;

        $stepMap = [
            'applied' => 1,
            'screening' => 2,
            'test_sent' => 2,
            'tested' => 3,
            'interviewing' => 4,
            'offered' => 5,
            'rejected' => 0,
        ];

        $application->status = $newStatus;
        $application->stage_step = $stepMap[$newStatus] ?? 1;
        if ($request->filled('rejection_reason')) {
            $application->rejection_reason = $request->rejection_reason;
        }
        $application->save();

        // Gửi email tự động theo workflow nếu chuyển trạng thái
        if ($oldStatus !== $newStatus) {
            if ($newStatus === 'screening') {
                $this->triggerAutomationEmail($application, 'screening_approved');
            } elseif ($newStatus === 'test_sent') {
                $this->triggerAutomationEmail($application, 'test_invitation');
            } elseif ($newStatus === 'offered') {
                $this->triggerAutomationEmail($application, 'offer_congrats');
            } elseif ($newStatus === 'rejected') {
                $this->triggerAutomationEmail($application, 'thank_you_rejection');
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Đã chuyển trạng thái ứng viên sang: " . strtoupper($newStatus),
                'status' => $newStatus,
            ]);
        }

        return back()->with('success', "Đã cập nhật trạng thái hồ sơ thành công!");
    }

    /**
     * Tự động duyệt toàn bộ hồ sơ đang ở bước 1 (Applied) và bước 2 (Screening)
     */
    public function autoApproveAll()
    {
        $pending = Application::with(['candidate', 'position'])
            ->whereIn('status', ['applied', 'screening'])
            ->get();

        $count = $pending->count();
        foreach ($pending as $appItem) {
            $appItem->status = 'test_sent';
            $appItem->stage_step = 3;
            $appItem->save();

            $this->triggerAutomationEmail($appItem, 'test_invitation');
        }

        return back()->with('success', "Đã tự động duyệt {$count} hồ sơ sang Bài Test và gửi email kèm link làm bài thi thành công!");
    }

    /**
     * Gửi lại email thông báo cho ứng viên
     */
    public function resendEmail(Request $request, $id)
    {
        $application = Application::with(['candidate', 'position'])->findOrFail($id);
        $templateCode = $request->template_code ?? 'screening_approved';

        $this->triggerAutomationEmail($application, $templateCode);

        return back()->with('success', "Đã gửi lại email thông báo thành công đến địa chỉ: {$application->candidate->email}");
    }

    /**
     * Điều phối Lịch phỏng vấn (Schedule Interview)
     */
    public function scheduleInterview(Request $request, $id)
    {
        $request->validate([
            'interview_time' => 'required',
            'interview_type' => 'required|in:online,offline',
        ]);

        $application = Application::with(['candidate', 'position'])->findOrFail($id);

        $application->interview_time = $request->interview_time;
        $application->interview_type = $request->interview_type;
        $application->interview_link = $request->interview_link ?? ($request->interview_type === 'online' ? 'https://meet.google.com/azm-interview-' . Str::random(6) : null);
        $application->interview_location = $request->interview_location ?? '84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng';

        // Xử lý phân công Mentor: 3 lựa chọn (Admin, Lê Đình Quang, hoặc Người phụ trách tự điền tên)
        $mentorType = $request->input('mentor_type');
        if ($mentorType === 'admin') {
            $adminUser = Admin::where('name', 'Admin')->first() ?? Admin::where('role', 'admin')->first();
            $application->assigned_mentor_id = $adminUser ? $adminUser->id : 1;
        } elseif ($mentorType === 'le_dinh_quang') {
            $quangUser = Admin::where('name', 'like', '%Lê Đình Quang%')->first();
            $application->assigned_mentor_id = $quangUser ? $quangUser->id : 2;
        } elseif ($mentorType === 'other') {
            $customName = trim($request->input('custom_mentor_name', ''));
            if (!empty($customName)) {
                $customMentor = Admin::firstOrCreate(
                    ['name' => $customName],
                    [
                        'email' => Str::slug($customName) . '@azmedia.com.vn',
                        'password' => bcrypt('12345678'),
                        'role' => 'mentor',
                    ]
                );
                $application->assigned_mentor_id = $customMentor->id;
            } else {
                $quangUser = Admin::where('name', 'like', '%Lê Đình Quang%')->first();
                $application->assigned_mentor_id = $quangUser ? $quangUser->id : 2;
            }
        } elseif ($request->filled('mentor_id')) {
            $application->assigned_mentor_id = $request->mentor_id;
        }

        $application->status = 'interviewing';
        $application->stage_step = 4;
        $application->save();

        // Gửi email mời phỏng vấn
        $this->triggerAutomationEmail($application, 'interview_invitation');

        return back()->with('success', 'Đã xếp lịch phỏng vấn và gửi email mời tham dự tự động cho ứng viên!');
    }

    /**
     * Chấm điểm Đánh giá Chuyên môn (Scorecard)
     */
    public function submitScorecard(Request $request, $id)
    {
        $user = $this->getCurrentUser();
        $application = Application::findOrFail($id);

        $tech = (float) $request->input('technical_score', 0);
        $logic = (float) $request->input('logic_score', 0);
        $attitude = (float) $request->input('attitude_score', 0);
        $comm = (float) $request->input('communication_score', 0);
        $avg = round(($tech + $logic + $attitude + $comm) / 4, 1);

        Evaluation::updateOrCreate(
            [
                'application_id' => $application->id,
                'evaluator_id' => $user['id'],
            ],
            [
                'evaluator_name' => $user['name'],
                'evaluator_role' => $user['role'] ?? 'mentor',
                'technical_score' => $tech,
                'logic_score' => $logic,
                'attitude_score' => $attitude,
                'communication_score' => $comm,
                'average_score' => $avg,
                'strengths' => $request->strengths,
                'weaknesses' => $request->weaknesses,
                'general_comment' => $request->general_comment,
                'recommendation' => $request->recommendation ?? 'consider',
            ]
        );

        // Nếu đề xuất pass và người chấm quyết định offer
        if ($request->recommendation === 'pass' && $request->auto_offer == 1) {
            $application->status = 'offered';
            $application->stage_step = 5;
            $application->save();
            $this->triggerAutomationEmail($application, 'offer_congrats');
        }

        return back()->with('success', 'Đã lưu bảng điểm Scorecard đánh giá ứng viên thành công!');
    }

    /**
     * Tự động gửi Email thật & Ghi log
     */
    private function triggerAutomationEmail(Application $application, $templateCode)
    {
        $template = EmailTemplate::where('code', $templateCode)->first();
        if (!$template) return;

        $trackUrl = route('azmedia.candidate.track', ['code' => $application->application_code]);

        $replacements = [
            '{candidate_name}'     => $application->candidate->name,
            '{position_title}'     => $application->position->title,
            '{application_code}'   => $application->application_code,
            '{track_url}'          => $trackUrl,
            '{test_link}'          => route('azmedia.candidate.test', ['code' => $application->application_code]),
            '{interview_time}'     => $application->interview_time
                                        ? date('H:i - d/m/Y', strtotime($application->interview_time))
                                        : 'Sẽ thông báo cụ thể',
            '{interview_link}'     => $application->interview_link ?? 'https://meet.google.com/azm-interview',
            '{interview_location}' => $application->interview_location ?? '84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng',
            '{mentor_name}'        => $application->assignedMentor ? $application->assignedMentor->name : 'Lê Đình Quang (Tổng Giám Đốc)',
        ];

        $subject = str_replace(array_keys($replacements), array_values($replacements), $template->subject);
        $body    = str_replace(array_keys($replacements), array_values($replacements), $template->body_html);

        // Gửi email thật qua SMTP Gmail
        $emailStatus = 'sent';
        $errorMsg    = null;
        try {
            Mail::to($application->candidate->email, $application->candidate->name)
                ->send(new AZMediaEmail($subject, $body, $application->candidate->name));
        } catch (\Exception $e) {
            $emailStatus = 'failed';
            $errorMsg    = $e->getMessage();
            Log::error("[AZ Media Email] Lỗi gửi email {$templateCode} → {$application->candidate->email}: " . $e->getMessage());
        }

        // Ghi log gửi email
        EmailLog::create([
            'application_id'  => $application->id,
            'recipient_email' => $application->candidate->email,
            'recipient_name'  => $application->candidate->name,
            'template_code'   => $templateCode,
            'subject'         => $subject,
            'body_preview'    => mb_substr(strip_tags($body), 0, 500, 'UTF-8'),
            'status'          => $emailStatus,
            'sent_at'         => now(),
        ]);
    }

    /**
     * Quản lý Vị trí tuyển dụng (CRUD Positions)
     */
    public function positions()
    {
        $user = $this->getCurrentUser();
        $positions = InternshipPosition::withCount('applications')->latest()->get();
        return view('azmedia.portal.positions', compact('user', 'positions'));
    }

    public function createPosition(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string',
            'category' => 'required|string',
            'stipend' => 'required|string',
        ]);

        $pos = InternshipPosition::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'department' => $request->department,
            'category' => $request->category,
            'location' => $request->location ?? '84 Nguyễn Hữu Dật, Đà Nẵng',
            'type' => $request->type ?? 'part_time',
            'quantity' => (int) ($request->quantity ?? 3),
            'stipend' => $request->stipend,
            'summary' => $request->summary,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'benefits' => $request->benefits,
            'experience_required' => $request->experience_required ?? 'Không yêu cầu kinh nghiệm, ưu tiên sinh viên năm 3, 4',
            'deadline' => $request->deadline ? date('Y-m-d', strtotime($request->deadline)) : now()->addMonths(2),
            'is_featured' => $request->has('is_featured'),
            'status' => 'open',
        ]);

        return back()->with('success', "Đã thêm vị trí tuyển dụng thực tập sinh '{$pos->title}' mới thành công!");
    }

    public function updatePosition(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'department' => 'required|string',
            'category' => 'required|string',
            'stipend' => 'required|string',
        ]);

        $pos = InternshipPosition::findOrFail($id);

        $pos->update([
            'title' => $request->title,
            'department' => $request->department,
            'category' => $request->category,
            'location' => $request->location ?? $pos->location,
            'type' => $request->type ?? $pos->type,
            'quantity' => (int) ($request->quantity ?? $pos->quantity),
            'stipend' => $request->stipend,
            'summary' => $request->summary ?? $pos->summary,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'benefits' => $request->benefits,
            'experience_required' => $request->experience_required ?? $pos->experience_required,
            'deadline' => $request->deadline ? date('Y-m-d', strtotime($request->deadline)) : $pos->deadline,
            'is_featured' => $request->has('is_featured'),
            'status' => $request->status ?? $pos->status,
        ]);

        return back()->with('success', "Đã cập nhật vị trí tuyển dụng '{$pos->title}' thành công!");
    }

    public function deletePosition($id)
    {
        $pos = InternshipPosition::findOrFail($id);
        $title = $pos->title;
        $appCount = $pos->applications()->count();

        $pos->delete();

        return back()->with('success', "Đã xóa vị trí tuyển dụng '{$title}'" . ($appCount > 0 ? " và {$appCount} hồ sơ liên quan." : " thành công!"));
    }

    public function togglePositionStatus($id)
    {
        $pos = InternshipPosition::findOrFail($id);
        $pos->status = ($pos->status === 'open') ? 'closed' : 'open';
        $pos->save();

        return back()->with('success', "Đã thay đổi trạng thái vị trí '{$pos->title}' thành: " . ($pos->status === 'open' ? 'Đang mở' : 'Đã đóng'));
    }

    /**
     * Ngân hàng Câu hỏi Test (Questions Bank)
     */
    public function questions()
    {
        $user = $this->getCurrentUser();
        $questions = TestQuestion::with('position')->latest()->get();
        $positions = InternshipPosition::all();
        return view('azmedia.portal.questions', compact('user', 'questions', 'positions'));
    }

    public function createQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:A,B,C,D',
        ]);

        TestQuestion::create([
            'position_category' => $request->position_category ?? 'general',
            'position_id' => $request->position_id ?? null,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_option' => $request->correct_option,
            'explanation' => $request->explanation,
            'points' => $request->points ?? 10,
        ]);

        return back()->with('success', 'Đã thêm câu hỏi trắc nghiệm mới vào Ngân hàng câu hỏi!');
    }

    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_option' => 'required|in:A,B,C,D',
        ]);

        $q = TestQuestion::findOrFail($id);

        $q->update([
            'position_category' => $request->position_category ?? $q->position_category,
            'position_id' => $request->position_id ?? $q->position_id,
            'question' => $request->question,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_option' => $request->correct_option,
            'explanation' => $request->explanation,
            'points' => (int) ($request->points ?? $q->points),
        ]);

        return back()->with('success', "Đã cập nhật câu hỏi #{$q->id} thành công!");
    }

    public function deleteQuestion($id)
    {
        $q = TestQuestion::findOrFail($id);
        $qId = $q->id;
        $q->delete();

        return back()->with('success', "Đã xóa câu hỏi #{$qId} thành công!");
    }
}
