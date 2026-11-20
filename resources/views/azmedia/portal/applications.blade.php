@extends('azmedia.portal.layout')

@section('page_title', 'Danh Sách Hồ Sơ Ứng Tuyển (Applications)')

@section('portal_content')

<div class="space-y-6">
    <!-- Filters & Search Toolbar -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <form action="{{ route('azmedia.portal.applications') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Keyword -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tìm kiếm ứng viên:</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên, Email, SĐT, Mã HS..."
                       class="w-full text-xs rounded-xl border border-slate-200 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Trạng thái hồ sơ:</label>
                <select name="status" class="w-full text-xs rounded-xl border border-slate-200 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    <option value="all">Tất cả trạng thái</option>
                    <option value="applied" {{ request('status') == 'applied' ? 'selected' : '' }}>Mới nộp (Applied)</option>
                    <option value="screening" {{ request('status') == 'screening' ? 'selected' : '' }}>Duyệt CV (Screening)</option>
                    <option value="test_sent" {{ request('status') == 'test_sent' ? 'selected' : '' }}>Đã gửi bài Test</option>
                    <option value="tested" {{ request('status') == 'tested' ? 'selected' : '' }}>Đã hoàn thành Test</option>
                    <option value="interviewing" {{ request('status') == 'interviewing' ? 'selected' : '' }}>Đang phỏng vấn</option>
                    <option value="offered" {{ request('status') == 'offered' ? 'selected' : '' }}>Nhận thực tập (Offered)</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối (Rejected)</option>
                </select>
            </div>

            <!-- Filter Position -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Vị trí tuyển dụng:</label>
                <select name="position_id" class="w-full text-xs rounded-xl border border-slate-200 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    <option value="all">Tất cả vị trí</option>
                    @foreach($positions as $p)
                        <option value="{{ $p->id }}" {{ request('position_id') == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Actions -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                    <i class="fa-solid fa-filter mr-1"></i> Lọc hồ sơ
                </button>
                <a href="{{ route('azmedia.portal.applications') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-bold transition" title="Xóa lọc">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-extrabold text-base text-slate-900">Danh Sách Ứng Viên Tuyển Dụng</h3>
            <span class="text-xs text-slate-500">Hiển thị {{ $applications->count() }} hồ sơ</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 uppercase text-[10px] font-bold text-slate-400 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-6">Mã HS</th>
                        <th class="py-3.5 px-6">Họ và tên</th>
                        <th class="py-3.5 px-6">Trường & Ngành</th>
                        <th class="py-3.5 px-6">Vị trí nộp</th>
                        <th class="py-3.5 px-6">Điểm Test</th>
                        <th class="py-3.5 px-6">Trạng thái</th>
                        <th class="py-3.5 px-6">Ngày nộp</th>
                        <th class="py-3.5 px-6 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($applications as $app)
                        @php $badge = $app->status_badge; @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-6 font-bold text-brand-600">
                                {{ $app->application_code }}
                            </td>
                            <td class="py-3.5 px-6 font-bold text-slate-900">
                                <a href="{{ route('azmedia.portal.candidate.detail', $app->id) }}" class="hover:text-brand-600 transition">
                                    {{ $app->candidate->name }}
                                </a>
                                <div class="text-[10px] text-slate-400 font-normal">{{ $app->candidate->email }} • {{ $app->candidate->phone }}</div>
                            </td>
                            <td class="py-3.5 px-6">
                                <div class="text-slate-800 font-semibold">{{ $app->candidate->university }}</div>
                                <div class="text-[10px] text-slate-400">{{ $app->candidate->major }}</div>
                            </td>
                            <td class="py-3.5 px-6 max-w-xs truncate">
                                {{ $app->position->title }}
                            </td>
                            <td class="py-3.5 px-6">
                                @if($app->testResult)
                                    <span class="px-2 py-0.5 rounded font-black {{ $app->testResult->passed ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $app->testResult->score }}/100
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Chưa làm</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold {{ $badge['class'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-6 text-slate-400">
                                {{ $app->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3.5 px-6 text-right space-x-2">
                                <a href="{{ route('azmedia.portal.candidate.cv', $app->id) }}" target="_blank"
                                   class="px-2.5 py-1.5 rounded-lg bg-orange-50 text-brand-700 hover:bg-orange-100 font-bold transition" title="Xem CV PDF">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                                @if($app->testResult && $app->testResult->completed_at)
                                    <a href="{{ route('azmedia.portal.candidate.test.pdf', $app->id) }}" target="_blank"
                                       class="px-2.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold transition" title="Xem PDF Bài Test (Phần 1, 2, 3, 4)">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </a>
                                @endif
                                <a href="{{ route('azmedia.portal.candidate.detail', $app->id) }}"
                                   class="px-3 py-1.5 rounded-lg bg-slate-900 text-white hover:bg-slate-800 font-bold transition">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 italic">
                                Không tìm thấy ứng viên nào phù hợp với điều kiện tìm kiếm.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $applications->links() }}
        </div>
    </div>
</div>

@endsection
