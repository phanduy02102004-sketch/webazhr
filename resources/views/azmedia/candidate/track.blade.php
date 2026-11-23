@extends('azmedia.layouts.app')

@section('title', 'Tra Cứu Tiến Độ Tuyển Dụng - AZ Media Đà Nẵng')

@section('content')

<!-- Header Banner -->
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-3xl">
        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-orange-500/20 text-brand-400 border border-orange-500/30">
            Candidate Portal • Cổng Tra Cứu Ứng Viên
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-3 mb-4">
            Theo Dõi Tiến Trình Ứng Tuyển
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
            Tra cứu trạng thái hồ sơ trực tuyến bằng <strong>Mã hồ sơ</strong> hoặc <strong>Email</strong> mà không cần đăng ký tài khoản phức tạp.
        </p>

        <!-- Search Bar -->
        <form action="{{ route('azmedia.candidate.track.post') }}" method="POST" class="mt-8 max-w-xl mx-auto">
            @csrf
            <div class="flex flex-col sm:flex-row gap-2 bg-slate-800 p-2 rounded-2xl border border-slate-700 shadow-xl">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="keyword" value="{{ $searchKey ?? '' }}" required
                           placeholder="Nhập Mã HS (VD: AZ-2026-0732) hoặc Email"
                           class="w-full pl-10 pr-3 py-3 text-sm bg-transparent text-white placeholder-slate-400 focus:outline-none">
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-lg transition text-sm">
                    Tra cứu hồ sơ
                </button>
            </div>
            <div class="flex items-center justify-center gap-3 mt-3 text-xs text-slate-400">
                <span>Hồ sơ mẫu trải nghiệm:</span>
                <a href="{{ route('azmedia.candidate.track', ['code' => 'AZ-2026-0732']) }}" class="text-brand-400 font-bold hover:underline">
                    AZ-2026-0732 (Linh Ân - DNC - Offer)
                </a>
                <span>•</span>
                <a href="{{ route('azmedia.candidate.track', ['code' => 'AZ-2026-1021']) }}" class="text-brand-400 font-bold hover:underline">
                    AZ-2026-1021 (Hoàng - Phỏng vấn)
                </a>
            </div>
        </form>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($application)
        <!-- Candidate Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden mb-10">
            <!-- Header Card Banner -->
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-6 sm:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl gradient-brand text-white font-extrabold text-2xl flex items-center justify-center shadow-lg">
                        {{ substr($application->candidate->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xl sm:text-2xl font-extrabold text-white">{{ $application->candidate->name }}</h2>
                            <span class="px-3 py-0.5 rounded-full text-xs font-black bg-brand-500 text-white shadow">
                                {{ $application->application_code }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-300 mt-1">
                            Vị trí: <strong class="text-brand-400">{{ $application->position->title }}</strong>
                        </p>
                        <p class="text-[11px] text-slate-400">
                            {{ $application->candidate->university }} • {{ $application->candidate->major }}
                        </p>
                    </div>
                </div>

                <div class="text-left md:text-right">
                    <div class="text-xs text-slate-400 mb-1">Trạng thái hiện tại:</div>
                    @php
                        $badge = $application->status_badge;
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold {{ $badge['class'] }} border">
                        <span class="w-2 h-2 rounded-full bg-current animate-ping"></span>
                        {{ $badge['label'] }}
                    </span>
                </div>
            </div>

            <!-- Banner Chuẩn Đầu Ra TTS -->
            <div class="px-6 py-4 bg-orange-50 border-b border-orange-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-orange-600 text-white flex items-center justify-center font-bold text-lg flex-shrink-0">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </span>
                    <div>
                        <div class="text-xs font-extrabold text-orange-950 flex items-center gap-2">
                            Chuẩn Đầu Ra & Báo Cáo Thực Tập TTS AZ Media
                            <span class="px-2 py-0.2 rounded-full text-[10px] bg-brand-600 text-white uppercase font-bold">Quan trọng</span>
                        </div>
                        <div class="text-[11px] text-orange-800">Khảo sát, nộp báo cáo 4 bước (Cổng AZ SUPPORT & 1+1), video & đánh giá 5 kênh.</div>
                    </div>
                </div>
                <a href="{{ route('azmedia.graduation.index', ['code' => $application->application_code]) }}"
                   class="whitespace-nowrap px-4 py-2 rounded-xl bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-extrabold text-xs shadow-md transition flex items-center gap-1.5 flex-shrink-0">
                    <i class="fa-solid fa-list-check"></i> Cổng Chuẩn Đầu Ra TTS <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <!-- Recruitment Workflow Stepper (Timeline) -->
            <div class="p-6 sm:p-10 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-8 flex items-center gap-2">
                    <i class="fa-solid fa-timeline text-brand-600"></i> Tiến trình Tuyển dụng Theo Luồng Chuẩn
                </h3>

                @php
                    $stages = [
                        ['key' => 'applied', 'step' => 1, 'name' => 'Nộp hồ sơ', 'desc' => 'Đã tiếp nhận CV'],
                        ['key' => 'screening', 'step' => 2, 'name' => 'Duyệt CV', 'desc' => 'HR sơ loại'],
                        ['key' => 'tested', 'step' => 3, 'name' => 'Bài Test Online', 'desc' => 'Đánh giá năng lực'],
                        ['key' => 'interviewing', 'step' => 4, 'name' => 'Phỏng vấn', 'desc' => 'HR & Mentor'],
                        ['key' => 'offered', 'step' => 5, 'name' => 'Nhận thực tập', 'desc' => 'Chính thức gia nhập'],
                    ];
                    $currentStep = $application->stage_step;
                    $isRejected = ($application->status === 'rejected');
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 relative">
                    @foreach($stages as $idx => $st)
                        @php
                            $isPassed = ($currentStep >= $st['step'] && !$isRejected);
                            $isCurrent = ($currentStep == $st['step'] && !$isRejected);
                        @endphp
                        <div class="flex flex-col items-center text-center relative z-10">
                            <!-- Step icon circle -->
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-sm mb-3 shadow transition-all duration-300
                                 {{ $isPassed ? 'bg-emerald-600 text-white shadow-emerald-500/20' : ($isCurrent ? 'gradient-brand text-white ring-4 ring-orange-200' : 'bg-white text-slate-400 border border-slate-200') }}">
                                @if($isPassed && !$isCurrent)
                                    <i class="fa-solid fa-check"></i>
                                @else
                                    {{ $idx + 1 }}
                                @endif
                            </div>
                            <span class="text-xs font-bold {{ $isCurrent ? 'text-brand-600 font-extrabold' : ($isPassed ? 'text-slate-900' : 'text-slate-400') }}">
                                {{ $st['name'] }}
                            </span>
                            <span class="text-[10px] text-slate-400 mt-0.5">
                                {{ $st['desc'] }}
                            </span>
                        </div>
                    @endforeach
                </div>

                @if($isRejected)
                    <div class="mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-3">
                        <i class="fa-solid fa-circle-xmark text-xl text-rose-500"></i>
                        <div>
                            <strong>Hồ sơ chưa đạt yêu cầu đợt này.</strong> Bộ phận nhân sự AZ Media đã lưu trữ hồ sơ của bạn vào Talent Pool và sẽ chủ động liên hệ khi có dự án mới phù hợp hơn.
                        </div>
                    </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="p-6 sm:p-10 space-y-8">
                <!-- Case 1: Cần làm bài test Online -->
                @if(in_array($application->status, ['test_sent', 'screening']))
                    <div class="p-6 rounded-2xl bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-xl font-bold">
                                <i class="fa-solid fa-clipboard-question"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-base text-indigo-950">Vòng 2: Bài Đánh Giá Năng Lực Trực Tuyến</h4>
                                <p class="text-xs text-indigo-700">Tự do, không giới hạn thời gian (Tính cách NLP, Bánh xe cuộc đời & Chuyên môn).</p>
                            </div>
                        </div>
                        <a href="{{ route('azmedia.candidate.test', $application->application_code) }}"
                           class="px-6 py-3 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md transition flex items-center gap-2 text-xs sm:text-sm whitespace-nowrap">
                            <i class="fa-solid fa-play"></i> Bắt đầu làm bài Test
                        </a>
                    </div>
                @endif

                <!-- Banner Nhóm Zalo Hỗ Trợ Ứng Tuyển -->
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-sm shadow flex-shrink-0">
                            Zalo
                        </div>
                        <div>
                            <h4 class="font-extrabold text-xs sm:text-sm text-emerald-950 flex items-center gap-1.5">
                                Nhóm Zalo Ứng Tuyển: <span class="text-blue-700">AZ HR - ỨNG TUYỂN</span>
                            </h4>
                            <p class="text-[11px] text-emerald-800">
                                Tham gia nhóm Zalo để tham khảo tài liệu làm bài test, giải đáp thắc mắc và nhận thông báo phỏng vấn nhanh nhất!
                            </p>
                        </div>
                    </div>
                    <a href="https://zalo.me/g/fcypks402" target="_blank"
                       class="px-4 py-2 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow transition flex items-center gap-1.5 flex-shrink-0">
                        <i class="fa-solid fa-comments"></i> Tham Gia Nhóm Zalo
                    </a>
                </div>

                <!-- Case 2: Đã làm xong Test (Hiển thị kết quả) -->
                @if($application->testResult)
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                        <h4 class="font-bold text-sm text-slate-800 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-square-poll-vertical text-brand-600"></i> Kết Quả Bài Test Năng Lực Online
                        </h4>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                            <div class="bg-white p-3 rounded-xl border border-slate-200">
                                <div class="text-2xl font-black text-brand-600">{{ $application->testResult->score }} / 100</div>
                                <div class="text-[11px] text-slate-500">Điểm số đạt được</div>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200">
                                <div class="text-2xl font-black text-slate-800">{{ $application->testResult->correct_answers }} / {{ $application->testResult->total_questions }}</div>
                                <div class="text-[11px] text-slate-500">Số câu đúng</div>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200">
                                <div class="text-2xl font-black text-slate-800">{{ round($application->testResult->time_spent_seconds / 60) }} phút</div>
                                <div class="text-[11px] text-slate-500">Thời gian làm bài</div>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200">
                                @if($application->testResult->passed)
                                    <div class="text-2xl font-black text-emerald-600">ĐẠT (PASS)</div>
                                @else
                                    <div class="text-2xl font-black text-rose-500">CHƯA ĐẠT</div>
                                @endif
                                <div class="text-[11px] text-slate-500">Kết quả vòng test</div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Case 3: Lịch phỏng vấn đã được xếp -->
                @if($application->interview_time)
                    <div class="p-6 rounded-2xl bg-orange-50 border border-orange-200">
                        <h4 class="font-bold text-sm text-slate-900 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-check text-brand-600"></i> Lịch Phỏng Vấn Chính Thức
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-700">
                            <div>
                                <p class="mb-1">📅 <strong>Thời gian:</strong> <span class="text-brand-700 font-bold text-sm">{{ date('H:i - d/m/Y', strtotime($application->interview_time)) }}</span></p>
                                <p class="mb-1">📍 <strong>Địa điểm:</strong> {{ $application->interview_location ?? '84 Nguyễn Hữu Dật, P. Hòa Cường, TP. Đà Nẵng' }}</p>
                                <p>👨‍🏫 <strong>Người phỏng vấn:</strong> {{ $application->assignedMentor ? $application->assignedMentor->name : 'Lê Đình Quang' }}</p>
                            </div>
                            <div>
                                @if($application->interview_link)
                                    <p class="mb-2">💻 <strong>Họp trực tuyến:</strong></p>
                                    <a href="{{ $application->interview_link }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition">
                                        <i class="fa-solid fa-video"></i> Vào phòng Google Meet
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Case 4: Nhận Offer trúng tuyển thực tập sinh -->
                @if($application->status === 'offered')
                    <div class="p-8 rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white shadow-xl text-center">
                        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-3xl mx-auto mb-4">
                            🎉
                        </div>
                        <h3 class="text-2xl font-extrabold mb-2">Chúc Mừng Bạn Đã Trúng Tuyển Thực Tập Sinh!</h3>
                        <p class="text-sm text-emerald-100 max-w-xl mx-auto mb-6">
                            Hội đồng chuyên môn AZ Media đánh giá cao năng lực và thái độ của bạn. Chào mừng bạn chính thức gia nhập ngôi nhà chung tại <strong>84 Nguyễn Hữu Dật, Đà Nẵng</strong>!
                        </p>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white text-emerald-800 font-bold text-xs">
                            <i class="fa-solid fa-award"></i> Hỗ trợ phụ cấp • Đào tạo 1-1 • Đóng dấu mộc tròn báo cáo thực tập
                        </div>
                    </div>
                @endif

                <!-- Thông tin hồ sơ & CV Preview Link -->
                <div class="pt-6 border-t border-slate-200">
                    <h4 class="font-bold text-sm text-slate-800 mb-4">Chi tiết hồ sơ cá nhân</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs text-slate-600 mb-6">
                        <div><strong>Email:</strong> {{ $application->candidate->email }}</div>
                        <div><strong>Số điện thoại:</strong> {{ $application->candidate->phone }}</div>
                        <div><strong>Ca làm việc:</strong> {{ $application->candidate->working_shift }}</div>
                        <div><strong>Trường:</strong> {{ $application->candidate->university }}</div>
                        <div><strong>Ngành:</strong> {{ $application->candidate->major }}</div>
                        <div><strong>File CV:</strong> <a href="{{ route('azmedia.portal.candidate.cv', $application->id) }}" target="_blank" class="text-brand-600 font-bold hover:underline"><i class="fa-solid fa-file-pdf"></i> Xem CV PDF trực tuyến</a></div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(isset($searchKey))
        <!-- Không tìm thấy hồ sơ -->
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-file-circle-xmark"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Không tìm thấy hồ sơ nào</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                Không tìm thấy hồ sơ nào khớp với từ khóa "<strong>{{ $searchKey }}</strong>". Vui lòng kiểm tra lại Mã hồ sơ hoặc Email bạn đã dùng khi nộp đơn.
            </p>
            <a href="{{ route('azmedia.home') }}#positions" class="px-6 py-3 rounded-xl font-bold text-white gradient-brand text-xs shadow">
                Nộp hồ sơ ứng tuyển mới
            </a>
        </div>
    @else
        <!-- Hướng dẫn tra cứu ban đầu -->
        <div class="bg-white rounded-3xl p-10 text-center border border-slate-200 shadow-sm">
            <div class="w-16 h-16 rounded-2xl bg-orange-100 text-brand-600 flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm">
                <i class="fa-solid fa-id-card-clip"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2">Nhập Mã Hồ Sơ Hoặc Email Để Tra Cứu</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                Mã hồ sơ (VD: <strong>AZ-2026-0732</strong>) được hệ thống cung cấp ngay sau khi bạn gửi đơn ứng tuyển thành công.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('azmedia.candidate.track', ['code' => 'AZ-2026-0732']) }}" class="px-4 py-2.5 rounded-xl bg-orange-50 text-brand-700 hover:bg-orange-100 border border-orange-200 text-xs font-bold transition">
                    👉 Thử hồ sơ mẫu: AZ-2026-0732 (Nguyễn Nhật Linh Ân)
                </a>
            </div>
        </div>
    @endif
</div>

@endsection
