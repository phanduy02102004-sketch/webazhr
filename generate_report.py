# -*- coding: utf-8 -*-
import os
import docx
from docx import Document
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT, WD_ALIGN_VERTICAL
from docx.oxml import OxmlElement, parse_xml
from docx.oxml.ns import nsdecls, qn

def set_cell_background(cell, fill_hex):
    """Sets the background color of a cell."""
    tcPr = cell._tc.get_or_add_tcPr()
    shd = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{fill_hex}"/>')
    tcPr.append(shd)

def set_cell_margins(cell, top=120, bottom=120, left=150, right=150):
    """Set cell padding in dxa (1 pt = 20 dxa)."""
    tcPr = cell._tc.get_or_add_tcPr()
    tcMar = OxmlElement('w:tcMar')
    for m, val in [('w:top', top), ('w:bottom', bottom), ('w:left', left), ('w:right', right)]:
        node = OxmlElement(m)
        node.set(qn('w:w'), str(val))
        node.set(qn('w:type'), 'dxa')
        tcMar.append(node)
    tcPr.append(tcMar)

def set_table_borders(table, color="CBD5E1", sz="4", val="single"):
    """Set subtle modern borders on a table."""
    tblPr = table._tbl.tblPr
    borders = parse_xml(
        f'<w:tblBorders {nsdecls("w")}>'
        f'  <w:top w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>'
        f'  <w:bottom w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>'
        f'  <w:left w:val="none"/>'
        f'  <w:right w:val="none"/>'
        f'  <w:insideH w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>'
        f'  <w:insideV w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>'
        f'</w:tblBorders>'
    )
    tblPr.append(borders)

