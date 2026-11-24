@extends('azmedia.layouts.app')

@section('title', 'Chuẩn Đầu Ra Thực Tập Sinh – AZ Media Đà Nẵng')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Banner Thông Báo Chính Thức Từ Ban Điều Hành -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-orange-950 text-white p-8 sm:p-10 shadow-2xl border border-orange-500/20">
            <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-brand-500/20 text-brand-400 border border-brand-500/30">
                        <i class="fa-solid fa-bullhorn text-brand-400 animate-bounce"></i>
                        THÔNG BÁO TỔNG HỢP CÔNG VIỆC CHUẨN ĐẦU RA – TTS AZ MEDIA
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                        Chuẩn Đầu Ra & Hồ Sơ Báo Cáo Thực Tập
                    </h1>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        <span class="text-brand-400 font-semibold">(Thay mặt anh Lê Đình Quang – Ban Điều Hành AZ MEDIA)</span><br>
                        Để hoàn tất chuẩn đầu ra và được nhận báo cáo, ký nhận mộc thực tập, các bạn TTS cần hoàn thành đầy đủ <strong>3 mục tiêu chuẩn bắt buộc</strong>: Khảo sát, Nộp báo cáo 4 bước (Cổng AZ SUPPORT & Giới thiệu 1+1), Video & Đánh giá 5 kênh của công ty.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a href="#az-support-portal" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold text-sm shadow-lg hover:shadow-orange-500/30 hover:scale-105 transition">
                        <i class="fa-solid fa-headset"></i> Cổng AZ SUPPORT
                    </a>
                    <a href="#graduation-checklist" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-slate-800/80 hover:bg-slate-700 text-slate-200 font-semibold text-sm border border-slate-700 transition">
                        <i class="fa-solid fa-list-check text-brand-400"></i> Xem Checklist 3 Mục
                    </a>
                </div>
            </div>
        </div>

        <!-- Thanh Thông Tin Tài Khoản Thực Tập Sinh Đang Đăng Nhập -->
        @if(Session::has('intern_user'))
            @php $intern = Session::get('intern_user'); @endphp
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-2xl p-4 border border-orange-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl gradient-brand text-white font-extrabold flex items-center justify-center text-sm shadow">
                        {{ mb_substr($intern['name'], 0, 1) }}
                    </span>
                    <div>
                        <div class="font-extrabold text-slate-900 flex items-center gap-2">
                            <span>Tài khoản TTS: {{ $intern['name'] }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold border border-emerald-200">
                                <i class="fa-solid fa-circle-check mr-0.5"></i> Đã đăng nhập
                            </span>
                        </div>
                        <div class="text-[11px] text-slate-500">
                            Email: <strong>{{ $intern['email'] }}</strong> • Trường: <strong>{{ $intern['university'] }}</strong>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('azmedia.intern.dashboard') }}" class="px-3.5 py-2 rounded-xl bg-white text-brand-700 hover:bg-orange-100 font-bold border border-orange-200 transition flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-id-badge"></i> Bảng điều khiển TTS
                    </a>
                    <a href="{{ route('azmedia.intern.logout') }}" class="px-3.5 py-2 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold border border-rose-200 transition flex items-center gap-1">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
                    </a>
                </div>
            </div>
        @endif

        <!-- Thanh Tra Cứu Tiến Độ Chuẩn Đầu Ra Của Thực Tập Sinh -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <div class="space-y-1 text-center lg:text-left">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 flex items-center justify-center lg:justify-start gap-2">
                        <i class="fa-solid fa-magnifying-glass text-brand-600"></i> Tra Cứu Tiến Độ Chuẩn Đầu Ra TTS
                    </h2>
                    <p class="text-xs text-slate-500">
                        Nhập Mã TTS (ví dụ: <span class="font-mono text-brand-600 font-bold">CDR-2026-0001</span>), Mã sinh viên, Mã hồ sơ (<span class="font-mono text-brand-600 font-bold">AZ-2026-0732</span>), Email hoặc Số điện thoại của bạn.
                    </p>
                </div>

                <form action="{{ route('azmedia.graduation.search') }}" method="POST" class="w-full lg:w-1/2 flex items-center gap-2">
                    @csrf
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <input type="text" name="keyword" value="{{ $keyword }}" required
                               placeholder="Nhập Mã TTS / Mã SV / Email / SĐT..."
                               class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm font-medium">
                    </div>
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-sm shadow transition flex items-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-search"></i> Tra cứu
                    </button>
                </form>
            </div>

            <!-- Gợi ý tra cứu nhanh -->
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="font-semibold text-slate-700"><i class="fa-solid fa-lightbulb text-amber-500 mr-1"></i> Hồ sơ mẫu kiểm tra:</span>
                <a href="{{ route('azmedia.graduation.index', ['code' => 'CDR-2026-0001']) }}" class="px-3 py-1 rounded-xl bg-orange-50 text-brand-700 border border-orange-200 hover:bg-orange-100 transition font-mono">
                    CDR-2026-0001 (Nguyễn Thị Thanh Hằng - ĐH Đông Á)
                </a>
                <a href="{{ route('azmedia.graduation.index', ['code' => 'CDR-2026-0002']) }}" class="px-3 py-1 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition font-mono">
                    CDR-2026-0002 (Phan Nhật Duy - ĐH FPT)
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center gap-3 shadow-sm animate-fade-in">
                <i class="fa-solid fa-circle-check text-emerald-600 text-xl flex-shrink-0"></i>
                <div class="flex-1">{{ session('success') }}</div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-semibold space-y-1 shadow-sm">
                <div class="flex items-center gap-2 text-rose-700 font-bold">
                    <i class="fa-solid fa-triangle-exclamation"></i> Vui lòng kiểm tra lại thông tin:
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-800">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Card Thông Tin Tiến Độ Của TTS (Nếu tìm thấy hồ sơ) -->
        @if($graduation)
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-500 to-orange-600 text-white font-extrabold text-2xl flex items-center justify-center shadow-md">
                            {{ mb_substr($graduation->student_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">{{ $graduation->student_name }}</h2>
                                <span class="px-3 py-1 rounded-full text-xs font-extrabold border {{ $graduation->status_badge['class'] }}">
                                    {{ $graduation->status_badge['label'] }}
                                </span>
                            </div>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-xs text-slate-500">
                                <span><i class="fa-solid fa-barcode text-brand-500 mr-1"></i> Mã CDR: <strong>{{ $graduation->graduation_code }}</strong></span>
                                @if($graduation->student_code)
                                    <span><i class="fa-solid fa-id-card text-brand-500 mr-1"></i> Mã SV: <strong>{{ $graduation->student_code }}</strong></span>
                                @endif
                                <span><i class="fa-solid fa-building-columns text-brand-500 mr-1"></i> {{ $graduation->school }}</span>
                                <span><i class="fa-solid fa-briefcase text-brand-500 mr-1"></i> {{ $graduation->intern_position }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 min-w-[220px]">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span>Tiến độ hoàn thành:</span>
                            <span class="text-brand-600 text-sm font-extrabold">{{ $graduation->progress_percent }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-orange-500 to-brand-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $graduation->progress_percent }}%"></div>
                        </div>
                        <div class="text-[10px] text-slate-400 mt-1.5 text-right">
                            {{ $graduation->progress_percent >= 100 ? '✅ Đã hoàn tất các tiêu chí' : '⏳ Cần hoàn thiện nốt các mục còn thiếu' }}
                        </div>
                    </div>
                </div>

                @if($graduation->admin_notes)
                    <div class="p-4 rounded-2xl bg-orange-50 border border-orange-200 text-slate-800 text-xs space-y-1">
                        <div class="font-bold text-brand-700 flex items-center gap-2">
                            <i class="fa-solid fa-comment-dots text-base"></i> Phản hồi từ Ban Điều Hành AZ Media:
                        </div>
                        <p class="leading-relaxed text-slate-700 pl-6">{{ $graduation->admin_notes }}</p>
                        @if($graduation->approved_by)
                            <div class="text-[11px] text-slate-500 pl-6 pt-1">
                                Người phê duyệt: <strong>{{ $graduation->approved_by }}</strong>
                                @if($graduation->approved_at)
                                    ({{ $graduation->approved_at->format('d/m/Y H:i') }})
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <!-- ================================================================= -->
        <!-- MÔ PHỎNG CHUẨN CỔNG HỖ TRỢ CHÍNH THỨC AZ SUPPORT (THEO ẢNH 1 & 3) -->
        <!-- ================================================================= -->
        <div id="az-support-portal" class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-200 space-y-8">
            <div class="text-center max-w-xl mx-auto space-y-3">
                <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-orange-50 mb-2">
                    <img src="{{ asset('uploads/az-homes-logo.png') }}" alt="AZ Media Logo" class="h-16 w-auto object-contain">
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-orange-600 tracking-tight">
                    AZ SUPPORT
                </h2>
                <div class="inline-block px-6 py-2 rounded-xl bg-emerald-600 text-white font-extrabold text-xs shadow-md uppercase tracking-wider">
                    Cổng hỗ trợ chính thức của AZ Media
                </div>
                <p class="text-xs text-slate-500">
                    Chọn các cổng dịch vụ trực tuyến dành cho thực tập sinh và ứng viên AZ Media
                </p>
            </div>

            <!-- Lưới 8 Nút Dịch Vụ Chuẩn Màu Cam Nhận Diện AZ SUPPORT -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-3xl mx-auto">
                <!-- 1. Đăng ký khóa học -->
                <button type="button" onclick="alert('Cổng đăng ký khóa học đang cập nhật các lớp đào tạo mới nhất!')"
                        class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="text-base font-bold">Đăng ký khóa học</div>
                        <div class="text-[11px] text-white/80 font-normal">Các khóa Marketing & Digital Skills</div>
                    </div>
                </button>

                <!-- 2. Đăng ký thực tập (1+1) -> Bấm vào cuộn xuống Form 1+1 -->
                <a href="#section-referral"
                   class="relative flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left group">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div class="flex-1">
                        <div class="text-base font-bold flex items-center gap-2">
                            Đăng ký thực tập
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-white text-orange-600 font-extrabold">Mục 1+1</span>
                        </div>
                        <div class="text-[11px] text-white/80 font-normal">Giới thiệu 01 bạn bè đợt sau</div>
                    </div>
                    <i class="fa-solid fa-arrow-down text-white/60 group-hover:translate-y-1 transition"></i>
                </a>

                <!-- 3. Tài liệu -->
                <a href="{{ $config['survey_intro_link'] }}" target="_blank"
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <div>
                        <div class="text-base font-bold">Tài liệu</div>
                        <div class="text-[11px] text-white/80 font-normal">Giới thiệu & Văn hóa doanh nghiệp AZ</div>
                    </div>
                </a>

                <!-- 4. Yêu cầu hỗ trợ -->
                <a href="tel:0968825068"
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <div class="text-base font-bold">Yêu cầu hỗ trợ</div>
                        <div class="text-[11px] text-white/80 font-normal">Hotline / Zalo: 0968.825.068</div>
                    </div>
                </a>

                <!-- 5. Đặt lịch hẹn (Bước 3) -> Bấm vào cuộn xuống Form Đặt lịch hẹn -->
                <a href="#section-appointment"
                   class="relative flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left group">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="flex-1">
                        <div class="text-base font-bold flex items-center gap-2">
                            Đặt lịch hẹn
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-white text-orange-600 font-extrabold">Bước 3</span>
                        </div>
                        <div class="text-[11px] text-white/80 font-normal">Lịch nộp bài & nhận kết quả (3-7 ngày)</div>
                    </div>
                    <i class="fa-solid fa-arrow-down text-white/60 group-hover:translate-y-1 transition"></i>
                </a>

                <!-- 6. Đánh giá & Góp ý -->
                <a href="#section-reviews"
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <div>
                        <div class="text-base font-bold">Đánh giá & Góp ý</div>
                        <div class="text-[11px] text-white/80 font-normal">Đánh giá 5 kênh của công ty</div>
                    </div>
                </a>

                <!-- 7. Khiếu nại -->
                <a href="mailto:contact@azmedia.com.vn?subject=[Khiếu Nại TTS] Chuẩn đầu ra"
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="text-base font-bold">Khiếu nại</div>
                        <div class="text-[11px] text-white/80 font-normal">Hộp thư BĐH: contact@azmedia.com.vn</div>
                    </div>
                </a>

                <!-- 8. Hướng dẫn -->
                <a href="#graduation-checklist"
                   class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-extrabold text-sm shadow-md hover:shadow-orange-500/40 hover:-translate-y-0.5 transition active:scale-95 text-left">
                    <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <div>
                        <div class="text-base font-bold">Hướng dẫn</div>
                        <div class="text-[11px] text-white/80 font-normal">Quy trình nộp báo cáo & ký mộc</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- FORM ĐẶT LỊCH HẸN ĐÃ NỘP BÀI (MÔ PHỎNG CHUẨN 100% THEO ẢNH 2)    -->
        <!-- ================================================================= -->
        <div id="section-appointment" class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-200">
            <div class="max-w-2xl mx-auto space-y-6">
                <!-- Header Form -->
                <div class="text-center space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                        <i class="fa-solid fa-calendar-day"></i> BƯỚC 3: CỔNG HỖ TRỢ (AZ SUPPORT)
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center justify-center gap-2">
                        Đặt lịch hẹn
                        <span class="text-amber-500 text-xl">☀️</span>
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        ⏳ Chờ <strong>3 – 7 ngày</strong> để xử lý kết quả. Mục ngày hẹn: <em>Lấy ngày mình nộp báo cáo</em>.
                    </p>
                </div>

                <form action="{{ route('azmedia.graduation.appointment') }}" method="POST" class="space-y-4">
                    @csrf
                    @if($graduation)
                        <input type="hidden" name="graduation_code" value="{{ $graduation->graduation_code }}">
                    @else
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Mã TTS của bạn <span class="text-rose-500">*</span></label>
                            <input type="text" name="graduation_code" required placeholder="Nhập mã CDR (VD: CDR-2026-0001)"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    @endif

                    <!-- Họ và tên -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Họ và tên <span class="text-rose-500">*</span></label>
                        <input type="text" name="appointment_name" required
                               value="{{ $graduation->appointment_name ?? $graduation->student_name ?? '' }}"
                               placeholder="Tên người nộp báo cáo (vd: Nguyễn Thị Thanh Hằng)"
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <!-- Số điện thoại -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại <span class="text-rose-500">*</span></label>
                        <input type="text" name="appointment_phone" required
                               value="{{ $graduation->appointment_phone ?? $graduation->phone ?? '' }}"
                               placeholder="sdt của Hằng: 0843619219"
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="appointment_email" required
                               value="{{ $graduation->appointment_email ?? $graduation->email ?? '' }}"
                               placeholder="email của Hằng: Hn2500215@gmail.com"
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <!-- Đội ngũ -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Đội ngũ</label>
                        <input type="text" name="appointment_team" readonly
                               value="{{ $graduation->appointment_team ?? 'Gặp hỗ trợ viên' }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 text-sm font-semibold">
                    </div>

                    <!-- Dịch vụ -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Dịch vụ</label>
                        <input type="text" name="appointment_service" readonly
                               value="{{ $graduation->appointment_service ?? 'Thực tập sinh' }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 text-sm font-semibold">
                    </div>

                    <!-- Ngày -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                            <span>Ngày hẹn nộp báo cáo <span class="text-rose-500">*</span></span>
                            <span class="text-[11px] text-brand-600 font-semibold">👉 Lấy ngày mình nộp báo cáo</span>
                        </label>
                        <input type="text" name="appointment_date" required
                               value="{{ $graduation->appointment_date ?? '09/07/2026' }}"
                               placeholder="dd/mm/yyyy (vd: 09/07/2026)"
                               class="w-full px-4 py-3 rounded-xl border-2 border-brand-300 bg-orange-50/50 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <!-- Giờ -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Giờ <span class="text-rose-500">*</span></label>
                        <input type="text" name="appointment_time" required
                               value="{{ $graduation->appointment_time ?? '09:00' }}"
                               placeholder="hh:mm (vd: 09:00)"
                               class="w-full px-4 py-3 rounded-xl border border-purple-300 focus:border-purple-500 text-sm font-bold text-slate-800 focus:ring-2 focus:ring-purple-200 focus:outline-none">
                    </div>

                    <!-- Cloudflare Turnstile Badge (Mô phỏng như ảnh 2) -->
                    <div class="py-2">
                        <div class="inline-flex items-center gap-3 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-xs">
                            <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="font-bold text-slate-700">Thành công!</span>
                            <span class="text-slate-400">|</span>
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                                <i class="fa-brands fa-cloudflare text-amber-500 text-base"></i>
                                <span>CLOUDFLARE</span>
                            </div>
                        </div>
                    </div>

                    <!-- Nút Submit -->
                    <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-extrabold text-base shadow-lg transition active:scale-98">
                        <i class="fa-solid fa-calendar-check mr-2"></i> Xác Nhận Đặt Lịch Hẹn Đã Nộp Bài
                    </button>
                </form>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- FORM ĐĂNG KÝ THỰC TẬP 1+1 (MÔ PHỎNG CHUẨN 100% THEO ẢNH 4)       -->
        <!-- ================================================================= -->
        <div id="section-referral" class="bg-white rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-200">
            <div class="max-w-2xl mx-auto space-y-6">
                <!-- Header Banner Cam chỉ dẫn theo đúng ảnh 4 -->
                <div class="p-4 rounded-2xl bg-orange-600 text-white text-center font-extrabold text-xs sm:text-sm shadow-md">
                    Tên người nộp + Tên người mình sẽ giới thiệu cho đợt sau (A) + SĐT của A + Email của A
                </div>

                <div class="text-center space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                        <i class="fa-solid fa-user-plus"></i> BƯỚC 4: THỰC HIỆN 1+1 (BẮT BUỘC)
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        ĐĂNG KÝ THỰC TẬP (1+1)
                    </h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        📌 Giới thiệu <strong>01 sinh viên</strong> (cùng khoa / trường) cho AZ Homes để phòng HCNS hỗ trợ kết nối việc làm & thực tập.<br>
                        <em>Chỉ khi hoàn thành đầy đủ mục 1+1 thì TTS mới được xác nhận là đã nộp báo cáo.</em>
                    </p>
                </div>

                <form action="{{ route('azmedia.graduation.referral') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @if($graduation)
                        <input type="hidden" name="graduation_code" value="{{ $graduation->graduation_code }}">
                    @else
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Mã TTS của bạn <span class="text-rose-500">*</span></label>
                            <input type="text" name="graduation_code" required placeholder="Nhập mã CDR (VD: CDR-2026-0001)"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    @endif

                    <!-- Họ và tên -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Họ và tên <span class="text-rose-500">*</span></label>
                        <input type="text" name="referral_full_info" required
                               value="{{ $graduation->referral_full_info ?? '' }}"
                               placeholder="Tên người nộp + Tên người mình sẽ giới thiệu (vd: Nguyễn Thị Thanh Hằng + Trần Mai Phương)"
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <!-- Số điện thoại -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại <span class="text-rose-500">*</span></label>
                        <input type="text" name="referral_phone" required
                               value="{{ $graduation->referral_phone ?? '' }}"
                               placeholder="Số điện thoại của người được giới thiệu (A)"
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="referral_email" required
                               value="{{ $graduation->referral_email ?? '' }}"
                               placeholder="Email của người được giới thiệu (A)"
                               class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Trường -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Trường <span class="text-rose-500">*</span></label>
                            <input type="text" name="referral_school" required
                                   value="{{ $graduation->referral_school ?? $graduation->school ?? '' }}"
                                   placeholder="Trường của bạn A (vd: ĐH Đông Á)"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>

                        <!-- Ngành -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ngành <span class="text-rose-500">*</span></label>
                            <input type="text" name="referral_major" required
                                   value="{{ $graduation->referral_major ?? '' }}"
                                   placeholder="Ngành của bạn A (vd: Marketing / CNTT)"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    </div>

                    <!-- Vị trí thực tập -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Vị trí thực tập <span class="text-rose-500">*</span></label>
                        <input type="text" name="referral_position" required
                               value="{{ $graduation->referral_position ?? '' }}"
                               placeholder="Vị trí bạn A muốn ứng tuyển (vd: TTS Marketing Online / Web)"
                               class="w-full px-4 py-3 rounded-xl border-2 border-purple-200 focus:border-purple-500 text-sm font-semibold focus:ring-2 focus:ring-purple-200 focus:outline-none">
                    </div>

                    <!-- Upload CV hoặc Ảnh -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Upload CV hoặc Ảnh (PDF, JPG, PNG - tối đa 10MB)
                        </label>
                        <input type="file" name="cv_file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-50 file:text-brand-700 hover:file:bg-orange-100 cursor-pointer border border-slate-300 rounded-xl p-1">
                        @if($graduation && $graduation->referral_cv_file)
                            <div class="mt-2 text-xs text-emerald-600 font-semibold flex items-center gap-1.5">
                                <i class="fa-solid fa-file-circle-check"></i> Đã tải lên file: 
                                <span class="font-mono text-slate-700">{{ basename($graduation->referral_cv_file) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Cloudflare Badge -->
                    <div class="py-2">
                        <div class="inline-flex items-center gap-3 px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-xs">
                            <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="font-bold text-slate-700">Thành công!</span>
                            <span class="text-slate-400">|</span>
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                                <i class="fa-brands fa-cloudflare text-amber-500 text-base"></i>
                                <span>CLOUDFLARE</span>
                            </div>
                        </div>
                    </div>

                    <!-- Nút Submit màu cam đúng như ảnh 4 -->
                    <button type="submit" class="w-full py-4 rounded-2xl bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-base shadow-lg transition active:scale-98">
                        Đăng Ký
                    </button>
                </form>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- CHECKLIST 3 MỤC TIÊU CHUẨN ĐẦU RA CHI TIẾT (THEO THÔNG BÁO)        -->
        <!-- ================================================================= -->
        <div id="graduation-checklist" class="space-y-8">
            <div class="text-center space-y-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-brand-100 text-brand-800">DANH MỤC TIÊU CHUẨN</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Chi Tiết 3 Hạng Mục Chuẩn Đầu Ra</h2>
                <p class="text-xs text-slate-500">Thực tập sinh tích chọn các mục đã hoàn tất và lưu đường link minh chứng</p>
            </div>

            @if($graduation)
                <form action="{{ route('azmedia.graduation.update') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="graduation_code" value="{{ $graduation->graduation_code }}">

                    <!-- MỤC 1: KHẢO SÁT -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                        <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg">
                                    1
                                </div>
                                <div>
                                    <h3 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                                        Mục 1: Khảo Sát
                                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                    </h3>
                                    <p class="text-xs text-slate-500">Hoàn thành 2 link khảo sát và nộp ảnh minh chứng vào Google Drive</p>
                                </div>
                            </div>
                            <a href="{{ $config['survey_intro_link'] }}" target="_blank" class="text-xs text-brand-600 hover:text-brand-800 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Xem giới thiệu AZ Media
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="survey_1_completed" value="1" {{ $graduation->survey_1_completed ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 rounded text-brand-600 focus:ring-brand-500">
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">(1) Bản Khảo Sát Số 1</div>
                                        <p class="text-xs text-slate-500">Khảo sát đánh giá trải nghiệm và văn hóa doanh nghiệp</p>
                                    </div>
                                </label>
                                <a href="{{ $config['survey_link_1'] }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:underline pt-1">
                                    <i class="fa-solid fa-external-link text-[10px]"></i> Mở Google Form (1)
                                </a>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="survey_2_completed" value="1" {{ $graduation->survey_2_completed ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 rounded text-brand-600 focus:ring-brand-500">
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">(2) Bản Khảo Sát Số 2</div>
                                        <p class="text-xs text-slate-500">Khảo sát định hướng nghề nghiệp và kỹ năng thực tập sinh</p>
                                    </div>
                                </label>
                                <a href="{{ $config['survey_link_2'] }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:underline pt-1">
                                    <i class="fa-solid fa-external-link text-[10px]"></i> Mở Google Form (2)
                                </a>
                            </div>
                        </div>

                        <!-- Link Drive Nộp Minh Chứng 2 Bản Khảo Sát -->
                        <div class="p-4 rounded-2xl bg-orange-50 border border-orange-200 space-y-2">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <span class="text-xs font-bold text-slate-800 flex items-center gap-2">
                                    <i class="fa-brands fa-google-drive text-amber-600 text-base"></i> Thư mục Drive nộp minh chứng 2 bản khảo sát:
                                </span>
                                <a href="{{ $config['survey_proof_folder'] }}" target="_blank" class="text-xs font-extrabold text-brand-600 hover:underline flex items-center gap-1">
                                    <i class="fa-solid fa-folder-open"></i> Mở Folder Drive Công Ty
                                </a>
                            </div>
                            <input type="url" name="survey_proof_link" value="{{ $graduation->survey_proof_link ?? '' }}"
                                   placeholder="Dán link Google Drive ảnh chụp màn hình hoàn thành khảo sát của bạn tại đây..."
                                   class="w-full px-4 py-2.5 rounded-xl border border-orange-300 bg-white text-xs font-mono focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    </div>

                    <!-- MỤC 2: NỘP BÁO CÁO (4 BƯỚC) -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg">
                                2
                            </div>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                                    Mục 2: Nộp Báo Cáo Thực Tập (4 Bước)
                                    <i class="fa-solid fa-file-signature text-blue-500"></i>
                                </h3>
                                <p class="text-xs text-slate-500">Thực hiện đầy đủ 4 bước quy định để được duyệt báo cáo và cấp dấu mộc</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Bước 1 -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-lg bg-orange-100 text-orange-800 text-[11px] font-extrabold">BƯỚC 1: BẢN THẢO</span>
                                    <span class="text-[11px] font-semibold text-rose-600">Trước {{ $config['report_step1_deadline'] }}</span>
                                </div>
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="report_draft_submitted" value="1" {{ $graduation->report_draft_submitted ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 rounded text-brand-600 focus:ring-brand-500">
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">Nộp Báo Cáo Bản Thảo (File Mềm)</div>
                                        <p class="text-xs text-slate-500 mt-1">
                                            Yêu cầu đặt tên file: <code class="px-1.5 py-0.5 rounded bg-slate-200 text-brand-700 font-bold font-mono">HọTên_Vị trí thực tập_MãSinhViên</code>
                                        </p>
                                    </div>
                                </label>
                                <a href="{{ $config['report_step1_form'] }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-brand-600 hover:bg-slate-50 shadow-sm">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Link nộp Form Bản Thảo
                                </a>
                            </div>

                            <!-- Bước 2 -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800 text-[11px] font-extrabold">BƯỚC 2: BẢN CHỈNH SỬA CUỐI</span>
                                    <span class="text-[11px] font-semibold text-emerald-600">Sau khi duyệt</span>
                                </div>
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="report_final_submitted" value="1" {{ $graduation->report_final_submitted ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 rounded text-brand-600 focus:ring-brand-500">
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">Nộp File Báo Cáo Chỉnh Sửa Lần Cuối</div>
                                        <p class="text-xs text-slate-500 mt-1">
                                            Nộp qua Google Form và chuẩn bị bản cứng theo trường.
                                        </p>
                                    </div>
                                </label>
                                <a href="{{ $config['report_step2_form'] }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-blue-600 hover:bg-slate-50 shadow-sm">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Link nộp Form Bản Sửa Cuối
                                </a>
                            </div>
                        </div>

                        <!-- Hướng dẫn nộp bản cứng riêng cho FPT và ĐH Đông Á -->
                        <div class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-xs space-y-2">
                            <div class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-stamp text-brand-600"></i> Hướng dẫn nộp bản cứng lên công ty (84 Nguyễn Hữu Dật, Đà Nẵng):
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <div class="p-3 rounded-xl bg-white border border-slate-200">
                                    <span class="font-bold text-orange-700">🎓 Đối với ĐH FPT:</span>
                                    <p class="text-slate-600 mt-0.5">Phải mang lên trường đóng dấu mộc trước, rồi mới mang nộp lên văn phòng công ty AZ Media.</p>
                                </div>
                                <div class="p-3 rounded-xl bg-white border border-slate-200">
                                    <span class="font-bold text-blue-700">🏛️ Đối với ĐH Đông Á:</span>
                                    <p class="text-slate-600 mt-0.5">In 2 bản cứng: 1 bản nộp cho doanh nghiệp AZ Media và 1 bản nộp cho nhà trường.</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-2 pt-2 cursor-pointer font-bold text-slate-800">
                                <input type="checkbox" name="hard_copy_submitted" value="1" {{ $graduation->hard_copy_submitted ? 'checked' : '' }}
                                       class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                                <span>Đã nộp đầy đủ bản cứng có dấu mộc theo quy định của trường</span>
                            </label>
                        </div>

                        <!-- Trạng thái Bước 3 & Bước 4 -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-2xl border {{ $graduation->appointment_booked ? 'bg-emerald-50 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-sm text-slate-800">Bước 3: Đặt lịch hẹn</span>
                                    @if($graduation->appointment_booked)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">✅ Đã đặt hẹn</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Chưa đặt</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    @if($graduation->appointment_booked)
                                        Ngày hẹn: <strong>{{ $graduation->appointment_date }}</strong> lúc <strong>{{ $graduation->appointment_time }}</strong>
                                    @else
                                        Chưa đặt lịch hẹn nộp bài trên Cổng AZ SUPPORT.
                                    @endif
                                </p>
                                <a href="#section-appointment" class="inline-flex items-center gap-1 text-xs font-bold text-brand-600 hover:underline mt-2">
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i> Điền Form Đặt Lịch Hẹn
                                </a>
                            </div>

                            <div class="p-4 rounded-2xl border {{ $graduation->referral_completed ? 'bg-emerald-50 border-emerald-200' : 'bg-slate-50 border-slate-200' }}">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-sm text-slate-800">Bước 4: Thực hiện 1+1</span>
                                    @if($graduation->referral_completed)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">✅ Đã hoàn thành 1+1</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">Bắt buộc</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 mt-1">
                                    @if($graduation->referral_completed)
                                        Người được giới thiệu: <strong>{{ $graduation->referral_full_info }}</strong>
                                    @else
                                        Cần giới thiệu 01 sinh viên đợt sau để hoàn tất chuẩn nộp bài.
                                    @endif
                                </p>
                                <a href="#section-referral" class="inline-flex items-center gap-1 text-xs font-bold text-orange-600 hover:underline mt-2">
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i> Điền Form Đăng Ký 1+1
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- MỤC 3: VIDEO, FILE WORD VÀ ĐÁNH GIÁ 5 KÊNH -->
                    <div id="section-reviews" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-lg">
                                3
                            </div>
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                                    Mục 3: Video, File Word và Đánh Giá 5 Kênh Của Công Ty
                                    <i class="fa-solid fa-star text-amber-500"></i>
                                </h3>
                                <p class="text-xs text-slate-500">Đăng video cá nhân, 1-2 hình ảnh thực tập tại công ty và review 5 kênh</p>
                            </div>
                        </div>

                        <!-- 3.1 & 3.2: File Word & Video -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 3.1 File Word -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-100 text-indigo-800 text-[11px] font-extrabold">3.1. FILE WORD TỔNG KẾT</span>
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="word_report_submitted" value="1" {{ $graduation->word_report_submitted ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 rounded text-brand-600 focus:ring-brand-500">
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">Gộp 3 nội dung vào 01 file Word:</div>
                                        <ul class="text-xs text-slate-600 list-disc list-inside space-y-0.5 mt-1.5">
                                            <li>Những điều đã học được</li>
                                            <li>Những việc đã làm được</li>
                                            <li>Cảm nhận bản thân về công ty (Facebook, GG Maps, văn bản)</li>
                                        </ul>
                                    </div>
                                </label>
                                <input type="url" name="word_report_link" value="{{ $graduation->word_report_link ?? '' }}"
                                       placeholder="Dán link Drive file Word của bạn..."
                                       class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs font-mono focus:ring-2 focus:ring-brand-500 focus:outline-none">
                            </div>

                            <!-- 3.2 Video -->
                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-800 text-[11px] font-extrabold">3.2. VIDEO CÁ NHÂN & NHÓM</span>
                                    <a href="{{ $config['video_proof_folder'] }}" target="_blank" class="text-xs font-bold text-brand-600 hover:underline">
                                        <i class="fa-solid fa-folder-open"></i> Link Folder Drive
                                    </a>
                                </div>
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" name="video_submitted" value="1" {{ $graduation->video_submitted ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 rounded text-brand-600 focus:ring-brand-500">
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">Hoàn thành Video cá nhân & Video nhóm</div>
                                        <p class="text-xs text-slate-500 mt-1">Quay clip cảm nhận thực tập và video hoạt động nhóm tại AZ Media.</p>
                                    </div>
                                </label>
                                <input type="url" name="video_link" value="{{ $graduation->video_link ?? '' }}"
                                       placeholder="Dán link Drive video của bạn..."
                                       class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white text-xs font-mono focus:ring-2 focus:ring-brand-500 focus:outline-none">
                            </div>
                        </div>

                        <!-- 3.3 Đánh giá 5 kênh công ty -->
                        <div class="space-y-4 pt-2">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <span class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                                    <i class="fa-solid fa-thumbs-up text-brand-600"></i> 3.3. Đánh Giá Đủ 5 Kênh Của Công Ty (Bắt buộc kèm video đã duyệt & 1-2 ảnh)
                                </span>
                                <a href="{{ $config['review_proof_folder'] }}" target="_blank" class="text-xs font-extrabold text-brand-600 hover:underline flex items-center gap-1">
                                    <i class="fa-brands fa-google-drive"></i> Link Thư Mục Nộp Minh Chứng Review
                                </a>
                            </div>

                            <!-- Danh sách 5 kênh -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <!-- Kênh 1: GG Maps Chiến Thắng Bằng Tốc Độ -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                                    <label class="flex items-start gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="review_map1" value="1" {{ $graduation->review_map1 ? 'checked' : '' }}
                                               class="mt-0.5 w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                                        <div>
                                            <div class="text-xs font-extrabold text-slate-800">Google Maps 1:</div>
                                            <div class="text-xs text-slate-600 font-semibold">{{ $config['review_channels']['map1']['name'] }}</div>
                                        </div>
                                    </label>
                                    <a href="{{ $config['review_channels']['map1']['link'] }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-200 hover:bg-emerald-100 transition">
                                        <i class="fa-solid fa-location-dot"></i> Mở Maps Đánh Giá
                                    </a>
                                </div>

                                <!-- Kênh 2: GG Maps Văn Phòng AZ Media -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                                    <label class="flex items-start gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="review_map2" value="1" {{ $graduation->review_map2 ? 'checked' : '' }}
                                               class="mt-0.5 w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                                        <div>
                                            <div class="text-xs font-extrabold text-slate-800">Google Maps 2:</div>
                                            <div class="text-xs text-slate-600 font-semibold">{{ $config['review_channels']['map2']['name'] }}</div>
                                        </div>
                                    </label>
                                    <a href="{{ $config['review_channels']['map2']['link'] }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-200 hover:bg-blue-100 transition">
                                        <i class="fa-solid fa-map-pin"></i> Mở Maps Đánh Giá
                                    </a>
                                </div>

                                <!-- Kênh 3: Fanpage AZ HOMES -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                                    <label class="flex items-start gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="review_page_homes" value="1" {{ $graduation->review_page_homes ? 'checked' : '' }}
                                               class="mt-0.5 w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                                        <div>
                                            <div class="text-xs font-extrabold text-slate-800">Fanpage 1:</div>
                                            <div class="text-xs text-slate-600 font-semibold">{{ $config['review_channels']['page_homes']['name'] }}</div>
                                        </div>
                                    </label>
                                    <a href="{{ $config['review_channels']['page_homes']['link'] }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 text-[11px] font-bold border border-indigo-200 hover:bg-indigo-100 transition">
                                        <i class="fa-brands fa-facebook"></i> Mở Fanpage Đánh Giá
                                    </a>
                                </div>

                                <!-- Kênh 4: Fanpage AZ MEDIA -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                                    <label class="flex items-start gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="review_page_media" value="1" {{ $graduation->review_page_media ? 'checked' : '' }}
                                               class="mt-0.5 w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                                        <div>
                                            <div class="text-xs font-extrabold text-slate-800">Fanpage 2:</div>
                                            <div class="text-xs text-slate-600 font-semibold">{{ $config['review_channels']['page_media']['name'] }}</div>
                                        </div>
                                    </label>
                                    <a href="{{ $config['review_channels']['page_media']['link'] }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 text-sky-700 text-[11px] font-bold border border-sky-200 hover:bg-sky-100 transition">
                                        <i class="fa-brands fa-facebook"></i> Mở Fanpage Đánh Giá
                                    </a>
                                </div>

                                <!-- Kênh 5: Fanpage AZ Media HR -->
                                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-2 sm:col-span-2 lg:col-span-1">
                                    <label class="flex items-start gap-2.5 cursor-pointer">
                                        <input type="checkbox" name="review_page_hr" value="1" {{ $graduation->review_page_hr ? 'checked' : '' }}
                                               class="mt-0.5 w-4 h-4 rounded text-brand-600 focus:ring-brand-500">
                                        <div>
                                            <div class="text-xs font-extrabold text-slate-800">Fanpage 3:</div>
                                            <div class="text-xs text-slate-600 font-semibold">{{ $config['review_channels']['page_hr']['name'] }}</div>
                                        </div>
                                    </label>
                                    <a href="{{ $config['review_channels']['page_hr']['link'] }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-orange-50 text-orange-700 text-[11px] font-bold border border-orange-200 hover:bg-orange-100 transition">
                                        <i class="fa-brands fa-facebook"></i> Mở Fanpage Đánh Giá
                                    </a>
                                </div>
                            </div>

                            <!-- Ô nhập link nộp minh chứng ảnh review -->
                            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-2">
                                <label class="block text-xs font-bold text-amber-900">
                                    <i class="fa-solid fa-camera mr-1"></i> Link Folder Drive chứa ảnh chụp màn hình đánh giá đủ 5 kênh:
                                </label>
                                <input type="url" name="review_proof_link" value="{{ $graduation->review_proof_link ?? '' }}"
                                       placeholder="Dán link Google Drive chứa ảnh minh chứng review 5 kênh của bạn..."
                                       class="w-full px-4 py-2.5 rounded-xl border border-amber-300 bg-white text-xs font-mono focus:ring-2 focus:ring-brand-500 focus:outline-none">
                            </div>

                            <!-- Ảnh mẫu ví dụ đánh giá thực tế (Mô phỏng như ảnh 5) -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                                <div class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                    <i class="fa-solid fa-image text-brand-600"></i> Ví dụ hình ảnh đánh giá mẫu đã được công nhận:
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1 text-[11px] text-slate-600">
                                    <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                                        <div class="font-bold text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-star text-amber-400"></i> Google Maps 5.0★</div>
                                        <p>Đánh giá 5 sao kèm chia sẻ cảm nhận thực tế tại 127 Lê Trọng Tấn và ảnh họp nhóm công ty.</p>
                                    </div>
                                    <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                                        <div class="font-bold text-blue-700 flex items-center gap-1"><i class="fa-solid fa-thumbs-up text-blue-500"></i> Đề xuất Fanpage 98%</div>
                                        <p>Đề xuất trang kèm ảnh làm việc, không khí lớp đào tạo marketing và gắn thẻ công ty.</p>
                                    </div>
                                    <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                                        <div class="font-bold text-orange-700 flex items-center gap-1"><i class="fa-solid fa-video text-orange-500"></i> Video cá nhân</div>
                                        <p>Đăng kèm video chia sẻ ngắn những bài học và giá trị cốt lõi tiếp thu được trong kỳ thực tập.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hành động gửi duyệt -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 bg-slate-900 rounded-3xl text-white">
                        <div>
                            <div class="text-sm font-extrabold">Cập nhật tiến độ hồ sơ chuẩn đầu ra</div>
                            <p class="text-xs text-slate-400">Lưu lại tiến độ đã làm hoặc gửi yêu cầu để Ban Điều Hành kiểm tra & ký duyệt báo cáo.</p>
                        </div>
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button type="submit" name="save_only" value="1"
                                    class="flex-1 sm:flex-none px-5 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition">
                                <i class="fa-solid fa-floppy-disk mr-1"></i> Lưu Tiến Độ
                            </button>
                            <button type="submit" name="submit_for_review" value="1"
                                    class="flex-1 sm:flex-none px-6 py-3 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-xs font-extrabold shadow-lg transition">
                                <i class="fa-solid fa-paper-plane mr-1"></i> Gửi Ban Điều Hành Duyệt
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <!-- Khi chưa tra cứu hồ sơ -->
                <div class="bg-white rounded-3xl p-8 sm:p-12 text-center border border-dashed border-slate-300 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-orange-50 text-brand-600 text-2xl flex items-center justify-center mx-auto">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="space-y-1 max-w-md mx-auto">
                        <h3 class="text-lg font-extrabold text-slate-900">Vui lòng tra cứu Mã TTS để bắt đầu cập nhật</h3>
                        <p class="text-xs text-slate-500">
                            Nhập Mã hồ sơ tuyển dụng (<span class="font-mono text-brand-600 font-bold">AZ-2026-0732</span>), Mã sinh viên hoặc Email vào ô tra cứu phía trên để đồng bộ dữ liệu.
                        </p>
                    </div>
                    <a href="{{ route('azmedia.graduation.index', ['code' => 'CDR-2026-0001']) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow transition">
                        <i class="fa-solid fa-eye"></i> Xem Hồ Sơ Mẫu: CDR-2026-0001
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
