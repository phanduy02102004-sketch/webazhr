# -*- coding: utf-8 -*-
import os
import docx
from docx import Document
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
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
    run_week = p_week.add_run("Tuần: 5 (Từ ngày 02/11/2026 đến ngày 08/11/2026)")
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
        "Hoàn thành 100% mục tiêu điều chỉnh và tối ưu hóa hệ thống Web Tuyển dụng AZHR trong tuần 5. "
        "Các hạng mục nâng cấp trọng tâm bao gồm: Chuẩn hóa chỉ số cam kết dấu mộc (95%), "
        "cải tiến bộ câu hỏi trắc nghiệm Phần 1 (Tính cách) bỏ chọn sẵn đáp án để thực tập sinh tự đánh giá khách quan, "
        "chuyển đổi toàn diện Phần 4 từ kiểm tra Chuyên môn kỹ thuật sang Đánh giá mức độ hiểu biết Văn hóa AZ Media, "
        "tích hợp khảo sát kênh tiếp cận cùng phần tự luận cảm nhận ứng viên, và đồng bộ hóa kết quả lên Cổng Quản trị ATS "
        "phục vụ Hội đồng Tuyển dụng và Mentor Lê Đình Quang đánh giá toàn diện."
    )
    r_eval_val.font.italic = True

    # Main Work Table
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
            "Chuẩn hóa chỉ số cam kết: Điều chỉnh 95% Cấp dấu mộc thực tập",
            "• Điều chỉnh số liệu thống kê tại Hero Section của trang chủ (careers/index.blade.php) từ 100% thành '95% Cấp dấu mộc thực tập'.\n"
            "• Đảm bảo tính minh bạch, khách quan và trung thực, sát với thực tế đánh giá kết quả thực tập theo tiêu chuẩn quy định của trường đại học.",
            "100%",
            "Hoàn thành",
            "Phan Duy phụ trách\n- Đã cập nhật giao diện và clear view cache"
        ),
        (
            "2",
            "Bổ sung & Tối ưu Phần 1: Trắc nghiệm Tính cách (NLB - DISC - MBTI)",
            "• Trích xuất nội dung từ Báo cáo thu hoạch của Phan Duy để bổ sung đầy đủ hệ thống câu hỏi khám phá tính cách, phong cách tư duy và giao tiếp.\n"
            "• Xóa bỏ toàn bộ các câu trả lời đã tích chọn sẵn trong file mẫu, thiết lập trạng thái mở hoàn toàn để thực tập sinh tự do đánh giá đúng năng lực thực tế của bản thân.",
            "100%",
            "Hoàn thành",
            "Linh Ân & Đăng Khải\n- Đã cập nhật take_test.blade.php"
        ),
        (
            "3",
            "Chuyển đổi Phần 4: Từ 'Chuyên môn' thành '4. AZ Media'",
            "• Loại bỏ hoàn toàn các câu hỏi kỹ thuật / coding (Middleware, HTTP method, Eloquent ORM, SQL Injection...) nhằm áp dụng chung cho mọi khối ngành ứng tuyển.\n"
            "• Thay thế bằng bộ câu hỏi văn hóa AZ Media: Slogan doanh nghiệp, triết lý chữ A (Action), văn hóa 'Thầy giỏi - Bạn tốt - Sách hay', địa chỉ văn phòng 84 Nguyễn Hữu Dật, Mentor Lê Đình Quang.",
            "100%",
            "Hoàn thành",
            "Phan Duy phụ trách\n- Đã seed CSDL test_questions với category 'azmedia'"
        ),
        (
            "4",
            "Tích hợp Khảo sát Kênh tìm hiểu & Tự luận Cảm nhận về AZ Media",
            "• Xây dựng câu hỏi trắc nghiệm đa lựa chọn: 'Bạn đã biết đến và tìm hiểu thông tin về AZ Media qua những kênh nào?' (Fanpage, TikTok, Thầy cô, Bạn bè, Job Fair, Google...) kèm ô tự nhập kênh khác.\n"
            "• Bổ sung phần tự luận: 'Điều gì ở AZ Media khiến bạn ấn tượng nhất và mong muốn được thực tập tại đây?' giúp hiểu rõ động lực của ứng viên.",
            "100%",
            "Hoàn thành",
            "Đăng Khải phụ trách\n- Đã xử lý lưu trữ az_channels & az_impression"
        ),
        (
            "5",
            "Đồng bộ hóa Hệ thống Chấm điểm & Giao diện Kết quả bài test",
            "• Cập nhật logic chấm điểm trong CandidatePortalController: Chuyển đổi từ 'Điểm chuyên môn' sang 'Điểm Văn Hóa AZ' (thang điểm 100, 20 điểm/câu).\n"
            "• Nâng cấp giao diện trang hoàn thành (test_completed.blade.php): Hiển thị điểm số văn hóa và card tóm tắt kênh tiếp cận, ấn tượng về AZ Media của ứng viên.",
            "100%",
            "Hoàn thành",
            "Phan Duy phụ trách\n- Đã cập nhật controller và giao diện kết quả"
        ),
        (
            "6",
            "Tích hợp Dữ liệu Văn hóa AZ Media vào Cổng Quản trị ATS",
            "• Nâng cấp giao diện Modal xem chi tiết ứng viên (candidate_detail.blade.php) trong hệ thống Quản trị tuyển dụng dành cho HR và Mentor.\n"
            "• Hiển thị chi tiết từng câu trắc nghiệm văn hóa (Đúng/Sai, đáp án chọn), danh sách kênh tiếp cận và nội dung tự luận cảm nhận để Hội đồng phỏng vấn tra cứu nhanh.",
            "100%",
            "Hoàn thành",
            "Linh Ân phụ trách\n- Giao diện Admin/ATS hiển thị trực quan, đầy đủ"
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
            "Thử nghiệm luồng nộp hồ sơ & làm bài test thực tế với nhóm sinh viên mẫu",
            "Mời 5-10 ứng viên sinh viên trải nghiệm toàn bộ quy trình từ ứng tuyển, nhận link test qua mail, làm bài test và phản hồi kết quả.",
            "Thứ 5 (12/11)",
            "Đội ngũ tuyển dụng hỗ trợ mời ứng viên test"
        ),
        (
            "2",
            "Tối ưu hóa bảng Dashboard phân tích ứng viên theo văn hóa & tính cách",
            "Bổ sung biểu đồ thống kê các kênh tiếp cận phổ biến nhất và tỷ lệ ứng viên nắm vững văn hóa doanh nghiệp trên trang Dashboard ATS.",
            "Thứ 6 (13/11)",
            "Mentor Lê Đình Quang góp ý các tiêu chí phân tích"
        ),
        (
            "3",
            "Hoàn thiện Báo cáo tổng kết đồ án & Chuẩn bị buổi nghiệm thu chính thức",
            "Hoàn chỉnh slide thuyết trình đồ án, tài liệu đặc tả chức năng và clip demo hoàn chỉnh gửi Hội đồng & Ban Giám đốc.",
            "Thứ 7 (14/11)",
            "Phòng họp IT & máy chiếu"
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
        "Việc thay đổi đề test Phần 4 thành 'AZ Media' mang lại hiệu quả cao trong việc đo lường độ gắn kết và mức độ quan tâm của ứng viên đối với doanh nghiệp, đề xuất áp dụng chuẩn hóa này cho tất cả các đợt tuyển thực tập sinh tiếp theo.",
        "Đề xuất Mentor Lê Đình Quang và Ban Tuyển dụng khai thác tối đa câu trả lời tự luận 'Cảm nhận về AZ Media' làm câu hỏi phỏng vấn khai mở trong buổi gặp mặt trực tiếp để đánh giá thái độ của ứng viên.",
        "Đề xuất tiếp tục duy trì số liệu cam kết '95% Cấp dấu mộc thực tập' trên toàn bộ các kênh truyền thông tuyển dụng để đảm bảo tính xác thực và uy tín của doanh nghiệp."
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
    out_public = os.path.join(pub_dir, "Bao_Cao_Tuan_AZHR_Tuan5.docx")
    out_root = r"c:\xampp\htdocs\laptrinhwebnangcao\laptrinhwebnangcao\Bao_Cao_Tuan_AZHR_Tuan5.docx"
    artifact_dir = r"C:\Users\OS\.gemini\antigravity\brain\2f712c8a-26db-4d51-b414-21df9b204240"
    out_artifact = os.path.join(artifact_dir, "Bao_Cao_Tuan_AZHR_Tuan5.docx")

    doc.save(out_public)
    doc.save(out_root)
    doc.save(out_artifact)
    print(f"SUCCESS: Saved to {out_public}, {out_root}, and {out_artifact}")

if __name__ == "__main__":
    build_report()