def build_report():
    doc = Document()

    # Page Margins (0.7 inch ~ 1.78 cm for professional clean look)
    for section in doc.sections:
        section.top_margin = Inches(0.7)
        section.bottom_margin = Inches(0.7)
        section.left_margin = Inches(0.75)
        section.right_margin = Inches(0.75)

    # Style defaults
    normal_style = doc.styles['Normal']
    normal_style.font.name = 'Arial'
    normal_style.font.size = Pt(10)
    normal_style.font.color.rgb = RGBColor(0x1E, 0x29, 0x3B) # slate-800

    # Colors
    NAVY = RGBColor(0x1B, 0x36, 0x5D)
    MUTED = RGBColor(0x64, 0x74, 0x8B)
    GREEN = RGBColor(0x15, 0x80, 0x3D)
    ORANGE = RGBColor(0xC2, 0x41, 0x0C)
    DARK = RGBColor(0x0F, 0x17, 0x2A)

    # ==================== TITLE ====================
    p_title = doc.add_paragraph()
    p_title.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_title.paragraph_format.space_before = Pt(0)
    p_title.paragraph_format.space_after = Pt(2)
    run_title = p_title.add_run("BÁO CÁO CÔNG VIỆC TUẦN")
    run_title.font.name = 'Arial'
    run_title.font.size = Pt(17)
    run_title.font.bold = True
    run_title.font.color.rgb = NAVY

    p_week = doc.add_paragraph()
    p_week.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_week.paragraph_format.space_after = Pt(14)
    run_week = p_week.add_run("Tuần: 4 (Từ ngày 26/10/2026 đến ngày 01/11/2026)")
    run_week.font.name = 'Arial'
    run_week.font.size = Pt(10.5)
    run_week.font.italic = True
    run_week.font.color.rgb = MUTED

    # ==================== I. THÔNG TIN CHUNG ====================
    p_sec1 = doc.add_paragraph()
    p_sec1.paragraph_format.space_after = Pt(6)
    r_sec1 = p_sec1.add_run("I. THÔNG TIN CHUNG")
    r_sec1.font.name = 'Arial'
    r_sec1.font.size = Pt(11.5)
    r_sec1.font.bold = True
    r_sec1.font.color.rgb = NAVY

    # Table Info (2 columns, borderless)
    t_info = doc.add_table(rows=2, cols=2)
    t_info.alignment = WD_TABLE_ALIGNMENT.CENTER
    t_info.autofit = False

    col_widths = [Inches(3.4), Inches(3.6)]
    for row in t_info.rows:
        for idx, width in enumerate(col_widths):
            row.cells[idx].width = width

    # Row 0
    p00 = t_info.cell(0, 0).paragraphs[0]
    p00.paragraph_format.space_after = Pt(4)
    r = p00.add_run("Họ và tên: ")
    r.font.bold = True
    r2 = p00.add_run("Phan Duy (Leader) - Nhóm: Đăng Khải, Linh Ân")

    p01 = t_info.cell(0, 1).paragraphs[0]
    p01.paragraph_format.space_after = Pt(4)
    r = p01.add_run("Bộ phận / Phòng ban: ")
    r.font.bold = True
    r2 = p01.add_run("Công nghệ thông tin / IT")

    # Row 1
    p10 = t_info.cell(1, 0).paragraphs[0]
    p10.paragraph_format.space_after = Pt(8)
    r = p10.add_run("Chức danh: ")
    r.font.bold = True
    r2 = p10.add_run("Lập trình viên Web / Leader")

    p11 = t_info.cell(1, 1).paragraphs[0]
    p11.paragraph_format.space_after = Pt(8)
    r = p11.add_run("Dự án thực hiện: ")
    r.font.bold = True
    r2 = p11.add_run("Hệ Thống Web Tuyển Dụng Thực Tập Sinh AZHR (AZ Media)")

    # ==================== II. TÓM TẮT KẾT QUẢ ====================
    p_sec2 = doc.add_paragraph()
    p_sec2.paragraph_format.space_before = Pt(8)
    p_sec2.paragraph_format.space_after = Pt(4)
    r_sec2 = p_sec2.add_run("II. TÓM TẮT KẾT QUẢ CÔNG VIỆC TRONG TUẦN")
    r_sec2.font.name = 'Arial'
    r_sec2.font.size = Pt(11.5)
    r_sec2.font.bold = True
    r_sec2.font.color.rgb = NAVY

    p_eval = doc.add_paragraph()
    p_eval.paragraph_format.space_after = Pt(8)
    r_eval_lbl = p_eval.add_run("Đánh giá tổng quan tiến độ tuần: ")
    r_eval_lbl.font.bold = True
    r_eval_lbl.font.italic = True
    r_eval_val = p_eval.add_run(
        "Hoàn thành 100% mục tiêu điều chỉnh và tính năng nâng cấp thực tế. "
        "Các yêu cầu trọng tâm của hệ thống Web Tuyển Dụng AZHR (Tự động hóa duyệt đơn & gửi mail bài test, "
        "tích hợp nhóm Zalo hỗ trợ, chuẩn hóa nhận diện Logo AZ Homes/AZ Media, hiệu ứng nút Ứng tuyển nhấp nháy, "
        "bỏ giới hạn thời gian làm bài test, tăng cường bảo mật đăng nhập Admin và đồng bộ toàn bộ Mentor thành Lê Đình Quang) "
        "đã được nhóm triển khai hoàn tất, nghiệm thu và hoạt động ổn định trên môi trường thực tế."
    )
    r_eval_val.font.italic = True

    # Main Work Table
    # Columns: STT (0.4 in), Tên công việc / Hạng mục (1.4 in), Chi tiết điều chỉnh & Nâng cấp đã thực hiện (2.8 in), Tỷ lệ (0.7 in), Trạng thái (0.8 in), Ghi chú / Khó khăn (0.9 in)
    widths = [Inches(0.4), Inches(1.35), Inches(2.75), Inches(0.7), Inches(0.85), Inches(0.95)]
    headers = [
        "STT",
        "Tên công việc / Hạng mục",
        "Nội dung điều chỉnh & Thêm mới (AZHR)",
        "Tỷ lệ hoàn thành",
        "Trạng thái",
        "Ghi chú / Phụ trách"
    ]

    work_items = [
        (
            "1",
            "Tự động duyệt hồ sơ & Gửi Email làm bài test tự động (Auto-Approval)",
            "• Nâng cấp luồng ứng tuyển: Khi ứng viên nộp hồ sơ, hệ thống tự động duyệt qua Bước 1 (Tiếp nhận) và Bước 2 (Sàng lọc), chuyển thẳng sang Bước 3 (Gửi bài test).\n"
            "• Tự động sinh mã ứng viên AZ-2026-XXXX và kích hoạt gửi Gmail SMTP thư mời làm test kèm link trực tuyến mà không cần Admin/HR thao tác duyệt thủ công.",
            "100%",
            "Hoàn thành",
            "Phan Duy phụ trách\n- Đã test tự động duyệt & gửi mail SMTP thành công"
        ),
        (
            "2",
            "Tích hợp liên kết Nhóm Zalo hỗ trợ ứng viên qua Email & Web",
            "• Bổ sung liên kết và nút tham gia nhóm Zalo nội bộ (https://zalo.me/g/fcypks402) vào: Email thư mời làm bài test tự động, màn hình làm bài test trực tuyến, màn hình nộp bài thành công và trang tra cứu hồ sơ.\n"
            "• Giúp ứng viên nhanh chóng kết nối, tham khảo tài liệu làm bài test và nhận thông báo kết quả tức thời.",
            "100%",
            "Hoàn thành",
            "Phan Duy & Linh Ân\n- Đã cập nhật template mail và 3 view giao diện"
        ),
        (
            "3",
            "Tối ưu Module Đề thi Trắc nghiệm (Bỏ đếm ngược thời gian)",
            "• Gỡ bỏ đồng hồ đếm ngược và giới hạn thời gian làm bài test (trước đây 20 phút).\n"
            "• Ứng viên thoải mái hoàn thành các câu hỏi chuyên môn mà không bị áp lực thời gian, hệ thống tự động chấm điểm ngay khi nhấn Nộp bài.",
            "100%",
            "Hoàn thành",
            "Đăng Khải phụ trách\n- Ứng viên làm bài linh hoạt, lưu điểm chính xác"
        ),
        (
            "4",
            "Đồng bộ hóa thông tin Mentor phụ trách toàn hệ thống",
            "• Cập nhật đồng bộ toàn bộ thông tin Mentor cho 6 vị trí tuyển dụng thực tập sinh (Backend, Frontend, Tester, UI/UX, Marketing, AI) thành 'Lê Đình Quang'.\n"
            "• Cập nhật mục quyền lợi kèm cặp 1-1 ('Thầy giỏi'), trang chi tiết việc làm, người phỏng vấn và seeder hệ thống.",
            "100%",
            "Hoàn thành",
            "Linh Ân phụ trách\n- Đã cập nhật CSDL và đồng bộ toàn bộ giao diện"
        ),
        (
            "5",
            "Cập nhật nhận diện thương hiệu Logo mới & Hiệu ứng nút Ứng tuyển",
            "• Thay thế hình ảnh logo AZ Media cũ bằng logo AZ Homes mới chuẩn nhận diện trên toàn bộ Header, Footer và các trang con.\n"
            "• Thêm hiệu ứng nhấp nháy phát sáng (Pulse Glow Animation) cho nút 'Ứng tuyển ngay' trên trang chủ nhằm kích thích tương tác nộp đơn.",
            "100%",
            "Hoàn thành",
            "Linh Ân phụ trách\n- Đã duyệt hiển thị trên Desktop và Mobile"
        ),
        (
            "6",
            "Bảo mật truy cập Quản trị & Hoàn thiện CRUD Vị trí tuyển dụng",
            "• Gỡ bỏ liên kết/nút đăng nhập admin trên thanh menu công khai của người dùng, chuyển sang cơ chế bảo mật chỉ cho phép đăng nhập qua link riêng (/admin/login).\n"
            "• Hoàn thiện đầy đủ tính năng Thêm, Sửa, Xoá (CRUD) vị trí thực tập sinh trong trang quản trị Admin.",
            "100%",
            "Hoàn thành",
            "Phan Duy & Đăng Khải\n- Phân quyền chặt chẽ, dữ liệu an toàn"
        )
    ]

    t_work = doc.add_table(rows=len(work_items)+1, cols=6)
    t_work.alignment = WD_TABLE_ALIGNMENT.CENTER
    t_work.autofit = False
    set_table_borders(t_work)

    # Style Header Row
    hdr_cells = t_work.rows[0].cells
    for i, title in enumerate(headers):
        hdr_cells[i].width = widths[i]
        set_cell_background(hdr_cells[i], "1B365D")
        set_cell_margins(hdr_cells[i], top=140, bottom=140, left=120, right=120)
        p = hdr_cells[i].paragraphs[0]
        p.alignment = WD_ALIGN_PARAGRAPH.CENTER
        p.paragraph_format.space_before = Pt(0)
        p.paragraph_format.space_after = Pt(0)
        run = p.add_run(title)
        run.font.name = 'Arial'
        run.font.size = Pt(9.5)
        run.font.bold = True
        run.font.color.rgb = RGBColor(0xFF, 0xFF, 0xFF)

    # Populate Data Rows
    for row_idx, item in enumerate(work_items, start=1):
        row_cells = t_work.rows[row_idx].cells
        # Background alternating
        bg_color = "FFFFFF" if row_idx % 2 != 0 else "F8FAFC"

        for col_idx in range(6):
            row_cells[col_idx].width = widths[col_idx]
            set_cell_background(row_cells[col_idx], bg_color)
            set_cell_margins(row_cells[col_idx], top=100, bottom=100, left=100, right=100)
            p = row_cells[col_idx].paragraphs[0]
            p.paragraph_format.space_before = Pt(0)
            p.paragraph_format.space_after = Pt(0)

            val = item[col_idx]
            run = p.add_run(val)
            run.font.name = 'Arial'
            run.font.size = Pt(8.5)

            # Column specific alignments & styling
            if col_idx == 0: # STT
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER
                run.font.bold = True
            elif col_idx == 1: # Tên công việc
                p.alignment = WD_ALIGN_PARAGRAPH.LEFT
                run.font.bold = True
                run.font.color.rgb = DARK
            elif col_idx == 2: # Nội dung chi tiết
                p.alignment = WD_ALIGN_PARAGRAPH.LEFT
                run.font.size = Pt(8.2)
            elif col_idx == 3: # Tỷ lệ
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER
                run.font.bold = True
            elif col_idx == 4: # Trạng thái
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER
                run.font.bold = True
                run.font.color.rgb = GREEN
            elif col_idx == 5: # Ghi chú
                p.alignment = WD_ALIGN_PARAGRAPH.LEFT
                run.font.size = Pt(8.0)
                run.font.color.rgb = MUTED

    # ==================== III. KẾ HOẠCH TUẦN TỚI ====================
    p_sec3 = doc.add_paragraph()
    p_sec3.paragraph_format.space_before = Pt(14)
    p_sec3.paragraph_format.space_after = Pt(4)
    r_sec3 = p_sec3.add_run("III. KẾ HOẠCH CÔNG VIỆC TUẦN TỚI")
    r_sec3.font.name = 'Arial'
    r_sec3.font.size = Pt(11.5)
    r_sec3.font.bold = True
    r_sec3.font.color.rgb = NAVY

    next_headers = ["STT", "Nhiệm vụ trọng tâm", "Kết quả dự kiến (Output)", "Thời hạn (Deadline)", "Đề xuất / Hỗ trợ cần thiết"]
    next_widths = [Inches(0.4), Inches(2.1), Inches(2.4), Inches(1.0), Inches(1.1)]

    next_items = [
        (
            "1",
            "Giám sát vận hành tự động & Kiểm thử tải gửi Email đồng thời",
            "Hệ thống vận hành trơn tru từ khi ứng viên nộp hồ sơ, tự động duyệt và gửi mail làm bài test tức thời.",
            "Thứ 4 (04/11)",
            "Hỗ trợ từ Dev Lead (Phan Duy)"
        ),
        (
            "2",
            "Bổ sung & cập nhật ngân hàng câu hỏi Test chuyên môn",
            "Bổ sung thêm 30+ câu hỏi trắc nghiệm mới chia theo từng vị trí (Backend, Frontend, Tester, Marketing, AI).",
            "Thứ 5 (05/11)",
            "Mentor Lê Đình Quang cố vấn chuyên môn"
        ),
        (
            "3",
            "Triển khai lên môi trường Demo & Chuẩn bị Báo cáo Đồ án",
            "Hệ thống sẵn sàng UAT, tài liệu báo cáo thực tập tốt nghiệp hoàn thiện, slide thuyết trình và video demo 5 phút.",
            "Thứ 6 (06/11)",
            "Chuẩn bị phòng họp & máy chiếu"
        )
    ]

    t_next = doc.add_table(rows=len(next_items)+1, cols=5)
    t_next.alignment = WD_TABLE_ALIGNMENT.CENTER
    t_next.autofit = False
    set_table_borders(t_next)

    # Next table header
    hdr_cells3 = t_next.rows[0].cells
    for i, title in enumerate(next_headers):
        hdr_cells3[i].width = next_widths[i]
        set_cell_background(hdr_cells3[i], "1B365D")
        set_cell_margins(hdr_cells3[i], top=120, bottom=120, left=120, right=120)
        p = hdr_cells3[i].paragraphs[0]
        p.alignment = WD_ALIGN_PARAGRAPH.CENTER
        p.paragraph_format.space_before = Pt(0)
        p.paragraph_format.space_after = Pt(0)
        run = p.add_run(title)
        run.font.name = 'Arial'
        run.font.size = Pt(9.5)
        run.font.bold = True
        run.font.color.rgb = RGBColor(0xFF, 0xFF, 0xFF)

    for row_idx, item in enumerate(next_items, start=1):
        row_cells = t_next.rows[row_idx].cells
        bg_color = "FFFFFF" if row_idx % 2 != 0 else "F8FAFC"
        for col_idx in range(5):
            row_cells[col_idx].width = next_widths[col_idx]
            set_cell_background(row_cells[col_idx], bg_color)
            set_cell_margins(row_cells[col_idx], top=90, bottom=90, left=100, right=100)
            p = row_cells[col_idx].paragraphs[0]
            p.paragraph_format.space_before = Pt(0)
            p.paragraph_format.space_after = Pt(0)

            val = item[col_idx]
            run = p.add_run(val)
            run.font.name = 'Arial'
            run.font.size = Pt(8.5)

            if col_idx == 0:
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER
                run.font.bold = True
            elif col_idx == 1:
                p.alignment = WD_ALIGN_PARAGRAPH.LEFT
                run.font.bold = True
            elif col_idx == 3:
                p.alignment = WD_ALIGN_PARAGRAPH.CENTER
                run.font.bold = True
                run.font.color.rgb = ORANGE
            else:
                p.alignment = WD_ALIGN_PARAGRAPH.LEFT

    # ==================== IV. ĐỀ XUẤT & KIẾN NGHỊ ====================
    p_sec4 = doc.add_paragraph()
    p_sec4.paragraph_format.space_before = Pt(14)
    p_sec4.paragraph_format.space_after = Pt(4)
    r_sec4 = p_sec4.add_run("IV. ĐỀ XUẤT & KIẾN NGHỊ")
    r_sec4.font.name = 'Arial'
    r_sec4.font.size = Pt(11.5)
    r_sec4.font.bold = True
    r_sec4.font.color.rgb = NAVY

    proposals = [
        "Hệ thống tự động duyệt hồ sơ và gửi link làm bài test qua Gmail SMTP đã hoạt động hoàn toàn chính xác và ổn định, đề xuất áp dụng chính thức cho tất cả các đợt tiếp nhận thực tập sinh tiếp theo của AZ Media.",
        "Đề xuất Mentor Lê Đình Quang phê duyệt bổ sung bộ câu hỏi trắc nghiệm chuyên sâu để nâng cao chất lượng sàng lọc ứng viên ở các khối ngành Kỹ thuật và Truyền thông số.",
        "Đề xuất tiếp tục duy trì nhóm Zalo cộng đồng thực tập sinh như một kênh tương tác chính thống để hỗ trợ kỹ thuật và thông báo kết quả nhanh cho sinh viên."
    ]
    for prop in proposals:
        p_prop = doc.add_paragraph()
        p_prop.paragraph_format.space_before = Pt(0)
        p_prop.paragraph_format.space_after = Pt(3)
        p_prop.paragraph_format.left_indent = Inches(0.2)
        r_bullet = p_prop.add_run("•  ")
        r_bullet.font.bold = True
        r_bullet.font.color.rgb = NAVY
        r_text = p_prop.add_run(prop)
        r_text.font.size = Pt(9.2)

    # ==================== V. XÁC NHẬN ====================
    p_sec5 = doc.add_paragraph()
    p_sec5.paragraph_format.space_before = Pt(14)
    p_sec5.paragraph_format.space_after = Pt(6)
    r_sec5 = p_sec5.add_run("V. XÁC NHẬN")
    r_sec5.font.name = 'Arial'
    r_sec5.font.size = Pt(11.5)
    r_sec5.font.bold = True
    r_sec5.font.color.rgb = NAVY

    t_sign = doc.add_table(rows=3, cols=2)
    t_sign.alignment = WD_TABLE_ALIGNMENT.CENTER
    t_sign.autofit = False
    for row in t_sign.rows:
        row.cells[0].width = Inches(3.5)
        row.cells[1].width = Inches(3.5)

    # Row 0: Titles
    p_s0 = t_sign.cell(0, 0).paragraphs[0]
    p_s0.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r = p_s0.add_run("Người làm báo cáo\n")
    r.font.bold = True
    r.font.size = Pt(10)
    r_sub = p_s0.add_run("(Ký và ghi rõ họ tên)")
    r_sub.font.italic = True
    r_sub.font.size = Pt(8.5)
    r_sub.font.color.rgb = MUTED

    p_s1 = t_sign.cell(0, 1).paragraphs[0]
    p_s1.alignment = WD_ALIGN_PARAGRAPH.CENTER
    r = p_s1.add_run("Quản lý duyệt / Mentor\n")
    r.font.bold = True
    r.font.size = Pt(10)
    r_sub = p_s1.add_run("(Ký và ghi rõ họ tên)")
    r_sub.font.italic = True
    r_sub.font.size = Pt(8.5)
    r_sub.font.color.rgb = MUTED

    # Row 1: Space for signatures
    p_sp0 = t_sign.cell(1, 0).paragraphs[0]
    p_sp0.paragraph_format.space_before = Pt(38)
    p_sp1 = t_sign.cell(1, 1).paragraphs[0]
    p_sp1.paragraph_format.space_before = Pt(38)

    # Row 2: Names
    p_n0 = t_sign.cell(2, 0).paragraphs[0]
    p_n0.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_n0.paragraph_format.space_after = Pt(0)
    r = p_n0.add_run("Phan Duy (Leader)\n")
    r.font.bold = True
    r.font.size = Pt(10.5)
    r.font.color.rgb = NAVY
    r2 = p_n0.add_run("Nhóm: Đăng Khải - Linh Ân")
    r2.font.size = Pt(9)
    r2.font.color.rgb = MUTED

    p_n1 = t_sign.cell(2, 1).paragraphs[0]
    p_n1.alignment = WD_ALIGN_PARAGRAPH.CENTER
    p_n1.paragraph_format.space_after = Pt(0)
    r = p_n1.add_run("Lê Đình Quang\n")
    r.font.bold = True
    r.font.size = Pt(10.5)
    r.font.color.rgb = NAVY
    r2 = p_n1.add_run("Tổng Giám Đốc / Mentor phụ trách")
    r2.font.size = Pt(9)
    r2.font.color.rgb = MUTED

    # Output paths
    pub_dir = r"c:\xampp\htdocs\laptrinhwebnangcao\laptrinhwebnangcao\public\downloads"
    os.makedirs(pub_dir, exist_ok=True)
    out_public = os.path.join(pub_dir, "Bao_Cao_Tuan_AZHR_Tuan4.docx")
    out_root = r"c:\xampp\htdocs\laptrinhwebnangcao\laptrinhwebnangcao\Bao_Cao_Tuan_AZHR_Tuan4.docx"

    doc.save(out_public)
    doc.save(out_root)
    print(f"SUCCESS: Saved to {out_public} and {out_root}")

if __name__ == "__main__":
    build_report()
