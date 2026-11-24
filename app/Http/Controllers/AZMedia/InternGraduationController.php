<?php

namespace App\Http\Controllers\AZMedia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\InternGraduation;
use App\Models\Application;
use App\Models\Candidate;
use Carbon\Carbon;

class InternGraduationController extends Controller
{
    /**
     * Dữ liệu cấu hình các kênh và liên kết chuẩn đầu ra của AZ Media
     */
    protected function getGraduationConfig()
    {
        return [
            // Mục 1: Khảo sát
            'survey_intro_link' => 'https://azmedia.com.vn/gioi-thieu/',
            'survey_link_1' => 'https://forms.gle/AveuvfcHsWLKhv1a8',
            'survey_link_2' => 'https://forms.gle/xDUSsv812EEJyqz78',
            'survey_proof_folder' => 'https://drive.google.com/drive/folders/1i1zZx97wSwZAsF5KRon3sexZABi8MtWB?usp=sharing',

            // Mục 2: Nộp báo cáo (4 bước)
            'report_step1_form' => 'https://forms.gle/NEw72ytvjGcCzuK56',
            'report_step1_deadline' => '15/07/2026',
            'report_step2_form' => 'https://forms.gle/fVAGvaDXkRxZwnh66',

            // Mục 3: Video, File Word và Đánh giá
            'video_proof_folder' => 'https://drive.google.com/drive/folders/1CmC8pLlrGXUkQBOdEPqP0wdKLb3Mqttd?usp=sharing',
            'review_proof_folder' => 'https://drive.google.com/drive/u/0/folders/18ez5f7HG4bjdOuePrH2uYqViip4rhkHA',
            
            // 5 kênh đánh giá công ty
            'review_channels' => [
                'map1' => [
                    'name' => 'Công Ty AZ Media – Chiến Thắng Bằng Tốc Độ',
                    'type' => 'Google Maps',
                    'icon' => 'fa-solid fa-map-location-dot',
                    'color' => 'text-emerald-600 bg-emerald-50 border-emerald-200',
                    'link' => 'https://maps.app.goo.gl/AcbW5QnZm6ehsXXq6?g_st=ipc',
                    'desc' => '127 Lê Trọng Tấn, Hòa Phát, Cẩm Lệ, Đà Nẵng'
                ],
                'map2' => [
                    'name' => 'Văn Phòng AZ Media',
                    'type' => 'Google Maps',
                    'icon' => 'fa-solid fa-location-dot',
                    'color' => 'text-blue-600 bg-blue-50 border-blue-200',
                    'link' => 'https://maps.app.goo.gl/2DjxdNDeyExVus8f8?g_st=ipc',
                    'desc' => 'Văn phòng đào tạo & thực tập sinh AZ Media'
                ],
                'page_homes' => [
                    'name' => 'Công ty Bất Động Sản AZ HOMES',
                    'type' => 'Fanpage Facebook',
                    'icon' => 'fa-brands fa-facebook',
                    'color' => 'text-indigo-600 bg-indigo-50 border-indigo-200',
                    'link' => 'https://www.facebook.com/congtyazhome?mibextid=wwXIfr&rdid=QOYvzWwLd6NMm1mt&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1JY6ar1QaG%2F%3Fmibextid%3DwwXIfr',
                    'desc' => 'Hệ thống đối tác & kết nối việc làm sinh viên'
                ],
                'page_media' => [
                    'name' => 'Công ty AZ MEDIA (Official)',
                    'type' => 'Fanpage Facebook',
                    'icon' => 'fa-brands fa-facebook',
                    'color' => 'text-sky-600 bg-sky-50 border-sky-200',
                    'link' => 'https://www.facebook.com/share/1FYsAoW1J8/?mibextid=wwXIfr',
                    'desc' => 'Trang truyền thông chính thức AZ Media'
                ],
                'page_hr' => [
                    'name' => 'AZ Media HR - Tuyển Dụng',
                    'type' => 'Fanpage Facebook',
                    'icon' => 'fa-brands fa-facebook',
                    'color' => 'text-orange-600 bg-orange-50 border-orange-200',
                    'link' => 'https://www.facebook.com/share/1FYsAoW1J8/?mibextid=wwXIfr',
                    'desc' => 'Kênh việc làm & phát triển thực tập sinh'
                ],
            ]
        ];
    }

