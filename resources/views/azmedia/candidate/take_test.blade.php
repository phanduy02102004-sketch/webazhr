@extends('azmedia.layouts.app')

@section('title', 'Bài Đánh Giá Năng Lực Toàn Diện AZHR - ' . $application->candidate->name)

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .step-tab.active {
        background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);
    }
    .slider-range::-webkit-slider-thumb {
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ea580c;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
</style>
@endpush

@section('content')

<!-- Header thanh tiến trình & đồng hồ -->
<div class="sticky top-20 z-40 bg-slate-900 text-white shadow-lg border-b border-slate-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
        <div>
            <div class="text-[11px] text-brand-400 font-bold uppercase tracking-wider flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                Quy Trình Đánh Giá Năng Lực Ứng Viên Thực Tập Sinh • AZ Media
            </div>
            <h1 class="text-base sm:text-lg font-extrabold truncate text-white">
                {{ $application->candidate->name }} — {{ $application->position->title }}
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-slate-300 border border-white/10">
                <i class="fa-solid fa-clock-rotate-left text-brand-400"></i> Không giới hạn thời gian làm bài
            </span>
        </div>
    </div>

    <!-- 4 Tabs Chuyển đổi trực quan -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 pb-3 pt-1">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
            <button type="button" onclick="switchTab(1)" id="tab_btn_1" class="step-tab active py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-slate-800 text-slate-300">
                <span>🔮</span> 1. Tính cách (NLB - DISC - MBTI)
            </button>
            <button type="button" onclick="switchTab(2)" id="tab_btn_2" class="step-tab py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-slate-800 text-slate-300">
                <span>🎡</span> 2. Bánh xe cuộc đời
            </button>
            <button type="button" onclick="switchTab(3)" id="tab_btn_3" class="step-tab py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-slate-800 text-slate-300">
                <span>🎯</span> 3. Hoài bão & Động cơ
            </button>
            <button type="button" onclick="switchTab(4)" id="tab_btn_4" class="step-tab py-2 px-3 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 bg-slate-800 text-slate-300">
                <span>🏢</span> 4. AZ Media ({{ $allQuestions->count() }} câu)
            </button>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
    <!-- Banner Nhóm Zalo Hỗ Trợ Làm Bài Test & Nhận Thông Báo -->
    <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-sm shadow flex-shrink-0">
                Zalo
            </div>
            <div>
                <h4 class="font-extrabold text-xs sm:text-sm text-emerald-950 flex items-center gap-1.5">
                    Nhóm Zalo Ứng Tuyển: <span class="text-blue-700">AZ HR - ỨNG TUYỂN</span>
                </h4>
                <p class="text-[11px] text-emerald-800">
                    Tham gia nhóm Zalo để được giải đáp thắc mắc, tham khảo tài liệu hướng dẫn và nhận thông báo phỏng vấn nhanh nhất!
                </p>
            </div>
        </div>
        <a href="https://zalo.me/g/fcypks402" target="_blank"
           class="px-4 py-2.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow transition flex items-center gap-1.5 flex-shrink-0">
            <i class="fa-solid fa-comments"></i> Tham Gia Nhóm Zalo
        </a>
    </div>

    <form id="test_form" novalidate action="{{ route('azmedia.candidate.test.submit', $application->application_code) }}" method="POST">
        @csrf
        <input type="hidden" name="time_spent" id="time_spent_input" value="0">

        <!-- ==========================================
             PHẦN 1: BÀI TRẮC NGHIỆM TÍNH CÁCH (NLB – DISC – MBTI – NHÂN SỐ HỌC)
             ========================================== -->
        <div id="section_1" class="space-y-6">
            <div class="bg-gradient-to-r from-orange-500 to-brand-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg">
                <div class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-extrabold uppercase tracking-wider mb-2">
                    Báo Cáo Thu Hoạch & Đánh Giá Năng Lực Toàn Diện • AZ Media
                </div>
                <h2 class="text-xl sm:text-2xl font-black mb-2">1. ĐÁNH GIÁ NĂNG LỰC & TÍNH CÁCH (NLB – DISC – MBTI)</h2>
                <p class="text-xs sm:text-sm text-orange-100 leading-relaxed mb-4">
                    Thấu hiểu bản thân qua ba khía cạnh cốt lõi: <strong>NLB</strong> (Năng lực & cách xử lý công việc), <strong>DISC</strong> (Cách làm việc & giao tiếp), <strong>MBTI</strong> (Kiểu tính cách) kết hợp <strong>Nhân số học đường đời</strong>.
                </p>

                <!-- 4 Khái niệm tóm tắt chuẩn từ Báo cáo thu hoạch -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 pt-2">
                    <div class="p-3 rounded-2xl bg-white/10 border border-white/20">
                        <div class="font-extrabold text-xs flex items-center gap-1.5 text-white mb-1">
                            <span>👁️</span> NLB (Năng Lực)
                        </div>
                        <p class="text-[11px] text-orange-100">Kiểm tra khả năng tiếp nhận và cách bạn xử lý công việc (Visual, Auditory, Kinesthetic, Ad).</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/10 border border-white/20">
                        <div class="font-extrabold text-xs flex items-center gap-1.5 text-white mb-1">
                            <span>💼</span> DISC (Làm Việc)
                        </div>
                        <p class="text-[11px] text-orange-100">Xem cách bạn cư xử, giao tiếp và làm việc với người khác (D, I, S hay C - Cẩn trọng).</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/10 border border-white/20">
                        <div class="font-extrabold text-xs flex items-center gap-1.5 text-white mb-1">
                            <span>🧠</span> MBTI (Tính Cách)
                        </div>
                        <p class="text-[11px] text-orange-100">Xác định kiểu tính cách: Hướng nội (I) hay Hướng ngoại (E), Cảm xúc (F) hay Lý trí (T)...</p>
                    </div>
                    <div class="p-3 rounded-2xl bg-white/10 border border-white/20">
                        <div class="font-extrabold text-xs flex items-center gap-1.5 text-white mb-1">
                            <span>🔢</span> Nhân Số Học
                        </div>
                        <p class="text-[11px] text-orange-100">Tra cứu con số đường đời từ ngày sinh, gắn liền với tinh thần trách nhiệm và lòng trắc ẩn.</p>
                    </div>
                </div>
            </div>

            <!-- MỤC 1.1: NLB (NĂNG LỰC TIẾP NHẬN & XỬ LÝ CÔNG VIỆC) -->
            <div class="pt-2">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-xl bg-orange-100 text-brand-600 flex items-center justify-center text-sm font-black">1.1</span>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Mô hình NLB / NLP (V-A-K-Ad)</h3>
                        <p class="text-xs text-slate-500">Đánh giá 4 phong cách tiếp nhận: Visual (Hình ảnh), Auditory (Nghe), Kinesthetic (Cảm giác), Auditory Digital (Logic).</p>
                    </div>
                </div>

                <div class="p-3 bg-amber-50 rounded-2xl text-xs flex flex-wrap gap-3 border border-amber-200 font-medium text-amber-900 mb-4">
                    <span>Thang điểm đánh giá:</span>
                    <span>⭐ <strong>4</strong> = Miêu tả đúng nhất</span>
                    <span>• <strong>3</strong> = Khá đúng</span>
                    <span>• <strong>2</strong> = Đúng</span>
                    <span>• <strong>1</strong> = Ít đúng nhất</span>
                </div>
            </div>

            @php
                $nlpQuestions = [
                    1 => [
                        'title' => 'Bạn thường đưa ra quyết định quan trọng dựa trên:',
                        'options' => [
                            ['code' => 'K', 'text' => 'Cảm tính và cảm nhận từ bên trong bản thân', 'badge' => 'Cảm tính'],
                            ['code' => 'A', 'text' => 'Những điều mà người khác nói và trao đổi với bạn', 'badge' => 'Nghe lời khuyên'],
                            ['code' => 'V', 'text' => 'Những điều mà (mình nhìn thấy) bạn cho là tốt nhất cho bản thân', 'badge' => 'Nhìn nhận'],
                            ['code' => 'Ad', 'text' => 'Những thông tin, dữ liệu, những dẫn chứng số liệu cụ thể', 'badge' => 'Logic & Dẫn chứng']
                        ]
                    ],
                    2 => [
                        'title' => 'Trong các buổi tranh luận hoặc trao đổi nhóm, bạn dễ bị tác động nhất bởi:',
                        'options' => [
                            ['code' => 'A', 'text' => 'Giọng điệu, ngữ điệu âm thanh của người khác', 'badge' => 'Giọng điệu'],
                            ['code' => 'V', 'text' => 'Liệu bạn có thể nhìn thấy được quan điểm/hình dung của người khác hay không', 'badge' => 'Hình dung'],
                            ['code' => 'Ad', 'text' => 'Tính logic, mạch lạc và chứng cứ trong lời tranh luận của người khác', 'badge' => 'Tính logic'],
                            ['code' => 'K', 'text' => 'Cảm xúc và năng lượng tinh thần của người khác', 'badge' => 'Cảm xúc']
                        ]
                    ],
                    3 => [
                        'title' => 'Điều gì bạn cảm thấy hài lòng nhất về bản thân khi xuất hiện trước mọi người:',
                        'options' => [
                            ['code' => 'V', 'text' => 'Cách bạn ăn mặc, phối đồ và diện mạo bên ngoài gọn gàng', 'badge' => 'Trang phục & Diện mạo'],
                            ['code' => 'K', 'text' => 'Cách bạn chia sẻ cảm xúc chân thành và kết nối với mọi người', 'badge' => 'Sự chân thành'],
                            ['code' => 'Ad', 'text' => 'Cách bạn dùng từ ngữ chính xác, lập luận chặt chẽ', 'badge' => 'Ngôn từ chuẩn xác'],
                            ['code' => 'A', 'text' => 'Giọng nói truyền cảm, âm lượng dễ nghe của bạn', 'badge' => 'Chất giọng']
                        ]
                    ],
                    4 => [
                        'title' => 'Trong cuộc sống hàng ngày, bạn cảm thấy thật dễ dàng khi:',
                        'options' => [
                            ['code' => 'A', 'text' => 'Điều chỉnh âm lượng và giai điệu của âm thanh sao cho hay nhất', 'badge' => 'Âm thanh'],
                            ['code' => 'Ad', 'text' => 'Chọn lựa những thông tin có giá trị nhất, logic nhất trong một chủ đề', 'badge' => 'Chắt lọc thông tin'],
                            ['code' => 'K', 'text' => 'Chọn những đồ đạc, chỗ ngồi bạn cảm thấy thoải mái và dễ chịu nhất', 'badge' => 'Sự thoải mái'],
                            ['code' => 'V', 'text' => 'Chọn những đồ có sự kết hợp màu sắc hài hòa và bắt mắt nhất', 'badge' => 'Màu sắc & Thẩm mỹ']
                        ]
                    ],
                    5 => [
                        'title' => 'Khi tiếp xúc với môi trường mới hoặc sự vật mới:',
                        'options' => [
                            ['code' => 'A', 'text' => 'Bạn rất nhạy cảm với những âm thanh xung quanh (tiếng nói, nhạc nền)', 'badge' => 'Nhạy âm thanh'],
                            ['code' => 'Ad', 'text' => 'Bạn rất nhạy bén với các thông tin, quy trình và kiến thức mới', 'badge' => 'Nhạy thông tin'],
                            ['code' => 'K', 'text' => 'Bạn rất nhạy cảm với cảm giác cơ thể và những đồ bạn đang mặc', 'badge' => 'Nhạy cảm giác'],
                            ['code' => 'V', 'text' => 'Bạn phản ứng rất nhanh với màu sắc, ánh sáng và bề ngoài của sự vật', 'badge' => 'Nhạy thị giác']
                        ]
                    ],
                ];
            @endphp

            @foreach($nlpQuestions as $qNum => $qData)
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-8 h-8 rounded-xl bg-orange-100 text-brand-700 font-extrabold text-sm flex items-center justify-center">
                            {{ $qNum }}
                        </span>
                        <h3 class="font-bold text-slate-900 text-sm sm:text-base">
                            {{ $qData['title'] }}
                        </h3>
                    </div>

                    <div class="space-y-3 sm:pl-11">
                        @foreach($qData['options'] as $idx => $opt)
                            <div class="p-3.5 rounded-2xl border border-slate-200 hover:border-orange-300 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3 transition">
                                <div class="text-xs sm:text-sm text-slate-800 font-medium">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700 mr-2">
                                        {{ $opt['badge'] }}
                                    </span>
                                    {{ $opt['text'] }}
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0 self-end sm:self-auto">
                                    <span class="text-[11px] text-slate-500">Mức độ:</span>
                                    <select name="nlp[{{ $qNum }}][{{ $opt['code'] }}]" class="text-xs font-bold py-1.5 px-3 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-brand-500">
                                        <option value="" disabled selected>-- Chọn điểm (1-4) --</option>
                                        <option value="4">4 - Đúng nhất</option>
                                        <option value="3">3 - Khá đúng</option>
                                        <option value="2">2 - Đúng</option>
                                        <option value="1">1 - Ít đúng nhất</option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- MỤC 1.2: ĐÁNH GIÁ PHONG CÁCH LÀM VIỆC (DISC) -->
            <div class="pt-6 border-t border-slate-200">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-black">1.2</span>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Mô hình DISC (Cách cư xử & Làm việc trong nhóm)</h3>
                        <p class="text-xs text-slate-500">Xem cách bạn cư xử, giao tiếp và phối hợp với người khác: D (Quyết đoán), I (Hòa đồng), S (Điềm tĩnh), C (Cẩn trọng).</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-5">
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-900 mb-2">
                            1. Khi tiếp nhận một nhiệm vụ hoặc dự án kỹ thuật mới, xu hướng làm việc tự nhiên nhất của bạn là: <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-blue-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="disc_choice" value="D" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Nhóm D (Quyết đoán):</strong>
                                    <span class="text-slate-600">Hành động quyết liệt, chấp nhận rủi ro, tập trung vào kết quả nhanh nhất và thích sự cạnh tranh.</span>
                                </div>
                            </label>
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-blue-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="disc_choice" value="I" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Nhóm I (Hòa đồng):</strong>
                                    <span class="text-slate-600">Nhiệt tình, hướng ngoại, thích kết nối, truyền cảm hứng và tạo không khí vui vẻ cho cả nhóm.</span>
                                </div>
                            </label>
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-blue-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="disc_choice" value="S" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Nhóm S (Điềm tĩnh):</strong>
                                    <span class="text-slate-600">Kiên định, chân thành, luôn sẵn sàng hỗ trợ đồng đội, duy trì sự ổn định và tránh đối đầu.</span>
                                </div>
                            </label>
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-blue-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="disc_choice" value="C" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">Nhóm C (Cẩn trọng):</strong>
                                    <span class="text-slate-600">Chú ý đến chi tiết, yêu cầu sự chính xác cao, chu đáo và luôn muốn hiểu rõ bản chất vấn đề trước khi thực hiện.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-900 mb-2">
                            2. Trong quy trình phối hợp làm việc nhóm, điều bạn chú trọng hàng đầu là:
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <label class="p-3 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 flex items-start gap-2.5 cursor-pointer transition">
                                <input type="radio" name="disc[q2]" value="goal" class="mt-0.5 text-blue-600">
                                <span class="text-slate-700">Tốc độ giải quyết vấn đề và năng suất vượt trội.</span>
                            </label>
                            <label class="p-3 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 flex items-start gap-2.5 cursor-pointer transition">
                                <input type="radio" name="disc[q2]" value="spirit" class="mt-0.5 text-blue-600">
                                <span class="text-slate-700">Mối quan hệ cởi mở, sáng tạo và sự gắn bó giữa các thành viên.</span>
                            </label>
                            <label class="p-3 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 flex items-start gap-2.5 cursor-pointer transition">
                                <input type="radio" name="disc[q2]" value="support" class="mt-0.5 text-blue-600">
                                <span class="text-slate-700">Sự đồng lòng, thấu hiểu và chia sẻ khối lượng công việc.</span>
                            </label>
                            <label class="p-3 rounded-xl border border-slate-200 hover:border-slate-300 bg-slate-50 flex items-start gap-2.5 cursor-pointer transition">
                                <input type="radio" name="disc[q2]" value="precision" class="mt-0.5 text-blue-600">
                                <span class="text-slate-700">Chuẩn mực chất lượng, tài liệu rõ ràng, hạn chế tối đa sai sót.</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MỤC 1.3: ĐÁNH GIÁ KIỂU TÍNH CÁCH (MBTI) -->
            <div class="pt-6 border-t border-slate-200">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-black">1.3</span>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Mô hình MBTI (Xu hướng tính cách & Tư duy)</h3>
                        <p class="text-xs text-slate-500">Xem bạn thuộc kiểu tính cách nào: Hướng nội (I) hay Hướng ngoại (E), Cảm xúc (F) hay Lý trí (T)...</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-5">
                    <!-- Cặp 1: I vs E -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-900 mb-2">
                            1. Về xu hướng năng lượng & giao tiếp (Energy Orientation): <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-indigo-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="mbti_energy" value="I" class="mt-0.5 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">I – Hướng nội (Introversion):</strong>
                                    <span class="text-slate-600">Bản tính trầm tĩnh, ít nói, có khả năng quan sát thầm lặng và nhìn nhận vấn đề sâu sắc hơn; nạp năng lượng qua không gian yên tĩnh.</span>
                                </div>
                            </label>
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-indigo-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="mbti_energy" value="E" class="mt-0.5 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">E – Hướng ngoại (Extraversion):</strong>
                                    <span class="text-slate-600">Sôi nổi, thích kết nối đám đông, thích thể hiện ý tưởng bằng lời nói và nạp năng lượng từ các buổi giao lưu.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Cặp 2: F vs T -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-900 mb-2">
                            2. Về cách xử lý cảm xúc & ra quyết định (Decision Making): <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-indigo-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="mbti_decision" value="F" class="mt-0.5 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">F – Cảm xúc (Feeling):</strong>
                                    <span class="text-slate-600">Coi trọng sự hài hòa và cảm xúc con người; có sự cân bằng giữa tính thực tế và khả năng sáng tạo; giàu lòng trắc ẩn.</span>
                                </div>
                            </label>
                            <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-indigo-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                                <input type="radio" name="mbti_decision" value="T" class="mt-0.5 text-indigo-600 focus:ring-indigo-500">
                                <div>
                                    <strong class="text-slate-900 block font-bold mb-0.5">T – Lý trí (Thinking):</strong>
                                    <span class="text-slate-600">Đưa ra quyết định thuần túy dựa trên quy chuẩn logic, tính khách quan tuyệt đối và phân tích số liệu không thiên vị.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MỤC 1.4: THAM KHẢO NHÂN SỐ HỌC (CON SỐ ĐƯỜNG ĐỜI) -->
            <div class="pt-6 border-t border-slate-200">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-sm font-black">1.4</span>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Nhân số học (Con số đường đời)</h3>
                        <p class="text-xs text-slate-500">Tham khảo con số đường đời theo ngày sinh để thấu hiểu bản mệnh, lòng trắc ẩn và tinh thần trách nhiệm.</p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-5 items-center">
                        <div class="sm:col-span-5">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                📅 Ngày sinh của bạn:
                            </label>
                            <input type="date" name="numerology_dob" id="numerology_dob"
                                   value="{{ $application->candidate->birth_date ?? '' }}"
                                   onchange="updateNumerology(this.value)"
                                   class="w-full text-xs sm:text-sm font-bold py-2.5 px-3.5 rounded-xl border border-slate-300 bg-white focus:ring-2 focus:ring-purple-500">
                            <p class="text-[11px] text-slate-400 mt-1 italic">Vui lòng chọn ngày sinh để xem con số đường đời</p>
                        </div>

                        <div class="sm:col-span-7 p-4 rounded-2xl bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200">
                            <div class="flex items-center gap-3 mb-1.5">
                                <div class="w-10 h-10 rounded-xl bg-purple-600 text-white font-black text-lg flex items-center justify-center shadow" id="num_badge">
                                    {{ !empty($application->candidate->birth_date) ? '9' : '?' }}
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-purple-600 uppercase tracking-wider">Kết quả tra cứu</div>
                                    <h4 class="font-black text-sm text-purple-950" id="num_title">
                                        {{ !empty($application->candidate->birth_date) ? 'Con số đường đời số 9' : 'Chưa chọn ngày sinh' }}
                                    </h4>
                                </div>
                            </div>
                            <p class="text-xs text-purple-900 leading-relaxed" id="num_desc">
                                {{ !empty($application->candidate->birth_date) ? 'Đường đời số 9 thường được gắn liền với lòng trắc ẩn, tính bao dung, trực giác tốt, tinh thần trách nhiệm cao và mong muốn mang lại những giá trị tích cực cho cộng đồng.' : 'Hệ thống sẽ tự động tính toán con số đường đời và phân tích thiên hướng tính cách của bạn ngay khi chọn ngày sinh.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" onclick="switchTab(2)" class="px-8 py-3.5 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-lg transition flex items-center gap-2 text-sm">
                    Sang Phần 2: Bánh Xe Cuộc Đời <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- ==========================================
             PHẦN 2: BÁNH XE CUỘC ĐỜI (WHEEL OF LIFE)
             ========================================== -->
        <div id="section_2" class="space-y-6 hidden">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg">
                <div class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-extrabold uppercase tracking-wider mb-2">
                    Tư Duy Cân Bằng Bản Thân • Coaching AZ Media
                </div>
                <h2 class="text-xl sm:text-2xl font-black mb-2">WHEEL OF LIFE – BÁNH XE CUỘC ĐỜI</h2>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Tự đánh giá mức độ thỏa mãn và đầu tư thời gian cho <strong>8 khía cạnh cốt lõi</strong> của bạn trên thang điểm từ 1 đến 10. Biểu đồ Radar bên dưới sẽ tự động mô phỏng độ cân bằng bánh xe cuộc đời của bạn!
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                <!-- 8 Sliders Cân bằng -->
                <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-emerald-600"></i> Đánh Giá 8 Lĩnh Vực (1 - 10 điểm)
                    </h3>

                    @php
                        $wheelItems = [
                            'finance'         => ['title' => 'Tài chính (Finance)', 'val' => 4, 'icon' => 'fa-coins', 'color' => 'text-amber-500'],
                            'personal_growth' => ['title' => 'Phát triển bản thân (Personal Growth)', 'val' => 8, 'icon' => 'fa-brain', 'color' => 'text-indigo-500'],
                            'health'          => ['title' => 'Sức khỏe (Health)', 'val' => 7, 'icon' => 'fa-heart-pulse', 'color' => 'text-rose-500'],
                            'family'          => ['title' => 'Gia đình (Family)', 'val' => 9, 'icon' => 'fa-house-user', 'color' => 'text-blue-500'],
                            'relationships'   => ['title' => 'Các mối quan hệ (Relationships)', 'val' => 5, 'icon' => 'fa-users', 'color' => 'text-emerald-500'],
                            'social_life'     => ['title' => 'Đời sống xã hội (Social Life)', 'val' => 6, 'icon' => 'fa-champagne-glasses', 'color' => 'text-purple-500'],
                            'spirituality'    => ['title' => 'Đời sống tinh thần (Spirituality)', 'val' => 7, 'icon' => 'fa-spa', 'color' => 'text-teal-500'],
                            'career'          => ['title' => 'Sự nghiệp (Career)', 'val' => 5, 'icon' => 'fa-briefcase', 'color' => 'text-orange-500'],
                        ];
                    @endphp

                    @foreach($wheelItems as $key => $w)
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="flex justify-between items-center mb-1 text-xs font-bold text-slate-800">
                                <span class="flex items-center gap-1.5">
                                    <i class="fa-solid {{ $w['icon'] }} {{ $w['color'] }}"></i> {{ $w['title'] }}
                                </span>
                                <span id="val_label_{{ $key }}" class="px-2.5 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-extrabold text-xs">
                                    {{ $w['val'] }}/10
                                </span>
                            </div>
                            <input type="range" name="wheel[{{ $key }}]" min="1" max="10" value="{{ $w['val'] }}"
                                   oninput="updateWheelValue('{{ $key }}', this.value)"
                                   class="slider-range w-full h-2 bg-slate-200 rounded-lg cursor-pointer accent-emerald-600">
                        </div>
                    @endforeach
                </div>

                <!-- Live Radar Chart -->
                <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm sticky top-44">
                    <h3 class="font-extrabold text-xs text-slate-800 uppercase tracking-wider mb-3 text-center">
                        🎡 Mô Phỏng Bánh Xe Cuộc Đời Trực Quan
                    </h3>
                    <div class="w-full max-w-[280px] mx-auto aspect-square">
                        <canvas id="wheelChart"></canvas>
                    </div>
                    <p class="text-[11px] text-slate-400 text-center mt-3 italic">
                        Bánh xe càng tròn và đồng đều, cuộc sống và tâm lý làm việc của bạn càng ổn định và bền vững.
                    </p>
                </div>
            </div>

            <!-- Bài học rút ra từ Bánh xe cuộc đời -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
                <label class="block font-bold text-sm text-slate-900 mb-2">
                    ✍️ Bài học rút ra qua việc thực hiện "Bánh xe cuộc đời": <span class="text-rose-500">*</span>
                </label>
                <p class="text-xs text-slate-500 mb-3">
                    Bạn nhận thấy bản thân có điểm mạnh ở lĩnh vực nào và cần dành nhiều thời gian hơn để cải thiện khía cạnh nào trong tương lai?
                </p>
                <textarea name="wheel_lesson" rows="4" class="w-full text-xs sm:text-sm rounded-2xl border border-slate-200 p-4 focus:ring-2 focus:ring-emerald-500"
                          placeholder="Nhập bài học tự nhận thức và định hướng cải thiện của bạn..."></textarea>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" onclick="switchTab(1)" class="px-6 py-3 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-xs sm:text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại Phần 1
                </button>
                <button type="button" onclick="switchTab(3)" class="px-8 py-3.5 rounded-xl font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow hover:shadow-lg transition flex items-center gap-2 text-xs sm:text-sm">
                    Sang Phần 3: Hoài Bão & Động Cơ <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- ==========================================
             PHẦN 3: HOÀI BÃO, ĐỘNG CƠ & KHẢO SÁT ỨNG VIÊN (File 1)
             ========================================== -->
        <div id="section_3" class="space-y-6 hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg">
                <div class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-extrabold uppercase tracking-wider mb-2">
                    Khảo Sát Tuyển Dụng AZ Homes - AZ Media
                </div>
                <h2 class="text-xl sm:text-2xl font-black mb-2">HOÀI BÃO, ĐỘNG CƠ & Ý THỨC CẦU TIẾN</h2>
                <p class="text-xs sm:text-sm text-blue-100 leading-relaxed">
                    Đây là các câu hỏi giúp Ban tuyển dụng và Mentor hiểu rõ hơn về mục tiêu nghề nghiệp, sự tự tin và cách bạn tổ chức công việc trong kỳ thực tập.
                </p>
            </div>

            <!-- Khối 1: Hoài bão & Mục tiêu -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-4">
                <h3 class="font-extrabold text-sm text-blue-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="fa-solid fa-compass text-blue-600"></i> A. Hoài Bão & Mục Tiêu Nghề Nghiệp
                </h3>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-800 mb-1">
                        1. Mục tiêu trong kỳ thực tập / 5 tháng tới của bạn là gì? <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="goal_short" rows="3" class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-blue-500"
                              placeholder="Nhập mục tiêu cụ thể trong 5 tháng tới của bạn..."></textarea>
                </div>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-800 mb-1">
                        2. Bạn dự định phát triển nghề nghiệp như thế nào trong 3 - 5 năm tới? <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="goal_long" rows="3" class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-blue-500"
                              placeholder="Nhập định hướng nghề nghiệp 3 - 5 năm tới của bạn..."></textarea>
                </div>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-800 mb-1">
                        3. Chia sẻ 1 thành công hoặc dự án tâm đắc nhất bạn từng thực hiện? <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="biggest_success" rows="3" class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-blue-500"
                              placeholder="Chia sẻ về thành công hoặc dự án tâm đắc nhất và bài học rút ra..."></textarea>
                </div>
            </div>

            <!-- Khối 2: Động cơ & Kế hoạch làm việc -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-4">
                <h3 class="font-extrabold text-sm text-blue-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="fa-solid fa-briefcase text-blue-600"></i> B. Động Cơ Xin Việc & Tổ Chức Công Việc
                </h3>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-800 mb-1">
                        4. Vì sao bạn lựa chọn nộp đơn ứng tuyển vào AZ Media Đà Nẵng? <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="why_apply" rows="3" class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-blue-500"
                              placeholder="Lý do bạn mong muốn thực tập tại AZ Media..."></textarea>
                </div>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-800 mb-1">
                        5. Bạn dự định sẽ tổ chức và thực hiện công việc được giao như thế nào? <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="work_organization" rows="3" class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-blue-500"
                              placeholder="Phương pháp bạn quản lý thời gian, sắp xếp và hoàn thành công việc..."></textarea>
                </div>
            </div>

            <!-- Khối 3: Tự nhận xét & Cầu tiến -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-4">
                <h3 class="font-extrabold text-sm text-blue-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-2">
                    <i class="fa-solid fa-user-check text-blue-600"></i> C. Tự Nhận Thức & Ý Thức Cầu Tiến
                </h3>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-800 mb-1">
                        6. Hãy kể về 1 khó khăn / thất bại bạn từng trải qua và cách bạn vượt qua? <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="failure_lesson" rows="3" class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-blue-500"
                              placeholder="Kể về khó khăn / thất bại và cách bạn đã vượt qua..."></textarea>
                </div>

                <div>
                    <label class="block font-bold text-xs sm:text-sm text-slate-800 mb-1">
                        7. Cho chúng tôi 1 lý do thuyết phục nhất để Ban tuyển dụng AZ Media chọn bạn? <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="why_choose_you" rows="3" class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-blue-500"
                              placeholder="Lý do thuyết phục nhất để Ban tuyển dụng lựa chọn bạn..."></textarea>
                </div>
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" onclick="switchTab(2)" class="px-6 py-3 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-xs sm:text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại Phần 2
                </button>
                <button type="button" onclick="switchTab(4)" class="px-8 py-3.5 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 shadow hover:shadow-lg transition flex items-center gap-2 text-xs sm:text-sm">
                    Sang Phần 4: Tìm Hiểu Về AZ Media <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- ==========================================
             PHẦN 4: TÌM HIỂU VỀ DOANH NGHIỆP AZ MEDIA
             ========================================== -->
        <div id="section_4" class="space-y-6 hidden">
            <div class="bg-gradient-to-r from-orange-600 via-brand-600 to-amber-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg">
                <div class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-extrabold uppercase tracking-wider mb-2">
                    Văn Hóa Doanh Nghiệp & Định Hướng Đồng Hành • AZ Media
                </div>
                <h2 class="text-xl sm:text-2xl font-black mb-2">4. TÌM HIỂU VỀ DOANH NGHIỆP AZ MEDIA</h2>
                <p class="text-xs sm:text-sm text-orange-100 leading-relaxed">
                    Khảo sát mức độ hiểu biết của bạn về văn hóa, triết lý hoạt động của AZ Media và kênh thông tin giúp bạn biết đến chương trình tuyển dụng thực tập sinh.
                </p>
            </div>

            <!-- Khối 4.1: Các câu hỏi cơ bản về AZ Media -->
            <div class="space-y-5">
                <div class="flex items-center gap-2 pt-2">
                    <span class="w-8 h-8 rounded-xl bg-orange-100 text-brand-600 flex items-center justify-center text-sm font-black">4.1</span>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Kiến thức cơ bản về AZ Media ({{ $allQuestions->count() }} câu)</h3>
                        <p class="text-xs text-slate-500">Khảo sát mức độ quan tâm và hiểu biết về môi trường văn hóa AZ Media</p>
                    </div>
                </div>

                @foreach($allQuestions as $index => $q)
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
                        <div class="flex items-start gap-3 mb-4">
                            <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-orange-100 text-brand-700 font-extrabold text-sm flex items-center justify-center">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-orange-50 text-brand-700 border border-orange-100">
                                    VĂN HÓA DOANH NGHIỆP • {{ $q->points }} ĐIỂM
                                </span>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 mt-1.5 leading-relaxed">
                                    {{ $q->question }}
                                </h3>
                            </div>
                        </div>

                        <!-- Options (Không chọn sẵn để TTS tự chọn) -->
                        <div class="space-y-2.5 sm:pl-11">
                            @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $optKey => $optVal)
                                <label class="flex items-start gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-brand-500 hover:bg-orange-50/40 cursor-pointer transition">
                                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $optKey }}" class="mt-1 text-brand-600 focus:ring-brand-500">
                                    <div class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                                        <strong class="text-slate-900 mr-1">{{ $optKey }}.</strong> {{ $optVal }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Khối 4.2: Khảo sát kênh tìm hiểu về AZ Media (Có gợi ý + Tự trả lời) -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-4">
                <div class="flex items-start gap-3 mb-2">
                    <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-orange-100 text-brand-600 font-extrabold text-sm flex items-center justify-center">
                        <i class="fa-solid fa-bullhorn text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-orange-100 text-brand-700">
                            KHẢO SÁT KÊNH TIẾP CẬN
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 mt-1.5 leading-relaxed">
                            Bạn đã biết đến và tìm hiểu thông tin về AZ Media qua những kênh nào? <span class="text-rose-500">*</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Chọn một hoặc nhiều kênh mà bạn đã tiếp cận thông tin tuyển dụng:</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:pl-11 text-xs">
                    <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-brand-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                        <input type="checkbox" name="az_channels[]" value="social_media" class="mt-0.5 text-brand-600 rounded focus:ring-brand-500">
                        <div>
                            <strong class="text-slate-800 block mb-0.5">Mạng xã hội AZ Media</strong>
                            <span class="text-slate-500">Facebook Fanpage, TikTok, Threads, Instagram, YouTube...</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-brand-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                        <input type="checkbox" name="az_channels[]" value="school" class="mt-0.5 text-brand-600 rounded focus:ring-brand-500">
                        <div>
                            <strong class="text-slate-800 block mb-0.5">Trường học & Thầy cô giáo</strong>
                            <span class="text-slate-500">Khoa CNTT, thầy cô hướng dẫn, nhóm Zalo lớp trường ĐH/CĐ...</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-brand-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                        <input type="checkbox" name="az_channels[]" value="friends" class="mt-0.5 text-brand-600 rounded focus:ring-brand-500">
                        <div>
                            <strong class="text-slate-800 block mb-0.5">Bạn bè & Cựu sinh viên</strong>
                            <span class="text-slate-500">Được bạn bè, anh chị khóa trước từng thực tập tại AZ Media chia sẻ.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-brand-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                        <input type="checkbox" name="az_channels[]" value="job_fair" class="mt-0.5 text-brand-600 rounded focus:ring-brand-500">
                        <div>
                            <strong class="text-slate-800 block mb-0.5">Ngày hội việc làm / Workshop</strong>
                            <span class="text-slate-500">Job Fair hoặc hội thảo hướng nghiệp do AZ Media tổ chức tại trường.</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-brand-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                        <input type="checkbox" name="az_channels[]" value="recruitment_sites" class="mt-0.5 text-brand-600 rounded focus:ring-brand-500">
                        <div>
                            <strong class="text-slate-800 block mb-0.5">Trang tin tuyển dụng</strong>
                            <span class="text-slate-500">TopCV, VietnamWorks, LinkedIn, Tìm Việc Nhanh...</span>
                        </div>
                    </label>

                    <label class="p-3.5 rounded-2xl border border-slate-200 hover:border-brand-400 bg-slate-50/50 flex items-start gap-3 cursor-pointer transition">
                        <input type="checkbox" name="az_channels[]" value="google_website" class="mt-0.5 text-brand-600 rounded focus:ring-brand-500">
                        <div>
                            <strong class="text-slate-800 block mb-0.5">Tìm kiếm Google & Website</strong>
                            <span class="text-slate-500">Tra cứu trực tiếp trên công cụ tìm kiếm và website chính thức AZHR.</span>
                        </div>
                    </label>
                </div>

                <!-- Phần tự trả lời kênh khác -->
                <div class="sm:pl-11 pt-2">
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        ✍️ Kênh khác hoặc chia sẻ thêm về cơ duyên bạn biết đến AZ Media:
                    </label>
                    <textarea name="az_channel_other" rows="2" class="w-full text-xs rounded-xl border border-slate-200 p-3 focus:ring-2 focus:ring-brand-500"
                              placeholder="Nếu bạn biết đến từ kênh khác hoặc có câu chuyện cụ thể, hãy chia sẻ tại đây..."></textarea>
                </div>
            </div>

            <!-- Khối 4.3: Phần tự trả lời cảm nhận & ấn tượng về AZ Media -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-3">
                <div class="flex items-start gap-3 mb-2">
                    <span class="flex-shrink-0 w-8 h-8 rounded-xl bg-orange-100 text-brand-600 font-extrabold text-sm flex items-center justify-center">
                        <i class="fa-solid fa-heart text-xs"></i>
                    </span>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-orange-100 text-brand-700">
                            GÓC NHÌN & CẢM NHẬN
                        </span>
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 mt-1.5 leading-relaxed">
                            Điều gì ở AZ Media khiến bạn ấn tượng nhất và mong muốn được thực tập tại đây? <span class="text-rose-500">*</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Chia sẻ về văn hóa môi trường "Thầy giỏi - Bạn tốt - Sách hay", triết lý hành động A - Action, các dự án thực tế hay cơ hội được Mentor kèm cặp 1-1...
                        </p>
                    </div>
                </div>

                <div class="sm:pl-11">
                    <textarea name="az_impression" rows="4" class="w-full text-xs sm:text-sm rounded-2xl border border-slate-200 p-4 focus:ring-2 focus:ring-brand-500"
                              placeholder="Nhập cảm nhận và lý do AZ Media là điểm đến thực tập lý tưởng của bạn..."></textarea>
                </div>
            </div>

            <!-- Nút Hoàn thành & Nộp bài -->
            <div class="p-6 bg-white rounded-3xl border border-slate-200 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <button type="button" onclick="switchTab(3)" class="w-full sm:w-auto px-6 py-3 rounded-xl font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition text-xs sm:text-sm">
                    <i class="fa-solid fa-arrow-left"></i> Xem lại Phần 3
                </button>
                <button type="button" id="submit_test_btn" onclick="submitAssessmentTest()"
                        class="w-full sm:w-auto px-10 py-3.5 rounded-xl font-bold text-white gradient-brand shadow-lg hover:shadow-xl transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Hoàn Thành & Nộp Toàn Bộ Bài Test
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // 1. Chuyển Tab / Step mượt mà
    function switchTab(step) {
        for (let i = 1; i <= 4; i++) {
            const sec = document.getElementById(`section_${i}`);
            const btn = document.getElementById(`tab_btn_${i}`);
            if (sec && btn) {
                if (i === step) {
                    sec.classList.remove('hidden');
                    btn.classList.add('active');
                } else {
                    sec.classList.add('hidden');
                    btn.classList.remove('active');
                }
            }
        }
        window.scrollTo({ top: 120, behavior: 'smooth' });
    }

    // 2. Ghi nhận thời gian làm bài (không giới hạn, không đếm ngược)
    let secondsSpent = 0;
    const timeSpentInput = document.getElementById('time_spent_input');
    setInterval(function() {
        secondsSpent++;
        if (timeSpentInput) timeSpentInput.value = secondsSpent;
    }, 1000);

    // 3. Khởi tạo Biểu đồ Radar Bánh xe cuộc đời (Chart.js)
    const wheelKeys = ['finance', 'personal_growth', 'health', 'family', 'relationships', 'social_life', 'spirituality', 'career'];
    const wheelLabels = ['Tài chính', 'Phát triển', 'Sức khỏe', 'Gia đình', 'Mối quan hệ', 'Xã hội', 'Tinh thần', 'Sự nghiệp'];
    let wheelData = [4, 8, 7, 9, 5, 6, 7, 5];

    let radarChart = null;

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('wheelChart');
        if (ctx) {
            radarChart = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: wheelLabels,
                    datasets: [{
                        label: 'Mức độ cân bằng (1-10)',
                        data: wheelData,
                        fill: true,
                        backgroundColor: 'rgba(16, 185, 129, 0.25)',
                        borderColor: '#059669',
                        pointBackgroundColor: '#ea580c',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#ea580c',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        r: {
                            min: 0,
                            max: 10,
                            ticks: { stepSize: 2, display: false },
                            grid: { color: 'rgba(148, 163, 184, 0.2)' },
                            pointLabels: {
                                font: { size: 10, weight: 'bold' },
                                color: '#334155'
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });

    function updateWheelValue(key, val) {
        const label = document.getElementById(`val_label_${key}`);
        if (label) label.textContent = `${val}/10`;

        const idx = wheelKeys.indexOf(key);
        if (idx !== -1 && radarChart) {
            radarChart.data.datasets[0].data[idx] = parseInt(val);
            radarChart.update();
        }
    }

    function updateNumerology(dateStr) {
        if (!dateStr) return;
        const digits = dateStr.replace(/\D/g, '');
        let sum = 0;
        for (let c of digits) sum += parseInt(c, 10);
        while (sum > 9 && sum !== 11 && sum !== 22 && sum !== 33) {
            let nextSum = 0;
            for (let c of sum.toString()) nextSum += parseInt(c, 10);
            sum = nextSum;
        }

        const descriptions = {
            1: "Đường đời số 1: Tinh thần tiên phong, độc lập, quyết đoán và năng lực dẫn dắt xuất sắc.",
            2: "Đường đời số 2: Khả năng hòa giải, tinh tế, lắng nghe và gắn kết đồng đội tuyệt vời.",
            3: "Đường đời số 3: Tư duy sáng tạo, hoạt ngôn, giàu cảm hứng và lan tỏa năng lượng tích cực.",
            4: "Đường đời số 4: Tính kỷ luật, thực tế, vững chắc, cẩn trọng và có quy chuẩn rõ ràng.",
            5: "Đường đời số 5: Thích nghi nhanh, linh hoạt, tự do tư duy và đam mê khám phá công nghệ mới.",
            6: "Đường đời số 6: Tinh thần phụng sự, yêu thương, quan tâm chăm sóc gia đình và tập thể.",
            7: "Đường đời số 7: Tư duy phân tích sâu sắc, tìm tòi bản chất chân lý và học hỏi không ngừng.",
            8: "Đường đời số 8: Bản lĩnh quản trị, tư duy mục tiêu, tính kỷ luật và điều hành hiệu quả.",
            9: "Đường đời số 9: Gắn liền với lòng trắc ẩn, tính bao dung, trực giác tốt, tinh thần trách nhiệm cao và mong muốn mang lại những giá trị tích cực cho cộng đồng.",
            11: "Đường đời số 11: Trực giác tâm linh nhạy bén, khả năng truyền cảm hứng và khai sáng tiềm năng.",
            22: "Đường đời số 22: Khả năng kiến tạo những công trình, hệ thống lớn mang tầm vóc thực tiễn cao.",
            33: "Đường đời số 33: Tấm lòng vị tha vô điều kiện, chữa lành và nâng đỡ tinh thần tập thể."
        };

        const badge = document.getElementById('num_badge');
        const title = document.getElementById('num_title');
        const desc = document.getElementById('num_desc');
        if (badge) badge.innerText = sum;
        if (title) title.innerText = `Con số đường đời số ${sum}`;
        if (desc) desc.innerText = descriptions[sum] || descriptions[9];
    }

    // 4. Xử lý Nộp Toàn Bộ Bài Test Đánh Giá Toàn Diện (Hỗ trợ validate đa bước mượt mà)
    function submitAssessmentTest() {
        // Kiểm tra Phần 1: Tính cách NLB
        const nlpSelects = document.querySelectorAll('select[name^="nlp["]');
        let unselectedNlp = 0;
        nlpSelects.forEach(sel => {
            if (!sel.value) unselectedNlp++;
        });

        if (unselectedNlp > 0) {
            const confirmReturn1 = confirm(`Tại Phần 1 (Tính cách NLB): Bạn còn ${unselectedNlp} câu chưa chọn mức điểm (1-4).\n\n• Bấm OK: Để hệ thống chuyển đến Phần 1 giúp bạn chọn nốt điểm.\n• Bấm Cancel: Để nộp bài ngay (các câu chưa chọn sẽ tự nhận điểm mặc định).`);
            if (confirmReturn1) {
                switchTab(1);
                return;
            }
        }

        // Kiểm tra Phần 2: Bánh xe cuộc đời
        const wheelLesson = document.querySelector('textarea[name="wheel_lesson"]');
        if (wheelLesson && !wheelLesson.value.trim()) {
            const confirmReturn2 = confirm(`Tại Phần 2 (Bánh xe cuộc đời): Bạn chưa nhập "Bài học sâu sắc bạn rút ra".\n\n• Bấm OK: Để hệ thống quay lại Phần 2 cho bạn nhập.\n• Bấm Cancel: Tiếp tục nộp bài.`);
            if (confirmReturn2) {
                switchTab(2);
                wheelLesson.focus();
                return;
            }
        }

        // Kiểm tra Phần 3: Khảo sát Hoài bão & Động cơ
        const p3Fields = ['goal_short', 'goal_long', 'biggest_success', 'why_apply', 'work_organization', 'failure_lesson', 'why_choose_you'];
        let emptyP3 = 0;
        p3Fields.forEach(name => {
            const el = document.querySelector(`textarea[name="${name}"]`);
            if (el && !el.value.trim()) emptyP3++;
        });

        if (emptyP3 > 0) {
            const confirmReturn3 = confirm(`Tại Phần 3 (Hoài bão & Động cơ): Còn ${emptyP3} câu hỏi tự luận chưa điền đầy đủ.\n\n• Bấm OK: Để quay lại Phần 3 bổ sung thông tin.\n• Bấm Cancel: Vẫn tiếp tục nộp bài.`);
            if (confirmReturn3) {
                switchTab(3);
                return;
            }
        }

        // Kiểm tra Phần 4: Câu hỏi trắc nghiệm AZ Media
        const quizGroups = {};
        document.querySelectorAll('input[type="radio"][name^="answers["]').forEach(rb => {
            if (!quizGroups[rb.name]) quizGroups[rb.name] = false;
            if (rb.checked) quizGroups[rb.name] = true;
        });

        let unselectedQuiz = 0;
        for (let key in quizGroups) {
            if (!quizGroups[key]) unselectedQuiz++;
        }

        if (unselectedQuiz > 0) {
            alert(`Tại Phần 4 (Tìm hiểu AZ Media): Bạn còn ${unselectedQuiz} câu hỏi trắc nghiệm chưa chọn đáp án. Vui lòng hoàn thành để hệ thống tính điểm trắc nghiệm!`);
            switchTab(4);
            return;
        }

        // Xác nhận nộp bài lần cuối
        const isSure = confirm('Bạn đã sẵn sàng nộp bài Đánh Giá Năng Lực Toàn Diện AZHR?\n\nToàn bộ câu trả lời Phần 1, 2, 3, 4 sẽ được nộp và tự động chuyển đổi thành file PDF lưu trữ hồ sơ cho Ban Tuyển Dụng AZ Media.');
        if (!isSure) return;

        // Cập nhật giao diện nút nộp bài sang trạng thái đang tải
        const btn = document.getElementById('submit_test_btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Đang nộp bài & xuất file PDF lưu trữ...';
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }

        // Nộp form chính thức lên máy chủ
        const form = document.getElementById('test_form');
        form.submit();
    }
</script>
@endpush
