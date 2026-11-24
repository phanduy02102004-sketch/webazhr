@extends('azmedia.layouts.app')

@section('title', 'Bảng Điều Khiển Thực Tập Sinh – AZ Media Đà Nẵng')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Top Profile Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-orange-950 rounded-3xl p-6 sm:p-10 text-white shadow-xl border border-orange-500/20 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-18 h-18 sm:w-20 sm:h-20 rounded-2xl gradient-brand text-white font-extrabold text-2xl sm:text-3xl flex items-center justify-center shadow-lg border-2 border-white/20">
                        {{ mb_substr($candidate->name, 0, 1) }}
                    </div>
                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <h1 class="text-xl sm:text-3xl font-extrabold text-white">{{ $candidate->name }}</h1>
                            @if($application)
                                <span class="px-3 py-0.5 rounded-full text-xs font-mono font-bold bg-brand-500/30 text-brand-300 border border-brand-500/40">
                                    {{ $application->application_code }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs sm:text-sm text-slate-300">
                            Vị trí: <strong class="text-brand-400">{{ ($application && $application->position) ? $application->position->title : 'Thực tập sinh AZ Media' }}</strong>
                        </p>
                        <div class="text-xs text-slate-400 flex flex-wrap items-center gap-x-4 gap-y-1 pt-1">
                            <span><i class="fa-solid fa-building-columns text-brand-400 mr-1"></i> {{ $candidate->university }}</span>
                            <span><i class="fa-solid fa-graduation-cap text-brand-400 mr-1"></i> {{ $candidate->major }}</span>
                            <span><i class="fa-solid fa-envelope text-brand-400 mr-1"></i> {{ $candidate->email }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
                    <div class="bg-slate-800/80 px-4 py-2.5 rounded-2xl border border-slate-700 text-right">
                        <div class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Trạng thái tiếp nhận:</div>
                        <div class="text-xs font-extrabold text-emerald-400 mt-0.5 flex items-center gap-1.5 justify-end">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            {{ ($application && $application->status === 'offered') ? 'Đã Nhận Thực Tập' : 'Đang Thực Tập' }}
                        </div>
                    </div>

                    <a href="{{ route('azmedia.intern.logout') }}"
                       class="px-4 py-2.5 rounded-2xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-300 border border-rose-500/30 text-xs font-bold transition flex items-center gap-2">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <div class="flex-1">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Lưới 2 Cột: Chuẩn Đầu Vào & Chuẩn Đầu Ra -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- KHỐI 1: CHUẨN ĐẦU VÀO (ENTRY CRITERIA) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 font-extrabold text-xl flex items-center justify-center">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">Chuẩn Đầu Vào (Entry Criteria)</h2>
                                <p class="text-xs text-slate-500">Bài Test nhận thức Văn hóa AZ Media & Đánh giá năng lực</p>
                            </div>
                        </div>

                        @if($testResult && $testResult->completed_at)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <i class="fa-solid fa-check mr-1"></i> Đã hoàn thành
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200 animate-pulse">
                                <i class="fa-solid fa-clock mr-1"></i> Chưa làm bài
                            </span>
                        @endif
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-3 text-xs">
                        <div class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-list-check text-blue-600"></i> Nội dung bài Test Chuẩn đầu vào bao gồm:
                        </div>
                        <ul class="space-y-1.5 text-slate-600 list-disc list-inside">
                            <li><strong>Phần 1:</strong> Trắc nghiệm Văn hóa & 7 Giá trị cốt lõi của AZ Media.</li>
                            <li><strong>Phần 2:</strong> Khảo sát nhận diện tính cách làm việc (VAK - NLP).</li>
                            <li><strong>Phần 3:</strong> Bánh xe cuộc đời & Động cơ phấn đấu trong kỳ thực tập.</li>
                        </ul>
                    </div>

                    @if($testResult && $testResult->completed_at)
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-2 text-xs">
                            <div class="flex items-center justify-between font-bold text-emerald-900">
                                <span>Kết quả bài test:</span>
                                <span class="text-sm font-extrabold text-emerald-700">{{ $testResult->score }}/100 điểm</span>
                            </div>
                            <div class="text-slate-600">
                                Thời gian hoàn thành: <strong>{{ \Carbon\Carbon::parse($testResult->completed_at)->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100">
                    @if($application)
                        @if($testResult && $testResult->completed_at)
                            <a href="{{ route('azmedia.candidate.test.pdf', $application->application_code) }}" target="_blank"
                               class="w-full py-3.5 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs shadow transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-file-pdf text-rose-400"></i> Tải Phiếu Kết Quả Chuẩn Đầu Vào (.PDF)
                            </a>
                        @else
                            <a href="{{ route('azmedia.candidate.test', $application->application_code) }}"
                               class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                                <i class="fa-solid fa-play"></i> Bắt Đầu Làm Bài Test Chuẩn Đầu Vào
                            </a>
                        @endif
                    @else
                        <p class="text-xs text-slate-400 italic text-center">Chưa có mã hồ sơ ứng tuyển liên kết để làm bài test.</p>
                    @endif
                </div>
            </div>

            <!-- KHỐI 2: CHUẨN ĐẦU RA (EXIT CRITERIA) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 font-extrabold text-xl flex items-center justify-center">
                                <i class="fa-solid fa-stamp"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">Chuẩn Đầu Ra & Cấp Mộc (Exit Criteria)</h2>
                                <p class="text-xs text-slate-500">Quy trình 3 mục: Khảo sát, Báo cáo AZ SUPPORT, Đánh giá 5 kênh</p>
                            </div>
                        </div>

                        @if($graduation)
                            <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $graduation->status_badge['class'] }}">
                                {{ $graduation->status_badge['label'] }}
                            </span>
                        @endif
                    </div>

                    @if($graduation)
                        <!-- Tiến độ % -->
                        <div class="p-4 rounded-2xl bg-orange-50/60 border border-orange-200/60 space-y-2">
                            <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                                <span>Tiến độ hoàn thành:</span>
                                <span class="text-brand-600 text-sm font-extrabold">{{ $graduation->progress_percent }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-orange-500 to-amber-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $graduation->progress_percent }}%"></div>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-slate-500 pt-1">
                                <span>Mã CDR: <strong class="font-mono text-slate-700">{{ $graduation->graduation_code }}</strong></span>
                                <span>{{ $graduation->progress_percent >= 100 ? '✅ Đã hoàn tất đủ tiêu chí' : '⏳ Cần tiếp tục hoàn thiện' }}</span>
                            </div>
                        </div>

                        <!-- 3 Tiêu chí -->
                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                            <div class="p-3 rounded-2xl border {{ ($graduation->survey_1_completed && $graduation->survey_2_completed) ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                                <div class="text-sm mb-1"><i class="fa-solid fa-poll"></i></div>
                                <div>Mục 1: Khảo sát</div>
                                <div class="text-[10px] mt-0.5">{{ ($graduation->survey_1_completed && $graduation->survey_2_completed) ? 'Đạt' : 'Chưa' }}</div>
                            </div>

                            <div class="p-3 rounded-2xl border {{ ($graduation->report_final_submitted && $graduation->appointment_booked && $graduation->referral_completed) ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                                <div class="text-sm mb-1"><i class="fa-solid fa-file-invoice"></i></div>
                                <div>Mục 2: Báo cáo (4B)</div>
                                <div class="text-[10px] mt-0.5">{{ ($graduation->referral_completed && $graduation->appointment_booked) ? 'Đạt 1+1' : 'Chưa xong' }}</div>
                            </div>

                            <div class="p-3 rounded-2xl border {{ ($graduation->review_map1 && $graduation->review_map2 && $graduation->review_page_homes) ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                                <div class="text-sm mb-1"><i class="fa-solid fa-star"></i></div>
                                <div>Mục 3: Đánh giá</div>
                                <div class="text-[10px] mt-0.5">{{ ($graduation->review_map1 && $graduation->review_map2) ? 'Đã review' : 'Chưa xong' }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <a href="{{ route('azmedia.graduation.index') }}"
                       class="w-full py-3.5 rounded-2xl gradient-brand hover:opacity-95 text-white font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Mở Cổng Chuẩn Đầu Ra & AZ SUPPORT
                    </a>
                </div>
            </div>

        </div>

        <!-- Khối Thông Tin Hướng Dẫn & Người Phụ Trách (Mentor / HCNS) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="space-y-1">
                    <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-user-shield text-brand-600"></i> Hỗ Trợ & Hướng Dẫn Kỹ Thuật Thực Tập Sinh
                    </h3>
                    <p class="text-xs text-slate-500">
                        Văn phòng công ty: <strong>84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng</strong> | Hotline Ban Điều Hành: <a href="tel:0968825068" class="text-brand-600 font-bold">0968.825.068</a>
                    </p>
                </div>

                <div class="flex items-center gap-4 text-xs">
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-slate-400 block text-[10px]">Người hướng dẫn (Mentor):</span>
                        <span class="font-bold text-slate-800">{{ $mentor ? $mentor->name : 'Lê Đình Quang (BĐH AZ Media)' }}</span>
                    </div>

                    <a href="https://zalo.me/0968825068" target="_blank"
                       class="px-4 py-3 rounded-2xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold transition flex items-center gap-1.5 border border-blue-200">
                        <i class="fa-solid fa-comment-dots"></i> Nhắn tin Zalo
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
