@extends('azmedia.portal.layout')

@section('page_title', 'Quản Lý Vị Trí Tuyển Dụng Thực Tập Sinh')

@section('portal_content')

<div class="space-y-8">
    <!-- Header Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="font-extrabold text-lg text-slate-900">Danh Mục Vị Trí Tuyển Dụng TTS</h3>
            <p class="text-xs text-slate-500">Quản lý Thêm, Sửa, Xóa vị trí, đóng/mở tuyển dụng và chỉ tiêu thực tập</p>
        </div>
        <button type="button" onclick="document.getElementById('newPositionModal').classList.remove('hidden')"
                class="px-5 py-2.5 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-md transition text-xs sm:text-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Thêm vị trí mới
        </button>
    </div>

    <!-- Positions List Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 uppercase text-[10px] font-bold text-slate-400 tracking-wider">
                    <tr>
                        <th class="py-4 px-6">Tên vị trí</th>
                        <th class="py-4 px-6">Phòng ban</th>
                        <th class="py-4 px-6">Địa điểm</th>
                        <th class="py-4 px-6">Chỉ tiêu</th>
                        <th class="py-4 px-6">Đã nộp</th>
                        <th class="py-4 px-6">Trợ cấp</th>
                        <th class="py-4 px-6">Trạng thái</th>
                        <th class="py-4 px-6 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($positions as $p)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                <a href="{{ route('azmedia.job.detail', $p->slug) }}" target="_blank" class="hover:text-brand-600 transition">
                                    {{ $p->title }}
                                </a>
                                @if($p->is_featured)
                                    <span class="ml-1 px-2 py-0.5 rounded text-[10px] font-black bg-rose-100 text-rose-700">Gấp</span>
                                @endif
                                <div class="text-[10px] text-slate-400 font-normal mt-0.5">
                                    Phân loại: <strong class="uppercase text-slate-500">{{ $p->category }}</strong>
                                </div>
                            </td>
                            <td class="py-4 px-6">{{ $p->department }}</td>
                            <td class="py-4 px-6">{{ $p->location }}</td>
                            <td class="py-4 px-6 font-bold">{{ $p->quantity }} TTS</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full font-extrabold bg-blue-100 text-blue-800">
                                    {{ $p->applications_count }} CV
                                </span>
                            </td>
                            <td class="py-4 px-6 font-semibold text-brand-600">{{ $p->stipend }}</td>
                            <td class="py-4 px-6">
                                @if($p->status === 'open')
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">Đang mở</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-slate-200 text-slate-700">Đã đóng</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Nút Sửa -->
                                    <button type="button" onclick='openEditModal(@json($p))'
                                            class="px-2.5 py-1.5 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 text-xs font-bold transition flex items-center gap-1"
                                            title="Chỉnh sửa thông tin vị trí">
                                        <i class="fa-solid fa-pen-to-square"></i> Sửa
                                    </button>

                                    <!-- Nút Đóng / Mở tuyển -->
                                    <a href="{{ route('azmedia.portal.positions.toggle', $p->id) }}"
                                       class="px-2.5 py-1.5 rounded-lg text-xs font-bold {{ $p->status === 'open' ? 'bg-amber-50 text-amber-800 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }} transition flex items-center gap-1"
                                       title="{{ $p->status === 'open' ? 'Tạm đóng nhận hồ sơ' : 'Mở lại đợt tuyển' }}">
                                        <i class="fa-solid {{ $p->status === 'open' ? 'fa-pause' : 'fa-play' }}"></i>
                                        {{ $p->status === 'open' ? 'Đóng tuyển' : 'Mở lại' }}
                                    </a>

                                    <!-- Nút Xem tin trên web -->
                                    <a href="{{ route('azmedia.job.detail', $p->slug) }}" target="_blank"
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition flex items-center gap-1"
                                       title="Xem trang hiển thị công khai">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Xem tin
                                    </a>

                                    <!-- Nút Xóa -->
                                    <form action="{{ route('azmedia.portal.positions.delete', $p->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn XÓA vị trí \'{{ addslashes($p->title) }}\'? Toàn bộ hồ sơ ứng tuyển liên quan sẽ bị xóa.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition flex items-center gap-1"
                                                title="Xóa vị trí">
                                            <i class="fa-solid fa-trash-can"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-400 italic">
                                Chưa có vị trí tuyển dụng nào. Hãy nhấn "Thêm vị trí mới" để tạo.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ==========================================
     MODAL 1: THÊM VỊ TRÍ TUYỂN DỤNG MỚI
     ========================================== -->
