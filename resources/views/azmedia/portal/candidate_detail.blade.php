@extends('azmedia.portal.layout')

@section('page_title', 'Hồ Sơ Ứng Viên: ' . $application->candidate->name . ' (' . $application->application_code . ')')

@section('portal_content')

<div class="space-y-8">
    <!-- Header Summary Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl gradient-brand text-white font-extrabold text-2xl flex items-center justify-center shadow-lg">
                {{ substr($application->candidate->name, 0, 1) }}
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-extrabold text-slate-900">{{ $application->candidate->name }}</h2>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-slate-900 text-white">
                        {{ $application->application_code }}
                    </span>
                    @php $badge = $application->status_badge; @endphp
                    <span class="px-3 py-1 rounded-xl text-xs font-bold {{ $badge['class'] }} border">
                        {{ $badge['label'] }}
                    </span>
                </div>
                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 mt-2">
                    <span><i class="fa-solid fa-graduation-cap text-slate-400"></i> {{ $application->candidate->university }} ({{ $application->candidate->major }})</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-envelope text-slate-400"></i> {{ $application->candidate->email }}</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-phone text-slate-400"></i> {{ $application->candidate->phone }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Status Change Bar -->
        <div class="flex items-center gap-2">
            <form action="{{ route('azmedia.portal.candidate.status', $application->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <select name="status" class="text-xs font-bold rounded-xl border border-slate-200 py-2 px-3 bg-slate-50 focus:ring-2 focus:ring-brand-500">
                    <option value="applied" {{ $application->status == 'applied' ? 'selected' : '' }}>1. Nộp đơn (Applied)</option>
                    <option value="screening" {{ $application->status == 'screening' ? 'selected' : '' }}>2. Duyệt CV (Screening)</option>
                    <option value="test_sent" {{ $application->status == 'test_sent' ? 'selected' : '' }}>3. Gửi bài Test Online</option>
                    <option value="tested" {{ $application->status == 'tested' ? 'selected' : '' }}>4. Đã hoàn thành Test</option>
                    <option value="interviewing" {{ $application->status == 'interviewing' ? 'selected' : '' }}>5. Phỏng vấn (Interview)</option>
                    <option value="offered" {{ $application->status == 'offered' ? 'selected' : '' }}>6. Nhận thực tập (Offered)</option>
                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>0. Từ chối (Rejected)</option>
                </select>
                <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition shadow">
                    Cập nhật
                </button>
            </form>
        </div>
    </div>

    <!-- Main 2-Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Left: Inline PDF CV Viewer (Yêu cầu phi chức năng: xem trực tiếp CV PDF) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-800">
                        <i class="fa-solid fa-file-pdf text-rose-500 text-base"></i>
                        <span>File CV Ứng Viên: {{ $application->cv_filename }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('azmedia.portal.candidate.cv', $application->id) }}" target="_blank"
                           class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 transition">
                            <i class="fa-solid fa-expand mr-1"></i> Mở tab mới
                        </a>
                    </div>
                </div>

                <!-- PDF Embedded Viewer -->
                <div class="w-full h-[650px] bg-slate-100">
                    <iframe src="{{ route('azmedia.portal.candidate.cv', $application->id) }}#toolbar=1" class="w-full h-full border-none">
                        Trình duyệt không hỗ trợ xem trực tiếp PDF. <a href="{{ route('azmedia.portal.candidate.cv', $application->id) }}" class="text-brand-600 underline">Nhấp vào đây để tải file CV</a>.
                    </iframe>
                </div>
            </div>

            <!-- Thư ngỏ (Cover letter) & Links -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h4 class="font-extrabold text-sm text-slate-900 mb-3">Thư ngỏ & Liên kết Portfolio</h4>
                <p class="text-xs text-slate-600 leading-relaxed italic bg-slate-50 p-4 rounded-xl border border-slate-100 mb-4">
                    "{{ $application->cover_letter ?? 'Không có thư ngỏ đính kèm.' }}"
                </p>
                <div class="flex flex-wrap gap-4 text-xs font-semibold">
                    @if($application->candidate->github_url)
                        <a href="{{ $application->candidate->github_url }}" target="_blank" class="text-slate-800 hover:text-brand-600 flex items-center gap-1.5">
                            <i class="fa-brands fa-github text-sm"></i> GitHub: {{ $application->candidate->github_url }}
                        </a>
                    @endif
                    @if($application->candidate->portfolio_url)
                        <a href="{{ $application->candidate->portfolio_url }}" target="_blank" class="text-brand-600 hover:underline flex items-center gap-1.5">
                            <i class="fa-solid fa-link text-sm"></i> Portfolio: {{ $application->candidate->portfolio_url }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Scorecard & Interview Scheduler & Email Logs -->
        <div class="lg:col-span-5 space-y-6">
            <!-- 1. Test Result Card Toàn Diện (NLP, Bánh Xe Cuộc Đời, Hoài Bão & Chuyên Môn) -->
            @if($application->testResult)
                @php
                    $testRes = $application->testResult;
                    $tData = $testRes->answers_data ?? [];
                    $tNlp = $tData['nlp'] ?? null;
                    $tPersonality = $tData['personality'] ?? null;
                    $tWheel = $tData['wheel_of_life'] ?? null;
                    $tSurvey = $tData['survey'] ?? null;
                    $tQuiz = $tData['quiz'] ?? null;
                @endphp
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-xl bg-orange-100 text-brand-600 flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </span>
                            <div>
                                <h4 class="font-extrabold text-sm text-slate-900 leading-tight">Kết Quả Đánh Giá Năng Lực</h4>
                                <p class="text-[10px] text-slate-400">Hoàn thành: {{ $testRes->completed_at ? date('H:i - d/m/Y', strtotime($testRes->completed_at)) : 'N/A' }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $testRes->passed ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $testRes->passed ? 'ĐẠT (PASS)' : 'KHÔNG ĐẠT' }}
                        </span>
                    </div>

                    <!-- Quick stats row -->
                    <div class="grid grid-cols-3 gap-2.5 text-center">
                        <div class="bg-indigo-50/70 p-2.5 rounded-2xl border border-indigo-100">
                            <div class="text-xl font-black text-indigo-700">{{ $testRes->score }}<span class="text-xs font-normal text-slate-500">/100</span></div>
                            <div class="text-[10px] text-slate-500 font-semibold">Điểm Test</div>
                        </div>
                        <div class="bg-indigo-50/70 p-2.5 rounded-2xl border border-indigo-100">
                            <div class="text-xl font-black text-slate-800">{{ $testRes->correct_answers }}<span class="text-xs font-normal text-slate-500">/{{ $testRes->total_questions }}</span></div>
                            <div class="text-[10px] text-slate-500 font-semibold">Câu đúng</div>
                        </div>
                        <div class="bg-indigo-50/70 p-2.5 rounded-2xl border border-indigo-100">
                            <div class="text-xl font-black text-slate-800">{{ round(($testRes->time_spent_seconds ?? 600) / 60) }}'</div>
                            <div class="text-[10px] text-slate-500 font-semibold">Thời gian</div>
                        </div>
                    </div>

                    @if($tNlp)
                        <!-- Phân Tích Tính Cách NLP (File 2) -->
                        <div class="p-3.5 rounded-2xl bg-orange-50/60 border border-orange-200 text-xs">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-orange-900 flex items-center gap-1.5">
                                    <i class="fa-solid fa-brain text-brand-600"></i> Tuýp Tính Cách (NLP):
                                </span>
                                <span class="px-2 py-0.5 rounded-lg font-black text-[11px] bg-orange-600 text-white">
                                    {{ $tNlp['dominant_title'] ?? 'N/A' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-600 mb-2.5 leading-relaxed italic">
                                "{{ $tNlp['dominant_summary'] ?? '' }}"
                            </p>
                            <!-- 4 chỉ số V - A - K - Ad -->
                            <div class="grid grid-cols-4 gap-1.5 text-center text-[10px]">
                                <div class="bg-white p-1.5 rounded-xl border border-orange-100">
                                    <div class="text-slate-500 font-semibold">Visual (Nhìn)</div>
                                    <div class="font-black text-orange-600 text-xs mt-0.5">{{ $tNlp['scores']['Visual'] ?? 0 }}</div>
                                </div>
                                <div class="bg-white p-1.5 rounded-xl border border-orange-100">
                                    <div class="text-slate-500 font-semibold">Auditory (Nghe)</div>
                                    <div class="font-black text-blue-600 text-xs mt-0.5">{{ $tNlp['scores']['Auditory'] ?? 0 }}</div>
                                </div>
                                <div class="bg-white p-1.5 rounded-xl border border-orange-100">
                                    <div class="text-slate-500 font-semibold">Kinesthetic (Cảm)</div>
                                    <div class="font-black text-emerald-600 text-xs mt-0.5">{{ $tNlp['scores']['Kinesthetic'] ?? 0 }}</div>
                                </div>
                                <div class="bg-white p-1.5 rounded-xl border border-orange-100">
                                    <div class="text-slate-500 font-semibold">Logic (Ad)</div>
                                    <div class="font-black text-purple-600 text-xs mt-0.5">{{ $tNlp['scores']['Auditory_Digital'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Báo cáo thu hoạch NLB - DISC - MBTI -->
                    <div class="p-3.5 rounded-2xl bg-indigo-50/60 border border-indigo-200 text-xs">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-indigo-900 flex items-center gap-1.5">
                                <i class="fa-solid fa-id-card-clip text-indigo-600"></i> NLB – DISC – MBTI:
                            </span>
                            <span class="px-2 py-0.5 rounded-lg font-black text-[10px] bg-indigo-600 text-white">
                                Thu Hoạch
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-1.5 text-center text-[10px]">
                            <div class="bg-white p-2 rounded-xl border border-indigo-100">
                                <div class="text-slate-500 font-semibold">DISC</div>
                                <div class="font-black text-blue-600 text-xs mt-0.5">{{ $tPersonality['disc']['group'] ?? 'C' }} - Cẩn trọng</div>
                            </div>
                            <div class="bg-white p-2 rounded-xl border border-indigo-100">
                                <div class="text-slate-500 font-semibold">MBTI</div>
                                <div class="font-black text-indigo-600 text-xs mt-0.5">{{ $tPersonality['mbti']['code'] ?? 'I - F' }}</div>
                            </div>
                            <div class="bg-white p-2 rounded-xl border border-indigo-100">
                                <div class="text-slate-500 font-semibold">Đường đời</div>
                                <div class="font-black text-purple-600 text-xs mt-0.5">Số {{ $tPersonality['numerology']['life_path_number'] ?? '9' }}</div>
                            </div>
                        </div>
                    </div>

                    @if($tWheel)
                        <!-- Bánh Xe Cuộc Đời (File 3) -->
                        <div class="p-3.5 rounded-2xl bg-emerald-50/60 border border-emerald-200 text-xs">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                                    <i class="fa-solid fa-dharmachakra text-emerald-600"></i> Bánh Xe Cuộc Đời:
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-1.5 mb-2.5">
                                @foreach($tWheel['dimensions'] ?? [] as $dim)
                                    <div class="bg-white p-1.5 rounded-xl border border-emerald-100 flex justify-between items-center text-[10px]">
                                        <span class="text-slate-600 truncate mr-1">{{ explode(' (', $dim['label'])[0] }}</span>
                                        <span class="font-black {{ $dim['score'] >= 7 ? 'text-emerald-600' : ($dim['score'] >= 5 ? 'text-blue-600' : 'text-amber-600') }}">
                                            {{ $dim['score'] }}/10
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            @if(!empty($tWheel['lesson']))
                                <div class="bg-white p-2 rounded-xl border border-emerald-100 text-[10px]">
                                    <span class="font-bold text-slate-700">💡 Tự nhận thức:</span>
                                    <span class="text-slate-600 italic">"{{ $tWheel['lesson'] }}"</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Nút mở Popup xem chi tiết & Nút Tải / Xem File PDF Bài Test -->
                    @if($tSurvey || $tQuiz)
                        <div class="space-y-2 pt-1">
                            <a href="{{ route('azmedia.portal.candidate.test.pdf', $application->id) }}" target="_blank"
                               class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow transition">
                                <i class="fa-solid fa-file-pdf text-sm"></i>
                                <span>Xem File PDF Bài Test (Phần 1, 2, 3, 4)</span>
                            </a>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('azmedia.portal.candidate.test.pdf', $application->id) }}?download=1"
                                   class="py-2 px-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-[11px] flex items-center justify-center gap-1.5 shadow-sm transition text-center">
                                    <i class="fa-solid fa-download text-emerald-400"></i>
                                    <span>Tải PDF Lưu Lại</span>
                                </a>
                                <button type="button" onclick="document.getElementById('surveyDetailsModal').classList.remove('hidden')"
                                        class="py-2 px-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[11px] flex items-center justify-center gap-1.5 border border-slate-300 transition text-center">
                                    <i class="fa-solid fa-list-check text-brand-600"></i>
                                    <span>Xem Nhanh Pop-up</span>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-amber-50/80 rounded-3xl p-5 border border-amber-200/80 space-y-2 shadow-sm">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold flex-shrink-0">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </span>
                        <div>
                            <h4 class="font-extrabold text-xs text-amber-950">Bài Test Đánh Giá Năng Lực (Chưa hoàn thành)</h4>
                            <p class="text-[10px] text-amber-800">Ứng viên chưa nộp bài test đánh giá 4 phần (NLB - Bánh xe - Hoài bão - AZ Media).</p>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-amber-200/50 flex items-center justify-between text-[11px]">
                        <a href="{{ route('azmedia.candidate.test', $application->application_code) }}" target="_blank" class="text-brand-600 font-bold hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Mở link làm bài test của ứng viên
                        </a>
                        <span class="text-slate-500 font-mono text-[10px] bg-white px-2 py-0.5 rounded border border-amber-200">Mã: {{ $application->application_code }}</span>
                    </div>
                </div>
            @endif

            <!-- 2. Scorecard Đánh Giá Chuyên Môn (Mentor & HR Scorecard) -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div>
                        <h4 class="font-extrabold text-base text-slate-900">Bảng Điểm Scorecard</h4>
                        <p class="text-[11px] text-slate-500">Dành cho Mentor & HR chấm điểm phỏng vấn</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">
                        Thang điểm 10
                    </span>
                </div>

                <form action="{{ route('azmedia.portal.candidate.scorecard', $application->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- 4 Tiêu chí đánh giá chuẩn -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">1. Kỹ thuật / Chuyên môn</label>
                            <input type="number" step="0.5" min="0" max="10" name="technical_score" value="9.0" required
                                   class="w-full text-xs rounded-xl border border-slate-200 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">2. Tư duy Logic</label>
                            <input type="number" step="0.5" min="0" max="10" name="logic_score" value="8.5" required
                                   class="w-full text-xs rounded-xl border border-slate-200 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">3. Thái độ & Văn hóa AZ</label>
                            <input type="number" step="0.5" min="0" max="10" name="attitude_score" value="9.5" required
                                   class="w-full text-xs rounded-xl border border-slate-200 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">4. Giao tiếp & Tiềm năng</label>
                            <input type="number" step="0.5" min="0" max="10" name="communication_score" value="8.5" required
                                   class="w-full text-xs rounded-xl border border-slate-200 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Ghi chú nhận xét chi tiết</label>
                        <textarea name="general_comment" rows="2" placeholder="Nhận xét về điểm mạnh, điểm yếu và khả năng phát triển..."
                                  class="w-full text-xs rounded-xl border border-slate-200 p-2.5 focus:ring-2 focus:ring-brand-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Đề xuất của Mentor / HR</label>
                        <select name="recommendation" class="w-full text-xs rounded-xl border border-slate-200 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                            <option value="pass" selected>✅ Đạt yêu cầu (Pass - Tiếp nhận thực tập)</option>
                            <option value="consider">🤔 Cân nhắc (Xem xét thêm)</option>
                            <option value="fail">❌ Chưa đạt yêu cầu (Fail)</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" name="auto_offer" id="auto_offer" value="1" class="rounded text-brand-600 focus:ring-brand-500">
                        <label for="auto_offer" class="text-xs text-slate-600 font-semibold cursor-pointer">
                            Tự động chuyển sang trạng thái <strong>Offer TTS</strong> và gửi email chúc mừng
                        </label>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-white bg-slate-900 hover:bg-slate-800 transition text-xs shadow">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Lưu Đánh Giá Scorecard
                    </button>
                </form>

                <!-- Lịch sử đánh giá trước đó -->
                @if($application->evaluations->isNotEmpty())
                    <div class="mt-4 pt-4 border-t border-slate-100 space-y-2">
                        <div class="text-[11px] font-bold text-slate-500 uppercase">Đánh giá đã ghi nhận:</div>
                        @foreach($application->evaluations as $ev)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                <div class="flex justify-between items-center font-bold text-slate-800 mb-1">
                                    <span>{{ $ev->evaluator_name }} ({{ strtoupper($ev->evaluator_role) }})</span>
                                    <span class="text-brand-600 font-extrabold">{{ $ev->average_score }}/10 điểm</span>
                                </div>
                                <p class="text-slate-600 text-[11px]">{{ $ev->general_comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 3. Lên Lịch Phỏng Vấn (Schedule Interview) -->
            <div id="schedule" class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 shadow-sm">
                <h4 class="font-extrabold text-base text-slate-900 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-plus text-brand-600"></i> Điều Phối Lịch Phỏng Vấn
                </h4>
                <form action="{{ route('azmedia.portal.candidate.interview', $application->id) }}" method="POST" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Thời gian phỏng vấn:</label>
                        <input type="datetime-local" name="interview_time" value="{{ now()->addDays(2)->format('Y-m-d\TH:i') }}" required
                               class="w-full rounded-xl border border-slate-200 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Hình thức:</label>
                        <select name="interview_type" class="w-full rounded-xl border border-slate-200 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500">
                            <option value="offline" selected>Trực tiếp tại Chi nhánh Đà Nẵng (84 Nguyễn Hữu Dật)</option>
                            <option value="online">Trực tuyến qua Google Meet / Zoom</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Link Google Meet (nếu online):</label>
                        <input type="url" name="interview_link" placeholder="https://meet.google.com/azm-..."
                               class="w-full rounded-xl border border-slate-200 py-2 px-3 focus:ring-2 focus:ring-brand-500">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Phân công Mentor phỏng vấn:</label>
                        <select name="mentor_type" id="mentor_type_select" onchange="toggleCustomMentorInput()" class="w-full rounded-xl border border-slate-200 py-2 px-3 bg-white focus:ring-2 focus:ring-brand-500 font-semibold text-slate-800">
                            <option value="admin" {{ ($application->assigned_mentor_id == 1 || ($application->assignedMentor && $application->assignedMentor->name === 'Admin')) ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="le_dinh_quang" {{ ($application->assigned_mentor_id == 2 || !$application->assigned_mentor_id || ($application->assignedMentor && str_contains($application->assignedMentor->name, 'Lê Đình Quang'))) ? 'selected' : '' }}>
                                Lê Đình Quang
                            </option>
                            <option value="other" {{ ($application->assigned_mentor_id && $application->assigned_mentor_id != 1 && $application->assigned_mentor_id != 2 && (!str_contains($application->assignedMentor->name ?? '', 'Lê Đình Quang'))) ? 'selected' : '' }}>
                                Người phụ trách
                            </option>
                        </select>
                    </div>

                    <!-- Ô nhập tên khi chọn mục 'Người phụ trách' -->
                    <div id="custom_mentor_container" class="{{ ($application->assigned_mentor_id && $application->assigned_mentor_id != 1 && $application->assigned_mentor_id != 2 && (!str_contains($application->assignedMentor->name ?? '', 'Lê Đình Quang'))) ? '' : 'hidden' }} space-y-1">
                        <label class="block font-bold text-slate-700 text-xs">
                            Họ và tên Người phụ trách: <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="custom_mentor_name" id="custom_mentor_name"
                               value="{{ ($application->assigned_mentor_id && $application->assigned_mentor_id != 1 && $application->assigned_mentor_id != 2) ? ($application->assignedMentor->name ?? '') : '' }}"
                               placeholder="Điền tên người phụ trách phỏng vấn..."
                               class="w-full rounded-xl border border-orange-300 bg-orange-50/50 py-2 px-3 text-xs font-semibold focus:ring-2 focus:ring-brand-500 text-slate-800">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-white gradient-brand shadow hover:shadow-md transition">
                        <i class="fa-solid fa-paper-plane mr-1"></i> Lưu Lịch & Tự Động Gửi Email Mời PV
                    </button>
                </form>
            </div>

            <!-- 4. Lịch Sử Gửi Email Tự Động (Email Automation Logs) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-extrabold text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-envelopes-bulk text-blue-600"></i> Lịch Sử Email Đã Gửi ({{ $application->emailLogs->count() }})
                    </h4>
                </div>

                <!-- Form Gửi lại email nhanh cho Admin -->
                <form action="{{ route('azmedia.portal.candidate.resend.email', $application->id) }}" method="POST" class="mb-4 p-3 bg-blue-50/60 rounded-2xl border border-blue-100 text-xs">
                    @csrf
                    <div class="font-bold text-blue-900 mb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-paper-plane text-blue-600"></i> Gửi lại thông báo cho ứng viên:
                    </div>
                    <div class="flex gap-2">
                        <select name="template_code" class="flex-1 rounded-xl border border-blue-200 text-xs py-1.5 px-2.5 bg-white focus:ring-2 focus:ring-blue-500 font-medium">
                            <option value="screening_approved" selected>🎉 Thông báo duyệt hồ sơ CV</option>
                            <option value="applied_received">✅ Xác nhận nộp đơn & Mã tra cứu</option>
                            <option value="test_invitation">📝 Mời làm bài Test Online 20p</option>
                            <option value="interview_invitation">📅 Thư mời Phỏng vấn</option>
                            <option value="offer_congrats">🏆 Chúc mừng trúng tuyển (Offer)</option>
                            <option value="thank_you_rejection">✉️ Thư cảm ơn & Từ chối</option>
                        </select>
                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition flex items-center gap-1 flex-shrink-0">
                            <i class="fa-solid fa-paper-plane"></i> Gửi ngay
                        </button>
                    </div>
                    <div class="text-[10px] text-blue-600/80 mt-1.5 italic">
                        * Email sẽ được gửi trực tiếp đến: <strong>{{ $application->candidate->email }}</strong>
                    </div>
                </form>

                <div class="space-y-2.5">
                    @forelse($application->emailLogs as $log)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <div class="flex justify-between items-center font-bold text-slate-800">
                                <span class="truncate mr-2">{{ $log->subject }}</span>
                                <span class="text-[10px] {{ $log->status === 'sent' ? 'text-emerald-600' : 'text-rose-600' }} font-extrabold uppercase flex-shrink-0">
                                    {{ $log->status === 'sent' ? 'Đã gửi' : 'Thất bại' }}
                                </span>
                            </div>
                            <div class="text-[10px] text-slate-400 mt-1 flex justify-between">
                                <span>Gửi đến: <strong>{{ $log->recipient_email }}</strong></span>
                                <span>{{ $log->sent_at ? date('H:i - d/m/Y', strtotime($log->sent_at)) : '' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Chưa có email nào trong nhật ký.</p>
                    @endforelse
                </div>

                <div class="mt-4 p-3 bg-amber-50 rounded-xl border border-amber-200/70 text-[11px] text-amber-800">
                    <i class="fa-solid fa-triangle-exclamation mr-1 text-amber-600"></i>
                    <strong>Lưu ý:</strong> Nếu ứng viên không thấy thư trong <em>Hộp thư đến</em>, hãy nhắc ứng viên kiểm tra mục <strong>Thư rác (Spam)</strong> hoặc tab <strong>Quảng cáo / Cập nhật</strong> trong Gmail.
                </div>
            </div>
        </div>
    </div>
</div>

@if($application->testResult)
    @php
        $mTest = $application->testResult;
        $mData = $mTest->answers_data ?? [];
        $mSurvey = $mData['survey'] ?? null;
        $mQuiz = $mData['quiz'] ?? null;
        $mAzSurvey = $mData['az_survey'] ?? null;
    @endphp
    <!-- Modal Chi Tiết Khảo Sát Hoài Bão & Tìm Hiểu Về AZ Media -->
    <div id="surveyDetailsModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-slate-200">
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-lg">
                        🎯
                    </span>
                    <div>
                        <h3 class="font-extrabold text-base text-slate-900">Chi Tiết Khảo Sát & Bài Làm Online</h3>
                        <p class="text-xs text-slate-500">Ứng viên: <strong>{{ $application->candidate->name }}</strong> ({{ $application->application_code }})</p>
                    </div>
                </div>
                <button type="button" onclick="document.getElementById('surveyDetailsModal').classList.add('hidden')"
                        class="w-8 h-8 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-6 text-xs">
                @if($mSurvey)
                    <div>
                        <h4 class="font-black text-sm text-slate-900 mb-3 flex items-center gap-2 text-indigo-700">
                            <i class="fa-solid fa-file-lines"></i> I. Phiếu Khảo Sát Hoài Bão, Động Cơ & Tự Đánh Giá (Mẫu AZHR)
                        </h4>
                        <div class="space-y-3">
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <div class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-flag text-indigo-600"></i> 1. Mục tiêu 5 tháng tới tại AZHR:
                                </div>
                                <p class="text-slate-600 leading-relaxed">{{ $mSurvey['goal_short'] ?? 'Chưa điền' }}</p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <div class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-mountain text-indigo-600"></i> 2. Mục tiêu nghề nghiệp 5 năm tới:
                                </div>
                                <p class="text-slate-600 leading-relaxed">{{ $mSurvey['goal_long'] ?? 'Chưa điền' }}</p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <div class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-trophy text-amber-500"></i> 3. Thành công lớn nhất trong học tập / công việc & Bài học:
                                </div>
                                <p class="text-slate-600 leading-relaxed">{{ $mSurvey['biggest_success'] ?? 'Chưa điền' }}</p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <div class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-heart text-rose-500"></i> 4. Lý do bạn muốn thực tập tại AZHR:
                                </div>
                                <p class="text-slate-600 leading-relaxed">{{ $mSurvey['why_apply'] ?? 'Chưa điền' }}</p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <div class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-check text-emerald-600"></i> 5. Phương pháp tổ chức, sắp xếp công việc hiệu quả:
                                </div>
                                <p class="text-slate-600 leading-relaxed">{{ $mSurvey['work_organization'] ?? 'Chưa điền' }}</p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <div class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> 6. Thất bại / Sai sót đáng nhớ & Bài học rút ra:
                                </div>
                                <p class="text-slate-600 leading-relaxed">{{ $mSurvey['failure_lesson'] ?? 'Chưa điền' }}</p>
                            </div>

                            <div class="p-3.5 rounded-2xl bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200">
                                <div class="font-bold text-orange-900 mb-1 flex items-center gap-1.5">
                                    <i class="fa-solid fa-star text-orange-500"></i> 7. Lý do AZHR nên chọn bạn thay vì ứng viên khác:
                                </div>
                                <p class="text-slate-800 font-medium leading-relaxed">{{ $mSurvey['why_choose_you'] ?? 'Chưa điền' }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($mQuiz['details']))
                    <div class="pt-4 border-t border-slate-200">
                        <h4 class="font-black text-sm text-slate-900 mb-3 flex items-center gap-2 text-brand-600">
                            <i class="fa-solid fa-circle-question"></i> II. Chi Tiết Trắc Nghiệm Tìm Hiểu Về AZ Media ({{ $mQuiz['correct'] }}/{{ $mQuiz['total'] }} Đúng)
                        </h4>
                        <div class="space-y-2.5">
                            @foreach($mQuiz['details'] as $idx => $qItem)
                                <div class="p-3 rounded-xl border {{ $qItem['is_correct'] ? 'bg-emerald-50/50 border-emerald-200' : 'bg-rose-50/50 border-rose-200' }}">
                                    <div class="flex items-start justify-between gap-2 mb-1.5">
                                        <div class="font-bold text-slate-800">
                                            Câu {{ $idx + 1 }}: {{ $qItem['question_text'] }}
                                        </div>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-black {{ $qItem['is_correct'] ? 'bg-emerald-600 text-white' : 'bg-rose-600 text-white' }} flex-shrink-0">
                                            {{ $qItem['is_correct'] ? 'ĐÚNG' : 'SAI' }}
                                        </span>
                                    </div>
                                    <div class="text-[11px] text-slate-600 flex flex-wrap gap-4">
                                        <span>Đã chọn: <strong class="{{ $qItem['is_correct'] ? 'text-emerald-700' : 'text-rose-700' }}">{{ $qItem['selected_option'] }}</strong></span>
                                        @if(!$qItem['is_correct'])
                                            <span>Đáp án đúng: <strong class="text-emerald-700">{{ $qItem['correct_option'] }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($mAzSurvey)
                    <div class="pt-4 border-t border-slate-200">
                        <h4 class="font-black text-sm text-slate-900 mb-3 flex items-center gap-2 text-brand-600">
                            <i class="fa-solid fa-building"></i> III. Khảo Sát Kênh Tìm Hiểu & Ấn Tượng Về AZ Media
                        </h4>
                        <div class="space-y-3">
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                                <div class="font-bold text-slate-800 mb-1.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-bullhorn text-brand-500"></i> Kênh biết đến và tìm hiểu về công ty:
                                </div>
                                @if(!empty($mAzSurvey['channels']))
                                    <div class="flex flex-wrap gap-1.5 mb-1.5">
                                        @foreach($mAzSurvey['channels'] as $ch)
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-brand-50 text-brand-700 border border-brand-200">
                                                ✓ {{ $ch }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                @if(!empty($mAzSurvey['channel_other']))
                                    <div class="text-slate-600 italic text-[11px]">
                                        <strong>Ghi chú khác:</strong> {{ $mAzSurvey['channel_other'] }}
                                    </div>
                                @endif
                                @if(empty($mAzSurvey['channels']) && empty($mAzSurvey['channel_other']))
                                    <p class="text-slate-400 italic">Chưa cung cấp</p>
                                @endif
                            </div>

                            @if(!empty($mAzSurvey['impression']))
                                <div class="p-3.5 rounded-2xl bg-gradient-to-r from-orange-50/70 to-amber-50/70 border border-orange-200">
                                    <div class="font-bold text-orange-950 mb-1 flex items-center gap-1.5">
                                        <i class="fa-solid fa-heart text-rose-500"></i> Điều ấn tượng nhất & Mong muốn thực tập tại AZ Media:
                                    </div>
                                    <p class="text-slate-800 font-medium leading-relaxed whitespace-pre-line">{{ $mAzSurvey['impression'] }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('azmedia.portal.candidate.test.pdf', $application->id) }}?download=1"
                   class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 shadow transition">
                    <i class="fa-solid fa-file-pdf"></i> Tải Toàn Bộ Bài Test Dưới Dạng File PDF
                </a>
                <button type="button" onclick="document.getElementById('surveyDetailsModal').classList.add('hidden')"
                        class="px-5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition">
                    Đóng cửa sổ
                </button>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function toggleCustomMentorInput() {
        const select = document.getElementById('mentor_type_select');
        const container = document.getElementById('custom_mentor_container');
        const input = document.getElementById('custom_mentor_name');
        if (select && container) {
            if (select.value === 'other') {
                container.classList.remove('hidden');
                if (input) {
                    input.focus();
                }
            } else {
                container.classList.add('hidden');
            }
        }
    }
</script>
@endpush
