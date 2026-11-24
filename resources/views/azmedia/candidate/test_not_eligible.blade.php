@extends('azmedia.layouts.app')

@section('title', 'Thông Báo Quy Trình Chuẩn Đầu Vào – AZ Media Đà Nẵng')

@section('content')
<div class="min-h-screen bg-slate-50 py-16 flex items-center justify-center px-4">
    <div class="max-w-lg w-full bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-sm text-center space-y-6">
        <div class="w-16 h-16 rounded-3xl bg-amber-100 text-amber-600 text-3xl flex items-center justify-center mx-auto shadow-inner">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>

        <div class="space-y-2">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                QUY TRÌNH TUYỂN DỤNG AZ MEDIA
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                Chưa Đến Giai Đoạn Chuẩn Đầu Vào
            </h1>
            <p class="text-xs text-slate-500 leading-relaxed">
                Xin chào <strong>{{ $application->candidate->name }}</strong> (Mã hồ sơ: <span class="font-mono text-brand-600 font-bold">{{ $application->application_code }}</span>).
            </p>
        </div>

        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-left text-xs space-y-2 text-slate-700">
            <div class="font-bold text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-info-circle text-brand-600"></i> Trạng thái hiện tại của bạn:
            </div>
            <p>
                Hồ sơ đang ở giai đoạn: <span class="px-2 py-0.5 rounded font-extrabold {{ $application->status_badge['class'] }}">{{ $application->status_badge['label'] }}</span>.
            </p>
            <p class="text-[11px] text-slate-500 leading-relaxed pt-1">
                Theo quy chế vận hành: Ứng viên gửi CV và Phỏng vấn <em>không cần làm bài test ngay</em>. Khi bạn hoàn tất phỏng vấn và công ty gửi <strong>Xác nhận tiếp nhận thực tập (Offer)</strong>, hệ thống sẽ mở quyền làm bài Test Chuẩn đầu vào cho bạn.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('azmedia.candidate.track', ['code' => $application->application_code]) }}"
               class="flex-1 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Tra Cứu Tiến Độ
            </a>
            <a href="{{ route('azmedia.home') }}"
               class="flex-1 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                Về Trang Chủ
            </a>
        </div>
    </div>
</div>
@endsection