<div id="newPositionModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="document.getElementById('newPositionModal').classList.add('hidden')"
                class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="flex items-center gap-3 mb-5 border-b border-slate-100 pb-3">
            <span class="w-10 h-10 rounded-2xl bg-orange-100 text-brand-600 flex items-center justify-center text-lg font-bold">
                <i class="fa-solid fa-plus"></i>
            </span>
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Thêm Vị Trí Tuyển Dụng Mới</h3>
                <p class="text-xs text-slate-500">Đăng tuyển vị trí thực tập sinh mới lên trang chủ AZHR</p>
            </div>
        </div>

        <form action="{{ route('azmedia.portal.positions.create') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Tiêu đề vị trí: <span class="text-rose-500">*</span></label>
                <input type="text" name="title" required placeholder="VD: Thực tập sinh Lập trình Web Fullstack (Laravel / Vue)"
                       class="w-full rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Phòng ban: <span class="text-rose-500">*</span></label>
                    <input type="text" name="department" required value="Công nghệ Thông tin"
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Phân loại bài test & chuyên môn: <span class="text-rose-500">*</span></label>
                    <select name="category" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="backend">Backend (PHP, Laravel, Node, DB)</option>
                        <option value="frontend">Frontend (Vue, React, HTML/CSS)</option>
                        <option value="tester">QA / Tester (Kiểm thử phần mềm)</option>
                        <option value="uiux">UI/UX & Đồ họa truyền thông</option>
                        <option value="marketing">Digital Marketing & Kênh Số</option>
                        <option value="ai">AI Solutions & Ứng dụng tự động hóa</option>
                        <option value="general">Chung (General)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Chỉ tiêu (số TTS): <span class="text-rose-500">*</span></label>
                    <input type="number" name="quantity" min="1" max="50" value="3" required
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Hình thức làm việc:</label>
                    <select name="type" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="part_time" selected>Bán thời gian (Part-time)</option>
                        <option value="full_time">Toàn thời gian (Full-time)</option>
                        <option value="flexible">Linh hoạt theo lịch học</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Hạn nộp hồ sơ:</label>
                    <input type="date" name="deadline" value="{{ now()->addMonths(2)->format('Y-m-d') }}"
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Địa điểm làm việc: <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" value="84 Nguyễn Hữu Dật, Hải Châu, Đà Nẵng" required
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Trợ cấp / Phụ cấp: <span class="text-rose-500">*</span></label>
                    <input type="text" name="stipend" value="3.500.000đ - 5.500.000đ / tháng + Thưởng dự án" required
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Mô tả công việc (JD): <span class="text-rose-500">*</span></label>
                <textarea name="description" rows="3" required placeholder="Tham gia phát triển hệ thống phần mềm, xây dựng website, làm việc nhóm theo mô hình Agile/Scrum..."
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Yêu cầu đầu vào:</label>
                <textarea name="requirements" rows="2" placeholder="Nắm vững kiến thức nền tảng, có tinh thần ham học hỏi, trách nhiệm cao, ưu tiên sinh viên năm 3, 4..."
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Quyền lợi thực tập:</label>
                <textarea name="benefits" rows="2" placeholder="Được đào tạo 1-1 bởi Mentor, hỗ trợ dấu mộc tròn báo cáo thực tập, phụ cấp hàng tháng và cơ hội nhận offer chính thức..."
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_featured" id="is_featured_new" value="1" class="rounded text-brand-600 focus:ring-brand-500">
                <label for="is_featured_new" class="text-xs text-slate-700 font-semibold cursor-pointer">
                    Đánh dấu vị trí <strong>Gấp / Ưu tiên tuyển gấp</strong> (Hiển thị nhãn nổi bật)
                </label>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-md transition text-xs flex items-center justify-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Lưu và Đăng Tuyển Vị Trí
            </button>
        </form>
    </div>
</div>

<!-- ==========================================
     MODAL 2: CHỈNH SỬA VỊ TRÍ TUYỂN DỤNG
     ========================================== -->
