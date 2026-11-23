@extends('azmedia.portal.layout')

@section('title', 'Chi Tiết Chuẩn Đầu Ra TTS – ' . $graduation->student_name)
@section('page_title', 'Hồ Sơ Chuẩn Đầu Ra: ' . $graduation->student_name)

@section('portal_content')
<div class="space-y-6">

    <!-- Top Navigation & Breadcrumb -->
    <div class="flex items-center justify-between">
        <a href="{{ route('azmedia.portal.graduations.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-800 transition">
            <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách Chuẩn đầu ra
        </a>

        <div class="flex items-center gap-3">
            @if($graduation->candidate_id)
                <a href="{{ route('azmedia.portal.candidate.detail', $graduation->candidate_id) }}" target="_blank"
                   class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-user-tie"></i> Xem Hồ Sơ Ứng Tuyển ATS
                </a>
            @endif

            <a href="{{ route('azmedia.graduation.index', ['code' => $graduation->graduation_code]) }}" target="_blank"
               class="px-3 py-1.5 rounded-xl bg-orange-100 hover:bg-orange-200 text-brand-700 text-xs font-bold transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Cổng Sinh Viên Tra Cứu
            </a>
        </div>
    </div>

    <!-- Layout 2 cột: Cột trái Thông tin & Phê duyệt, Cột phải Chi tiết 3 Mục -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- CỘT TRÁI: THÔNG TIN TTS & FORM DUYỆT CỦA BAN ĐIỀU HÀNH -->
        <div class="space-y-6">
            <!-- Card Thông tin cá nhân -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl gradient-brand text-white font-extrabold text-xl flex items-center justify-center shadow">
                        {{ mb_substr($graduation->student_name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 leading-tight">{{ $graduation->student_name }}</h2>
                        <div class="font-mono text-xs text-brand-600 font-bold mt-0.5">{{ $graduation->graduation_code }}</div>
                    </div>
                </div>

                <!-- Tiến độ hoàn thành -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                        <span>Tiến độ tổng thể:</span>
                        <span class="text-brand-600 font-extrabold text-sm" id="progress-text">{{ $graduation->progress_percent }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div id="progress-bar" class="bg-gradient-to-r from-orange-500 to-brand-600 h-2 rounded-full transition-all duration-300" style="width: {{ $graduation->progress_percent }}%"></div>
                    </div>
                </div>

                <div class="divide-y divide-slate-100 text-xs space-y-2.5 pt-1">
                    @if($graduation->student_code)
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-slate-400">Mã sinh viên:</span>
                            <span class="font-mono font-bold text-slate-800">{{ $graduation->student_code }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-slate-400">Trường:</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $graduation->school }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-slate-400">Chuyên ngành:</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $graduation->major }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-slate-400">Vị trí thực tập:</span>
                        <span class="font-bold text-brand-700 text-right">{{ $graduation->intern_position }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-slate-400">Email:</span>
                        <a href="mailto:{{ $graduation->email }}" class="font-semibold text-blue-600 hover:underline">{{ $graduation->email }}</a>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-slate-400">Số điện thoại:</span>
                        <a href="tel:{{ $graduation->phone }}" class="font-semibold text-slate-800">{{ $graduation->phone }}</a>
                    </div>
                </div>
            </div>

            <!-- Card Quyết Định Phê Duyệt Của Ban Điều Hành -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-stamp text-brand-600"></i> Phê Duyệt Chuẩn Đầu Ra
                </div>

                <form action="{{ route('azmedia.portal.graduations.status', $graduation->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Trạng thái hồ sơ:</label>
                        <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-brand-500 bg-white">
                            <option value="in_progress" {{ $graduation->status === 'in_progress' ? 'selected' : '' }}>⏳ Đang thực hiện (Chưa đủ)</option>
                            <option value="pending_review" {{ $graduation->status === 'pending_review' ? 'selected' : '' }}>📨 Chờ BĐH duyệt</option>
                            <option value="approved" {{ $graduation->status === 'approved' ? 'selected' : '' }}>✅ Đạt Chuẩn Đầu Ra (Đã cấp mộc)</option>
                            <option value="needs_update" {{ $graduation->status === 'needs_update' ? 'selected' : '' }}>⚠️ Cần bổ sung hồ sơ</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ghi chú / Nhận xét của BĐH:</label>
                        <textarea name="admin_notes" rows="4"
                                  placeholder="Nhập nhận xét hoặc thông báo cho thực tập sinh (vd: đã cấp mộc, hoặc cần bổ sung bản in cứng...)"
                                  class="w-full p-3 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none">{{ $graduation->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl gradient-brand text-white font-bold text-xs shadow hover:shadow-orange-500/30 transition">
                        Lưu Quyết Định & Cập Nhật
                    </button>
                </form>

                @if($graduation->approved_by)
                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-[11px] text-emerald-800 space-y-0.5">
                        <div class="font-bold flex items-center gap-1">
                            <i class="fa-solid fa-circle-check"></i> Đã phê duyệt:
                        </div>
                        <div>Người duyệt: <strong>{{ $graduation->approved_by }}</strong></div>
                        @if($graduation->approved_at)
                            <div>Thời gian: {{ $graduation->approved_at->format('d/m/Y H:i:s') }}</div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- CỘT PHẢI: CHI TIẾT 3 MỤC TIÊU CHUẨN ĐẦU RA -->
        <div class="lg:col-span-2 space-y-6">

            <!-- MỤC 1: KHẢO SÁT -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center">1</span>
                        <h3 class="font-extrabold text-sm text-slate-900">Mục 1: Khảo Sát (2 Bản Form & Minh Chứng)</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Form 1 -->
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Bản khảo sát (1)</div>
                            <a href="{{ $config['survey_link_1'] }}" target="_blank" class="text-[11px] text-brand-600 hover:underline">Xem Google Form (1)</a>
                        </div>
                        <button type="button" onclick="toggleItem('survey_1_completed', this)"
                                class="px-3 py-1 rounded-lg text-xs font-bold transition {{ $graduation->survey_1_completed ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                            {{ $graduation->survey_1_completed ? 'Đã xong' : 'Chưa làm' }}
                        </button>
                    </div>

                    <!-- Form 2 -->
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-slate-800">Bản khảo sát (2)</div>
                            <a href="{{ $config['survey_link_2'] }}" target="_blank" class="text-[11px] text-brand-600 hover:underline">Xem Google Form (2)</a>
                        </div>
                        <button type="button" onclick="toggleItem('survey_2_completed', this)"
                                class="px-3 py-1 rounded-lg text-xs font-bold transition {{ $graduation->survey_2_completed ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                            {{ $graduation->survey_2_completed ? 'Đã xong' : 'Chưa làm' }}
                        </button>
                    </div>
                </div>

                <!-- Link Minh Chứng Drive -->
                <div class="p-3 rounded-xl bg-orange-50 border border-orange-200 flex items-center justify-between text-xs">
                    <span class="font-semibold text-slate-700">
                        <i class="fa-brands fa-google-drive text-amber-600 mr-1"></i> Minh chứng khảo sát của TTS:
                    </span>
                    @if($graduation->survey_proof_link)
                        <a href="{{ $graduation->survey_proof_link }}" target="_blank" class="font-bold text-brand-600 hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Mở Thư Mục Drive
                        </a>
                    @else
                        <span class="text-slate-400 italic">Chưa nộp link</span>
                    @endif
                </div>
            </div>

            <!-- MỤC 2: NỘP BÁO CÁO (4 BƯỚC) -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center">2</span>
                        <h3 class="font-extrabold text-sm text-slate-900">Mục 2: Nộp Báo Cáo Thực Tập (4 Bước Quy Định)</h3>
                    </div>
                </div>

                <!-- Bước 1, Bước 2, Nộp bản cứng -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <div class="text-xs font-bold text-slate-800">Bước 1: Bản thảo</div>
                        <button type="button" onclick="toggleItem('report_draft_submitted', this)"
                                class="w-full py-1.5 rounded-lg text-xs font-bold transition {{ $graduation->report_draft_submitted ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                            {{ $graduation->report_draft_submitted ? 'Đã nộp form B1' : 'Chưa nộp B1' }}
                        </button>
                    </div>

                    <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <div class="text-xs font-bold text-slate-800">Bước 2: Bản sửa cuối</div>
                        <button type="button" onclick="toggleItem('report_final_submitted', this)"
                                class="w-full py-1.5 rounded-lg text-xs font-bold transition {{ $graduation->report_final_submitted ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                            {{ $graduation->report_final_submitted ? 'Đã nộp form B2' : 'Chưa nộp B2' }}
                        </button>
                    </div>

                    <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <div class="text-xs font-bold text-slate-800">Bản cứng có dấu mộc</div>
                        <button type="button" onclick="toggleItem('hard_copy_submitted', this)"
                                class="w-full py-1.5 rounded-lg text-xs font-bold transition {{ $graduation->hard_copy_submitted ? 'bg-purple-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                            {{ $graduation->hard_copy_submitted ? 'Đã nộp bản cứng' : 'Chưa nộp bản cứng' }}
                        </button>
                    </div>
                </div>

                <!-- Bước 3: Chi Tiết Lịch Hẹn Đã Nộp Bài Trên AZ SUPPORT -->
                <div class="p-4 rounded-xl border border-purple-200 bg-purple-50/40 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-extrabold text-xs text-purple-900 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-check text-purple-600"></i> BƯỚC 3: LỊCH HẸN NỘP BÀI (AZ SUPPORT)
                        </span>
                        <button type="button" onclick="toggleItem('appointment_booked', this)"
                                class="px-2.5 py-0.5 rounded text-[11px] font-bold {{ $graduation->appointment_booked ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-700' }}">
                            {{ $graduation->appointment_booked ? 'Đã đặt lịch hẹn' : 'Chưa đặt hẹn' }}
                        </button>
                    </div>

                    @if($graduation->appointment_booked)
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-2 text-xs">
                            <div class="p-2 bg-white rounded-lg border border-purple-100">
                                <span class="text-slate-400 block text-[10px]">Người nộp:</span>
                                <span class="font-bold text-slate-800">{{ $graduation->appointment_name }}</span>
                            </div>
                            <div class="p-2 bg-white rounded-lg border border-purple-100">
                                <span class="text-slate-400 block text-[10px]">SĐT / Email:</span>
                                <span class="font-bold text-slate-800">{{ $graduation->appointment_phone }}</span>
                            </div>
                            <div class="p-2 bg-white rounded-lg border border-purple-100">
                                <span class="text-slate-400 block text-[10px]">Ngày nộp:</span>
                                <span class="font-bold text-brand-600 font-mono">{{ $graduation->appointment_date }}</span>
                            </div>
                            <div class="p-2 bg-white rounded-lg border border-purple-100">
                                <span class="text-slate-400 block text-[10px]">Giờ hẹn:</span>
                                <span class="font-bold text-purple-700 font-mono">{{ $graduation->appointment_time }}</span>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-slate-500 italic">Thực tập sinh chưa đặt lịch hẹn trên Cổng AZ SUPPORT.</p>
                    @endif
                </div>

                <!-- Bước 4: Chi Tiết Thực Hiện 1+1 (Giới Thiệu Ứng Viên) -->
                <div class="p-4 rounded-xl border border-orange-200 bg-orange-50/40 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-extrabold text-xs text-orange-900 flex items-center gap-1.5">
                            <i class="fa-solid fa-user-plus text-orange-600"></i> BƯỚC 4: ỨNG VIÊN GIỚI THIỆU 1+1 (BẮT BUỘC)
                        </span>
                        <button type="button" onclick="toggleItem('referral_completed', this)"
                                class="px-2.5 py-0.5 rounded text-[11px] font-bold {{ $graduation->referral_completed ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                            {{ $graduation->referral_completed ? 'Đã hoàn tất 1+1' : 'Chưa hoàn thành' }}
                        </button>
                    </div>

                    @if($graduation->referral_completed)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-2 text-xs">
                            <div class="p-2.5 bg-white rounded-lg border border-orange-100 space-y-1">
                                <span class="text-slate-400 text-[10px] block">Họ tên đăng ký:</span>
                                <span class="font-bold text-slate-800">{{ $graduation->referral_full_info }}</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-lg border border-orange-100 space-y-1">
                                <span class="text-slate-400 text-[10px] block">Liên hệ bạn A:</span>
                                <span class="font-semibold text-slate-800">{{ $graduation->referral_phone }} | {{ $graduation->referral_email }}</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-lg border border-orange-100 space-y-1">
                                <span class="text-slate-400 text-[10px] block">Trường & Ngành:</span>
                                <span class="font-semibold text-slate-800">{{ $graduation->referral_school }} - {{ $graduation->referral_major }}</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-lg border border-orange-100 space-y-1">
                                <span class="text-slate-400 text-[10px] block">Vị trí thực tập bạn A muốn ứng tuyển:</span>
                                <span class="font-bold text-brand-700">{{ $graduation->referral_position }}</span>
                            </div>
                        </div>

                        <!-- Tải file CV nếu có -->
                        @if($graduation->referral_cv_file)
                            <div class="pt-2 flex items-center justify-between">
                                <span class="text-xs text-slate-600 font-semibold">
                                    <i class="fa-solid fa-file-pdf text-rose-500 mr-1"></i> File CV bạn được giới thiệu:
                                </span>
                                <a href="{{ route('azmedia.portal.graduations.cv', $graduation->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs shadow-sm transition">
                                    <i class="fa-solid fa-download"></i> Tải CV Ứng Viên 1+1
                                </a>
                            </div>
                        @endif
                    @else
                        <p class="text-xs text-slate-500 italic">Chưa có thông tin sinh viên giới thiệu 1+1.</p>
                    @endif
                </div>
            </div>

            <!-- MỤC 3: VIDEO, WORD VÀ ĐÁNH GIÁ 5 KÊNH -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-purple-100 text-purple-700 font-bold text-xs flex items-center justify-center">3</span>
                        <h3 class="font-extrabold text-sm text-slate-900">Mục 3: Video, File Word & Đánh Giá 5 Kênh Của Công Ty</h3>
                    </div>
                </div>

                <!-- File Word & Video -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800">File Word tổng kết</span>
                            <button type="button" onclick="toggleItem('word_report_submitted', this)"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $graduation->word_report_submitted ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $graduation->word_report_submitted ? 'Đạt' : 'Chưa' }}
                            </button>
                        </div>
                        @if($graduation->word_report_link)
                            <a href="{{ $graduation->word_report_link }}" target="_blank" class="text-[11px] text-blue-600 hover:underline flex items-center gap-1 font-mono truncate">
                                <i class="fa-solid fa-link"></i> {{ $graduation->word_report_link }}
                            </a>
                        @else
                            <span class="text-slate-400 text-[11px] italic">Chưa dán link</span>
                        @endif
                    </div>

                    <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-800">Video cá nhân & nhóm</span>
                            <button type="button" onclick="toggleItem('video_submitted', this)"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $graduation->video_submitted ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $graduation->video_submitted ? 'Đạt' : 'Chưa' }}
                            </button>
                        </div>
                        @if($graduation->video_link)
                            <a href="{{ $graduation->video_link }}" target="_blank" class="text-[11px] text-purple-600 hover:underline flex items-center gap-1 font-mono truncate">
                                <i class="fa-solid fa-link"></i> {{ $graduation->video_link }}
                            </a>
                        @else
                            <span class="text-slate-400 text-[11px] italic">Chưa dán link</span>
                        @endif
                    </div>
                </div>

                <!-- 5 Kênh Đánh Giá -->
                <div class="space-y-2 pt-2">
                    <div class="text-xs font-bold text-slate-800">Đánh giá 5 kênh công ty:</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <!-- Maps 1 -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <span class="font-semibold text-slate-700">1. GG Maps Chiến Thắng Bằng Tốc Độ</span>
                            <button type="button" onclick="toggleItem('review_map1', this)"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $graduation->review_map1 ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $graduation->review_map1 ? 'Đã duyệt' : 'Chưa' }}
                            </button>
                        </div>

                        <!-- Maps 2 -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <span class="font-semibold text-slate-700">2. GG Maps Văn Phòng AZ Media</span>
                            <button type="button" onclick="toggleItem('review_map2', this)"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $graduation->review_map2 ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $graduation->review_map2 ? 'Đã duyệt' : 'Chưa' }}
                            </button>
                        </div>

                        <!-- Page 1 -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <span class="font-semibold text-slate-700">3. Fanpage AZ HOMES</span>
                            <button type="button" onclick="toggleItem('review_page_homes', this)"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $graduation->review_page_homes ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $graduation->review_page_homes ? 'Đã duyệt' : 'Chưa' }}
                            </button>
                        </div>

                        <!-- Page 2 -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                            <span class="font-semibold text-slate-700">4. Fanpage Cty AZ MEDIA</span>
                            <button type="button" onclick="toggleItem('review_page_media', this)"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $graduation->review_page_media ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $graduation->review_page_media ? 'Đã duyệt' : 'Chưa' }}
                            </button>
                        </div>

                        <!-- Page 3 -->
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between sm:col-span-2">
                            <span class="font-semibold text-slate-700">5. Fanpage AZ Media HR - Tuyển Dụng</span>
                            <button type="button" onclick="toggleItem('review_page_hr', this)"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $graduation->review_page_hr ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600' }}">
                                {{ $graduation->review_page_hr ? 'Đã duyệt' : 'Chưa' }}
                            </button>
                        </div>
                    </div>

                    <!-- Link Drive Minh Chứng Review -->
                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-between text-xs mt-3">
                        <span class="font-semibold text-amber-900">
                            <i class="fa-solid fa-camera mr-1"></i> Thư mục minh chứng review 5 kênh:
                        </span>
                        @if($graduation->review_proof_link)
                            <a href="{{ $graduation->review_proof_link }}" target="_blank" class="font-bold text-brand-600 hover:underline flex items-center gap-1">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Mở Drive Minh Chứng
                            </a>
                        @else
                            <span class="text-slate-400 italic">Chưa nộp link</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@push('scripts')
<script>
    function toggleItem(field, btn) {
        btn.disabled = true;
        fetch('{{ route("azmedia.portal.graduations.toggle", $graduation->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ field: field })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            if (data.success) {
                // Update button style
                if (data.value) {
                    btn.classList.remove('bg-slate-200', 'text-slate-600', 'text-slate-700', 'bg-rose-500');
                    btn.classList.add('bg-emerald-500', 'text-white');
                    btn.innerText = 'Đã xong';
                } else {
                    btn.classList.remove('bg-emerald-500', 'text-white');
                    btn.classList.add('bg-slate-200', 'text-slate-600');
                    btn.innerText = 'Chưa xong';
                }

                // Update progress bar
                if (data.progress !== undefined) {
                    document.getElementById('progress-text').innerText = data.progress + '%';
                    document.getElementById('progress-bar').style.width = data.progress + '%';
                }
            }
        })
        .catch(err => {
            btn.disabled = false;
            console.error(err);
        });
    }
</script>
@endpush
@endsection
