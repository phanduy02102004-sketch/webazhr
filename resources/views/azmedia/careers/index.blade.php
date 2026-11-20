@extends('azmedia.layouts.app')

@section('title', 'Tuyển Dụng Thực Tập Sinh 2026 - AZ Media Đà Nẵng')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-slate-900 text-white pt-16 pb-24 lg:pt-24 lg:pb-32">
    <!-- Decorative glow background -->
    <div class="absolute top-0 right-0 -mt-12 -mr-12 w-96 h-96 bg-brand-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Column: Heading & Pitch -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-800/90 border border-slate-700 text-brand-400 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-ping"></span>
                    Kỳ Thực Tập Sinh Tài Năng Đợt 2026 • Chi Nhánh Đà Nẵng
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Định hình tư duy <br>
                    <span class="text-gradient">Chinh phục thị trường số</span>
                </h1>

                <p class="text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
                    Chào mừng bạn đến với môi trường <strong>"Thầy giỏi - Bạn tốt - Sách hay"</strong> tại <strong>AZ Media Đà Nẵng</strong>. Nơi biến lý thuyết trên giảng đường thành hành động thực chiến, giúp bạn bứt phá từ một khởi đầu bình thường trở nên phi thường!
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="#positions" class="w-full sm:w-auto px-8 py-4 rounded-xl font-bold text-white gradient-brand shadow-lg shadow-brand-500/25 hover:shadow-xl hover:scale-[1.02] transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-briefcase"></i> Khám phá vị trí TTS
                    </a>
                    <a href="{{ route('azmedia.candidate.track') }}" class="w-full sm:w-auto px-7 py-4 rounded-xl font-bold text-slate-200 bg-slate-800 hover:bg-slate-700 border border-slate-700 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-brand-400"></i> Tra cứu tiến độ hồ sơ
                    </a>
                </div>

                <!-- Fast Info Badges -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-slate-800/80">
                    <div>
                        <div class="text-2xl font-extrabold text-white">300+</div>
                        <div class="text-xs text-slate-400">Doanh nghiệp tư vấn</div>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-brand-400">1.000+</div>
                        <div class="text-xs text-slate-400">Bạn trẻ đào tạo nghề</div>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-white">100+</div>
                        <div class="text-xs text-slate-400">Khóa đào tạo chuyên sâu</div>
                    </div>
                    <div>
                        <div class="text-2xl font-extrabold text-emerald-400">95%</div>
                        <div class="text-xs text-slate-400">Cấp dấu mộc thực tập</div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Lookup & Application Box -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-2xl border border-slate-100 text-slate-800">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-12 h-12 rounded-xl bg-orange-100 text-brand-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-lg text-slate-900">Tra cứu & Nộp đơn nhanh</h3>
                            <p class="text-xs text-slate-500">Dành riêng cho sinh viên thực tập các trường</p>
                        </div>
                    </div>

                    <!-- Fast Track Search Box -->
                    <form action="{{ route('azmedia.candidate.track.post') }}" method="POST" class="mb-6">
                        @csrf
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Bạn đã nộp đơn? Kiểm tra kết quả:
                        </label>
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-id-badge text-sm"></i>
                                </span>
                                <input type="text" name="keyword" required placeholder="Nhập Mã HS (AZ-2026-...) hoặc Email"
                                       class="w-full pl-9 pr-3 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                            </div>
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold transition flex items-center gap-1">
                                <i class="fa-solid fa-search"></i> Tra cứu
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            * Ví dụ mã mẫu: <a href="{{ route('azmedia.candidate.track', ['code' => 'AZ-2026-0732']) }}" class="text-brand-600 font-semibold hover:underline">AZ-2026-0732</a> (Linh Ân - DNC)
                        </p>
                    </form>

                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-3 text-xs uppercase font-bold text-slate-400">Hoặc</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <!-- Quick Apply Trigger -->
                    <div class="mt-4 bg-orange-50/70 rounded-xl p-4 border border-orange-100 text-center">
                        <p class="text-xs text-slate-600 mb-3">
                            Chưa nộp đơn? Nộp hồ sơ ngay chỉ với 1 bước tải CV PDF:
                        </p>
                        <button type="button" onclick="openApplyModal()" class="w-full py-3 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-md transition flex items-center justify-center gap-2 text-sm">
                            <i class="fa-solid fa-file-arrow-up"></i> Nộp hồ sơ ngay (Quick Apply)
                        </button>
                        <p class="text-[11px] text-slate-400 mt-2">Hỗ trợ sinh viên thực tập năm 2, 3, 4 hoặc mới tốt nghiệp</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Ý Nghĩa Thương Hiệu AZ MEDIA & 7 Giá Trị Cốt Lõi -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-orange-100 text-brand-700">
                Văn Hóa Doanh Nghiệp AZ MEDIA
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 mb-4">
                Ý Nghĩa Thương Hiệu & 7 Giá Trị Cốt Lõi
            </h2>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Được thành lập từ năm 2019, Chi nhánh AZ Media tại Đà Nẵng (84 Nguyễn Hữu Dật) là bệ phóng vững chắc giúp các bạn trẻ khai mở tư duy, rèn luyện kỹ năng và chinh phục thị trường số.
            </p>
        </div>

        <!-- 3 Trụ Cột: A - Z - M -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- A: Action -->
            <div class="bg-gradient-to-br from-orange-50 to-white p-8 rounded-2xl border border-orange-100 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl gradient-brand text-white flex items-center justify-center text-2xl font-black mb-6 shadow">
                    A
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">ACTION • HÀNH ĐỘNG</h3>
                <p class="text-sm font-semibold text-brand-600 mb-3">"Học lý thuyết để nắm rõ bản chất, hành động để thành công"</p>
                <p class="text-xs text-slate-600 leading-relaxed">
                    AZ Media lấy hành động làm trung tâm. Mọi kiến thức giảng dạy hay đào tạo thực tập sinh đều được đưa vào áp dụng trực tiếp trên các hệ thống thực tế.
                </p>
            </div>

            <!-- Z: Zoom -->
            <div class="bg-gradient-to-br from-slate-50 to-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-2xl font-black mb-6 shadow">
                    Z
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">ZOOM • PHÓNG TO TẦM NHÌN</h3>
                <p class="text-sm font-semibold text-slate-700 mb-3">Tầm nhìn xa trông rộng & Sự phát triển vượt bậc</p>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Đại diện cho hành động "phóng to", bứt phá giới hạn của bản thân. Đồng hành đưa doanh nghiệp từ nhỏ bé thành khổng lồ, đưa cá nhân từ bình thường sang phi thường.
                </p>
            </div>

            <!-- M: Media -->
            <div class="bg-gradient-to-br from-blue-50 to-white p-8 rounded-2xl border border-blue-100 shadow-sm hover:shadow-md transition">
                <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl font-black mb-6 shadow">
                    M
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">MEDIA • TRUYỀN THÔNG SỐ</h3>
                <p class="text-sm font-semibold text-blue-600 mb-3">Công cụ kết nối & Dữ liệu chuyển đổi số</p>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Media chính là những kênh truyền thông, công nghệ phần mềm, công cụ lưu trữ dữ liệu và giải pháp chuyển đổi số toàn diện kết nối doanh nghiệp với hàng triệu khách hàng.
                </p>
            </div>
        </div>

        <!-- 7 Giá Trị Cốt Lõi Grid -->
        <div id="core-values" class="bg-slate-50 rounded-3xl p-8 sm:p-12 border border-slate-100">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h3 class="text-2xl font-extrabold text-slate-900">7 Giá Trị Cốt Lõi AZ Media Cống Hiến</h3>
                <p class="text-xs text-slate-500 mt-2">Kim chỉ nam định hình môi trường làm việc và văn hóa ứng xử chuyên nghiệp</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- 1. Đạo đức -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <div class="text-brand-600 text-2xl mb-3"><i class="fa-solid fa-shield-heart"></i></div>
                    <h4 class="font-bold text-base text-slate-900 mb-1">1. Đạo đức</h4>
                    <p class="text-xs text-slate-600">Giá trị cốt lõi tối thượng, chân thành, trung thực, minh bạch và cam kết không bao giờ bỏ rơi đối tác.</p>
                </div>

                <!-- 2. Trí tuệ -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <div class="text-brand-600 text-2xl mb-3"><i class="fa-solid fa-brain"></i></div>
                    <h4 class="font-bold text-base text-slate-900 mb-1">2. Trí tuệ</h4>
                    <p class="text-xs text-slate-600">Tri thức là chìa khóa cạnh tranh. Không ngừng cập nhật Marketing, Công nghệ, AI và tư duy sáng tạo dám nghĩ dám làm.</p>
                </div>

                <!-- 3. Môi trường -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <div class="text-brand-600 text-2xl mb-3"><i class="fa-solid fa-seedling"></i></div>
                    <h4 class="font-bold text-base text-slate-900 mb-1">3. Môi trường</h4>
                    <p class="text-xs text-slate-600 font-semibold text-brand-700">"Thầy giỏi - Bạn tốt - Sách hay"</p>
                    <p class="text-xs text-slate-600 mt-1">Xây dựng môi trường chuyên nghiệp, cởi mở, gắn kết và hỗ trợ lẫn nhau trong từng dòng mã và dự án.</p>
                </div>

                <!-- 4. Tận tâm -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <div class="text-brand-600 text-2xl mb-3"><i class="fa-solid fa-heart-pulse"></i></div>
                    <h4 class="font-bold text-base text-slate-900 mb-1">4. Tận tâm</h4>
                    <p class="text-xs text-slate-600 font-semibold text-slate-800">"Có tâm ắt sẽ có tầm"</p>
                    <p class="text-xs text-slate-600 mt-1">Mọi hoạt động huấn luyện, hướng dẫn thực tập sinh đều xuất phát từ đam mê và trách nhiệm cao nhất.</p>
                </div>

                <!-- 5. Cam kết -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <div class="text-brand-600 text-2xl mb-3"><i class="fa-solid fa-handshake-angle"></i></div>
                    <h4 class="font-bold text-base text-slate-900 mb-1">5. Cam kết</h4>
                    <p class="text-xs text-slate-600">Nói đi đôi với làm, giữ trọn chữ tín về tiến độ và chất lượng thực tế thay vì những lời hứa hẹn suông.</p>
                </div>

                <!-- 6. Đổi mới sáng tạo -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <div class="text-brand-600 text-2xl mb-3"><i class="fa-solid fa-lightbulb"></i></div>
                    <h4 class="font-bold text-base text-slate-900 mb-1">6. Đổi mới sáng tạo</h4>
                    <p class="text-xs text-slate-600">Gìn giữ bản sắc truyền thống đồng thời không ngừng tìm kiếm giải pháp công nghệ mới để tối ưu hiệu quả.</p>
                </div>

                <!-- 7. Kết quả -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <div class="text-brand-600 text-2xl mb-3"><i class="fa-solid fa-trophy"></i></div>
                    <h4 class="font-bold text-base text-slate-900 mb-1">7. Kết quả</h4>
                    <p class="text-xs text-slate-600">Thước đo thực tế của mọi sự cống hiến, giúp thực tập sinh bứt phá từ "bình thường" sang "phi thường".</p>
                </div>

                <!-- Thông tin chi nhánh Đà Nẵng -->
                <div class="bg-gradient-to-br from-brand-600 to-orange-700 text-white p-6 rounded-xl shadow">
                    <div class="text-white text-2xl mb-3"><i class="fa-solid fa-location-dot"></i></div>
                    <h4 class="font-bold text-base mb-1">Chi nhánh Đà Nẵng</h4>
                    <p class="text-xs text-orange-100">84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng</p>
                    <p class="text-xs text-orange-200 mt-2">Hotline: 0968.825.068</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Lộ Trình Đào Tạo Thực Tập Sinh 3 Tháng (Internship Roadmap) -->
