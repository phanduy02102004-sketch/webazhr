@extends('azmedia.portal.layout')

@section('page_title', 'Quản Lý Pipeline Ứng Viên (Kanban Board ATS)')

@section('portal_content')

<div class="space-y-6">
    <!-- Top Bar Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                <i class="fa-solid fa-circle-check text-emerald-600"></i> Tự Động Duyệt CV Đang Bật
            </span>
            <span class="text-xs text-slate-600 font-medium hidden md:inline">
                TTS nộp đơn sẽ được <strong>tự động duyệt qua Bước 1 & 2</strong>, nhận email chứa link làm bài Test Online ngay!
            </span>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('azmedia.portal.candidates.auto.approve') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn TỰ ĐỘNG DUYỆT toàn bộ hồ sơ đang ở bước Nộp đơn & Duyệt CV sang Bài Test và gửi email?');">
                @csrf
                <button type="submit" class="px-3.5 py-2 rounded-xl text-xs font-bold text-white gradient-brand shadow hover:shadow-md transition flex items-center gap-1.5">
                    <i class="fa-solid fa-bolt"></i> Tự Động Duyệt Sang Bài Test
                </button>
            </form>
            <a href="{{ route('azmedia.portal.applications') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                <i class="fa-solid fa-list mr-1"></i> Bảng (Table)
            </a>
        </div>
    </div>

    <!-- Kanban Board Grid (Horizontal Scrollable) -->
    <div class="flex gap-5 overflow-x-auto pb-6 items-start">
        @foreach($columns as $colKey => $column)
            <div class="w-80 flex-shrink-0 bg-slate-200/70 rounded-2xl p-4 flex flex-col max-h-[calc(100vh-210px)] border border-slate-300/60">
                <!-- Column Header -->
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-300">
                    <div class="flex items-center gap-2">
                        <h3 class="font-extrabold text-xs text-slate-800 tracking-tight">{{ $column['title'] }}</h3>
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-black {{ $column['badge'] }}">
                            {{ $column['items']->count() }}
                        </span>
                    </div>
                </div>

                <!-- Column Cards Scrollable -->
                <div class="flex-1 overflow-y-auto space-y-3.5 pr-1">
                    @forelse($column['items'] as $item)
                        <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm hover:shadow-md transition group">
                            <!-- Card Header -->
                            <div class="flex items-center justify-between gap-1 mb-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-slate-100 text-slate-700">
                                    {{ $item->application_code }}
                                </span>
                                <span class="text-[10px] text-slate-400">
                                    {{ $item->created_at->format('d/m') }}
                                </span>
                            </div>

                            <!-- Candidate Name -->
                            <h4 class="font-bold text-sm text-slate-900 group-hover:text-brand-600 transition mb-1">
                                <a href="{{ route('azmedia.portal.candidate.detail', $item->id) }}">
                                    {{ $item->candidate->name }}
                                </a>
                            </h4>

                            <!-- University & Major -->
                            <div class="text-[11px] text-slate-500 mb-2 truncate" title="{{ $item->candidate->university }}">
                                🏫 {{ $item->candidate->university }}
                            </div>

                            <!-- Position Applied -->
                            <div class="text-[11px] font-semibold text-brand-700 bg-orange-50 px-2.5 py-1 rounded-lg border border-orange-100 mb-3 truncate">
                                {{ $item->position->title }}
                            </div>

                            <!-- Test Score / Details if available -->
                            @if($item->testResult)
                                <div class="text-[11px] font-bold p-2 rounded-xl bg-indigo-50 text-indigo-700 mb-3 border border-indigo-100 flex items-center justify-between">
                                    <span>Điểm: {{ $item->testResult->score }}/100</span>
                                    <a href="{{ route('azmedia.portal.candidate.test.pdf', $item->id) }}" target="_blank"
                                       class="px-2 py-0.5 rounded bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] flex items-center gap-1 shadow-sm transition" title="Xem trọn bộ PDF Bài Test">
                                        <i class="fa-solid fa-file-pdf"></i> PDF
                                    </a>
                                </div>
                            @endif

                            @if($item->interview_time)
                                <div class="text-[10px] text-amber-700 bg-amber-50 p-1.5 rounded mb-3 border border-amber-100">
                                    📅 PV: {{ date('H:i - d/m', strtotime($item->interview_time)) }}
                                </div>
                            @endif

                            <!-- Quick Action Buttons -->
                            <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                                <a href="{{ route('azmedia.portal.candidate.detail', $item->id) }}" class="text-[11px] font-bold text-slate-600 hover:text-brand-600">
                                    Xem CV ➔
                                </a>

                                <!-- Move Stage Dropdown / Quick Buttons -->
                                <div class="flex items-center gap-1">
                                    @if($colKey === 'applied')
                                        <form action="{{ route('azmedia.portal.candidate.status', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="screening">
                                            <button type="submit" class="px-2 py-1 rounded-md text-[10px] font-bold bg-amber-500 hover:bg-amber-600 text-white shadow-sm" title="Duyệt CV">
                                                Duyệt CV
                                            </button>
                                        </form>
                                    @elseif($colKey === 'screening')
                                        <form action="{{ route('azmedia.portal.candidate.status', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="test_sent">
                                            <button type="submit" class="px-2 py-1 rounded-md text-[10px] font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm" title="Gửi bài Test Online">
                                                Gửi Test
                                            </button>
                                        </form>
                                    @elseif($colKey === 'test_sent')
                                        <a href="{{ route('azmedia.portal.candidate.detail', $item->id) }}#schedule" class="px-2 py-1 rounded-md text-[10px] font-bold bg-orange-600 hover:bg-orange-700 text-white shadow-sm" title="Lên lịch Phỏng vấn">
                                            Lên lịch PV
                                        </a>
                                    @elseif($colKey === 'interviewing')
                                        <form action="{{ route('azmedia.portal.candidate.status', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="offered">
                                            <button type="submit" class="px-2 py-1 rounded-md text-[10px] font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm" title="Đồng ý tiếp nhận thực tập (Offer)">
                                                Offer TTS
                                            </button>
                                        </form>
                                    @endif

                                    @if($colKey !== 'rejected' && $colKey !== 'offered')
                                        <form action="{{ route('azmedia.portal.candidate.status', $item->id) }}" method="POST" onsubmit="return confirm('Từ chối hồ sơ này và gửi thư cảm ơn?');">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="px-1.5 py-1 rounded-md text-[10px] font-bold bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-600" title="Từ chối">
                                                ✕
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center text-slate-400 text-xs italic">
                            Chưa có ứng viên ở bước này
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
