<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cổng Tuyển Dụng Thực Tập Sinh - AZ Media Đà Nẵng')</title>
    <meta name="description" content="Hệ thống tuyển dụng thực tập sinh AZ Media - Định hình tư duy, Chinh phục thị trường số. Cơ hội thực tập CNTT, Marketing, AI tại Đà Nẵng.">

    <!-- Google Fonts & Font Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                            dark: '#0f172a',
                            navy: '#1e293b',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-brand { background: linear-gradient(135deg, #ea580c 0%, #f97316 50%, #fb923c 100%); }
        .gradient-dark { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
        .text-gradient { background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        /* Hiệu ứng nhấp nháy nút Ứng tuyển */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 8px rgba(249,115,22,0.4), 0 4px 15px rgba(234,88,12,0.2); transform: scale(1); }
            50% { box-shadow: 0 0 20px rgba(249,115,22,0.7), 0 4px 25px rgba(234,88,12,0.4); transform: scale(1.05); }
        }
        .btn-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        .btn-pulse-glow:hover {
            animation: none;
            transform: scale(1.07);
            box-shadow: 0 0 25px rgba(249,115,22,0.8), 0 6px 30px rgba(234,88,12,0.5);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <!-- Top Announcement Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-600 text-white animate-pulse">
                    TUYỂN DỤNG ĐỢT 2026
                </span>
                <span>🔥 Đang mở đợt tuyển Thực tập sinh tại <strong>84 Nguyễn Hữu Dật, Đà Nẵng</strong></span>
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <a href="tel:0968825068" class="hover:text-brand-400 transition flex items-center gap-1">
                    <i class="fa-solid fa-phone text-xs"></i> 0968.825.068
                </a>
                <span class="hidden sm:inline">|</span>
                <a href="{{ route('azmedia.candidate.track') }}" class="hover:text-brand-400 transition flex items-center gap-1">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i> Tra cứu hồ sơ ứng viên
                </a>
                <span class="hidden sm:inline">|</span>
                <a href="{{ route('azmedia.graduation.index') }}" class="hover:text-orange-300 transition flex items-center gap-1 text-orange-400 font-semibold">
                    <i class="fa-solid fa-graduation-cap text-xs"></i> Chuẩn đầu ra TTS
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo & Slogan -->
                <a href="{{ route('azmedia.home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('uploads/az-homes-logo.png') }}" alt="AZ Homes Logo" class="w-12 h-12 object-contain group-hover:scale-105 transition">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl font-extrabold tracking-tight text-slate-900">AZ<span class="text-brand-600">HR</span></span>
                            <span class="text-[11px] px-1.5 py-0.5 rounded bg-orange-100 text-orange-700 font-semibold">Đà Nẵng</span>
                        </div>
                        <p class="text-[11px] text-slate-500 font-medium">Định hình tư duy – Chinh phục thị trường số</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-slate-600">
                    <a href="{{ route('azmedia.home') }}" class="hover:text-brand-600 transition {{ request()->routeIs('azmedia.home') ? 'text-brand-600 font-bold' : '' }}">
                        Trang chủ
                    </a>
                    <a href="{{ route('azmedia.home') }}#positions" class="hover:text-brand-600 transition">
                        Vị trí Tuyển dụng
                    </a>
                    <a href="{{ route('azmedia.home') }}#internship-program" class="hover:text-brand-600 transition">
                        Lộ trình TTS
                    </a>
                    <a href="{{ route('azmedia.home') }}#core-values" class="hover:text-brand-600 transition">
                        7 Giá trị cốt lõi
                    </a>
                    <a href="{{ route('azmedia.home') }}#about" class="hover:text-brand-600 transition">
                        Về AZ Media
                    </a>
                    <a href="{{ route('azmedia.candidate.track') }}" class="hover:text-brand-600 transition flex items-center gap-1 {{ request()->routeIs('azmedia.candidate.track*') ? 'text-brand-600 font-bold' : '' }}">
                        <i class="fa-solid fa-search text-xs"></i> Tra cứu tiến độ
                    </a>
                    <a href="{{ route('azmedia.graduation.index') }}" class="hover:text-brand-600 transition flex items-center gap-1.5 {{ request()->routeIs('azmedia.graduation*') ? 'text-brand-600 font-bold' : '' }}">
                        <i class="fa-solid fa-user-graduate text-xs"></i> Chuẩn đầu ra TTS
                        <span class="px-1.5 py-0.2 rounded-full text-[9px] font-extrabold bg-orange-100 text-orange-700 uppercase">Mới</span>
                    </a>
                </nav>

                <!-- Desktop Right Actions -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('azmedia.candidate.track') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-brand-600 hover:bg-slate-100 rounded-lg transition">
                        Tra cứu kết quả
                    </a>
                    <a href="{{ route('azmedia.home') }}#positions" class="px-5 py-2.5 text-sm font-bold text-white gradient-brand rounded-xl transition btn-pulse-glow">
                        Ứng tuyển ngay <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Mobile Hamburger Toggle -->
                <div class="flex md:hidden">
                    <button id="mobile-menu-btn" type="button" class="text-slate-600 hover:text-slate-900 p-2 rounded-lg focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 pt-3 pb-6 space-y-2 shadow-lg">
            <a href="{{ route('azmedia.home') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-orange-50 hover:text-brand-600">Trang chủ</a>
            <a href="{{ route('azmedia.home') }}#positions" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-orange-50 hover:text-brand-600">Vị trí tuyển dụng</a>
            <a href="{{ route('azmedia.home') }}#internship-program" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-orange-50 hover:text-brand-600">Lộ trình thực tập</a>
            <a href="{{ route('azmedia.home') }}#core-values" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-orange-50 hover:text-brand-600">7 Giá trị cốt lõi</a>
            <a href="{{ route('azmedia.home') }}#about" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-orange-50 hover:text-brand-600">Giới thiệu AZ Media</a>
            <a href="{{ route('azmedia.candidate.track') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-orange-50 hover:text-brand-600">Tra cứu tiến độ hồ sơ</a>
            <a href="{{ route('azmedia.graduation.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-orange-50 hover:text-brand-600 flex items-center justify-between">
                <span><i class="fa-solid fa-user-graduate text-brand-600 mr-2"></i> Chuẩn đầu ra TTS</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-orange-100 text-orange-700">Mới</span>
            </a>
            <div class="pt-2">
                <a href="{{ route('azmedia.home') }}#positions" class="block w-full text-center px-4 py-2.5 rounded-xl font-bold text-white gradient-brand btn-pulse-glow">
                    Ứng tuyển ngay
                </a>
            </div>
        </div>
    </header>

    <!-- Global Alert Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 w-full">
        @if(session('success'))
            <div class="flex items-center p-4 mb-4 text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg mr-3"></i>
                <div class="text-sm font-medium flex-1">
                    {{ session('success') }}
                </div>
                <button type="button" class="text-emerald-500 hover:text-emerald-800 text-sm" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center p-4 mb-4 text-rose-800 bg-rose-50 rounded-xl border border-rose-200 shadow-sm" role="alert">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg mr-3"></i>
                <div class="text-sm font-medium flex-1">
                    {{ session('error') }}
                </div>
                <button type="button" class="text-rose-500 hover:text-rose-800 text-sm" onclick="this.parentElement.remove()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="p-4 mb-4 text-rose-800 bg-rose-50 rounded-xl border border-rose-200 shadow-sm">
                <div class="flex items-center mb-1">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 mr-2"></i>
                    <span class="font-bold text-sm">Vui lòng kiểm tra lại thông tin:</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-0.5 text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content Slot -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer with Full AZ Media Profile & Student Info -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-10 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">
                <!-- Col 1: AZ Media Overview -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('uploads/az-homes-logo.png') }}" alt="AZ Homes Logo" class="w-10 h-10 object-contain">
                        <div>
                            <span class="text-lg font-extrabold tracking-tight text-white">AZ<span class="text-brand-500">HR</span></span>
                            <p class="text-[10px] text-slate-400">Coaching & Marketing Online</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        <strong>CÔNG TY TNHH ĐẦU TƯ PHÁT TRIỂN DOANH NGHIỆP AZ HOMES – CHI NHÁNH AZ MEDIA</strong><br>
                        Slogan: <em>“Định hình tư duy – Chinh phục thị trường số”</em>. Tiên phong đào tạo kỹ năng thực chiến và giải pháp chuyển đổi số cho cá nhân và doanh nghiệp.
                    </p>
                    <div class="flex items-center gap-3 text-slate-400">
                        <a href="https://www.facebook.com/share/1A5N2tisXh/?mibextid=wwXIfr" target="_blank" class="w-8 h-8 rounded-lg bg-brand-600 text-white hover:bg-brand-700 flex items-center justify-center transition shadow-sm" title="Facebook Fanpage AZ Media">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="https://www.tiktok.com/@ctyazmedia" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition" title="TikTok @ctyazmedia">
                            <i class="fa-brands fa-tiktok text-sm"></i>
                        </a>
                        <a href="https://www.instagram.com/azmediaacademy/" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition" title="Instagram">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="https://www.threads.com/@congtyazmedia" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition" title="Threads">
                            <i class="fa-brands fa-threads text-sm"></i>
                        </a>
                        <a href="https://azmedia.com.vn/" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition" title="Website chính thức">
                            <i class="fa-solid fa-globe text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Văn phòng & Pháp lý -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-brand-500 pl-2">Văn phòng & Pháp lý</h4>
                    <ul class="text-xs space-y-3 text-slate-400">
                        <li>
                            <strong class="text-slate-200">📍 Chi nhánh Đà Nẵng:</strong><br>
                            84 Nguyễn Hữu Dật, Phường Hòa Cường, Quận Hải Châu, TP. Đà Nẵng
                        </li>
                        <li>
                            <strong class="text-slate-200">🏢 Trụ sở chính TP.HCM:</strong><br>
                            Tầng 3, Tòa nhà WMC, 102A-B-C Cống Quỳnh, P. Bến Thành, TP. Hồ Chí Minh
                        </li>
                        <li>
                            <strong class="text-slate-200">📋 Mã số thuế:</strong> 0314247738-002
                        </li>
                        <li>
                            <strong class="text-slate-200">👤 Đại diện pháp luật:</strong> Tổng Giám Đốc Lê Đình Quang
                        </li>
                        <li>
                            <strong class="text-slate-200">📞 Hotline:</strong> <a href="tel:0968825068" class="text-brand-400 hover:underline">0968.825.068</a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Triết lý & Giá trị cốt lõi -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-brand-500 pl-2">Triết lý AZ Media</h4>
                    <ul class="text-xs space-y-2 text-slate-400">
                        <li><strong class="text-brand-400">A (Action):</strong> "Học lý thuyết để nắm rõ bản chất, hành động để thành công"</li>
                        <li><strong class="text-brand-400">Z (Zoom):</strong> Tầm nhìn xa trông rộng, sự phát triển vượt bậc</li>
                        <li><strong class="text-brand-400">M (Media):</strong> Truyền thông số & Giải pháp công nghệ</li>
                        <li><strong class="text-slate-200">🌱 Môi trường:</strong> "Thầy giỏi - Bạn tốt - Sách hay"</li>
                        <li><strong class="text-slate-200">🎯 Tận tâm:</strong> "Có tâm ắt sẽ có tầm"</li>
                        <li><strong class="text-slate-200">⭐ Đích đến:</strong> Từ "bình thường" sang "phi thường", từ "bé nhỏ" thành "khổng lồ"</li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>© 2026 AZ Media - Bản quyền thuộc Công ty TNHH Đầu tư Phát triển Doanh nghiệp AZ Homes.</p>
                <p>Hệ thống Tuyển dụng Thực tập sinh trực tuyến thiết kế theo chuẩn Client-Server & RESTful API.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Drawer Script -->
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
