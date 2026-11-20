<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Báo Cáo Thu Hoạch & Đánh Giá Năng Lực - {{ $application->candidate->name }}</title>
    <style type="text/css">
        * {
            font-family: 'DejaVu Sans', sans-serif !important;
            box-sizing: border-box;
        }
        body {
            font-size: 11px;
            color: #1e293b;
            line-height: 1.45;
            margin: 0;
            padding: 0;
        }
        .page-break {
            page-break-before: always;
        }
        .no-break {
            page-break-inside: avoid;
        }

        /* Header table */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #ea580c;
            padding-bottom: 8px;
            margin-bottom: 14px;
        }
        .company-name {
            font-size: 12px;
            font-weight: bold;
            color: #1b365d;
            text-transform: uppercase;
        }
        .company-meta {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Document Title */
        .doc-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #1b365d;
            text-transform: uppercase;
            margin: 6px 0 2px 0;
            letter-spacing: 0.5px;
        }
        .doc-subtitle {
            text-align: center;
            font-size: 10px;
            color: #ea580c;
            font-weight: bold;
            margin-bottom: 12px;
        }

        /* Candidate Info Box */
        .info-table {
            width: 100%;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            margin-bottom: 14px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 8px;
            font-size: 10px;
            border: 1px solid #e2e8f0;
        }
        .info-label {
            font-weight: bold;
            color: #334155;
            width: 22%;
            background-color: #f1f5f9;
        }
        .info-val {
            color: #0f172a;
        }

        /* Section Title */
        .section-header {
            background-color: #1b365d;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            padding: 6px 10px;
            margin-top: 12px;
            margin-bottom: 8px;
            text-transform: uppercase;
            border-radius: 3px;
        }
        .subsection-header {
            font-size: 10.5px;
            font-weight: bold;
            color: #ea580c;
            border-left: 3px solid #ea580c;
            padding-left: 6px;
            margin: 8px 0 5px 0;
        }

        /* General tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .data-table th {
            background-color: #334155;
            color: #ffffff;
            font-size: 9.5px;
            padding: 5px 6px;
            border: 1px solid #475569;
            text-align: center;
        }
        .data-table td {
            font-size: 9.5px;
            padding: 4px 6px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        /* Answer block */
        .answer-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #1b365d;
            padding: 6px 8px;
            margin-bottom: 6px;
            font-size: 9.5px;
        }
        .answer-box strong {
            color: #0f172a;
        }
        .answer-box p {
            margin: 3px 0 0 0;
            color: #334155;
            line-height: 1.4;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 8.5px;
            font-weight: bold;
            border-radius: 3px;
        }
        .badge-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .badge-orange {
            background-color: #ffedd5;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }

        /* Signatures */
        .sign-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
        }
        .sign-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 10px;
        }
    </style>