    /**
     * Trang chủ Chuẩn Đầu Ra TTS dành cho ứng viên / thực tập sinh
     */
    public function index(Request $request)
    {
        // Yêu cầu Đăng nhập tài khoản Thực tập sinh để sử dụng Chuẩn đầu ra
        if (!Session::has('intern_user')) {
            return redirect()->route('azmedia.intern.login', [
                'redirect' => $request->fullUrl(),
                'code' => $request->get('code') ?? $request->get('keyword') ?? ''
            ])->with('warning', 'Theo quy định AZ Media: Chuẩn đầu ra yêu cầu Đăng nhập tài khoản Thực tập sinh (đã được công ty tiếp nhận) để nộp báo cáo và ký duyệt mộc!');
        }

        $config = $this->getGraduationConfig();
        $sessionUser = Session::get('intern_user');
        $candidate = Candidate::with(['applications.position', 'graduations'])->find($sessionUser['id']);

        $graduation = null;
        $application = null;
        $keyword = trim($request->get('code') ?? $request->get('keyword') ?? '');

        if ($candidate) {
            $application = $candidate->applications()->latest()->first();
            $graduation = $candidate->graduations()->latest()->first();

            // Nếu đã đăng nhập nhưng chưa có bản ghi Chuẩn đầu ra -> Tự khởi tạo ngay
            if (!$graduation) {
                $code = 'CDR-2026-' . str_pad($candidate->id, 4, '0', STR_PAD_LEFT);
                $graduation = InternGraduation::create([
                    'graduation_code' => $code,
                    'candidate_id' => $candidate->id,
                    'application_id' => $application ? $application->id : null,
                    'student_name' => $candidate->name,
                    'student_code' => 'TTS-' . $candidate->id,
                    'email' => $candidate->email,
                    'phone' => $candidate->phone,
                    'school' => $candidate->university,
                    'major' => $candidate->major,
                    'intern_position' => ($application && $application->position) ? $application->position->title : 'Thực tập sinh',
                    'status' => 'in_progress',
                ]);
            }
        }

        // Lấy danh sách hồ sơ gần đây để sinh viên tham khảo nếu cần
        $recentGraduations = InternGraduation::latest()->take(5)->get();

        return view('azmedia.graduation.index', compact('config', 'keyword', 'graduation', 'application', 'recentGraduations', 'candidate'));
    }

