<?php

namespace App\Http\Controllers\AZMedia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\InternshipPosition;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\TestQuestion;
use App\Models\CandidateTest;
use App\Models\Evaluation;
use App\Models\EmailTemplate;
use App\Models\EmailLog;

class AZMediaApiController extends Controller
{
    /**
     * GET /api/v1/positions
     */
    public function getPositions(Request $request)
    {
        $query = InternshipPosition::where('status', 'open');

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }
        if ($request->filled('location') && $request->location !== 'all') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $positions = $query->orderBy('is_featured', 'desc')->get();

        return response()->json([
            'success' => true,
            'count' => $positions->count(),
            'data' => $positions
        ]);
    }

    /**
     * GET /api/v1/positions/{id}
     */
    public function getPositionDetail($id)
    {
        $position = InternshipPosition::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $position
        ]);
    }

    /**
     * POST /api/v1/apply
     */
    public function submitApply(Request $request)
    {
        $request->validate([
            'position_id' => 'required|exists:internship_positions,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'university' => 'required|string',
            'major' => 'required|string',
            'working_shift' => 'required|string',
        ]);

        $position = InternshipPosition::findOrFail($request->position_id);

        $candidate = Candidate::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'university' => $request->university,
                'major' => $request->major,
                'academic_year' => $request->academic_year ?? 'Năm 3',
                'gpa' => $request->gpa ?? null,
                'github_url' => $request->github_url ?? null,
                'portfolio_url' => $request->portfolio_url ?? null,
                'working_shift' => $request->working_shift,
                'address' => $request->address ?? 'Đà Nẵng',
            ]
        );

        $cvPath = 'uploads/cvs/CV_Nguyen_Nhat_Linh_An_24CNTT1A.pdf';
        $originalName = 'CV_UngVien.pdf';

        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $originalName = $file->getClientOriginalName();
            $safeName = 'CV_' . Str::slug($candidate->name, '_') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/cvs');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $safeName);
            $cvPath = 'uploads/cvs/' . $safeName;
        }

        $appCode = 'AZ-2026-' . strtoupper(Str::random(4));
        $application = Application::create([
            'candidate_id' => $candidate->id,
            'position_id' => $position->id,
            'application_code' => $appCode,
            'cv_path' => $cvPath,
            'cv_filename' => $originalName,
            'cover_letter' => $request->cover_letter ?? null,
            'status' => 'test_sent', // Tự động duyệt CV
            'stage_step' => 3,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nộp hồ sơ thành công vào hệ thống AZ Media!',
            'application_code' => $appCode,
            'track_url' => route('azmedia.candidate.track', ['code' => $appCode]),
        ], 201);
    }

    /**
     * GET /api/v1/candidate/track/{key}
     */
    public function trackProgress($key)
    {
        $application = Application::with(['candidate', 'position', 'testResult', 'evaluations'])
            ->where('application_code', $key)
            ->orWhereHas('candidate', function ($q) use ($key) {
                $q->where('email', $key);
            })
            ->latest()
            ->first();

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy hồ sơ ứng tuyển nào khớp với thông tin cung cấp.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $application
        ]);
    }

    /**
     * GET /api/v1/candidate/test/{code}
     */
    public function getTestQuestions($code)
    {
        $application = Application::with(['position', 'candidate'])
            ->where('application_code', $code)
            ->firstOrFail();

        $category = $application->position->category ?? 'general';
        $specific = TestQuestion::where('position_category', $category)->get();
        $general = TestQuestion::where('position_category', 'general')->get();
        $all = $specific->merge($general);

        // Ẩn đáp án đúng và giải thích khi gửi ra cho client làm bài
        $cleanQuestions = $all->map(function ($item) {
            return [
                'id' => $item->id,
                'question' => $item->question,
                'option_a' => $item->option_a,
                'option_b' => $item->option_b,
                'option_c' => $item->option_c,
                'option_d' => $item->option_d,
                'points' => $item->points,
            ];
        });

        return response()->json([
            'success' => true,
            'application_code' => $code,
            'candidate_name' => $application->candidate->name,
            'position' => $application->position->title,
            'time_limit_minutes' => 20,
            'total_questions' => $cleanQuestions->count(),
            'questions' => $cleanQuestions
        ]);
    }

    /**
     * GET /api/v1/ats/analytics
     */
    public function getAnalytics()
    {
        return response()->json([
            'success' => true,
            'stats' => [
                'total_positions' => InternshipPosition::count(),
                'total_applications' => Application::count(),
                'total_interviews' => Application::where('status', 'interviewing')->count(),
                'total_offered' => Application::where('status', 'offered')->count(),
                'total_rejected' => Application::where('status', 'rejected')->count(),
            ],
            'conversion_funnel' => [
                'applied' => Application::where('status', 'applied')->count(),
                'screening' => Application::where('status', 'screening')->count(),
                'tested' => Application::whereIn('status', ['test_sent', 'tested'])->count(),
                'interviewing' => Application::where('status', 'interviewing')->count(),
                'offered' => Application::where('status', 'offered')->count(),
                'rejected' => Application::where('status', 'rejected')->count(),
            ],
            'universities' => Candidate::select('university', \DB::raw('count(*) as count'))
                ->groupBy('university')
                ->orderBy('count', 'desc')
                ->get(),
        ]);
    }
}
