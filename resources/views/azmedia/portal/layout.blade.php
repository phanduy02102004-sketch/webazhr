<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mini-ATS Hệ Thống Tuyển Dụng AZ Media')</title>

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
        .gradient-brand { background: linear-gradient(135deg, #ea580c 0%, #f97316 100%); }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between flex-shrink-0 z-30">
        <div>
            <!-- Brand Logo -->
            <div class="h-20 flex items-center px-6 border-b border-slate-800 gap-3">
                <div class="w-10 h-10 rounded-xl gradient-brand flex items-center justify-center text-white font-extrabold text-xl shadow">
                    AZ
                </div>
                <div>
                    <div class="text-base font-extrabold text-white tracking-tight">AZ <span class="text-brand-500">ATS</span></div>
                    <div class="text-[10px] text-slate-400">Tuyển Dụng Nội Bộ Đà Nẵng</div>
                </div>
            </div>

            <!-- Role Badge -->
            <div class="p-4 mx-4 my-4 rounded-xl bg-slate-800/80 border border-slate-700/60">
                <div class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Đang đăng nhập với vai trò:</div>
                <div class="flex items-center gap-2 mt-1">
                    @php
                        $userRole = $user['role'] ?? 'admin';
                        $roleLabels = [
                            'admin' => ['label' => 'Quản trị viên (Admin)', 'class' => 'bg-purple-500/20 text-purple-300 border-purple-500/30'],
                            'hr' => ['label' => 'Tuyển dụng (HR Lead)', 'class' => 'bg-blue-500/20 text-blue-300 border-blue-500/30'],
                            'mentor' => ['label' => 'Mentor / Tech Lead', 'class' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30'],
                        ];
                    @endphp
                    <span class="px-2 py-0.5 rounded text-[11px] font-bold border {{ $roleLabels[$userRole]['class'] ?? '' }}">
                        {{ $roleLabels[$userRole]['label'] ?? $userRole }}
                    </span>
                </div>
                <div class="text-xs text-white font-bold mt-1.5 truncate">{{ $user['name'] ?? 'Lê Đình Quang' }}</div>
            </div>

            <!-- Menu links -->
            <nav class="px-4 space-y-1.5 text-xs font-semibold">
                <a href="{{ route('azmedia.portal.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('azmedia.portal.dashboard') ? 'bg-brand-600 text-white shadow' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-sm"></i> Dashboard & Thống kê
                </a>

                <a href="{{ route('azmedia.portal.kanban') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('azmedia.portal.kanban') ? 'bg-brand-600 text-white shadow' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-table-columns w-5 text-center text-sm"></i> Pipeline Kanban ATS
                </a>

                <a href="{{ route('azmedia.portal.applications') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('azmedia.portal.applications*') ? 'bg-brand-600 text-white shadow' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-users-viewfinder w-5 text-center text-sm"></i> Danh sách Hồ sơ CV
                </a>

                <a href="{{ route('azmedia.portal.positions') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('azmedia.portal.positions*') ? 'bg-brand-600 text-white shadow' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-briefcase w-5 text-center text-sm"></i> Vị trí Tuyển dụng
                </a>

                <a href="{{ route('azmedia.portal.questions') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('azmedia.portal.questions*') ? 'bg-brand-600 text-white shadow' : 'hover:bg-slate-800 text-slate-300' }}">
                    <i class="fa-solid fa-file-circle-question w-5 text-center text-sm"></i> Ngân hàng Đề Test
                </a>
            </nav>
        </div>

        <!-- Bottom Actions -->
        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('azmedia.home') }}" target="_blank"
               class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Xem Careers Portal
            </a>
            <a href="{{ route('azmedia.logout') }}"
               class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
            </a>
        </div>
    </aside>

    <!-- Main Workspace -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Top App Bar -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between flex-shrink-0 z-20">
            <!-- Left breadcrumb / page title -->
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">@yield('page_title', 'Hệ Thống Quản Lý Tuyển Dụng AZ Media')</h1>
                <p class="text-xs text-slate-500">Mô hình tuyển dụng thực tập sinh chuẩn Mini-ATS & Workflow</p>
            </div>

            <!-- Right: User Info -->
            <div class="flex items-center gap-3">
                <!-- User Name & Role -->
                <div class="hidden sm:block text-right">
                    <div class="text-sm font-bold text-slate-800">{{ $user['name'] ?? 'Admin' }}</div>
                    <div class="text-[11px] text-slate-400">{{ $user['email'] ?? '' }}</div>
                </div>

                <!-- Avatar User -->
                <div class="w-10 h-10 rounded-xl gradient-brand text-white font-bold flex items-center justify-center text-sm shadow">
                    {{ substr($user['name'] ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 sm:p-8">
            <!-- Alerts -->
            @if(session('success'))
                <div class="p-4 mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i>
                    <span class="flex-1">{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-6 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-base"></i>
                    <span class="flex-1">{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @yield('portal_content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