</head>
<body>

    @php
        $test = $application->testResult;
        $data = $test ? $test->answers_data : [];
        $nlp = $data['nlp'] ?? null;
        $personality = $data['personality'] ?? null;
        $disc = $personality['disc'] ?? null;
        $mbti = $personality['mbti'] ?? null;
        $numerology = $personality['numerology'] ?? null;
        $wheel = $data['wheel_of_life'] ?? null;
        $survey = $data['survey'] ?? null;
        $azSurvey = $data['az_survey'] ?? null;
        $quiz = $data['quiz'] ?? null;
    @endphp

    <!-- HEADER TRANG BÁO CÁO -->
    <table class="header-table">
        <tr>
            <td style="width: 70%; vertical-align: top;">
                <div class="company-name">CÔNG TY TNHH ĐẦU TƯ PHÁT TRIỂN DOANH NGHIỆP AZ HOMES</div>
                <div style="font-size: 11px; font-weight: bold; color: #ea580c; margin-top: 1px;">CHI NHÁNH AZ MEDIA – ĐÀ NẴNG</div>
                <div class="company-meta">
                    Địa chỉ: 84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng<br>
                    Hotline: 0968.825.068 | Website: azmedia.com.vn | Fanpage: fb.com/congtyazmedia
                </div>
            </td>
            <td style="width: 30%; text-align: right; vertical-align: top;">
                <div style="font-size: 10px; font-weight: bold; color: #1b365d;">HỆ THỐNG TUYỂN DỤNG AZHR</div>
                <div style="font-size: 9px; color: #64748b; margin-top: 2px;">Mã HS: <strong style="color: #ea580c;">{{ $application->application_code }}</strong></div>
                <div style="font-size: 9px; color: #64748b;">Thời gian nộp: {{ $test->completed_at ? date('H:i - d/m/Y', strtotime($test->completed_at)) : date('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <div class="doc-title">BÁO CÁO KẾT QUẢ ĐÁNH GIÁ NĂNG LỰC TOÀN DIỆN</div>
    <div class="doc-subtitle">Quy trình tuyển chọn & Đào tạo Thực tập sinh AZ Media (Phần 1 - 2 - 3 - 4)</div>

    <!-- THÔNG TIN ỨNG VIÊN -->
    <table class="info-table">
        <tr>
            <td class="info-label">Họ và tên ứng viên:</td>
            <td class="info-val"><strong>{{ $application->candidate->name }}</strong></td>
            <td class="info-label">Vị trí ứng tuyển:</td>
            <td class="info-val"><strong>{{ $application->position->title }}</strong></td>
        </tr>
        <tr>
            <td class="info-label">Email liên hệ:</td>
            <td class="info-val">{{ $application->candidate->email }}</td>
            <td class="info-label">Số điện thoại:</td>
            <td class="info-val">{{ $application->candidate->phone }}</td>
        </tr>
        <tr>
            <td class="info-label">Trường ĐH / Cao đẳng:</td>
            <td class="info-val">{{ $application->candidate->university ?? 'Cao đẳng Đà Nẵng (DNC)' }}</td>
            <td class="info-label">Chuyên ngành đào tạo:</td>
            <td class="info-val">{{ $application->candidate->major ?? 'Công nghệ Thông tin' }}</td>
        </tr>
        <tr>
            <td class="info-label">Điểm Văn Hóa AZ Media:</td>
            <td class="info-val">
                <span class="badge {{ ($test->score ?? 100) >= 60 ? 'badge-success' : 'badge-danger' }}" style="font-size: 10px;">
                    {{ $test->score ?? 100 }} / 100 Điểm ({{ $test->correct_answers ?? 5 }}/{{ $test->total_questions ?? 5 }} Câu đúng)
                </span>
            </td>
            <td class="info-label">Thời gian làm bài:</td>
            <td class="info-val">{{ round(($test->time_spent_seconds ?? 600) / 60) }} phút</td>
        </tr>
    </table>

    <!-- ==================== PHẦN 1 ==================== -->
    <div class="section-header">PHẦN 1. ĐÁNH GIÁ NĂNG LỰC & TÍNH CÁCH (NLB - DISC - MBTI - THẦN SỐ HỌC)</div>

    <!-- 1.1 NLP -->
    <div class="subsection-header">1.1 Mô hình NLB / NLP (Phong cách tiếp nhận thông tin V-A-K-Ad)</div>
    @if($nlp)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Visual (Thị giác / Nhìn)</th>
                    <th style="width: 25%;">Auditory (Thính giác / Nghe)</th>
                    <th style="width: 25%;">Kinesthetic (Cảm giác / Trải nghiệm)</th>
                    <th style="width: 25%;">Auditory Digital (Logic nội tâm)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight: bold; font-size: 11px; color: #ea580c;">{{ $nlp['scores']['Visual'] ?? 0 }} điểm</td>
                    <td style="text-align: center; font-weight: bold; font-size: 11px; color: #2563eb;">{{ $nlp['scores']['Auditory'] ?? 0 }} điểm</td>
                    <td style="text-align: center; font-weight: bold; font-size: 11px; color: #059669;">{{ $nlp['scores']['Kinesthetic'] ?? 0 }} điểm</td>
                    <td style="text-align: center; font-weight: bold; font-size: 11px; color: #7c3aed;">{{ $nlp['scores']['Auditory_Digital'] ?? 0 }} điểm</td>
                </tr>
            </tbody>
        </table>
        <div class="answer-box">
            <strong>Phong cách tiếp nhận vượt trội:</strong> <span class="badge badge-orange">{{ $nlp['dominant_title'] ?? 'Toàn diện' }}</span><br>
            <p>{{ $nlp['dominant_summary'] ?? 'Ứng viên có phong cách tiếp nhận thông tin và xử lý công việc hài hòa.' }}</p>
        </div>
    @endif

    <!-- 1.2 DISC & MBTI -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 6px;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 5px;">
                <div class="subsection-header">1.2 Nhóm phong cách DISC</div>
                <div class="answer-box">
                    <strong>Nhóm nổi trội:</strong> <span class="badge badge-orange">{{ $disc['title'] ?? 'Nhóm C – Cẩn trọng' }}</span>
                    <p>{{ $disc['summary'] ?? 'Chú ý đến chi tiết, yêu cầu sự chính xác cao, chu đáo và muốn hiểu rõ bản chất vấn đề.' }}</p>
                </div>
            </td>
            <td style="width: 50%; vertical-align: top; padding-left: 5px;">
                <div class="subsection-header">1.3 Kiểu tính cách MBTI</div>
                <div class="answer-box">
                    <strong>Đặc tính MBTI:</strong> <span class="badge badge-orange">{{ $mbti['title'] ?? 'I (Hướng nội) & F (Cảm xúc)' }}</span>
                    <p>{{ $mbti['summary'] ?? 'Coi trọng sự hài hòa, thực tế kết hợp sáng tạo; bản tính trầm tính, quan sát thầm lặng.' }}</p>
                </div>
            </td>
        </tr>
    </table>

    <!-- 1.4 Thần số học -->
    @if($numerology)
        <div class="subsection-header" style="margin-top: 6px;">1.4 Con số đường đời (Nhân số học ứng dụng)</div>
        <div class="answer-box">
            <strong>{{ $numerology['title'] ?? 'Con số đường đời 9' }}</strong> (Ngày sinh: {{ $numerology['dob'] ?? $application->candidate->birth_date ?? 'N/A' }}):
            <p>{{ $numerology['summary'] ?? 'Gắn với lòng trắc ẩn, tính bao dung, tinh thần trách nhiệm cao và mong muốn mang lại giá trị tích cực.' }}</p>
        </div>
    @endif

    <!-- ==================== PHẦN 2 ==================== -->
    <div class="section-header" style="margin-top: 14px;">PHẦN 2. BÁNH XE CUỘC ĐỜI (WHEEL OF LIFE - 8 KHÍA CẠNH)</div>
    @if($wheel && !empty($wheel['dimensions']))
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 12.5%;">Tài chính</th>
                    <th style="width: 12.5%;">Phát triển</th>
                    <th style="width: 12.5%;">Sức khỏe</th>
                    <th style="width: 12.5%;">Gia đình</th>
                    <th style="width: 12.5%;">Mối quan hệ</th>
                    <th style="width: 12.5%;">Xã hội</th>
                    <th style="width: 12.5%;">Tinh thần</th>
                    <th style="width: 12.5%;">Sự nghiệp</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['finance']['score'] ?? 5 }}/10</td>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['personal_growth']['score'] ?? 5 }}/10</td>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['health']['score'] ?? 5 }}/10</td>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['family']['score'] ?? 5 }}/10</td>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['relationships']['score'] ?? 5 }}/10</td>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['social_life']['score'] ?? 5 }}/10</td>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['spirituality']['score'] ?? 5 }}/10</td>
                    <td style="text-align: center; font-weight: bold;">{{ $wheel['dimensions']['career']['score'] ?? 5 }}/10</td>
                </tr>
            </tbody>
        </table>
        @if(!empty($wheel['lesson']))
            <div class="answer-box">
                <strong>Nhận thức & Bài học rút ra từ Bánh xe cuộc đời:</strong>
                <p>{{ $wheel['lesson'] }}</p>
            </div>
        @endif
    @endif

    <div class="page-break"></div>

    <!-- ==================== PHẦN 3 ==================== -->
    <div class="section-header">PHẦN 3. PHIẾU KHẢO SÁT HOÀI BÃO, ĐỘNG CƠ & TỰ ĐÁNH GIÁ BẢN THÂN</div>
    @if($survey)
        <div class="answer-box">
            <strong>1. Mục tiêu ngắn hạn (1 - 2 năm tới):</strong>
            <p>{{ $survey['goal_short'] ?? 'Chưa cung cấp' }}</p>
        </div>
        <div class="answer-box">
            <strong>2. Mục tiêu dài hạn (3 - 5 năm tới):</strong>
            <p>{{ $survey['goal_long'] ?? 'Chưa cung cấp' }}</p>
        </div>
        <div class="answer-box">
            <strong>3. Thành công lớn nhất từng đạt được:</strong>
            <p>{{ $survey['biggest_success'] ?? 'Chưa cung cấp' }}</p>
        </div>
        <div class="answer-box">
            <strong>4. Lý do lựa chọn ứng tuyển vào AZ Media / AZHR:</strong>
            <p>{{ $survey['why_apply'] ?? 'Chưa cung cấp' }}</p>
        </div>
        <div class="answer-box">
            <strong>5. Phương pháp tổ chức và quản lý công việc:</strong>
            <p>{{ $survey['work_organization'] ?? 'Chưa cung cấp' }}</p>
        </div>
        <div class="answer-box">
            <strong>6. Thất bại / sai lầm lớn nhất và bài học đắt giá rút ra:</strong>
            <p>{{ $survey['failure_lesson'] ?? 'Chưa cung cấp' }}</p>
        </div>
        <div class="answer-box" style="border-left-color: #ea580c; background-color: #fff7ed;">
            <strong style="color: #9a3412;">7. Lý do AZ Media nên chọn bạn thay vì ứng viên khác:</strong>
            <p style="color: #9a3412; font-weight: 500;">{{ $survey['why_choose_you'] ?? 'Chưa cung cấp' }}</p>
        </div>
    @endif

    <!-- ==================== PHẦN 4 ==================== -->
    <div class="section-header" style="margin-top: 14px;">PHẦN 4. TÌM HIỂU VỀ DOANH NGHIỆP AZ MEDIA</div>

    <!-- 4.1 Trắc nghiệm văn hóa -->
    <div class="subsection-header">4.1 Kết quả trắc nghiệm hiểu biết về AZ Media ({{ $quiz['correct'] ?? 5 }}/{{ $quiz['total'] ?? 5 }} câu đúng)</div>
    @if(!empty($quiz['details']))
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 6%;">STT</th>
                    <th style="width: 52%;">Nội dung câu hỏi trắc nghiệm</th>
                    <th style="width: 16%;">Đã chọn</th>
                    <th style="width: 16%;">Đáp án đúng</th>
                    <th style="width: 10%;">Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quiz['details'] as $idx => $item)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">{{ $idx + 1 }}</td>
                        <td>{{ $item['question_text'] }}</td>
                        <td style="text-align: center; font-weight: bold; color: {{ $item['is_correct'] ? '#166534' : '#991b1b' }};">
                            {{ $item['selected_option'] }}
                        </td>
                        <td style="text-align: center; font-weight: bold; color: #166534;">
                            {{ $item['correct_option'] }}
                        </td>
                        <td style="text-align: center;">
                            <span class="badge {{ $item['is_correct'] ? 'badge-success' : 'badge-danger' }}">
                                {{ $item['is_correct'] ? 'ĐÚNG' : 'SAI' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- 4.2 Kênh tìm hiểu & Tự luận cảm nhận -->
    @if($azSurvey)
        <div class="subsection-header">4.2 Kênh biết đến & Khảo sát tìm hiểu về AZ Media</div>
        <div class="answer-box">
            <strong>Các kênh ứng viên đã tiếp cận:</strong>
            @if(!empty($azSurvey['channels']))
                <div style="margin-top: 3px;">
                    @foreach($azSurvey['channels'] as $ch)
                        <span class="badge badge-orange" style="margin-right: 4px;">✓ {{ $ch }}</span>
                    @endforeach
                </div>
            @endif
            @if(!empty($azSurvey['channel_other']))
                <p><em>Kênh khác bổ sung:</em> {{ $azSurvey['channel_other'] }}</p>
            @endif
        </div>

        @if(!empty($azSurvey['impression']))
            <div class="subsection-header">4.3 Điều ấn tượng nhất & Mong muốn thực tập tại AZ Media</div>
            <div class="answer-box" style="border-left-color: #ea580c; background-color: #fff7ed;">
                <p style="white-space: pre-line; color: #1e293b; font-weight: 500;">{{ $azSurvey['impression'] }}</p>
            </div>
        @endif
    @endif

    <!-- XÁC NHẬN CHỮ KÝ -->
    <table class="sign-table no-break">
        <tr>
            <td>
                <strong>Ứng viên thực hiện bài test</strong><br>
                <span style="font-size: 8.5px; color: #64748b; font-style: italic;">(Ký và ghi rõ họ tên)</span>
                <div style="height: 50px;"></div>
                <strong style="color: #1b365d;">{{ $application->candidate->name }}</strong>
            </td>
            <td>
                <strong>Người duyệt hồ sơ / Mentor phụ trách</strong><br>
                <span style="font-size: 8.5px; color: #64748b; font-style: italic;">(Ký và xác nhận kết quả)</span>
                <div style="height: 50px;"></div>
                <strong style="color: #1b365d;">Lê Đình Quang</strong><br>
                <span style="font-size: 9px; color: #64748b;">Tổng Giám Đốc / Mentor AZ Media</span>
            </td>
        </tr>
    </table>

</body>
</html>
