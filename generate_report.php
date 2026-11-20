<?php
/**
 * Generate DOCX Weekly Report - AZ Media Web Tuyển TTS Project
 * Team: Phan Duy (Leader), Đăng Khải, Linh Ân
 */

$weekNum   = (int)date('W');
$year      = date('Y');
$monday    = new DateTime();
$monday->setISODate($year, $weekNum, 1);
$friday    = clone $monday;
$friday->modify('+4 days');
$weekRange = $monday->format('d/m/Y') . ' - ' . $friday->format('d/m/Y');

/* ---- XML helpers ---- */
function p2($text, $bold = false, $sz = 22, $color = '1e293b', $align = 'left', $spAfter = 120) {
    $b  = $bold ? '<w:b/><w:bCs/>' : '';
    return "<w:p><w:pPr><w:jc w:val=\"{$align}\"/><w:spacing w:after=\"{$spAfter}\"/></w:pPr>"
         . "<w:r><w:rPr>{$b}<w:sz w:val=\"{$sz}\"/><w:szCs w:val=\"{$sz}\"/><w:color w:val=\"{$color}\"/></w:rPr>"
         . "<w:t xml:space=\"preserve\">" . htmlspecialchars($text, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p>";
}

function h1($text) {
    return "<w:p><w:pPr><w:spacing w:before=\"280\" w:after=\"120\"/></w:pPr>"
         . "<w:r><w:rPr><w:b/><w:bCs/><w:sz w:val=\"30\"/><w:szCs w:val=\"30\"/><w:color w:val=\"EA580C\"/></w:rPr>"
         . "<w:t xml:space=\"preserve\">" . htmlspecialchars($text, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p>";
}

function h2($text) {
    return "<w:p><w:pPr><w:spacing w:before=\"200\" w:after=\"100\"/></w:pPr>"
         . "<w:r><w:rPr><w:b/><w:bCs/><w:sz w:val=\"25\"/><w:szCs w:val=\"25\"/><w:color w:val=\"1E40AF\"/></w:rPr>"
         . "<w:t xml:space=\"preserve\">" . htmlspecialchars($text, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p>";
}

function bullet2($text) {
    return "<w:p><w:pPr><w:ind w:left=\"720\" w:hanging=\"360\"/><w:spacing w:after=\"60\"/></w:pPr>"
         . "<w:r><w:rPr><w:sz w:val=\"21\"/><w:szCs w:val=\"21\"/><w:color w:val=\"374151\"/></w:rPr>"
         . "<w:t xml:space=\"preserve\">- " . htmlspecialchars($text, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p>";
}

function tblStart($widths) {
    $cols = '';
    foreach ($widths as $w) $cols .= "<w:col w:w=\"{$w}\" w:type=\"dxa\"/>";
    return '<w:tbl><w:tblPr><w:tblW w:w="9360" w:type="dxa"/>'
         . '<w:tblBorders>'
         . '<w:top w:val="single" w:sz="4" w:color="d1d5db"/>'
         . '<w:left w:val="single" w:sz="4" w:color="d1d5db"/>'
         . '<w:bottom w:val="single" w:sz="4" w:color="d1d5db"/>'
         . '<w:right w:val="single" w:sz="4" w:color="d1d5db"/>'
         . '<w:insideH w:val="single" w:sz="4" w:color="d1d5db"/>'
         . '<w:insideV w:val="single" w:sz="4" w:color="d1d5db"/>'
         . '</w:tblBorders></w:tblPr>';
}

function tblRow2($cells, $widths, $header = false) {
    $xml = '<w:tr>';
    foreach ($cells as $i => $cell) {
        $w   = $widths[$i] ?? 2000;
        $b   = $header ? '<w:b/><w:bCs/>' : '';
        $bg  = $header ? '<w:shd w:val="clear" w:color="auto" w:fill="EA580C"/>' : '';
        $col = $header ? 'FFFFFF' : '1e293b';
        $xml .= "<w:tc><w:tcPr><w:tcW w:w=\"{$w}\" w:type=\"dxa\"/>{$bg}</w:tcPr>"
              . "<w:p><w:pPr><w:spacing w:after=\"60\"/></w:pPr>"
              . "<w:r><w:rPr>{$b}<w:sz w:val=\"20\"/><w:szCs w:val=\"20\"/><w:color w:val=\"{$col}\"/></w:rPr>"
              . "<w:t xml:space=\"preserve\">" . htmlspecialchars($cell, ENT_XML1, 'UTF-8') . "</w:t></w:r></w:p></w:tc>";
    }
    return $xml . '</w:tr>';
}
function tblEnd2() { return '</w:tbl>'; }
function sep2() {
    return '<w:p><w:pPr><w:pBdr><w:bottom w:val="single" w:sz="6" w:space="1" w:color="F97316"/></w:pBdr>'
         . '<w:spacing w:after="120"/></w:pPr></w:p>';
}

/* ---- Build body ---- */
$b = '';

// Tiêu đề
$b .= p2('TRUONG DAI HOC DUY TAN - KHOA CONG NGHE THONG TIN', true, 20, '475569', 'center', 60);
$b .= p2('Mon: Lap Trinh Web Nang Cao - Hoc ky I / 2026-2027', false, 19, '64748b', 'center', 60);
$b .= p2('_______________________________________________', false, 18, 'e2e8f0', 'center', 160);
$b .= p2('BAO CAO CONG VIEC TUAN', true, 44, 'EA580C', 'center', 80);
$b .= p2("Tuan {$weekNum} - Nam {$year} ({$weekRange})", true, 27, '1e293b', 'center', 80);
$b .= p2('DU AN: He Thong Web Tuyen Dung Thuc Tap Sinh AZHR - AZ Media', true, 25, '1E40AF', 'center', 80);
$b .= p2('_______________________________________________', false, 18, 'e2e8f0', 'center', 240);

// I. Thong tin du an
$b .= h1('I. THONG TIN DU AN');
$b .= sep2();
$b .= tblStart([2800, 6560]);
$b .= tblRow2(['Ten du an', 'He Thong Web Tuyen Dung Thuc Tap Sinh AZHR - AZ Media Da Nang'], [2800, 6560]);
$b .= tblRow2(['Cong nghe', 'Laravel 8 · PHP 8.2 · MySQL · Blade · Tailwind CSS · Gmail SMTP'], [2800, 6560]);
$b .= tblRow2(['Moi truong', 'XAMPP (Apache + MySQL) · PHP Artisan Dev Server (port 8000)'], [2800, 6560]);
$b .= tblRow2(['URL local', 'http://127.0.0.1:8000'], [2800, 6560]);
$b .= tblRow2(['Thu muc', 'c:\xampp\htdocs\laptrinhwebnangcao\laptrinhwebnangcao'], [2800, 6560]);
$b .= tblRow2(['So bang CSDL', '9 bang (roles, internship_positions, candidates, applications, ...)'], [2800, 6560]);
$b .= tblEnd2();

// II. Thanh vien nhom
$b .= h1('II. THANH VIEN NHOM');
$b .= sep2();
$b .= tblStart([600, 2500, 1800, 4460]);
$b .= tblRow2(['STT', 'Ho va Ten', 'Vai tro', 'Trach nhiem chinh'], [600, 2500, 1800, 4460], true);
$b .= tblRow2(['1', 'Phan Duy', 'Leader / Full-stack', 'Quan ly tien do, thiet ke kien truc he thong, code backend (ATS Controller, Email Automation, Auth), review code'], [600, 2500, 1800, 4460]);
$b .= tblRow2(['2', 'Dang Khai', 'Backend Developer', 'Xay dung database migrations, models, seeders, RESTful API, CandidatePortal, Online Test system'], [600, 2500, 1800, 4460]);
$b .= tblRow2(['3', 'Linh An', 'Frontend / QA', 'Thiet ke UI/UX Blade views (Careers, Kanban, Dashboard), kiem thu tinh nang, viet bao cao'], [600, 2500, 1800, 4460]);
$b .= tblEnd2();

// III. Tong quan tien do
$b .= h1('III. TONG QUAN TIEN DO DU AN');
$b .= sep2();
$b .= h2('3.1. Cac module da hoan thanh (100%)');
$done = [
    'Co so du lieu: 9 bang day du (roles, internship_positions, candidates, applications, test_questions, candidate_tests, evaluations, email_templates, email_logs)',
    'Module Careers Landing Page: trang tuyen dung cong khai, bo loc vi tri, form nop don nhanh co upload CV PDF',
    'Module Candidate Portal: tra cuu tien do ho so theo ma, lam bai test online 20 phut (countdown timer, MCQ)',
    'Module Mini-ATS Portal: dang nhap Gmail + mat khau, Dashboard thong ke, Kanban Board 6 cot, bang ho so, chi tiet ung vien',
    'Email Automation: gui email that qua Gmail SMTP (xac nhan nop don kem ma tra cuu, gui test, moi phong van, chuc mung, tu choi)',
    'He thong phan quyen: Admin, HR Lead, Mentor voi session-based authentication',
    'Seeder: 3 tai khoan nhan vien AZ Media, 6 vi tri tuyen dung, 13 MCQ, 5 email template, 7 ung vien mau',
    'RESTful API v1: 6 endpoints (getPositions, getPositionDetail, submitApply, trackProgress, getTestQuestions, getAnalytics)',
    'Scorecard danh gia ung vien: cham diem 4 tieu chi (technical, logic, attitude, communication)',
    'Xem CV inline PDF tren trinh duyet khong can tai ve',
    'Xuat bao cao cong viec tuan ra file Word (.docx)',
];
foreach ($done as $item) $b .= bullet2($item);

$b .= h2('3.2. Dang thuc hien / Ke hoach tuan toi');
$todo = [
    'Hoan thien chuc nang xuat bao cao tuyen dung ra file Excel',
    'Bo sung Unit Test cho cac Controller chinh',
    'Nang cap ngan hang cau hoi MCQ (them 30+ cau moi)',
    'Trien khai len hosting / VPS production',
    'Quay video demo san pham cho buoi bao ve do an (5 phut)',
];
foreach ($todo as $item) $b .= bullet2($item);

// IV. Cong viec chi tiet
$b .= h1('IV. CONG VIEC CHI TIET TUNG THANH VIEN');
$b .= sep2();

// Phan Duy
$b .= h2('4.1. Phan Duy (Leader / Full-stack)');
$b .= tblStart([1400, 5300, 2660]);
$b .= tblRow2(['Ngay', 'Noi dung cong viec', 'Ket qua / Ghi chu'], [1400, 5300, 2660], true);
$b .= tblRow2(['Thu 2', 'Thiet ke kien truc he thong, phan chia task cho nhom', 'Hoan thanh - Da assign task tren nhom chat'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 3', 'Code AZMediaATSController: login, processLogin, dashboard, kanban, applications', 'Hoan thanh - Login Gmail+password OK'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 4', 'Tich hop Email Automation su dung Laravel Mail facade + Gmail SMTP', 'Hoan thanh - Email gui that thanh cong'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 5', 'Fix bug xac thuc email, cap nhat email template HTML dep hon', 'Hoan thanh - SMTP test thanh cong'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 6', 'Review code nhom, viet bao cao tuan, sinh file Word download', 'Hoan thanh'], [1400, 5300, 2660]);
$b .= tblEnd2();

// Dang Khai
$b .= h2('4.2. Dang Khai (Backend Developer)');
$b .= tblStart([1400, 5300, 2660]);
$b .= tblRow2(['Ngay', 'Noi dung cong viec', 'Ket qua / Ghi chu'], [1400, 5300, 2660], true);
$b .= tblRow2(['Thu 2', 'Viet 9 migrations tao database schema toan bo he thong', 'Hoan thanh - migrate:fresh thanh cong'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 3', 'Tao 9 Eloquent Models + relationships (belongsTo, hasMany, hasOne)', 'Hoan thanh - Tat ca relationship chinh xac'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 4', 'Viet AZMediaRecruitmentSeeder (staff, positions, questions, templates, candidates)', 'Hoan thanh - Seed 7 ung vien mau'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 5', 'Xay dung CandidatePortalController: trackPage, trackSubmit, takeTest, submitTest', 'Hoan thanh - Online test 20 phut OK'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 6', 'Xay dung RESTful API v1 (AZMediaApiController) 6 endpoints tra ve JSON', 'Hoan thanh - Tat ca endpoint HTTP 200'], [1400, 5300, 2660]);
$b .= tblEnd2();

// Linh An
$b .= h2('4.3. Linh An (Frontend / QA)');
$b .= tblStart([1400, 5300, 2660]);
$b .= tblRow2(['Ngay', 'Noi dung cong viec', 'Ket qua / Ghi chu'], [1400, 5300, 2660], true);
$b .= tblRow2(['Thu 2', 'Thiet ke layout tong the (app.blade.php) voi Tailwind CSS, responsive mobile', 'Hoan thanh - Mobile OK'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 3', 'Xay dung Careers Landing Page: hero section, filter, positions grid, apply modal', 'Hoan thanh - UI dep, co animation'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 4', 'Xay dung Portal Dashboard: KPI cards, funnel pipeline chart, university stats', 'Hoan thanh - Chart hien thi chinh xac'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 5', 'Xay dung Kanban Board 6 cot + candidate detail co inline PDF viewer', 'Hoan thanh - PDF xem truc tiep OK'], [1400, 5300, 2660]);
$b .= tblRow2(['Thu 6', 'Kiem thu toan bo luong (apply->test->interview->offer), viet bao cao', 'Hoan thanh - 0 loi critical'], [1400, 5300, 2660]);
$b .= tblEnd2();

// V. Van de gap phai
$b .= h1('V. VAN DE GAP PHAI & GIAI PHAP');
$b .= sep2();
$b .= tblStart([450, 3200, 3250, 1860]);
$b .= tblRow2(['#', 'Van de gap phai', 'Giai phap da xu ly', 'Nguoi xu ly'], [450, 3200, 3250, 1860], true);
$b .= tblRow2(['1', 'ParseError tieng Viet trong PHP single-quoted string (seeder dong 448)', "Thay ky tu nhay don bang \" trong chuoi PHP", 'Phan Duy'], [450, 3200, 3250, 1860]);
$b .= tblRow2(['2', 'Cai PHPWord that bai do thieu ext-gd va conflict phpspec/prophecy PHP 8.2', 'Dung PHP thuan tao file DOCX tu XML (Open XML format), khong can thu vien ngoai', 'Phan Duy'], [450, 3200, 3250, 1860]);
$b .= tblRow2(['3', 'Gmail SMTP tu choi ket noi lan dau', 'Bat ung dung kem an toan + dung App Password 16 ky tu', 'Dang Khai'], [450, 3200, 3250, 1860]);
$b .= tblRow2(['4', 'Session portal_user bi mat sau restart server', 'Chuyen SESSION_DRIVER=database luu session vao MySQL', 'Linh An'], [450, 3200, 3250, 1860]);
$b .= tblRow2(['5', 'Upload CV PDF bi loi 413 (file > 2MB)', 'Tang upload_max_filesize va post_max_size trong php.ini XAMPP len 10M', 'Linh An'], [450, 3200, 3250, 1860]);
$b .= tblEnd2();

// VI. Danh gia
$b .= h1('VI. DANH GIA TIEN DO & KE HOACH TUAN SAU');
$b .= sep2();
$b .= h2('6.1. Tien do tong the');
$b .= p2('Du an da hoan thanh uoc tinh 85% tong khoi luong cong viec theo ke hoach ban dau. Cac module core (Database, Careers Portal, Candidate Portal, Mini-ATS, Email Automation) da van hanh on dinh va day du tinh nang. Con lai 15% bao gom: tinh nang nang cao, unit test, trien khai production va tai lieu hoan thien.', false, 21, '374151', 'left', 120);

$b .= h2('6.2. Ke hoach tuan ' . ($weekNum + 1));
$next = [
    'Thu 2-3: Hoan thien tinh nang export Excel bao cao tuyen dung (Maatwebsite/Laravel-Excel)',
    'Thu 4: Viet Unit Test cho AZMediaATSController va AZMediaCareersController',
    'Thu 5: Nang cap ngan hang cau hoi MCQ, bo sung 30 cau moi cho cac vi tri Frontend, Marketing, AI',
    'Thu 6: Demo noi bo, review tong the, chuan bi tai lieu bao cao cuoi ky',
    'Cuoi tuan: Quay video demo san pham 5 phut cho buoi bao ve do an',
];
foreach ($next as $item) $b .= bullet2($item);

// VII. Chu ky
$b .= h1('VII. XAC NHAN & CHU KY');
$b .= sep2();
$signDate = date('d/m/Y');
$b .= '<w:tbl><w:tblPr><w:tblW w:w="9360" w:type="dxa"/>'
    . '<w:tblBorders><w:insideH w:val="none"/><w:insideV w:val="none"/>'
    . '<w:top w:val="none"/><w:bottom w:val="none"/><w:left w:val="none"/><w:right w:val="none"/>'
    . '</w:tblBorders></w:tblPr>';
$b .= '<w:tr>';
foreach ([
    ['Nhom truong', 'Phan Duy', $signDate],
    ['Giang vien huong dan', '', $signDate],
    ['Ky ten', '(Thanh vien)', $signDate],
] as $col) {
    $b .= '<w:tc><w:tcPr><w:tcW w:w="3120" w:type="dxa"/></w:tcPr>'
        . p2($col[0], true, 21, '1e293b', 'center', 60)
        . p2($col[1], false, 20, '64748b', 'center', 60)
        . p2("Da Nang, ngay {$col[2]}", false, 19, '94a3b8', 'center', 60)
        . p2('Ky ten: ...............................', false, 19, '94a3b8', 'center', 60)
        . '</w:tc>';
}
$b .= '</w:tr></w:tbl>';

/* ---- Build document.xml ---- */
$docXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"
  xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>
' . $b . '
    <w:sectPr>
      <w:pgSz w:w="12240" w:h="15840"/>
      <w:pgMar w:top="1080" w:right="1080" w:bottom="1080" w:left="1260" w:header="720" w:footer="720" w:gutter="0"/>
    </w:sectPr>
  </w:body>
</w:document>';

/* ---- Write DOCX ---- */
$filename = "BaoCaoCongViec_Tuan{$weekNum}_{$year}_AZHR.docx";
$outDir   = __DIR__ . '/public/downloads';
if (!is_dir($outDir)) mkdir($outDir, 0777, true);
$outPath  = "$outDir/$filename";

$tmp = sys_get_temp_dir() . '/azhr_docx_' . uniqid();
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
    <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
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
  <dc:title>Bao Cao Cong Viec Tuan {$weekNum} - AZHR</dc:title>
  <dc:creator>Phan Duy (Leader) - Nhom AZHR</dc:creator>
  <dc:subject>He Thong Web Tuyen Dung Thuc Tap Sinh AZ Media</dc:subject>
  <dcterms:created xsi:type=\"dcterms:W3CDTF\">{$now}</dcterms:created>
  <dcterms:modified xsi:type=\"dcterms:W3CDTF\">{$now}</dcterms:modified>
</cp:coreProperties>");

file_put_contents("$tmp/word/document.xml", $docXml);

$zip = new ZipArchive();
$zip->open($outPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zip->addFile("$tmp/[Content_Types].xml",       '[Content_Types].xml');
$zip->addFile("$tmp/_rels/.rels",               '_rels/.rels');
$zip->addFile("$tmp/word/_rels/document.xml.rels", 'word/_rels/document.xml.rels');
$zip->addFile("$tmp/word/document.xml",         'word/document.xml');
$zip->addFile("$tmp/word/styles.xml",           'word/styles.xml');
$zip->addFile("$tmp/docProps/core.xml",         'docProps/core.xml');
$zip->close();

// Cleanup tmp
foreach ([$tmp.'/word/_rels', $tmp.'/word', $tmp.'/_rels', $tmp.'/docProps', $tmp] as $d) {
    foreach (glob("$d/*") as $f) if (is_file($f)) unlink($f);
    @rmdir($d);
}

echo "OK\n";
echo "FILE: $outPath\n";
echo "URL: http://127.0.0.1:8000/downloads/$filename\n";