<div id="editPositionModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="document.getElementById('editPositionModal').classList.add('hidden')"
                class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="flex items-center gap-3 mb-5 border-b border-slate-100 pb-3">
            <span class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-lg font-bold">
                <i class="fa-solid fa-pen-to-square"></i>
            </span>
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Chỉnh Sửa Vị Trí Tuyển Dụng</h3>
                <p class="text-xs text-slate-500" id="edit_modal_subtitle">Cập nhật thông tin chi tiết và điều kiện tuyển</p>
            </div>
        </div>

        <form id="editPositionForm" action="" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Tiêu đề vị trí: <span class="text-rose-500">*</span></label>
                <input type="text" name="title" id="edit_title" required
                       class="w-full rounded-xl border border-slate-300 py-2.5 px-3 focus:ring-2 focus:ring-brand-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Phòng ban: <span class="text-rose-500">*</span></label>
                    <input type="text" name="department" id="edit_department" required
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Phân loại chuyên môn: <span class="text-rose-500">*</span></label>
                    <select name="category" id="edit_category" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="backend">Backend (PHP, Laravel, Node, DB)</option>
                        <option value="frontend">Frontend (Vue, React, HTML/CSS)</option>
                        <option value="tester">QA / Tester (Kiểm thử phần mềm)</option>
                        <option value="uiux">UI/UX & Đồ họa truyền thông</option>
                        <option value="marketing">Digital Marketing & Kênh Số</option>
                        <option value="ai">AI Solutions & Ứng dụng tự động hóa</option>
                        <option value="general">Chung (General)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Chỉ tiêu (số TTS): <span class="text-rose-500">*</span></label>
                    <input type="number" name="quantity" id="edit_quantity" min="1" max="50" required
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Hình thức làm việc:</label>
                    <select name="type" id="edit_type" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="part_time">Bán thời gian (Part-time)</option>
                        <option value="full_time">Toàn thời gian (Full-time)</option>
                        <option value="flexible">Linh hoạt theo lịch học</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Trạng thái:</label>
                    <select name="status" id="edit_status" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="open">Đang mở tuyển (Open)</option>
                        <option value="closed">Đã đóng tuyển (Closed)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Địa điểm làm việc: <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" id="edit_location" required
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Trợ cấp / Phụ cấp: <span class="text-rose-500">*</span></label>
                    <input type="text" name="stipend" id="edit_stipend" required
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Hạn nộp hồ sơ:</label>
                    <input type="date" name="deadline" id="edit_deadline"
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Yêu cầu kinh nghiệm:</label>
                    <input type="text" name="experience_required" id="edit_experience_required"
                           class="w-full rounded-xl border border-slate-300 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Mô tả công việc (JD): <span class="text-rose-500">*</span></label>
                <textarea name="description" id="edit_description" rows="3" required
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Yêu cầu đầu vào:</label>
                <textarea name="requirements" id="edit_requirements" rows="2"
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Quyền lợi thực tập:</label>
                <textarea name="benefits" id="edit_benefits" rows="2"
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_featured" id="edit_is_featured" value="1" class="rounded text-brand-600 focus:ring-brand-500">
                <label for="edit_is_featured" class="text-xs text-slate-700 font-semibold cursor-pointer">
                    Đánh dấu vị trí <strong>Gấp / Ưu tiên tuyển gấp</strong> (Hiển thị nhãn nổi bật)
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editPositionModal').classList.add('hidden')"
                        class="w-1/3 py-2.5 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-xs">
                    Hủy bỏ
                </button>
                <button type="submit" class="w-2/3 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow hover:shadow-md transition text-xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Cập Nhật Vị Trí
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openEditModal(pos) {
        const form = document.getElementById('editPositionForm');
        form.action = `/portal/positions/${pos.id}/update`;

        document.getElementById('edit_modal_subtitle').textContent = `ID: #${pos.id} — ${pos.title}`;
        document.getElementById('edit_title').value = pos.title || '';
        document.getElementById('edit_department').value = pos.department || '';
        document.getElementById('edit_category').value = pos.category || 'general';
        document.getElementById('edit_quantity').value = pos.quantity || 3;
        document.getElementById('edit_type').value = pos.type || 'part_time';
        document.getElementById('edit_status').value = pos.status || 'open';
        document.getElementById('edit_location').value = pos.location || '';
        document.getElementById('edit_stipend').value = pos.stipend || '';
        document.getElementById('edit_experience_required').value = pos.experience_required || '';
        document.getElementById('edit_deadline').value = pos.deadline ? pos.deadline.substring(0, 10) : '';
        document.getElementById('edit_description').value = pos.description || '';
        document.getElementById('edit_requirements').value = pos.requirements || '';
        document.getElementById('edit_benefits').value = pos.benefits || '';
        document.getElementById('edit_is_featured').checked = !!pos.is_featured;

        document.getElementById('editPositionModal').classList.remove('hidden');
    }
</script>
@endpush