<section id="internship-program" class="py-20 bg-slate-50 border-t border-b border-slate-200/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-orange-100 text-brand-700">
                Lộ Trình Đào Tạo Thực Tập Chuẩn
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 mb-4">
                3 Tháng Thực Chiến Từ Cơ Bản Đến Làm Chủ Dự Án
            </h2>
            <p class="text-slate-600 text-sm sm:text-base">
                Quy trình đào tạo bài bản được thiết kế bởi Mentor Lê Đình Quang, đảm bảo bạn vững vàng kiến thức và sẵn sàng đi làm ngay sau kỳ thực tập.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
            <!-- Phase 1 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm relative">
                <span class="absolute -top-4 left-8 px-4 py-1 rounded-full text-xs font-black bg-brand-600 text-white shadow">
                    GIAI ĐOẠN 1 • TUẦN 1 - 4
                </span>
                <div class="text-3xl font-black text-brand-600 mt-2 mb-4">Onboarding & Kỹ Năng Nền Tảng</div>
                <ul class="text-xs text-slate-600 space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Làm quen văn hóa công ty, quy trình Git Workflow, Jira/Kanban.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Được Mentor Lê Đình Quang hướng dẫn 1-1 ("Thầy giỏi").</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Huấn luyện kiến trúc Clean Code, RESTful API, Database Indexing.</span>
                    </li>
                </ul>
                <div class="p-3 rounded-xl bg-orange-50 text-xs font-semibold text-brand-800 border border-orange-100">
                    🎯 Mục tiêu: Nắm chắc bản chất công nghệ và quy chuẩn coding của dự án.
                </div>
            </div>

            <!-- Phase 2 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm relative">
                <span class="absolute -top-4 left-8 px-4 py-1 rounded-full text-xs font-black bg-slate-900 text-white shadow">
                    GIAI ĐOẠN 2 • TUẦN 5 - 8
                </span>
                <div class="text-3xl font-black text-slate-900 mt-2 mb-4">Thực Chiến Dự Án Thực Tế</div>
                <ul class="text-xs text-slate-600 space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Tham gia trực tiếp module của hệ thống nội bộ Mini-ATS & Khách hàng.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Phối hợp đa phòng ban giữa Dev, Tester, UI/UX và Marketing.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Kiểm thử tự động, tối ưu hiệu năng tốc độ tải trang dưới 2 giây.</span>
                    </li>
                </ul>
                <div class="p-3 rounded-xl bg-slate-100 text-xs font-semibold text-slate-800 border border-slate-200">
                    🎯 Mục tiêu: Xây dựng sản phẩm hoàn thiện, tích lũy kinh nghiệm làm việc nhóm.
                </div>
            </div>

            <!-- Phase 3 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm relative">
                <span class="absolute -top-4 left-8 px-4 py-1 rounded-full text-xs font-black bg-emerald-600 text-white shadow">
                    GIAI ĐOẠN 3 • TUẦN 9 - 12
                </span>
                <div class="text-3xl font-black text-emerald-700 mt-2 mb-4">Đánh Giá & Offer Chính Thức</div>
                <ul class="text-xs text-slate-600 space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Đánh giá kết quả bằng hệ thống Scorecard tiêu chuẩn (Tech, Logic, Attitude, Comm).</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Cấp dấu mộc tròn pháp nhân xác nhận báo cáo thực tập cho trường.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                        <span>Cơ hội ký hợp đồng nhân viên chính thức (Official Member) tại AZ Media.</span>
                    </li>
                </ul>
                <div class="p-3 rounded-xl bg-emerald-50 text-xs font-semibold text-emerald-800 border border-emerald-100">
                    🎯 Mục tiêu: Tốt nghiệp thực tập xuất sắc, khởi đầu sự nghiệp vững chắc.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Danh Sách Vị Trí Tuyển Dụng & Bộ Lọc Đa Năng -->
