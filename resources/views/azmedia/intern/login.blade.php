@extends('azmedia.layouts.app')

@section('title', 'Đăng Nhập Cổng Thực Tập Sinh – AZ Media Đà Nẵng')

@section('content')
<div class="min-h-screen bg-slate-50 py-12 flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full space-y-8">

        <!-- Header Brand -->
        <div class="text-center space-y-3">
            <div class="inline-flex items-center justify-center p-3 rounded-2xl bg-orange-100 mb-1">
                <img src="{{ asset('uploads/az-homes-logo.png') }}" alt="AZ Media Logo" class="h-16 w-auto object-contain">
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-brand-500/10 text-brand-700 border border-brand-500/20">
                <i class="fa-solid fa-graduation-cap"></i> CỔNG DÀNH RIÊNG CHO THỰC TẬP SINH
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Đăng Nhập Tài Khoản TTS
            </h1>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                Hệ thống xác thực dành cho sinh viên đã được công ty <strong>tiếp nhận thực tập</strong> để hoàn thành Chuẩn đầu vào & Chuẩn đầu ra.
            </p>
        </div>

        <!-- Hộp Thông Báo Quy Trình Vận Hành (Quan Trọng) -->
        <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-3">
            <div class="text-xs font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-brand-600 text-sm"></i>
                Quy định phân quyền vận hành hệ thống AZHR:
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-[11px]">
                <div class="p-3 rounded-2xl bg-blue-50/70 border border-blue-200 text-blue-900 space-y-1">
                    <div class="font-extrabold flex items-center gap-1.5 text-blue-700">
                        <i class="fa-solid fa-file-lines"></i> 1. Ứng tuyển & Phỏng vấn
                    </div>
                    <p class="text-blue-800/80 leading-relaxed">
                        Hoàn toàn <strong>không cần đăng nhập</strong>. Ứng viên gửi CV, làm thủ tục phỏng vấn và tra cứu tiến độ tự do.
                    </p>
                </div>

                <div class="p-3 rounded-2xl bg-orange-50 border border-orange-200 text-orange-950 space-y-1">
                    <div class="font-extrabold flex items-center gap-1.5 text-orange-700">
                        <i class="fa-solid fa-user-check"></i> 2. Chuẩn Đầu Vào / Ra
                    </div>
                    <p class="text-orange-900/80 leading-relaxed">
                        <strong>Bắt buộc đăng nhập</strong> tài khoản TTS khi công ty xác nhận tiếp nhận để làm bài Test và nộp báo cáo.
                    </p>
                </div>
            </div>
        </div>

        @if(session('warning'))
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-semibold flex items-start gap-3 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 text-base flex-shrink-0 mt-0.5"></i>
                <div class="flex-1">{{ session('warning') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-semibold flex items-start gap-3 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base flex-shrink-0 mt-0.5"></i>
                <div class="flex-1">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-semibold flex items-start gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base flex-shrink-0 mt-0.5"></i>
                <div class="flex-1">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Card Form Đăng Nhập -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
            <form action="{{ route('azmedia.intern.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="redirect" value="{{ $redirectUrl }}">

                <!-- Email hoặc Mã hồ sơ -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                        <span>Email hoặc Mã hồ sơ ứng tuyển <span class="text-rose-500">*</span></span>
                        <span class="text-[10px] text-slate-400 font-normal">VD: AZ-2026-0732</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user-tag text-xs"></i>
                        </div>
                        <input type="text" name="login_id" required
                               value="{{ old('login_id', $suggestedCode) }}"
                               placeholder="Nhập email ứng tuyển hoặc mã hồ sơ (vd: linhan.nguyen@azmedia.com.vn)..."
                               class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none font-medium">
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700">Mật khẩu <span class="text-rose-500">*</span></label>
                        <a href="{{ route('azmedia.intern.register', ['redirect' => $redirectUrl]) }}" class="text-[11px] text-brand-600 font-bold hover:underline">
                            Chưa có mật khẩu? Kích hoạt ngay
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </div>
                        <input type="password" name="password" required
                               placeholder="Nhập mật khẩu của bạn..."
                               class="w-full pl-10 pr-4 py-3 rounded-2xl border border-slate-300 text-sm focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <!-- Nút Submit -->
                <button type="submit" class="w-full py-3.5 rounded-2xl gradient-brand text-white font-extrabold text-sm shadow-lg hover:shadow-orange-500/30 transition active:scale-98 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i> Đăng Nhập Cổng Thực Tập Sinh
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <span class="text-slate-500">Chưa tạo tài khoản hoặc chưa có mật khẩu?</span>
                <a href="{{ route('azmedia.intern.register', ['redirect' => $redirectUrl]) }}" class="font-extrabold text-brand-600 hover:text-brand-700">
                    Kích hoạt tài khoản TTS <i class="fa-solid fa-arrow-right text-[10px] ml-0.5"></i>
                </a>
            </div>
        </div>

        <!-- Hộp Đăng nhập Nhanh Cho Tài Khoản Mẫu (Test) -->
        <div class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-xs space-y-2">
            <div class="font-bold text-slate-700 flex items-center gap-1.5">
                <i class="fa-solid fa-key text-brand-600"></i> Tài khoản mẫu thực tập sinh (Test nhanh):
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-[11px]">
                <button type="button" onclick="fillLogin('linhan.nguyen@azmedia.com.vn', 'password123')"
                        class="p-2.5 bg-white rounded-xl border border-slate-200 hover:border-brand-500 text-left transition flex items-center justify-between group">
                    <div>
                        <div class="font-bold text-slate-800">Linh Ân (Đã có Offer)</div>
                        <div class="text-[10px] text-slate-400">linhan.nguyen@azmedia.com.vn</div>
                    </div>
                    <span class="text-brand-600 font-extrabold group-hover:translate-x-1 transition">Chọn &rarr;</span>
                </button>

                <button type="button" onclick="fillLogin('duypn.fpt@gmail.com', 'password123')"
                        class="p-2.5 bg-white rounded-xl border border-slate-200 hover:border-brand-500 text-left transition flex items-center justify-between group">
                    <div>
                        <div class="font-bold text-slate-800">Phan Nhật Duy (FPT)</div>
                        <div class="text-[10px] text-slate-400">duypn.fpt@gmail.com</div>
                    </div>
                    <span class="text-brand-600 font-extrabold group-hover:translate-x-1 transition">Chọn &rarr;</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function fillLogin(email, pwd) {
        document.querySelector('input[name="login_id"]').value = email;
        document.querySelector('input[name="password"]').value = pwd;
    }
</script>
@endsection
