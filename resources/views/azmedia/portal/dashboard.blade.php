@extends('azmedia.portal.layout')

@section('page_title', 'Báo Cáo & Thống Kê Tuyển Dụng (Dashboard & Analytics)')

@section('portal_content')

<div class="space-y-8">
    <!-- Top 4 Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Metric 1: Vị trí đang mở -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Vị trí tuyển TTS</span>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalPositions }}</div>
                <div class="text-[11px] text-emerald-600 font-semibold mt-1">
                    <i class="fa-solid fa-circle-check"></i> Đang mở tuyển sinh viên
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-100 text-brand-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-briefcase"></i>
            </div>
        </div>

        <!-- Metric 2: Tổng số CV tiếp nhận -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tổng Hồ Sơ (CV)</span>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalApplications }}</div>
                <div class="text-[11px] font-semibold mt-1">
                    <a href="{{ route('azmedia.portal.applications', ['status' => 'tested']) }}" class="text-emerald-700 hover:text-emerald-800 hover:underline flex items-center gap-1 font-bold">
                        <i class="fa-solid fa-file-circle-check"></i> {{ $totalTested }} ứng viên đã nộp bài test ➔
                    </a>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-file-lines"></i>
            </div>
        </div>

        <!-- Metric 3: Đang phỏng vấn -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Đang Phỏng Vấn</span>
                <div class="text-3xl font-extrabold text-slate-900 mt-1">{{ $totalInterviews }}</div>
                <div class="text-[11px] text-amber-600 font-semibold mt-1">
                    <i class="fa-solid fa-calendar-check"></i> Lịch PV tại 84 Nguyễn Hữu Dật
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>

        <!-- Metric 4: Đã nhận thực tập (Offer) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Đã Nhận Thực Tập</span>
                <div class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $totalOffers }}</div>
                <div class="text-[11px] text-emerald-600 font-semibold mt-1">
                    <i class="fa-solid fa-award"></i> Tỷ lệ đạt {{ $totalApplications > 0 ? round(($totalOffers / $totalApplications) * 100, 1) : 0 }}%
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <!-- Charts & Analytics Section (Yêu cầu phân hệ Báo cáo & Thống kê trong PDF) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Funnel Pipeline Conversion Rate (Tỷ lệ chuyển đổi qua các vòng) -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-base text-slate-900">Phễu Tuyển Dụng & Tỷ Lệ Chuyển Đổi (Conversion Funnel)</h3>
                    <p class="text-xs text-slate-500">Tiến trình ứng viên qua từng vòng lọc tự động & phỏng vấn</p>
                </div>
                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-orange-100 text-brand-700">Workflow Chuẩn</span>
            </div>

            <div class="space-y-4">
                @foreach($pipelineStages as $stageKey => $stageInfo)
                    @php
                        $percentage = $totalApplications > 0 ? round(($stageInfo['count'] / $totalApplications) * 100) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-xs font-bold mb-1">
                            <span class="text-slate-700">{{ $stageInfo['label'] }}</span>
                            <span class="text-slate-900">{{ $stageInfo['count'] }} ứng viên <span class="text-slate-400 font-normal">({{ $percentage }}%)</span></span>
                        </div>
                        <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ max($percentage, 5) }}%; background-color: {{ $stageInfo['color'] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Luồng xử lý: Nộp đơn ➔ Duyệt CV ➔ Làm bài Test ➔ Phỏng vấn ➔ Offer</span>
                <a href="{{ route('azmedia.portal.kanban') }}" class="text-brand-600 font-bold hover:underline">
                    Mở bảng Kanban ➔
                </a>
            </div>
        </div>

        <!-- University Distribution (Thống kê nguồn ứng viên đến từ trường ĐH/CĐ) -->
        <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-base text-slate-900">Nguồn Ứng Viên Theo Trường</h3>
                    <p class="text-xs text-slate-500">Top các trường Đại học & Cao đẳng tại Đà Nẵng</p>
                </div>
                <i class="fa-solid fa-graduation-cap text-slate-400"></i>
            </div>

            <div class="space-y-3.5">
                @forelse($universitiesData as $uni)
                    @php
                        $uniPercent = $totalApplications > 0 ? round(($uni->count / $totalApplications) * 100) : 0;
                    @endphp
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60">
                        <div class="flex justify-between items-center text-xs font-bold mb-1">
                            <span class="text-slate-800 truncate">{{ $uni->university }}</span>
                            <span class="text-brand-600 font-extrabold ml-2">{{ $uni->count }} CV ({{ $uniPercent }}%)</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden">
                            <div class="h-full rounded-full bg-brand-500" style="width: {{ $uniPercent }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">Chưa có dữ liệu trường học.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- CVs Per Position Table (Thống kê số lượng CV theo từng vị trí tuyển dụng) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="font-extrabold text-base text-slate-900">Thống Kê Số Lượng CV Theo Vị Trí Tuyển Dụng</h3>
                <p class="text-xs text-slate-500">Theo dõi tiến độ tuyển quân của từng phòng ban</p>
            </div>
            <a href="{{ route('azmedia.portal.positions') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white gradient-brand shadow hover:shadow-md transition">
                + Thêm vị trí mới
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 uppercase text-[10px] font-bold text-slate-400 tracking-wider">
                    <tr>
                        <th class="py-3 px-6">Vị trí tuyển dụng</th>
                        <th class="py-3 px-6">Phòng ban</th>
                        <th class="py-3 px-6">Địa điểm</th>
                        <th class="py-3 px-6">Chỉ tiêu</th>
                        <th class="py-3 px-6">Số CV đã nhận</th>
                        <th class="py-3 px-6">Trạng thái</th>
                        <th class="py-3 px-6 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($positionsData as $p)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-6 font-bold text-slate-900">
                                {{ $p->title }}
                            </td>
                            <td class="py-3.5 px-6">{{ $p->department }}</td>
                            <td class="py-3.5 px-6">{{ $p->location }}</td>
                            <td class="py-3.5 px-6 font-bold">{{ $p->quantity }} TTS</td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-full font-extrabold bg-blue-100 text-blue-800 text-xs">
                                    {{ $p->applications_count }} CV
                                </span>
                            </td>
                            <td class="py-3.5 px-6">
                                @if($p->status === 'open')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Đang tuyển</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700">Đã đóng</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-right">
                                <a href="{{ route('azmedia.portal.applications', ['position_id' => $p->id]) }}" class="text-brand-600 font-bold hover:underline">
                                    Xem ứng viên ➔
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Applications Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="font-extrabold text-base text-slate-900">Hồ Sơ Ứng Tuyển Mới Nhất</h3>
                <p class="text-xs text-slate-500">Các hồ sơ sinh viên vừa gửi qua cổng Careers</p>
            </div>
            <a href="{{ route('azmedia.portal.applications') }}" class="text-xs font-bold text-brand-600 hover:underline">
                Xem tất cả hồ sơ ({{ $totalApplications }}) ➔
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 uppercase text-[10px] font-bold text-slate-400 tracking-wider">
                    <tr>
                        <th class="py-3 px-6">Mã HS</th>
                        <th class="py-3 px-6">Ứng viên</th>
                        <th class="py-3 px-6">Trường & Ngành</th>
                        <th class="py-3 px-6">Vị trí ứng tuyển</th>
                        <th class="py-3 px-6">Trạng thái</th>
                        <th class="py-3 px-6">Ngày nộp</th>
                        <th class="py-3 px-6 text-right">Xem chi tiết</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recentApplications as $app)
                        @php $badge = $app->status_badge; @endphp
                        <tr class="hover:bg-slate-50/80 transition font-medium">
                            <td class="py-3.5 px-6 font-bold text-brand-600">
                                {{ $app->application_code }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-900">
                                {{ $app->candidate->name }}
                            </td>
                            <td class="py-3.5 px-6">
                                {{ $app->candidate->university }}
                            </td>
                            <td class="py-3.5 px-6">{{ $app->position->title }}</td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold {{ $badge['class'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-400">
                                {{ $app->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3.5 px-6 text-right space-x-1.5 whitespace-nowrap">
                                @if($app->testResult && $app->testResult->completed_at)
                                    <a href="{{ route('azmedia.portal.candidate.test.pdf', $app->id) }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold transition text-[11px]" title="Xem file PDF bài test">
                                        <i class="fa-solid fa-file-pdf"></i> PDF Test
                                    </a>
                                @endif
                                <a href="{{ route('azmedia.portal.candidate.detail', $app->id) }}" class="inline-block px-3 py-1.5 rounded-lg bg-slate-900 text-white font-bold hover:bg-slate-800 transition text-[11px]">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
