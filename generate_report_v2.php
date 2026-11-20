<?php
/**
 * Script tạo file Word Báo Cáo Công Việc Tuần theo đúng form mẫu chuẩn
 * Tuần: 3 (Từ ngày 18/10/2026 đến ngày 24/10/2026)
 * Dự án: Web Tuyển Thực Tập Sinh AZHR - AZ Media
 * Nhóm: Phan Duy (Leader), Đăng Khải, Linh Ân
 */

function docx_text($text, $bold = false, $sz = 22, $color = '1e293b', $align = 'left', $spBefore = 0, $spAfter = 100, $italic = false) {
    $b = $bold ? '<w:b/><w:bCs/>' : '';
    $i = $italic ? '<w:i/><w:iCs/>' : '';
    $jc = $align !== 'left' ? "<w:jc w:val=\"{$align}\"/>" : '';
    return "<w:p><w:pPr>{$jc}<w:spacing w:before=\"{$spBefore}\" w:after=\"{$spAfter}\"/></w:pPr>"
         . "<w:r><w:rPr>{$b}{$i}<w:sz w:val=\"{$sz}\"/><w:szCs w:val=\"{$sz}\"/><w:color w:val=\"{$color}\"/></w:rPr>"
         . "<w:t xml:space=\"preserve\">" . htmlspecialchars($text, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p>";
}

function docx_section_title($text) {
    return "<w:p><w:pPr><w:spacing w:before=\"240\" w:after=\"120\"/></w:pPr>"
         . "<w:r><w:rPr><w:b/><w:bCs/><w:sz w:val=\"24\"/><w:szCs w:val=\"24\"/><w:color w:val=\"1e3a8a\"/></w:rPr>"
         . "<w:t xml:space=\"preserve\">" . htmlspecialchars($text, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p>";
}

function docx_bullet($text) {
    return "<w:p><w:pPr><w:ind w:left=\"480\" w:hanging=\"240\"/><w:spacing w:before=\"40\" w:after=\"60\"/></w:pPr>"
         . "<w:r><w:rPr><w:sz w:val=\"21\"/><w:szCs w:val=\"21\"/><w:color w:val=\"334155\"/></w:rPr>"
         . "<w:t xml:space=\"preserve\">•  " . htmlspecialchars($text, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p>";
}

function docx_hr() {
    return '<w:p><w:pPr><w:pBdr><w:bottom w:val="single" w:sz="6" w:space="1" w:color="CBD5E1"/></w:pBdr>'
         . '<w:spacing w:before="60" w:after="160"/></w:pPr></w:p>';
}

$body = '';

// =================== TIÊU ĐỀ BÁO CÁO ===================
$body .= docx_text('BÁO CÁO CÔNG VIỆC TUẦN', true, 36, '1e3a8a', 'center', 0, 80);
$body .= docx_text('Tuần: 3   (Từ ngày 18/10/2026  đến ngày 24/10/2026)', true, 22, '475569', 'center', 0, 200, true);
$body .= docx_hr();

// =================== I. THÔNG TIN CHUNG ===================
$body .= docx_section_title('I. THÔNG TIN CHUNG');

$infoTable = '<w:tbl><w:tblPr><w:tblW w:w="9360" w:type="dxa"/>'
    . '<w:tblBorders>'
    . '<w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/>'
    . '<w:insideH w:val="none"/><w:insideV w:val="none"/>'
    . '</w:tblBorders></w:tblPr>';

$rowsInfo = [
    [
        'label1' => 'Họ và tên:',
        'val1'   => 'Phan Duy (Leader) - Nhóm: Đăng Khải, Linh Ân',
        'label2' => 'Bộ phận / Phòng ban:',
        'val2'   => 'Công nghệ thông tin / AZHR Dev Team'
    ],
    [
        'label1' => 'Chức danh:',
        'val1'   => 'Lập trình viên Web / Leader',
        'label2' => 'Người quản lý trực tiếp:',
        'val2'   => 'ThS. Đặng Quý Linh (GVHD / Mentor)'
    ],
    [
        'label1' => 'Dự án thực hiện:',
        'val1'   => 'Hệ Thống Web Tuyển Dụng Thực Tập Sinh AZHR (AZ Media)',
        'label2' => 'Học phần / Môn:',
        'val2'   => 'Lập trình Web nâng cao - ĐH Duy Tân'
    ]
];

foreach ($rowsInfo as $r) {
    $infoTable .= '<w:tr>'
        // Cột 1: Label 1 + Val 1
        . '<w:tc><w:tcPr><w:tcW w:w="4800" w:type="dxa"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:after="80"/></w:pPr>'
        . '<w:r><w:rPr><w:b/><w:sz w:val="21"/><w:color w:val="1e293b"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($r['label1'], ENT_XML1, 'UTF-8') . ' </w:t></w:r>'
        . '<w:r><w:rPr><w:sz w:val="21"/><w:color w:val="334155"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($r['val1'], ENT_XML1, 'UTF-8') . '</w:t></w:r>'
        . '</w:p></w:tc>'
        // Cột 2: Label 2 + Val 2
        . '<w:tc><w:tcPr><w:tcW w:w="4560" w:type="dxa"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:after="80"/></w:pPr>'
        . '<w:r><w:rPr><w:b/><w:sz w:val="21"/><w:color w:val="1e293b"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($r['label2'], ENT_XML1, 'UTF-8') . ' </w:t></w:r>'
        . '<w:r><w:rPr><w:sz w:val="21"/><w:color w:val="334155"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($r['val2'], ENT_XML1, 'UTF-8') . '</w:t></w:r>'
        . '</w:p></w:tc>'
        . '</w:tr>';
}
$infoTable .= '</w:tbl>';
$body .= $infoTable;
$body .= docx_hr();

// =================== II. TÓM TẮT KẾT QUẢ CÔNG VIỆC TRONG TUẦN ===================
$body .= docx_section_title('II. TÓM TẮT KẾT QUẢ CÔNG VIỆC TRONG TUẦN');
$body .= docx_text('Đánh giá tổng quan tiến độ tuần: Hoàn thành 92% mục tiêu đề ra. Các nhiệm vụ trọng tâm của hệ thống Web Tuyển Dụng AZHR (Careers Portal, Quản trị ATS, Tự động hóa gửi Email duyệt hồ sơ) đã được nhóm xử lý đúng hạn.', false, 21, '334155', 'left', 0, 140, true);

// Bảng công việc tuần (Mẫu y hệt ảnh)
$tblWork = '<w:tbl><w:tblPr><w:tblW w:w="9360" w:type="dxa"/>'
    . '<w:tblBorders>'
    . '<w:top w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:left w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:bottom w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:right w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:insideH w:val="single" w:sz="4" w:color="E2E8F0"/>'
    . '<w:insideV w:val="single" w:sz="4" w:color="E2E8F0"/>'
    . '</w:tblBorders></w:tblPr>';

$headersWork = [
    ['text' => 'STT', 'w' => 600, 'align' => 'center'],
    ['text' => 'Tên công việc / Hạng mục', 'w' => 2400, 'align' => 'center'],
    ['text' => 'Mục tiêu / Sản phẩm bàn giao', 'w' => 2460, 'align' => 'center'],
    ['text' => 'Tỷ lệ hoàn thành', 'w' => 1200, 'align' => 'center'],
    ['text' => 'Trạng thái', 'w' => 1300, 'align' => 'center'],
    ['text' => 'Ghi chú / Khó khăn', 'w' => 1400, 'align' => 'center']
];

// Header row
$tblWork .= '<w:tr><w:trPr><w:tblHeader/></w:trPr>';
foreach ($headersWork as $h) {
    $tblWork .= "<w:tc><w:tcPr><w:tcW w:w=\"{$h['w']}\" w:type=\"dxa\"/><w:shd w:val=\"clear\" w:color=\"auto\" w:fill=\"1E3A8A\"/><w:vAlign w:val=\"center\"/></w:tcPr>"
        . "<w:p><w:pPr><w:jc w:val=\"center\"/><w:spacing w:before=\"80\" w:after=\"80\"/></w:pPr>"
        . "<w:r><w:rPr><w:b/><w:bCs/><w:sz w:val=\"19\"/><w:szCs w:val=\"19\"/><w:color w:val=\"FFFFFF\"/></w:rPr>"
        . "<w:t xml:space=\"preserve\">{$h['text']}</w:t></w:r></w:p></w:tc>";
}
$tblWork .= '</w:tr>';

// Dữ liệu bám sát dự án thực tế của nhóm: Phan Duy, Đăng Khải, Linh Ân
$dataWork = [
    [
        'stt'     => '1',
        'task'    => "Thiết kế & Hoàn thiện Giao diện Tuyển dụng (Careers Portal & AZHR)",
        'target'  => "Landing Page nộp đơn TTS, Brand logo AZHR Đà Nẵng hoàn chỉnh",
        'rate'    => "100%",
        'status'  => "Hoàn thành",
        'note'    => "Linh Ân phụ trách - Đã duyệt & test responsive",
        'stColor' => '059669' // Green
    ],
    [
        'stt'     => '2',
        'task'    => "Tích hợp Gửi Email tự động kèm Mã tra cứu (Email Automation)",
        'target'  => "Admin duyệt hồ sơ / TTS đăng ký gửi email thật qua Gmail SMTP kèm mã AZ-2026-XXXX",
        'rate'    => "100%",
        'status'  => "Hoàn thành",
        'note'    => "Phan Duy phụ trách - Đã test SMTP gửi thành công",
        'stColor' => '059669'
    ],
    [
        'stt'     => '3',
        'task'    => "Xây dựng Quản lý Tuyển dụng Mini-ATS & Pipeline Kanban",
        'target'  => "Pipeline 6 bước: Nộp đơn, Duyệt CV, Làm test, Phỏng vấn, Nhận TTS, Từ chối",
        'rate'    => "100%",
        'status'  => "Hoàn thành",
        'note'    => "Phan Duy & Đăng Khải - Xem CV inline PDF tốt",
        'stColor' => '059669'
    ],
    [
        'stt'     => '4',
        'task'    => "Module Đề thi Trắc nghiệm Online 20 phút (Candidate Portal)",
        'target'  => "Trang kiểm tra trắc nghiệm online có đếm ngược, tự động chấm điểm bài test",
        'rate'    => "85%",
        'status'  => "Đang thực hiện",
        'note'    => "Đăng Khải phụ trách - Cần bổ sung thêm ngân hàng câu hỏi",
        'stColor' => '2563EB' // Blue
    ],
    [
        'stt'     => '5',
        'task'    => "Kiểm thử hệ thống & Viết Tài liệu Báo cáo đồ án",
        'target'  => "Báo cáo tiến độ tuần, tài liệu hướng dẫn vận hành hệ thống",
        'rate'    => "75%",
        'status'  => "Đang thực hiện",
        'note'    => "Cả nhóm - Đang hoàn thiện tài liệu nộp GVHD",
        'stColor' => '2563EB'
    ]
];

foreach ($dataWork as $d) {
    $tblWork .= '<w:tr>'
        // STT
        . '<w:tc><w:tcPr><w:tcW w:w="600" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:sz w:val="19"/><w:color w:val="1e293b"/></w:rPr><w:t>' . $d['stt'] . '</w:t></w:r></w:p></w:tc>'
        // Tên CV
        . '<w:tc><w:tcPr><w:tcW w:w="2400" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:b/><w:sz w:val="19"/><w:color w:val="0f172a"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['task'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        // Mục tiêu
        . '<w:tc><w:tcPr><w:tcW w:w="2460" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:sz w:val="19"/><w:color w:val="334155"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['target'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        // Tỷ lệ
        . '<w:tc><w:tcPr><w:tcW w:w="1200" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:b/><w:sz w:val="19"/><w:color w:val="1e3a8a"/></w:rPr><w:t>' . $d['rate'] . '</w:t></w:r></w:p></w:tc>'
        // Trạng thái
        . '<w:tc><w:tcPr><w:tcW w:w="1300" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:b/><w:sz w:val="19"/><w:color w:val="' . $d['stColor'] . '"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['status'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        // Ghi chú
        . '<w:tc><w:tcPr><w:tcW w:w="1400" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:sz w:val="18"/><w:color w:val="64748b"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['note'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        . '</w:tr>';
}
$tblWork .= '</w:tbl>';
$body .= $tblWork;
$body .= docx_hr();

// =================== III. KẾ HOẠCH CÔNG VIỆC TUẦN TỚI ===================
$body .= docx_section_title('III. KẾ HOẠCH CÔNG VIỆC TUẦN TỚI');

$tblNext = '<w:tbl><w:tblPr><w:tblW w:w="9360" w:type="dxa"/>'
    . '<w:tblBorders>'
    . '<w:top w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:left w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:bottom w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:right w:val="single" w:sz="6" w:color="94A3B8"/>'
    . '<w:insideH w:val="single" w:sz="4" w:color="E2E8F0"/>'
    . '<w:insideV w:val="single" w:sz="4" w:color="E2E8F0"/>'
    . '</w:tblBorders></w:tblPr>';

$headersNext = [
    ['text' => 'STT', 'w' => 600, 'align' => 'center'],
    ['text' => 'Nhiệm vụ trọng tâm', 'w' => 3100, 'align' => 'center'],
    ['text' => 'Kết quả dự kiến (Output)', 'w' => 2660, 'align' => 'center'],
    ['text' => 'Thời hạn (Deadline)', 'w' => 1500, 'align' => 'center'],
    ['text' => 'Đề xuất / Hỗ trợ cần thiết', 'w' => 1500, 'align' => 'center']
];

$tblNext .= '<w:tr><w:trPr><w:tblHeader/></w:trPr>';
foreach ($headersNext as $h) {
    $tblNext .= "<w:tc><w:tcPr><w:tcW w:w=\"{$h['w']}\" w:type=\"dxa\"/><w:shd w:val=\"clear\" w:color=\"auto\" w:fill=\"1E3A8A\"/><w:vAlign w:val=\"center\"/></w:tcPr>"
        . "<w:p><w:pPr><w:jc w:val=\"center\"/><w:spacing w:before=\"80\" w:after=\"80\"/></w:pPr>"
        . "<w:r><w:rPr><w:b/><w:bCs/><w:sz w:val=\"19\"/><w:szCs w:val=\"19\"/><w:color w:val=\"FFFFFF\"/></w:rPr>"
        . "<w:t xml:space=\"preserve\">{$h['text']}</w:t></w:r></w:p></w:tc>";
}
$tblNext .= '</w:tr>';

$dataNext = [
    [
        'stt'      => '1',
        'task'     => 'Hoàn thiện kiểm thử toàn diện & Fix Bug quy trình tuyển dụng',
        'output'   => 'Hệ thống vận hành trơn tru từ nộp CV đến gửi mail kết quả',
        'deadline' => 'Thứ 4 (28/10)',
        'support'  => 'Hỗ trợ từ Dev Lead (Phan Duy)'
    ],
    [
        'stt'      => '2',
        'task'     => 'Bổ sung ngân hàng câu hỏi Test chuyên môn (Backend, Frontend, AI)',
        'output'   => 'Thêm 30+ câu hỏi trắc nghiệm chia theo từng vị trí',
        'deadline' => 'Thứ 5 (29/10)',
        'support'  => 'Tài liệu đề thi từ Mentor Đặng Quý Linh'
    ],
    [
        'stt'      => '3',
        'task'     => 'Triển khai lên môi trường Demo Staging & Chuẩn bị Báo cáo nghiệm thu',
        'output'   => 'Hệ thống sẵn sàng UAT, slide thuyết trình và video demo 5 phút',
        'deadline' => 'Thứ 6 (30/10)',
        'support'  => 'Chuẩn bị phòng họp & máy chiếu'
    ]
];

foreach ($dataNext as $d) {
    $tblNext .= '<w:tr>'
        // STT
        . '<w:tc><w:tcPr><w:tcW w:w="600" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:sz w:val="19"/><w:color w:val="1e293b"/></w:rPr><w:t>' . $d['stt'] . '</w:t></w:r></w:p></w:tc>'
        // Nhiệm vụ
        . '<w:tc><w:tcPr><w:tcW w:w="3100" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:b/><w:sz w:val="19"/><w:color w:val="0f172a"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['task'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        // Output
        . '<w:tc><w:tcPr><w:tcW w:w="2660" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:sz w:val="19"/><w:color w:val="334155"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['output'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        // Deadline
        . '<w:tc><w:tcPr><w:tcW w:w="1500" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:jc w:val="center"/><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:b/><w:sz w:val="19"/><w:color w:val="ea580c"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['deadline'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        // Hỗ trợ
        . '<w:tc><w:tcPr><w:tcW w:w="1500" w:type="dxa"/><w:vAlign w:val="center"/></w:tcPr>'
        . '<w:p><w:pPr><w:spacing w:before="60" w:after="60"/></w:pPr>'
        . '<w:r><w:rPr><w:sz w:val="18"/><w:color w:val="64748b"/></w:rPr><w:t xml:space="preserve">' . htmlspecialchars($d['support'], ENT_XML1, 'UTF-8') . '</w:t></w:r></w:p></w:tc>'
        . '</w:tr>';
}
$tblNext .= '</w:tbl>';
$body .= $tblNext;
$body .= docx_hr();

// =================== IV. ĐỀ XUẤT & KIẾN NGHỊ ===================
$body .= docx_section_title('IV. ĐỀ XUẤT & KIẾN NGHỊ');
$body .= docx_bullet('Đề xuất Mentor/GVHD phê duyệt ngân hàng 30 câu hỏi đánh giá thực tập sinh cho các vị trí mới (Tester, AI, Marketing).');
$body .= docx_bullet('Đề xuất tổ chức buổi họp trao đổi ngắn (15 phút) đầu ngày để đồng bộ tiến độ dự án giữa các thành viên Phan Duy, Đăng Khải và Linh Ân.');
$body .= docx_bullet('Hệ thống gửi Email tự động qua Gmail SMTP đã hoạt động tốt, đề xuất áp dụng chính thức cho các đợt duyệt hồ sơ tiếp theo.');
$body .= docx_hr();

// =================== V. XÁC NHẬN ===================
$body .= docx_section_title('V. XÁC NHẬN');

$tblSign = '<w:tbl><w:tblPr><w:tblW w:w="9360" w:type="dxa"/>'
    . '<w:tblBorders>'
    . '<w:top w:val="none"/><w:left w:val="none"/><w:bottom w:val="none"/><w:right w:val="none"/>'
    . '<w:insideH w:val="none"/><w:insideV w:val="none"/>'
    . '</w:tblBorders></w:tblPr>'
    . '<w:tr>'
    // Cột Người làm báo cáo
    . '<w:tc><w:tcPr><w:tcW w:w="4680" w:type="dxa"/></w:tcPr>'
    . docx_text('Người làm báo cáo', true, 22, '1e293b', 'center', 0, 40)
    . docx_text('(Ký và ghi rõ họ tên)', false, 18, '64748b', 'center', 0, 900, true)
    . docx_text('Phan Duy (Leader)', true, 22, '1e3a8a', 'center', 0, 20)
    . docx_text('Nhóm: Đăng Khải - Linh Ân', false, 18, '64748b', 'center', 0, 40)
    . '</w:tc>'
    // Cột Quản lý duyệt
    . '<w:tc><w:tcPr><w:tcW w:w="4680" w:type="dxa"/></w:tcPr>'
    . docx_text('Quản lý duyệt', true, 22, '1e293b', 'center', 0, 40)
    . docx_text('(Ký và ghi rõ họ tên)', false, 18, '64748b', 'center', 0, 900, true)
    . docx_text('ThS. Đặng Quý Linh', true, 22, '1e3a8a', 'center', 0, 20)
    . docx_text('Giảng viên hướng dẫn / Mentor', false, 18, '64748b', 'center', 0, 40)
    . '</w:tc>'
    . '</w:tr></w:tbl>';

$body .= $tblSign;

/* ---- Build XML wrapper ---- */
$docXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
  xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>
' . $body . '
    <w:sectPr>
      <w:pgSz w:w="11906" w:h="16838"/> <!-- A4 Size: 210mm x 297mm -->
      <w:pgMar w:top="1134" w:right="1134" w:bottom="1134" w:left="1417" w:header="708" w:footer="708" w:gutter="0"/> <!-- Lề chuẩn: Trái 2.5cm, còn lại 2cm -->
    </w:sectPr>
  </w:body>
</w:document>';

// Lưu ra file DOCX
$filename = "BaoCaoCongViec_Tuan3_18-10_den_24-10-2026.docx";
$outDir   = __DIR__ . '/public/downloads';
if (!is_dir($outDir)) mkdir($outDir, 0777, true);
$outPath  = "$outDir/$filename";

$tmp = sys_get_temp_dir() . '/azhr_docx_template_' . uniqid();
mkdir($tmp);
mkdir($tmp . '/word');
mkdir($tmp . '/word/_rels');
mkdir($tmp . '/_rels');
mkdir($tmp . '/docProps');

file_put_contents("$tmp/[Content_Types].xml",
'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml"  ContentType="application/xml"/>
  <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
  <Override PartName="/word/styles.xml"   ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
  <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
</Types>');

file_put_contents("$tmp/_rels/.rels",
'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
  <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
</Relationships>');

file_put_contents("$tmp/word/_rels/document.xml.rels",
'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>');

file_put_contents("$tmp/word/styles.xml",
'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:docDefaults><w:rPrDefault><w:rPr>
    <w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman" w:cs="Times New Roman"/>
    <w:sz w:val="22"/><w:szCs w:val="22"/>
    <w:lang w:val="vi-VN"/>
  </w:rPr></w:rPrDefault></w:docDefaults>
</w:styles>');

$now = date('Y-m-d\TH:i:s\Z');
file_put_contents("$tmp/docProps/core.xml",
"<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
<cp:coreProperties xmlns:cp=\"http://schemas.openxmlformats.org/package/2006/metadata/core-properties\"
  xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:dcterms=\"http://purl.org/dc/terms/\"
  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
  <dc:title>Báo Cáo Công Việc Tuần 3 - Nhóm AZHR</dc:title>
  <dc:creator>Phan Duy (Leader) - Nhóm: Đăng Khải, Linh Ân</dc:creator>
  <dc:subject>Dự án Hệ Thống Web Tuyển Dụng Thực Tập Sinh AZHR</dc:subject>
  <dcterms:created xsi:type=\"dcterms:W3CDTF\">{$now}</dcterms:created>
  <dcterms:modified xsi:type=\"dcterms:W3CDTF\">{$now}</dcterms:modified>
</cp:coreProperties>");

file_put_contents("$tmp/word/document.xml", $docXml);

$zip = new ZipArchive();
if ($zip->open($outPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
    $zip->addFile("$tmp/[Content_Types].xml",          '[Content_Types].xml');
    $zip->addFile("$tmp/_rels/.rels",                  '_rels/.rels');
    $zip->addFile("$tmp/word/_rels/document.xml.rels", 'word/_rels/document.xml.rels');
    $zip->addFile("$tmp/word/document.xml",            'word/document.xml');
    $zip->addFile("$tmp/word/styles.xml",              'word/styles.xml');
    $zip->addFile("$tmp/docProps/core.xml",            'docProps/core.xml');
    $zip->close();
}

// Dọn dẹp
foreach ([$tmp.'/word/_rels', $tmp.'/word', $tmp.'/_rels', $tmp.'/docProps', $tmp] as $d) {
    foreach (glob("$d/*") as $f) if (is_file($f)) unlink($f);
    @rmdir($d);
}

echo "SUCCESS\n";
echo "FILE: " . realpath($outPath) . "\n";
echo "DOWNLOAD URL: http://127.0.0.1:8000/downloads/$filename\n";
