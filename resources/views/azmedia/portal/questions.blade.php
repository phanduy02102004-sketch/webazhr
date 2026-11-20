@extends('azmedia.portal.layout')

@section('page_title', 'Ngân Hàng Câu Hỏi Trắc Nghiệm Đánh Giá Năng Lực')

@section('portal_content')

<div class="space-y-8">
    <!-- Header Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h3 class="font-extrabold text-lg text-slate-900">Ngân Hàng Đề Thi Test Online</h3>
            <p class="text-xs text-slate-500">Bộ câu hỏi trắc nghiệm kỹ thuật và văn hóa AZ Media phục vụ vòng lọc tự động</p>
        </div>
        <button type="button" onclick="document.getElementById('newQuestionModal').classList.remove('hidden')"
                class="px-5 py-2.5 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-md transition text-xs sm:text-sm flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Thêm câu hỏi mới
        </button>
    </div>

    <!-- Questions Grid / List -->
    <div class="space-y-4">
        @foreach($questions as $idx => $q)
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                <div class="flex items-start justify-between gap-4 mb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded-lg bg-orange-100 text-brand-700 font-extrabold text-xs flex items-center justify-center">
                            {{ $idx + 1 }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">
                            Chuyên mục: {{ $q->position_category }}
                        </span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                            Đáp án đúng: {{ $q->correct_option }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-500 mr-1">{{ $q->points }} điểm</span>
                        <!-- Nút Sửa -->
                        <button type="button" onclick='openEditQuestionModal(@json($q))'
                                class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100 text-xs font-bold transition flex items-center gap-1 shadow-sm"
                                title="Chỉnh sửa câu hỏi">
                            <i class="fa-solid fa-pen-to-square"></i> Sửa
                        </button>
                        <!-- Nút Xóa -->
                        <form action="{{ route('azmedia.portal.questions.delete', $q->id) }}" method="POST" class="inline"
                              onsubmit="return confirm('Bạn có chắc chắn muốn XÓA câu hỏi #{{ $q->id }} này không? Thao tác này không thể hoàn tác.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-2.5 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition flex items-center gap-1 shadow-sm"
                                    title="Xóa câu hỏi">
                                <i class="fa-solid fa-trash-can"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>

                <h4 class="text-sm font-bold text-slate-900 mb-3 leading-relaxed">
                    {{ $q->question }}
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-600 mb-3 pl-2">
                    <div class="p-2 rounded-lg {{ $q->correct_option === 'A' ? 'bg-emerald-50 border border-emerald-200 font-bold text-emerald-900' : 'bg-slate-50' }}">
                        A. {{ $q->option_a }}
                    </div>
                    <div class="p-2 rounded-lg {{ $q->correct_option === 'B' ? 'bg-emerald-50 border border-emerald-200 font-bold text-emerald-900' : 'bg-slate-50' }}">
                        B. {{ $q->option_b }}
                    </div>
                    <div class="p-2 rounded-lg {{ $q->correct_option === 'C' ? 'bg-emerald-50 border border-emerald-200 font-bold text-emerald-900' : 'bg-slate-50' }}">
                        C. {{ $q->option_c }}
                    </div>
                    <div class="p-2 rounded-lg {{ $q->correct_option === 'D' ? 'bg-emerald-50 border border-emerald-200 font-bold text-emerald-900' : 'bg-slate-50' }}">
                        D. {{ $q->option_d }}
                    </div>
                </div>

                @if($q->explanation)
                    <div class="p-3 rounded-xl bg-orange-50/70 text-[11px] text-brand-900 border border-orange-100">
                        <strong>Giải thích:</strong> {{ $q->explanation }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Modal Add Question -->
<div id="newQuestionModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="document.getElementById('newQuestionModal').classList.add('hidden')"
                class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-lg font-extrabold text-slate-900 mb-4">Thêm Câu Hỏi Trắc Nghiệm Mới</h3>

        <form action="{{ route('azmedia.portal.questions.create') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Chuyên mục:</label>
                    <select name="position_category" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="azmedia">AZ Media (Văn hóa & Đào tạo)</option>
                        <option value="general">Triết lý & Năng lực Chung</option>
                        <option value="backend">Backend (PHP / Laravel)</option>
                        <option value="frontend">Frontend (Vue / React)</option>
                        <option value="tester">QA / Tester</option>
                        <option value="uiux">UI/UX Design</option>
                        <option value="marketing">Marketing & Media</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Điểm số:</label>
                    <select name="points" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500 font-bold">
                        <option value="20" selected>20 điểm</option>
                        <option value="10">10 điểm</option>
                        <option value="15">15 điểm</option>
                        <option value="25">25 điểm</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Đáp án đúng:</label>
                    <select name="correct_option" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500 font-bold text-emerald-700">
                        <option value="A">Đáp án A</option>
                        <option value="B">Đáp án B</option>
                        <option value="C">Đáp án C</option>
                        <option value="D">Đáp án D</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nội dung câu hỏi:</label>
                <textarea name="question" rows="2" required placeholder="Nhập câu hỏi trắc nghiệm..."
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn A:</label>
                <input type="text" name="option_a" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn B:</label>
                <input type="text" name="option_b" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn C:</label>
                <input type="text" name="option_c" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn D:</label>
                <input type="text" name="option_d" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Giải thích đáp án:</label>
                <textarea name="explanation" rows="2" placeholder="Giải thích vì sao đáp án này đúng..."
                          class="w-full rounded-xl border border-slate-300 p-2.5"></textarea>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-md transition text-xs">
                Lưu Câu Hỏi Vào Ngân Hàng
            </button>
        </form>
    </div>
</div>

<!-- Modal Edit Question -->
<div id="editQuestionModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="document.getElementById('editQuestionModal').classList.add('hidden')"
                class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 id="edit_modal_title" class="text-lg font-extrabold text-slate-900 mb-1">Chỉnh Sửa Câu Hỏi Trắc Nghiệm</h3>
        <p class="text-xs text-slate-500 mb-4">Cập nhật nội dung câu hỏi, các lựa chọn A, B, C, D và đáp án đúng</p>

        <form id="editQuestionForm" action="" method="POST" class="space-y-4 text-xs">
            @csrf
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Chuyên mục:</label>
                    <select name="position_category" id="edit_position_category" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                        <option value="azmedia">AZ Media (Văn hóa & Đào tạo)</option>
                        <option value="general">Triết lý & Năng lực Chung</option>
                        <option value="backend">Backend (PHP / Laravel)</option>
                        <option value="frontend">Frontend (Vue / React)</option>
                        <option value="tester">QA / Tester</option>
                        <option value="uiux">UI/UX Design</option>
                        <option value="marketing">Marketing & Media</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Điểm số:</label>
                    <select name="points" id="edit_points" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500 font-bold">
                        <option value="20">20 điểm</option>
                        <option value="10">10 điểm</option>
                        <option value="15">15 điểm</option>
                        <option value="25">25 điểm</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Đáp án đúng:</label>
                    <select name="correct_option" id="edit_correct_option" class="w-full rounded-xl border border-slate-300 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500 font-bold text-emerald-700">
                        <option value="A">Đáp án A</option>
                        <option value="B">Đáp án B</option>
                        <option value="C">Đáp án C</option>
                        <option value="D">Đáp án D</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Nội dung câu hỏi:</label>
                <textarea name="question" id="edit_question" rows="3" required placeholder="Nhập nội dung câu hỏi..."
                          class="w-full rounded-xl border border-slate-300 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn A:</label>
                <input type="text" name="option_a" id="edit_option_a" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn B:</label>
                <input type="text" name="option_b" id="edit_option_b" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn C:</label>
                <input type="text" name="option_c" id="edit_option_c" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Lựa chọn D:</label>
                <input type="text" name="option_d" id="edit_option_d" required class="w-full rounded-xl border border-slate-300 py-2 px-3">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Giải thích đáp án:</label>
                <textarea name="explanation" id="edit_explanation" rows="2" placeholder="Giải thích vì sao đáp án này đúng..."
                          class="w-full rounded-xl border border-slate-300 p-2.5"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('editQuestionModal').classList.add('hidden')"
                        class="w-1/3 py-2.5 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-xs">
                    Hủy bỏ
                </button>
                <button type="submit" class="w-2/3 py-2.5 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow hover:shadow-md transition text-xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu Thay Đổi Câu Hỏi
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openEditQuestionModal(q) {
        const form = document.getElementById('editQuestionForm');
        form.action = `/portal/questions/${q.id}/update`;

        document.getElementById('edit_modal_title').textContent = `Chỉnh Sửa Câu Hỏi #${q.id}`;
        document.getElementById('edit_position_category').value = q.position_category || 'azmedia';
        document.getElementById('edit_points').value = q.points || 20;
        document.getElementById('edit_correct_option').value = q.correct_option || 'A';
        document.getElementById('edit_question').value = q.question || '';
        document.getElementById('edit_option_a').value = q.option_a || '';
        document.getElementById('edit_option_b').value = q.option_b || '';
        document.getElementById('edit_option_c').value = q.option_c || '';
        document.getElementById('edit_option_d').value = q.option_d || '';
        document.getElementById('edit_explanation').value = q.explanation || '';

        document.getElementById('editQuestionModal').classList.remove('hidden');
    }
</script>
@endpush
