@extends('azmedia.layouts.app')

@section('title', $position->title . ' - Tuyển Dụng AZ Media Đà Nẵng')

@section('content')

<!-- Header Breadcrumb -->
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4">
            <a href="{{ route('azmedia.home') }}" class="hover:text-white transition">Trang chủ</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('azmedia.home') }}#positions" class="hover:text-white transition">Vị trí tuyển dụng</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-brand-400 font-semibold truncate">{{ $position->title }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 rounded-md text-xs font-bold bg-orange-500/20 text-brand-400 border border-orange-500/30">
                        {{ $position->department }}
                    </span>
                    @if($position->is_featured)
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-black bg-rose-500/20 text-rose-400 border border-rose-500/30">
                            🔥 Tuyển gấp
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                    {{ $position->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 text-xs sm:text-sm text-slate-300 mt-4">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-brand-500"></i> {{ $position->location }}</span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-money-bill-wave text-emerald-400"></i> {{ $position->stipend }}</span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-clock text-amber-400"></i> {{ $position->type === 'part_time' ? 'Bán thời gian (Part-time)' : 'Toàn thời gian (Full-time)' }}</span>
                </div>
            </div>

            <a href="#apply-section" class="px-7 py-3.5 rounded-xl font-bold text-white gradient-brand shadow-lg hover:shadow-xl transition flex items-center gap-2 text-sm">
                <i class="fa-solid fa-file-arrow-up"></i> Nộp hồ sơ ngay
            </a>
        </div>
    </div>
</div>

<!-- Main Body -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <!-- Left Column: Job Details -->
        <div class="lg:col-span-7 space-y-8">
            <!-- Tóm tắt vị trí -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
                <h2 class="text-xl font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-brand-600"></i> Giới thiệu vị trí
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $position->summary ?? $position->description }}
                </p>
            </div>

            <!-- Mô tả công việc (JD) -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
                <h2 class="text-xl font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-brand-600"></i> Mô tả công việc chi tiết
                </h2>
                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $position->description }}
                </div>
            </div>

            <!-- Yêu cầu đầu vào -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
                <h2 class="text-xl font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user-check text-brand-600"></i> Yêu cầu đối với thực tập sinh
                </h2>
                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $position->requirements }}
                </div>
            </div>

            <!-- Quyền lợi & Chế độ -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200/80 shadow-sm">
                <h2 class="text-xl font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-gift text-brand-600"></i> Quyền lợi & Hỗ trợ đào tạo
                </h2>
                <div class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $position->benefits }}
                </div>
            </div>

            <!-- Thông tin Mentor phụ trách -->
            <div class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-2xl border border-orange-200 shadow-sm flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl gradient-brand text-white flex items-center justify-center text-2xl font-bold shadow">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <h3 class="font-bold text-base text-slate-900">Cán bộ chuyên môn / Mentor phụ trách:</h3>
                    <p class="text-sm font-extrabold text-brand-600">{{ $position->mentor_name ?? 'Lê Đình Quang' }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">Triết lý đào tạo thực chiến 1-1: <em>"Thầy giỏi - Bạn tốt - Sách hay"</em></p>
                </div>
            </div>
        </div>

        <!-- Right Column: Sticky Quick Apply Form -->
        <div id="apply-section" class="lg:col-span-5 lg:sticky lg:top-24">
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                    <div class="w-12 h-12 rounded-2xl gradient-brand text-white flex items-center justify-center text-xl font-bold shadow">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-lg text-slate-900">Ứng tuyển vị trí này</h3>
                        <p class="text-xs text-slate-500">Điền thông tin và tải CV PDF để nộp hồ sơ</p>
                    </div>
                </div>

                <form action="{{ route('azmedia.apply.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4" onsubmit="handleSubmitDetail(this)">
                    @csrf
                    <input type="hidden" name="position_id" value="{{ $position->id }}">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Họ và tên <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="VD: Nguyễn Nhật Linh Ân"
                               class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" required placeholder="name@email.com"
                                   class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại <span class="text-rose-500">*</span></label>
                            <input type="tel" name="phone" required placeholder="0905..."
                                   class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Trường Đại học / Cao đẳng <span class="text-rose-500">*</span></label>
                        <input list="uni_list_detail" name="university" required placeholder="VD: Cao đẳng Đà Nẵng (DNC)"
                               class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        <datalist id="uni_list_detail">
                            <option value="Cao đẳng Đà Nẵng (DNC)">
                            <option value="Đại học Bách Khoa - ĐH Đà Nẵng">
                            <option value="ĐH CNTT & Truyền thông Việt - Hàn (VKU)">
                            <option value="ĐH Sư phạm Kỹ thuật - ĐH Đà Nẵng">
                            <option value="Đại học Duy Tân (DTU)">
                            <option value="Đại học FPT Đà Nẵng">
                        </datalist>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ngành học <span class="text-rose-500">*</span></label>
                            <input type="text" name="major" required placeholder="VD: Công nghệ Thông tin"
                                   class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ca thực tập <span class="text-rose-500">*</span></label>
                            <select name="working_shift" required class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none">
                                <option value="morning">Sáng (8h - 12h)</option>
                                <option value="afternoon">Chiều (13h30 - 17h30)</option>
                                <option value="fulltime" selected>Cả ngày (Full-time)</option>
                                <option value="flexible">Linh hoạt</option>
                            </select>
                        </div>
                    </div>

                    <!-- Github / Portfolio -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Link GitHub / Portfolio</label>
                        <input type="url" name="github_url" placeholder="https://github.com/..."
                               class="w-full text-xs sm:text-sm rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>

                    <!-- Upload File CV PDF -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            File CV (PDF, tối đa 5MB) <span class="text-rose-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-slate-300 hover:border-brand-500 rounded-2xl p-4 text-center cursor-pointer transition bg-slate-50 relative">
                            <input type="file" name="cv_file" required accept=".pdf,application/pdf"
                                   class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                                   onchange="updateDetailFileName(this)">
                            <div id="detail_file_label">
                                <i class="fa-solid fa-file-pdf text-2xl text-rose-500 mb-1"></i>
                                <p class="text-xs font-bold text-slate-700">Chọn file CV PDF</p>
                                <p class="text-[10px] text-slate-400">Tối đa 5MB</p>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="btnSubmitDetail" class="w-full py-3.5 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-lg transition flex items-center justify-center gap-2 text-sm disabled:opacity-60 disabled:cursor-not-allowed">
                        <i class="fa-solid fa-paper-plane" id="btnDetailIcon"></i> <span id="btnDetailText">Gửi đơn ứng tuyển</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function handleSubmitDetail(form) {
        const btn = document.getElementById('btnSubmitDetail');
        const icon = document.getElementById('btnDetailIcon');
        const text = document.getElementById('btnDetailText');
        if (btn) {
            btn.disabled = true;
            btn.classList.add('opacity-75');
            icon.className = 'fa-solid fa-circle-notch fa-spin';
            text.innerText = 'Đang gửi hồ sơ & gửi mã tra cứu qua Gmail...';
        }
        return true;
    }

    function updateDetailFileName(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const fileSize = (input.files[0].size / (1024 * 1024)).toFixed(2);
            document.getElementById('detail_file_label').innerHTML = `
                <i class="fa-solid fa-circle-check text-2xl text-emerald-500 mb-1"></i>
                <p class="text-xs font-bold text-slate-800">${fileName}</p>
                <p class="text-[10px] text-slate-500">${fileSize} MB</p>
            `;
        }
    }
</script>
@endpush