<section id="positions" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-10 pb-6 border-b border-slate-100">
            <div>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-orange-100 text-brand-700">
                    Cơ Hội Nghề Nghiệp 2026
                </span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">
                    Các Vị Trí Thực Tập Sinh Đang Mở Tuyển
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Hiện có <strong class="text-brand-600">{{ $positions->count() }}</strong> vị trí đang mở tiếp nhận hồ sơ tại Chi nhánh Đà Nẵng & Trụ sở chính
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="openApplyModal()" class="px-5 py-2.5 rounded-xl font-bold text-white gradient-brand shadow text-xs sm:text-sm flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Nộp hồ sơ nhanh
                </button>
            </div>
        </div>

        <!-- Filter Tabs & Dropdowns -->
        <form action="{{ route('azmedia.home') }}#positions" method="GET" class="bg-slate-50 p-4 sm:p-6 rounded-2xl border border-slate-200/80 mb-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Chuyên ngành -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Chuyên ngành / Vị trí:</label>
                    <select name="category" onchange="this.form.submit()" class="w-full text-xs sm:text-sm rounded-xl border-slate-200 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>Tất cả chuyên ngành</option>
                        <option value="backend" {{ request('category') == 'backend' ? 'selected' : '' }}>Backend PHP / Laravel</option>
                        <option value="frontend" {{ request('category') == 'frontend' ? 'selected' : '' }}>Frontend Vue / React</option>
                        <option value="tester" {{ request('category') == 'tester' ? 'selected' : '' }}>QA / QC / Tester</option>
                        <option value="uiux" {{ request('category') == 'uiux' ? 'selected' : '' }}>Thiết kế UI/UX & Đồ họa</option>
                        <option value="marketing" {{ request('category') == 'marketing' ? 'selected' : '' }}>Digital Marketing & Social Media</option>
                        <option value="ai" {{ request('category') == 'ai' ? 'selected' : '' }}>AI Solutions & Tự động hóa</option>
                    </select>
                </div>

                <!-- Hình thức -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Hình thức thực tập:</label>
                    <select name="type" onchange="this.form.submit()" class="w-full text-xs sm:text-sm rounded-xl border-slate-200 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Tất cả hình thức</option>
                        <option value="part_time" {{ request('type') == 'part_time' ? 'selected' : '' }}>Bán thời gian (Part-time)</option>
                        <option value="full_time" {{ request('type') == 'full_time' ? 'selected' : '' }}>Toàn thời gian (Full-time)</option>
                    </select>
                </div>

                <!-- Địa điểm -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Địa điểm làm việc:</label>
                    <select name="location" onchange="this.form.submit()" class="w-full text-xs sm:text-sm rounded-xl border-slate-200 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        <option value="all" {{ request('location') == 'all' ? 'selected' : '' }}>Tất cả chi nhánh</option>
                        <option value="Đà Nẵng" {{ request('location') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng (84 Nguyễn Hữu Dật)</option>
                        <option value="Hồ Chí Minh" {{ request('location') == 'Hồ Chí Minh' ? 'selected' : '' }}>TP. Hồ Chí Minh (102A Cống Quỳnh)</option>
                    </select>
                </div>

                <!-- Reset / Filter button -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2.5 rounded-xl bg-slate-900 text-white text-xs sm:text-sm font-bold hover:bg-slate-800 transition">
                        <i class="fa-solid fa-filter mr-1"></i> Lọc vị trí
                    </button>
                    @if(request()->hasAny(['category', 'type', 'location']))
                        <a href="{{ route('azmedia.home') }}#positions" class="px-3 py-2.5 rounded-xl bg-slate-200 text-slate-700 hover:bg-slate-300 text-xs font-bold transition" title="Xóa bộ lọc">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Positions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($positions as $job)
                <div class="bg-white rounded-2xl border border-slate-200 hover:border-brand-300 hover:shadow-xl transition-all duration-300 p-6 flex flex-col justify-between group">
                    <div>
                        <!-- Header Badges -->
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-orange-100 text-brand-700">
                                {{ $job->department }}
                            </span>
                            @if($job->is_featured)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-700 uppercase">
                                    <i class="fa-solid fa-fire text-rose-500"></i> Tuyển gấp
                                </span>
                            @endif
                        </div>

                        <!-- Job Title -->
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition mb-3 line-clamp-2">
                            <a href="{{ route('azmedia.job.detail', $job->slug) }}">
                                {{ $job->title }}
                            </a>
                        </h3>

                        <!-- Info pills -->
                        <div class="space-y-2 text-xs text-slate-600 mb-4">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-slate-400 w-4"></i>
                                <span class="truncate">{{ $job->location }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-clock text-slate-400 w-4"></i>
                                <span>{{ $job->type === 'part_time' ? 'Bán thời gian (Part-time)' : 'Toàn thời gian (Full-time)' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-brand-600 font-semibold">
                                <i class="fa-solid fa-money-bill-wave w-4"></i>
                                <span>{{ $job->stipend }}</span>
                            </div>
                            @if($job->mentor_name)
                                <div class="flex items-center gap-2 text-slate-500">
                                    <i class="fa-solid fa-user-tie text-slate-400 w-4"></i>
                                    <span>Mentor: <strong>{{ $job->mentor_name }}</strong></span>
                                </div>
                            @endif
                        </div>

                        <p class="text-xs text-slate-500 line-clamp-3 mb-6">
                            {{ $job->summary }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <a href="{{ route('azmedia.job.detail', $job->slug) }}" class="text-xs font-bold text-slate-700 hover:text-brand-600 transition flex items-center gap-1">
                            Xem chi tiết <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                        <button type="button" onclick="openApplyModal({{ $job->id }}, '{{ addslashes($job->title) }}')"
                                class="px-4 py-2 rounded-xl text-xs font-bold text-white gradient-brand shadow hover:shadow-md transition">
                            Ứng tuyển ngay
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-16 text-center text-slate-500 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                    <i class="fa-solid fa-briefcase text-4xl text-slate-300 mb-3"></i>
                    <p class="text-sm font-semibold">Chưa có vị trí nào phù hợp với bộ lọc đã chọn.</p>
                    <a href="{{ route('azmedia.home') }}#positions" class="inline-block mt-3 text-xs text-brand-600 font-bold hover:underline">
                        Xóa bộ lọc để xem tất cả vị trí
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Section: Cảm nhận Thực tế từ Sinh viên Thực tập sinh -->
<section class="py-20 bg-slate-50 border-t border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-orange-100 text-brand-700">
                Chia Sẻ Từ Các Cựu Thực Tập Sinh
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-3 mb-4">
                Trải Nghiệm Thực Tế Tại AZ Media Đà Nẵng
            </h2>
            <p class="text-slate-600 text-sm sm:text-base">
                Lắng nghe chia sẻ từ các bạn sinh viên đã trải qua kỳ thực tập và trưởng thành cùng công ty.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Review 1: Nguyễn Nhật Linh Ân (Từ báo cáo thực tập file bên trái!) -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm relative">
                <div class="flex items-center gap-1 text-amber-400 mb-4 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed italic mb-6">
                    "Kỳ thực tập tại AZ Media chi nhánh Đà Nẵng (84 Nguyễn Hữu Dật) là bước ngoặt lớn trong quá trình học tập của em. Được Mentor Lê Đình Quang hướng dẫn trực tiếp theo triết lý 'Thầy giỏi - Bạn tốt - Sách hay', em đã tự tay xây dựng hệ thống website tuyển dụng thực tập sinh, nắm vững bản chất kiến trúc MVC/Laravel và biến lý thuyết thành hành động đúng như chữ A - Action trong tên công ty!"
                </p>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <div class="w-11 h-11 rounded-full bg-brand-600 text-white font-bold flex items-center justify-center text-sm shadow">
                        LA
                    </div>
                    <div>
                        <div class="font-bold text-sm text-slate-900">Nguyễn Nhật Linh Ân</div>
                        <div class="text-[11px] text-slate-500">Lớp 24CNTT1A • Cao đẳng Đà Nẵng (DNC)</div>
                        <div class="text-[10px] text-brand-600 font-semibold">TTS Lập trình Web Backend</div>
                    </div>
                </div>
            </div>

            <!-- Review 2: Trần Văn Hoàng (DUT) -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm relative">
                <div class="flex items-center gap-1 text-amber-400 mb-4 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed italic mb-6">
                    "Quy trình tuyển dụng và làm bài test online của AZ Media rất hiện đại và minh bạch. Em có thể theo dõi tiến độ hồ sơ bất kỳ lúc nào mà không cần đăng ký tài khoản rườm rà. Môi trường tại đây rất năng động, hỗ trợ phụ cấp và cấp dấu mộc chuẩn xác cho trường Bách Khoa."
                </p>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <div class="w-11 h-11 rounded-full bg-slate-800 text-white font-bold flex items-center justify-center text-sm shadow">
                        VH
                    </div>
                    <div>
                        <div class="font-bold text-sm text-slate-900">Trần Văn Hoàng</div>
                        <div class="text-[11px] text-slate-500">Kỹ thuật Phần mềm • ĐH Bách Khoa ĐN</div>
                        <div class="text-[10px] text-brand-600 font-semibold">TTS Frontend Developer</div>
                    </div>
                </div>
            </div>

            <!-- Review 3: Ngô Bảo Trâm (FPT) -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm relative">
                <div class="flex items-center gap-1 text-amber-400 mb-4 text-xs">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed italic mb-6">
                    "Đúng với slogan 'Định hình tư duy – Chinh phục thị trường số', em được trực tiếp tham gia xây dựng các chiến dịch truyền thông đa kênh trên TikTok @ctyazmedia và Threads. Học được cách tư vấn chiến lược cho hơn 300 doanh nghiệp thực tế từ Tổng Giám Đốc Lê Đình Quang."
                </p>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <div class="w-11 h-11 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow">
                        BT
                    </div>
                    <div>
                        <div class="font-bold text-sm text-slate-900">Ngô Bảo Trâm</div>
                        <div class="text-[11px] text-slate-500">Digital Marketing • Đại học FPT Đà Nẵng</div>
                        <div class="text-[10px] text-brand-600 font-semibold">TTS Social Media & Marketing</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Nộp Đơn Nhanh (Quick Apply Modal) -->
<div id="applyModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <!-- Close button -->
        <button type="button" onclick="closeApplyModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center transition">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-2xl gradient-brand text-white flex items-center justify-center text-xl font-bold shadow">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">Nộp Đơn Thực Tập Sinh Nhanh</h3>
                <p class="text-xs text-slate-500">Gia nhập đội ngũ tài năng tại AZ Media Đà Nẵng</p>
            </div>
        </div>

        <form id="applyModalForm" action="{{ route('azmedia.apply.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4" onsubmit="handleSubmitApply(this)">
            @csrf

            <!-- Chọn vị trí -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Vị trí ứng tuyển <span class="text-rose-500">*</span></label>
                <select name="position_id" id="modal_position_id" onchange="handlePositionChange()" required class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    @foreach($positions as $pos)
                        <option value="{{ $pos->id }}">{{ $pos->title }} ({{ $pos->department }})</option>
                    @endforeach
                    <option value="other" class="font-bold text-brand-600">✨ Vị trí khác (Tự điền vị trí mong muốn)...</option>
                </select>
            </div>

            <!-- Ô nhập tự do khi chọn vị trí khác -->
            <div id="custom_position_wrapper" class="hidden space-y-1">
                <label class="block text-xs font-bold text-brand-700 mb-1">
                    <i class="fa-solid fa-pen-nib mr-1"></i> Nhập tên vị trí thực tập bạn muốn ứng tuyển: <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="custom_position_title" id="custom_position_title"
                       placeholder="VD: Thực tập sinh Biên tập Video / Content Creator / Nhân sự..."
                       class="w-full text-xs sm:text-sm rounded-xl border-2 border-brand-500 bg-orange-50/50 py-2.5 px-3 font-semibold focus:ring-2 focus:ring-brand-500 focus:outline-none text-slate-900 shadow-sm">
            </div>

            <!-- Họ tên & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Họ và tên của bạn <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="VD: Nguyễn Nhật Linh Ân"
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" required placeholder="VD: linhan.nguyen@gmail.com"
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
            </div>

            <!-- Số điện thoại & Trường học -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại <span class="text-rose-500">*</span></label>
                    <input type="tel" name="phone" required placeholder="VD: 0968825068"
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Trường Đại học / Cao đẳng <span class="text-rose-500">*</span></label>
                    <input list="universities_list" name="university" required placeholder="Chọn hoặc nhập tên trường"
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    <datalist id="universities_list">
                        <option value="Cao đẳng Đà Nẵng (DNC)">
                        <option value="Đại học Bách Khoa - ĐH Đà Nẵng">
                        <option value="ĐH CNTT & Truyền thông Việt - Hàn (VKU)">
                        <option value="ĐH Sư phạm Kỹ thuật - ĐH Đà Nẵng">
                        <option value="Đại học Duy Tân (DTU)">
                        <option value="Đại học FPT Đà Nẵng">
                        <option value="Đại học Kinh tế - ĐH Đà Nẵng">
                        <option value="Đại học Kiến trúc Đà Nẵng">
                    </datalist>
                </div>
            </div>

            <!-- Ngành học & Ca làm việc -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ngành học <span class="text-rose-500">*</span></label>
                    <input type="text" name="major" required placeholder="VD: Công nghệ Thông tin"
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sinh viên năm</label>
                    <select name="academic_year" class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        <option value="Năm 2">Năm 2</option>
                        <option value="Năm 3" selected>Năm 3</option>
                        <option value="Năm 4">Năm 4</option>
                        <option value="Mới tốt nghiệp">Mới tốt nghiệp</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ca thực tập dự kiến <span class="text-rose-500">*</span></label>
                    <select name="working_shift" required class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        <option value="morning">Ca Sáng (8h00 - 12h00)</option>
                        <option value="afternoon">Ca Chiều (13h30 - 17h30)</option>
                        <option value="fulltime" selected>Cả ngày (Full-time)</option>
                        <option value="flexible">Linh hoạt theo lịch học</option>
                    </select>
                </div>
            </div>

            <!-- Github / Portfolio -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link GitHub / GitLab (nếu có)</label>
                    <input type="url" name="github_url" placeholder="https://github.com/..."
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link Portfolio / Behance (nếu có)</label>
                    <input type="url" name="portfolio_url" placeholder="https://..."
                           class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                </div>
            </div>

            <!-- Upload File CV PDF (max 5MB) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    Tải lên File CV của bạn (Định dạng PDF, tối đa 5MB) <span class="text-rose-500">*</span>
                </label>
                <div class="border-2 border-dashed border-slate-300 hover:border-brand-500 rounded-2xl p-4 text-center cursor-pointer transition bg-slate-50 relative">
                    <input type="file" name="cv_file" id="cv_file" required accept=".pdf,application/pdf"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                           onchange="updateFileName(this)">
                    <div id="file_upload_label">
                        <i class="fa-solid fa-file-pdf text-3xl text-rose-500 mb-2"></i>
                        <p class="text-xs font-bold text-slate-700">Kéo thả hoặc nhấp để chọn file CV (PDF)</p>
                        <p class="text-[11px] text-slate-400 mt-1">Dung lượng tối đa 5MB</p>
                    </div>
                </div>
            </div>

            <!-- Thư ngỏ (Cover letter) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Lời nhắn / Giới thiệu bản thân</label>
                <textarea name="cover_letter" rows="2" placeholder="Chia sẻ ngắn về mục tiêu thực tập và mong muốn học hỏi tại AZ Media..."
                          class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 p-3 focus:ring-2 focus:ring-brand-500 focus:outline-none"></textarea>
            </div>

            <!-- Submit button -->
            <div class="pt-2">
                <button type="submit" id="btnSubmitModal" class="w-full py-3.5 rounded-xl font-bold text-white gradient-brand shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2 text-sm disabled:opacity-60 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-paper-plane" id="btnSubmitIcon"></i> <span id="btnSubmitText">Gửi hồ sơ ứng tuyển ngay</span>
                </button>
                <p class="text-[11px] text-center text-slate-400 mt-2">
                    * Sau khi nộp đơn, bạn sẽ nhận được mã hồ sơ để tra cứu tiến độ trực tuyến ngay lập tức.
                </p>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function handleSubmitApply(form) {
        const btn = document.getElementById('btnSubmitModal');
        const icon = document.getElementById('btnSubmitIcon');
        const text = document.getElementById('btnSubmitText');
        if (btn) {
            btn.disabled = true;
            btn.classList.add('opacity-75');
            icon.className = 'fa-solid fa-circle-notch fa-spin';
            text.innerText = 'Đang gửi hồ sơ & gửi mã tra cứu qua Gmail...';
        }
        return true;
    }

    function handlePositionChange() {
        const select = document.getElementById('modal_position_id');
        const wrapper = document.getElementById('custom_position_wrapper');
        const input = document.getElementById('custom_position_title');
        if (select && wrapper) {
            if (select.value === 'other') {
                wrapper.classList.remove('hidden');
                if (input) {
                    input.required = true;
                    input.focus();
                }
            } else {
                wrapper.classList.add('hidden');
                if (input) {
                    input.required = false;
                }
            }
        }
    }

    function openApplyModal(positionId = null, title = null) {
        const modal = document.getElementById('applyModal');
        modal.classList.remove('hidden');
        if (positionId) {
            document.getElementById('modal_position_id').value = positionId;
        }
        handlePositionChange();
    }

    function closeApplyModal() {
        document.getElementById('applyModal').classList.add('hidden');
        const wrapper = document.getElementById('custom_position_wrapper');
        if (wrapper) wrapper.classList.add('hidden');
    }

    function updateFileName(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const fileSize = (input.files[0].size / (1024 * 1024)).toFixed(2);
            document.getElementById('file_upload_label').innerHTML = `
                <i class="fa-solid fa-circle-check text-3xl text-emerald-500 mb-2"></i>
                <p class="text-xs font-bold text-slate-800">${fileName}</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Dung lượng: ${fileSize} MB (Đã sẵn sàng tải lên)</p>
            `;
        }
    }

    // Close modal on click outside
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('applyModal');
        if (e.target === modal) {
            closeApplyModal();
        }
    });
</script>
@endpush