    /**
     * Tra cứu hồ sơ chuẩn đầu ra
     */
    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:100',
        ], [
            'keyword.required' => 'Vui lòng nhập Mã TTS, Mã hồ sơ tuyển dụng, Email hoặc Mã sinh viên.',
        ]);

        return redirect()->route('azmedia.graduation.index', ['code' => trim($request->keyword)]);
    }

    /**
     * Khởi tạo hồ sơ chuẩn đầu ra mới nếu sinh viên tự đăng ký trực tiếp
     */
    public function register(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:150',
            'student_code' => 'required|string|max:50',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:20',
            'school' => 'required|string|max:150',
            'major' => 'nullable|string|max:150',
            'intern_position' => 'nullable|string|max:150',
        ], [
            'student_name.required' => 'Vui lòng nhập Họ và tên thực tập sinh.',
            'student_code.required' => 'Vui lòng nhập Mã số sinh viên.',
            'email.required' => 'Vui lòng nhập địa chỉ Email.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'school.required' => 'Vui lòng chọn hoặc nhập tên Trường Đại học / Cao đẳng.',
        ]);

        $nextId = (InternGraduation::max('id') ?? 0) + 1;
        $code = 'CDR-2026-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $graduation = InternGraduation::create([
            'graduation_code' => $code,
            'student_name' => trim($request->student_name),
            'student_code' => trim($request->student_code),
            'email' => trim($request->email),
            'phone' => trim($request->phone),
            'school' => trim($request->school),
            'major' => trim($request->major ?? 'Công nghệ thông tin / Marketing'),
            'intern_position' => trim($request->intern_position ?? 'Thực tập sinh'),
            'status' => 'in_progress',
        ]);

        return redirect()->route('azmedia.graduation.index', ['code' => $graduation->graduation_code])
            ->with('success', "Đã tạo hồ sơ theo dõi Chuẩn Đầu Ra thành công! Mã chuẩn đầu ra của bạn là: {$graduation->graduation_code}");
    }

    /**
     * Xử lý Bước 3: Đặt lịch hẹn đã nộp bài trên Cổng AZ SUPPORT (Mô phỏng chuẩn ảnh 1 & 2)
     */
    public function bookAppointment(Request $request)
    {
        if (!Session::has('intern_user')) {
            return redirect()->route('azmedia.intern.login')->with('error', 'Vui lòng đăng nhập tài khoản thực tập sinh để đặt lịch hẹn.');
        }

        $request->validate([
            'graduation_code' => 'required|string',
            'appointment_name' => 'required|string|max:150',
            'appointment_phone' => 'required|string|max:20',
            'appointment_email' => 'required|email|max:150',
            'appointment_date' => 'required|string|max:50',
            'appointment_time' => 'required|string|max:50',
            'appointment_team' => 'nullable|string|max:100',
            'appointment_service' => 'nullable|string|max:100',
        ], [
            'appointment_name.required' => 'Vui lòng nhập Tên người nộp báo cáo.',
            'appointment_phone.required' => 'Vui lòng nhập số điện thoại người nộp.',
            'appointment_email.required' => 'Vui lòng nhập email người nộp.',
            'appointment_date.required' => 'Vui lòng chọn ngày nộp báo cáo.',
            'appointment_time.required' => 'Vui lòng chọn giờ hẹn.',
        ]);

        $graduation = InternGraduation::where('graduation_code', $request->graduation_code)->firstOrFail();

        $graduation->update([
            'appointment_booked' => true,
            'appointment_name' => trim($request->appointment_name),
            'appointment_phone' => trim($request->appointment_phone),
            'appointment_email' => trim($request->appointment_email),
            'appointment_team' => trim($request->appointment_team ?? 'Gặp hỗ trợ viên'),
            'appointment_service' => trim($request->appointment_service ?? 'Thực tập sinh'),
            'appointment_date' => trim($request->appointment_date),
            'appointment_time' => trim($request->appointment_time),
            'appointment_status' => 'pending',
        ]);

        return redirect()->route('azmedia.graduation.index', ['code' => $graduation->graduation_code])
            ->with('success', '🎉 Đặt lịch hẹn nộp bài thành công trên Cổng AZ SUPPORT! Hệ thống sẽ xử lý kết quả trong 3 - 7 ngày làm việc.');
    }

    /**
     * Xử lý Bước 4: Đăng ký thực tập 1+1 trên Cổng AZ SUPPORT (Mô phỏng chuẩn ảnh 3 & 4)
     */
    public function submitReferral(Request $request)
    {
        if (!Session::has('intern_user')) {
            return redirect()->route('azmedia.intern.login')->with('error', 'Vui lòng đăng nhập tài khoản thực tập sinh để giới thiệu 1+1.');
        }

        $request->validate([
            'graduation_code' => 'required|string',
            'referral_full_info' => 'required|string|max:255',
            'referral_phone' => 'required|string|max:20',
            'referral_email' => 'required|email|max:150',
            'referral_school' => 'required|string|max:150',
            'referral_major' => 'required|string|max:150',
            'referral_position' => 'required|string|max:150',
            'cv_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // tối đa 10MB
        ], [
            'referral_full_info.required' => 'Vui lòng điền Họ và tên (Tên người nộp + Tên người giới thiệu đợt sau A).',
            'referral_phone.required' => 'Vui lòng điền Số điện thoại.',
            'referral_email.required' => 'Vui lòng điền Email.',
            'referral_school.required' => 'Vui lòng điền Trường.',
            'referral_major.required' => 'Vui lòng điền Ngành.',
            'referral_position.required' => 'Vui lòng điền Vị trí thực tập.',
            'cv_file.max' => 'File tải lên không được vượt quá 10MB.',
            'cv_file.mimes' => 'Hệ thống chỉ nhận file định dạng PDF, JPG, PNG hoặc DOC/DOCX.',
        ]);

        $graduation = InternGraduation::where('graduation_code', $request->graduation_code)->firstOrFail();

        $filePath = $graduation->referral_cv_file;

        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $fileName = 'referral_' . time() . '_' . Str::slug($graduation->graduation_code) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/referrals');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $fileName);
            $filePath = 'uploads/referrals/' . $fileName;
        }

        $graduation->update([
            'referral_completed' => true,
            'referral_full_info' => trim($request->referral_full_info),
            'referral_phone' => trim($request->referral_phone),
            'referral_email' => trim($request->referral_email),
            'referral_school' => trim($request->referral_school),
            'referral_major' => trim($request->referral_major),
            'referral_position' => trim($request->referral_position),
            'referral_cv_file' => $filePath,
            'referral_status' => 'submitted',
        ]);

        return redirect()->route('azmedia.graduation.index', ['code' => $graduation->graduation_code])
            ->with('success', '✅ Đã hoàn thành mục 1+1: Giới thiệu ứng viên thành công cho AZ Homes & HCNS!');
    }

    /**
     * Cập nhật toàn bộ tiến độ / checklist chuẩn đầu ra của TTS
     */
    public function updateChecklist(Request $request)
    {
        if (!Session::has('intern_user')) {
            return redirect()->route('azmedia.intern.login')->with('error', 'Vui lòng đăng nhập tài khoản thực tập sinh.');
        }

        $request->validate([
            'graduation_code' => 'required|string',
        ]);

        $graduation = InternGraduation::where('graduation_code', $request->graduation_code)->firstOrFail();

        $graduation->survey_1_completed = $request->has('survey_1_completed');
        $graduation->survey_2_completed = $request->has('survey_2_completed');
        $graduation->survey_proof_link = $request->survey_proof_link ? trim($request->survey_proof_link) : $graduation->survey_proof_link;

        $graduation->report_draft_submitted = $request->has('report_draft_submitted');
        $graduation->report_final_submitted = $request->has('report_final_submitted');
        $graduation->hard_copy_submitted = $request->has('hard_copy_submitted');
        $graduation->report_notes = $request->report_notes ? trim($request->report_notes) : $graduation->report_notes;

        $graduation->word_report_submitted = $request->has('word_report_submitted');
        $graduation->word_report_link = $request->word_report_link ? trim($request->word_report_link) : $graduation->word_report_link;

        $graduation->video_submitted = $request->has('video_submitted');
        $graduation->video_link = $request->video_link ? trim($request->video_link) : $graduation->video_link;

        $graduation->review_map1 = $request->has('review_map1');
        $graduation->review_map2 = $request->has('review_map2');
        $graduation->review_page_homes = $request->has('review_page_homes');
        $graduation->review_page_media = $request->has('review_page_media');
        $graduation->review_page_hr = $request->has('review_page_hr');
        $graduation->review_proof_link = $request->review_proof_link ? trim($request->review_proof_link) : $graduation->review_proof_link;

        // Nếu người dùng bấm gửi duyệt
        if ($request->has('submit_for_review')) {
            $graduation->status = 'pending_review';
        }

        $graduation->save();

        return redirect()->route('azmedia.graduation.index', ['code' => $graduation->graduation_code])
            ->with('success', 'Đã lưu tiến độ chuẩn đầu ra thành công! Hồ sơ của bạn đã được cập nhật.');
    }

    // =========================================================================
    // PHÂN HỆ QUẢN TRỊ ADMIN / BAN ĐIỀU HÀNH AZ MEDIA (ATS PORTAL)
    // =========================================================================

    /**
     * Danh sách Chuẩn đầu ra TTS trong Admin Portal
     */
    public function adminIndex(Request $request)
    {
        $user = Session::get('portal_user');
        if (!$user) {
            return redirect()->route('azmedia.login')->with('error', 'Vui lòng đăng nhập để truy cập trang quản trị.');
        }

        $query = InternGraduation::with(['candidate', 'application']);

        // Bộ lọc từ khóa
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('student_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('graduation_code', 'like', "%{$search}%");
            });
        }

        // Bộ lọc trạng thái
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Bộ lọc trường
        if ($request->filled('school') && $request->school !== 'all') {
            $query->where('school', 'like', "%{$request->school}%");
        }

        // Thống kê
        $totalGraduations = InternGraduation::count();
        $approvedCount = InternGraduation::where('status', 'approved')->count();
        $pendingCount = InternGraduation::where('status', 'pending_review')->count();
        $inProgressCount = InternGraduation::where('status', 'in_progress')->count();
        $appointmentCount = InternGraduation::where('appointment_booked', true)->count();
        $referralCount = InternGraduation::where('referral_completed', true)->count();

        $graduations = $query->latest()->paginate(15)->appends($request->query());

        // Lấy danh sách các trường đại học để làm dropdown
        $schools = InternGraduation::whereNotNull('school')->distinct()->pluck('school');

        return view('azmedia.portal.graduations.index', compact(
            'user',
            'graduations',
            'totalGraduations',
            'approvedCount',
            'pendingCount',
            'inProgressCount',
            'appointmentCount',
            'referralCount',
            'schools'
        ));
    }

    /**
     * Chi tiết hồ sơ Chuẩn đầu ra của 1 TTS
     */
    public function adminDetail($id)
    {
        $user = Session::get('portal_user');
        if (!$user) {
            return redirect()->route('azmedia.login')->with('error', 'Vui lòng đăng nhập để truy cập trang quản trị.');
        }

        $graduation = InternGraduation::with(['candidate', 'application.position'])->findOrFail($id);
        $config = $this->getGraduationConfig();

        return view('azmedia.portal.graduations.detail', compact('user', 'graduation', 'config'));
    }

    /**
     * Cập nhật trạng thái duyệt & nhận xét của BĐH
     */
    public function adminUpdateStatus(Request $request, $id)
    {
        $user = Session::get('portal_user');
        if (!$user) {
            return redirect()->route('azmedia.login')->with('error', 'Vui lòng đăng nhập.');
        }

        $request->validate([
            'status' => 'required|in:in_progress,pending_review,approved,needs_update',
            'admin_notes' => 'nullable|string',
        ]);

        $graduation = InternGraduation::findOrFail($id);

        $graduation->status = $request->status;
        $graduation->admin_notes = $request->admin_notes ? trim($request->admin_notes) : null;

        if ($request->status === 'approved') {
            $graduation->approved_by = $user['name'] ?? 'Lê Đình Quang (BĐH)';
            $graduation->approved_at = Carbon::now();
        } else {
            if ($graduation->status !== 'approved') {
                $graduation->approved_by = null;
                $graduation->approved_at = null;
            }
        }

        $graduation->save();

        return back()->with('success', "Đã cập nhật trạng thái chuẩn đầu ra thành công cho thực tập sinh {$graduation->student_name}!");
    }

    /**
     * Toggle nhanh từng tiêu chí (AJAX / POST)
     */
    public function adminToggleItem(Request $request, $id)
    {
        $user = Session::get('portal_user');
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $field = $request->get('field');
        $validFields = [
            'survey_1_completed', 'survey_2_completed',
            'report_draft_submitted', 'report_final_submitted', 'hard_copy_submitted',
            'appointment_booked', 'referral_completed',
            'word_report_submitted', 'video_submitted',
            'review_map1', 'review_map2', 'review_page_homes', 'review_page_media', 'review_page_hr'
        ];

        if (!in_array($field, $validFields)) {
            return response()->json(['success' => false, 'message' => 'Trường không hợp lệ'], 400);
        }

        $graduation = InternGraduation::findOrFail($id);
        $graduation->{$field} = !$graduation->{$field};
        $graduation->save();

        return response()->json([
            'success' => true,
            'field' => $field,
            'value' => $graduation->{$field},
            'progress' => $graduation->progress_percent
        ]);
    }

    /**
     * Tải file CV ứng viên 1+1
     */
    public function adminDownloadCV($id)
    {
        $graduation = InternGraduation::findOrFail($id);

        if (!$graduation->referral_cv_file || !file_exists(public_path($graduation->referral_cv_file))) {
            return back()->with('error', 'Không tìm thấy file CV hoặc ứng viên chưa upload file.');
        }

        return response()->download(public_path($graduation->referral_cv_file));
    }
}
