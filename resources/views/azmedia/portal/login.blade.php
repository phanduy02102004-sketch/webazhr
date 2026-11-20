@extends('azmedia.layouts.app')

@section('title', 'Đăng Nhập Hệ Thống Quản Lý Tuyển Dụng AZ Media')

@section('content')

<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl p-8 sm:p-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl gradient-brand text-white font-extrabold text-2xl flex items-center justify-center shadow-lg mx-auto mb-4">
                AZ
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">Portal Tuyển Dụng Nội Bộ</h1>
            <p class="text-xs text-slate-500 mt-1">Đăng nhập bằng tài khoản Gmail và mật khẩu của bạn</p>
        </div>

        <!-- Standard Login Form -->
        <form action="{{ route('azmedia.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Địa chỉ Gmail / Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="Nhập địa chỉ Gmail của bạn..."
                           class="w-full pl-10 pr-3.5 py-3 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none transition">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700">Mật khẩu</label>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" required
                           placeholder="Nhập mật khẩu..."
                           class="w-full pl-10 pr-3.5 py-3 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:outline-none transition">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-white gradient-brand shadow-lg hover:shadow-xl hover:opacity-95 transition text-sm flex items-center justify-center gap-2 mt-4">
                <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập hệ thống ATS
            </button>

            <div class="text-center pt-2">
                <a href="{{ route('azmedia.home') }}" class="text-xs font-semibold text-slate-500 hover:text-brand-600 transition">
                    ← Quay lại Trang chủ tuyển dụng
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
