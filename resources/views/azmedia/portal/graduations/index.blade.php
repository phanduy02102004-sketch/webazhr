@extends('azmedia.portal.layout')

@section('title', 'Quản Lý Chuẩn Đầu Ra TTS – AZ Media Đà Nẵng')
@section('page_title', 'Quản Lý Chuẩn Đầu Ra Thực Tập Sinh')

@section('portal_content')
<div class="space-y-6">

    <!-- Thống kê tổng quan -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <!-- Tổng hồ sơ -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tổng TTS theo dõi</div>
            <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalGraduations }}</div>
            <div class="text-[10px] text-slate-500 mt-1">Đợt thực tập 2026</div>
        </div>

        <!-- Đã duyệt cấp mộc -->
        <div class="bg-white p-4 rounded-2xl border border-emerald-200 shadow-sm bg-emerald-50/30">
            <div class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Đạt Chuẩn Đầu Ra</div>
            <div class="text-2xl font-extrabold text-emerald-700 mt-1">{{ $approvedCount }}</div>
            <div class="text-[10px] text-emerald-600 mt-1">Đã cấp mộc & báo cáo</div>
        </div>

        <!-- Chờ BĐH duyệt -->
        <div class="bg-white p-4 rounded-2xl border border-blue-200 shadow-sm bg-blue-50/30">
            <div class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Chờ BĐH Duyệt</div>
            <div class="text-2xl font-extrabold text-blue-700 mt-1">{{ $pendingCount }}</div>
            <div class="text-[10px] text-blue-600 mt-1">Đã gửi hồ sơ</div>
        </div>

        <!-- Đang thực hiện -->
        <div class="bg-white p-4 rounded-2xl border border-amber-200 shadow-sm bg-amber-50/30">
            <div class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Đang hoàn thiện</div>
            <div class="text-2xl font-extrabold text-amber-700 mt-1">{{ $inProgressCount }}</div>
            <div class="text-[10px] text-amber-600 mt-1">Chưa đủ tiêu chí</div>
        </div>

        <!-- Lịch hẹn AZ SUPPORT -->
        <div class="bg-white p-4 rounded-2xl border border-purple-200 shadow-sm bg-purple-50/30">
            <div class="text-[11px] font-bold text-purple-600 uppercase tracking-wider">Lịch hẹn nộp bài</div>
            <div class="text-2xl font-extrabold text-purple-700 mt-1">{{ $appointmentCount }}</div>
            <div class="text-[10px] text-purple-600 mt-1">Cổng AZ SUPPORT</div>
        </div>

        <!-- Mục 1+1 hoàn thành -->
        <div class="bg-white p-4 rounded-2xl border border-orange-200 shadow-sm bg-orange-50/30">
            <div class="text-[11px] font-bold text-orange-600 uppercase tracking-wider">Hoàn thành 1+1</div>
            <div class="text-2xl font-extrabold text-orange-700 mt-1">{{ $referralCount }}</div>
            <div class="text-[10px] text-orange-600 mt-1">Giới thiệu TTS mới</div>
        </div>
    </div>

    <!-- Bộ lọc & Tìm kiếm -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('azmedia.portal.graduations.index') }}" class="flex flex-wrap items-center gap-3 w-full">
            <!-- Search input -->
            <div class="relative flex-1 min-w-[240px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-search text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Tìm theo Tên TTS, Mã SV, Mã CDR, SĐT, Email..."
                       class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <!-- Filter Status -->
            <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                <option value="all">-- Tất cả trạng thái --</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Đang thực hiện</option>
                <option value="pending_review" {{ request('status') === 'pending_review' ? 'selected' : '' }}>Chờ BĐH duyệt</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Đạt Chuẩn Đầu Ra (Đã cấp mộc)</option>
                <option value="needs_update" {{ request('status') === 'needs_update' ? 'selected' : '' }}>Cần bổ sung hồ sơ</option>
            </select>

            <!-- Filter School -->
            <select name="school" onchange="this.form.submit()" class="px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                <option value="all">-- Tất cả trường ĐH/CĐ --</option>
                @foreach($schools as $sch)
                    <option value="{{ $sch }}" {{ request('school') === $sch ? 'selected' : '' }}>{{ $sch }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                Lọc
            </button>

            @if(request()->hasAny(['search', 'status', 'school']))
                <a href="{{ route('azmedia.portal.graduations.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-800 transition">
                    Xóa lọc
                </a>
            @endif
        </form>

        <a href="{{ route('azmedia.graduation.index') }}" target="_blank"
           class="whitespace-nowrap px-4 py-2 rounded-xl bg-orange-100 text-brand-700 hover:bg-orange-200 text-xs font-bold transition flex items-center gap-1.5 flex-shrink-0">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Xem Cổng TTS
        </a>
    </div>

    <!-- Bảng danh sách chuẩn đầu ra -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3.5">Mã CDR</th>
                        <th class="px-4 py-3.5">Thực Tập Sinh / Trường</th>
                        <th class="px-4 py-3.5">Vị trí thực tập</th>
                        <th class="px-4 py-3.5 text-center">Tiến độ</th>
                        <th class="px-4 py-3.5 text-center">Mục 1: Khảo sát</th>
                        <th class="px-4 py-3.5 text-center">Mục 2: Báo cáo</th>
                        <th class="px-4 py-3.5 text-center">Lịch hẹn AZ SUPPORT</th>
                        <th class="px-4 py-3.5 text-center">Mục 1+1</th>
                        <th class="px-4 py-3.5 text-center">Trạng thái</th>
                        <th class="px-4 py-3.5 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($graduations as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Mã CDR -->
                            <td class="px-4 py-3 font-mono font-bold text-brand-700 whitespace-nowrap">
                                <a href="{{ route('azmedia.portal.graduations.detail', $item->id) }}" class="hover:underline">
                                    {{ $item->graduation_code }}
                                </a>
                            </td>

                            <!-- Thông tin TTS -->
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900 text-sm">
                                    <a href="{{ route('azmedia.portal.graduations.detail', $item->id) }}" class="hover:text-brand-600 transition">
                                        {{ $item->student_name }}
                                    </a>
                                </div>
                                <div class="text-[11px] text-slate-400 flex items-center gap-2 mt-0.5">
                                    @if($item->student_code)
                                        <span class="font-mono bg-slate-100 px-1.5 py-0.2 rounded text-slate-700 font-semibold">{{ $item->student_code }}</span>
                                    @endif
                                    <span>{{ $item->school }}</span>
                                </div>
                            </td>

                            <!-- Vị trí thực tập -->
                            <td class="px-4 py-3">
                                <span class="font-medium text-slate-800">{{ $item->intern_position ?? 'TTS AZ Media' }}</span>
                                <div class="text-[11px] text-slate-400">{{ $item->major }}</div>
                            </td>

                            <!-- Tiến độ % -->
                            <td class="px-4 py-3 text-center">
                                <div class="font-extrabold text-xs {{ $item->progress_percent >= 100 ? 'text-emerald-600' : 'text-slate-800' }}">
                                    {{ $item->progress_percent }}%
                                </div>
                                <div class="w-16 mx-auto bg-slate-200 h-1.5 rounded-full mt-1 overflow-hidden">
                                    <div class="h-1.5 rounded-full {{ $item->progress_percent >= 100 ? 'bg-emerald-500' : 'bg-brand-500' }}" style="width: {{ $item->progress_percent }}%"></div>
                                </div>
                            </td>

                            <!-- Mục 1: Khảo sát -->
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if($item->survey_1_completed && $item->survey_2_completed)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check"></i> Đủ 2 form
                                    </span>
                                @elseif($item->survey_1_completed || $item->survey_2_completed)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                        1/2 form
                                    </span>
                                @else
                                    <span class="text-slate-300"><i class="fa-solid fa-circle-minus"></i></span>
                                @endif
                            </td>

                            <!-- Mục 2: Báo cáo -->
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1 text-[11px]">
                                    <span title="Bản thảo" class="px-1.5 py-0.5 rounded {{ $item->report_draft_submitted ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-slate-100 text-slate-400' }}">B1</span>
                                    <span title="Bản cuối" class="px-1.5 py-0.5 rounded {{ $item->report_final_submitted ? 'bg-emerald-100 text-emerald-800 font-bold' : 'bg-slate-100 text-slate-400' }}">B2</span>
                                    <span title="Bản cứng mộc" class="px-1.5 py-0.5 rounded {{ $item->hard_copy_submitted ? 'bg-purple-100 text-purple-800 font-bold' : 'bg-slate-100 text-slate-400' }}">Mộc</span>
                                </div>
                            </td>

                            <!-- Lịch hẹn AZ SUPPORT -->
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if($item->appointment_booked)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">
                                        <i class="fa-solid fa-calendar-check"></i> {{ $item->appointment_date }}
                                    </span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            <!-- Mục 1+1 -->
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                @if($item->referral_completed)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-user-check"></i> Đạt 1+1
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                        Chưa có
                                    </span>
                                @endif
                            </td>

                            <!-- Trạng thái -->
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-extrabold border {{ $item->status_badge['class'] }}">
                                    {{ $item->status_badge['label'] }}
                                </span>
                            </td>

                            <!-- Thao tác -->
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('azmedia.portal.graduations.detail', $item->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-brand-600 hover:text-white text-slate-700 font-bold transition text-xs shadow-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Xem & Duyệt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-10 text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                Không tìm thấy hồ sơ chuẩn đầu ra nào khớp với điều kiện lọc.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($graduations->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $graduations->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
