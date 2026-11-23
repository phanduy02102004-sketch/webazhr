<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternGraduation;
use App\Models\Application;
use App\Models\Candidate;
use Carbon\Carbon;

class InternGraduationSeeder extends Seeder
{
    public function run()
    {
        // 1. Hồ sơ mẫu TTS Nguyễn Thị Thanh Hằng (Theo đúng ảnh mẫu hướng dẫn của công ty)
        InternGraduation::updateOrCreate(
            ['student_code' => 'DNC2026019'],
            [
                'graduation_code' => 'CDR-2026-0001',
                'student_name' => 'Nguyễn Thị Thanh Hằng',
                'email' => 'Hn2500215@gmail.com',
                'phone' => '0843619219',
                'school' => 'Đại học Đông Á',
                'major' => 'Truyền thông đa phương tiện & Marketing',
                'intern_position' => 'TTS Marketing & Nội dung số',
                
                // Mục 1: Khảo sát
                'survey_1_completed' => true,
                'survey_2_completed' => true,
                'survey_proof_link' => 'https://drive.google.com/drive/folders/1i1zZx97wSwZAsF5KRon3sexZABi8MtWB?usp=sharing',

                // Mục 2: Nộp báo cáo
                'report_draft_submitted' => true,
                'report_final_submitted' => true,
                'hard_copy_submitted' => true,
                'report_notes' => 'Đã nộp 2 bản in cứng: 1 bản cho doanh nghiệp AZ Media và 1 bản nộp cho trường ĐH Đông Á.',

                // Bước 3: Đặt lịch hẹn AZ SUPPORT (Đúng như ảnh 2)
                'appointment_booked' => true,
                'appointment_name' => 'Nguyễn Thị Thanh Hằng',
                'appointment_phone' => '0843619219',
                'appointment_email' => 'Hn2500215@gmail.com',
                'appointment_team' => 'Gặp hỗ trợ viên',
                'appointment_service' => 'Thực tập sinh',
                'appointment_date' => '09/07/2026',
                'appointment_time' => '09:00',
                'appointment_status' => 'confirmed',

                // Bước 4: 1+1 (Đúng như ảnh 4)
                'referral_completed' => true,
                'referral_full_info' => 'Nguyễn Thị Thanh Hằng + Trần Mai Phương (0912445566 - maiphuong.dnc@gmail.com)',
                'referral_phone' => '0912445566',
                'referral_email' => 'maiphuong.dnc@gmail.com',
                'referral_school' => 'Đại học Đông Á',
                'referral_major' => 'Thương mại điện tử & Marketing',
                'referral_position' => 'TTS Marketing Online & Content Creator',
                'referral_status' => 'verified',

                // Mục 3: Video, Word & Đánh giá 5 kênh
                'word_report_submitted' => true,
                'word_report_link' => 'https://drive.google.com/drive/folders/1CmC8pLlrGXUkQBOdEPqP0wdKLb3Mqttd?usp=sharing',
                'video_submitted' => true,
                'video_link' => 'https://drive.google.com/drive/folders/1CmC8pLlrGXUkQBOdEPqP0wdKLb3Mqttd?usp=sharing',
                'review_map1' => true,
                'review_map2' => true,
                'review_page_homes' => true,
                'review_page_media' => true,
                'review_page_hr' => true,
                'review_proof_link' => 'https://drive.google.com/drive/u/0/folders/18ez5f7HG4bjdOuePrH2uYqViip4rhkHA',

                // Tổng duyệt
                'status' => 'approved',
                'admin_notes' => 'Hồ sơ chuẩn đầu ra đầy đủ 3 mục, đã nộp đủ 2 bản in mộc, xác nhận đạt chuẩn tốt nghiệp thực tập và cấp giấy chứng nhận + mộc đỏ AZ Media.',
                'approved_by' => 'Lê Đình Quang (BĐH AZ Media)',
                'approved_at' => Carbon::now()->subDays(2),
            ]
        );

        // 2. Hồ sơ mẫu TTS FPT đang chờ duyệt
        InternGraduation::updateOrCreate(
            ['student_code' => 'FPTS182934'],
            [
                'graduation_code' => 'CDR-2026-0002',
                'student_name' => 'Phan Nhật Duy',
                'email' => 'duypn.fpt@gmail.com',
                'phone' => '0968825068',
                'school' => 'Đại học FPT Đà Nẵng',
                'major' => 'Kỹ thuật phần mềm (Software Engineering)',
                'intern_position' => 'TTS Lập trình Web Fullstack & Mini-ATS',

                'survey_1_completed' => true,
                'survey_2_completed' => true,
                'survey_proof_link' => 'https://drive.google.com/drive/folders/1i1zZx97wSwZAsF5KRon3sexZABi8MtWB',

                'report_draft_submitted' => true,
                'report_final_submitted' => true,
                'hard_copy_submitted' => false,
                'report_notes' => 'Đã mang lên trường FPT đóng dấu mộc, đang chờ nộp bản cứng lên công ty trước 15/7/2026.',

                'appointment_booked' => true,
                'appointment_name' => 'Phan Nhật Duy',
                'appointment_phone' => '0968825068',
                'appointment_email' => 'duypn.fpt@gmail.com',
                'appointment_team' => 'Gặp hỗ trợ viên',
                'appointment_service' => 'Thực tập sinh',
                'appointment_date' => '12/07/2026',
                'appointment_time' => '14:30',
                'appointment_status' => 'pending',

                'referral_completed' => true,
                'referral_full_info' => 'Phan Nhật Duy + Lê Hoàng Nam (0905123987 - namlh.fpt@gmail.com)',
                'referral_phone' => '0905123987',
                'referral_email' => 'namlh.fpt@gmail.com',
                'referral_school' => 'Đại học FPT Đà Nẵng',
                'referral_major' => 'Kỹ thuật phần mềm',
                'referral_position' => 'TTS Lập trình Backend Laravel / AI',
                'referral_status' => 'submitted',

                'word_report_submitted' => true,
                'word_report_link' => 'https://drive.google.com/drive/folders/1CmC8pLlrGXUkQBOdEPqP0wdKLb3Mqttd',
                'video_submitted' => true,
                'video_link' => 'https://drive.google.com/drive/folders/1CmC8pLlrGXUkQBOdEPqP0wdKLb3Mqttd',
                'review_map1' => true,
                'review_map2' => true,
                'review_page_homes' => true,
                'review_page_media' => true,
                'review_page_hr' => true,
                'review_proof_link' => 'https://drive.google.com/drive/u/0/folders/18ez5f7HG4bjdOuePrH2uYqViip4rhkHA',

                'status' => 'pending_review',
                'admin_notes' => 'Chờ sinh viên mang bản cứng đã có dấu mộc trường FPT nộp tại văn phòng 84 Nguyễn Hữu Dật để hoàn tất thủ tục.',
            ]
        );

        // 3. Đồng bộ với các Application đã có trong hệ thống nếu có
        $applications = Application::with('candidate')->take(3)->get();
        foreach ($applications as $app) {
            $cand = $app->candidate;
            if ($cand) {
                InternGraduation::firstOrCreate(
                    ['application_id' => $app->id],
                    [
                        'graduation_code' => 'CDR-2026-' . str_pad($app->id + 10, 4, '0', STR_PAD_LEFT),
                        'candidate_id' => $cand->id,
                        'student_name' => $cand->name ?? 'Thực tập sinh AZ Media',
                        'student_code' => $cand->student_id ?? ('SV' . (1000 + $cand->id)),
                        'email' => $cand->email,
                        'phone' => $cand->phone ?? '0905000111',
                        'school' => $cand->university ?? 'Đại học Bách Khoa - ĐH Đà Nẵng',
                        'major' => $cand->major ?? 'Công nghệ thông tin',
                        'intern_position' => $app->position ? $app->position->title : 'Thực tập sinh AZ Media',
                        'survey_1_completed' => true,
                        'survey_2_completed' => false,
                        'report_draft_submitted' => true,
                        'status' => 'in_progress',
                    ]
                );
            }
        }
    }
}
