<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternGraduationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intern_graduations', function (Blueprint $table) {
            $table->id();
            $table->string('graduation_code')->unique();
            $table->unsignedBigInteger('application_id')->nullable()->index();
            $table->unsignedBigInteger('candidate_id')->nullable()->index();
            $table->string('student_name');
            $table->string('student_code')->nullable()->index();
            $table->string('email')->index();
            $table->string('phone')->index();
            $table->string('school')->nullable();
            $table->string('major')->nullable();
            $table->string('intern_position')->nullable();

            // Mục 1: Khảo sát
            $table->boolean('survey_1_completed')->default(false);
            $table->boolean('survey_2_completed')->default(false);
            $table->text('survey_proof_link')->nullable();

            // Mục 2: Nộp báo cáo
            $table->boolean('report_draft_submitted')->default(false);
            $table->boolean('report_final_submitted')->default(false);
            $table->boolean('hard_copy_submitted')->default(false);
            $table->text('report_notes')->nullable();

            // Mục 2 - Bước 3: Đặt lịch hẹn AZ SUPPORT
            $table->boolean('appointment_booked')->default(false);
            $table->string('appointment_name')->nullable();
            $table->string('appointment_phone')->nullable();
            $table->string('appointment_email')->nullable();
            $table->string('appointment_team')->default('Gặp hỗ trợ viên');
            $table->string('appointment_service')->default('Thực tập sinh');
            $table->string('appointment_date')->nullable();
            $table->string('appointment_time')->nullable();
            $table->string('appointment_status')->default('pending');

            // Mục 2 - Bước 4: Giới thiệu 1+1 AZ SUPPORT
            $table->boolean('referral_completed')->default(false);
            $table->text('referral_full_info')->nullable();
            $table->string('referral_name')->nullable();
            $table->string('referral_phone')->nullable();
            $table->string('referral_email')->nullable();
            $table->string('referral_school')->nullable();
            $table->string('referral_major')->nullable();
            $table->string('referral_position')->nullable();
            $table->string('referral_cv_file')->nullable();
            $table->string('referral_status')->default('submitted');

            // Mục 3: Video, Word & Đánh giá 5 kênh
            $table->boolean('word_report_submitted')->default(false);
            $table->text('word_report_link')->nullable();
            $table->boolean('video_submitted')->default(false);
            $table->text('video_link')->nullable();
            $table->boolean('review_map1')->default(false);
            $table->boolean('review_map2')->default(false);
            $table->boolean('review_page_homes')->default(false);
            $table->boolean('review_page_media')->default(false);
            $table->boolean('review_page_hr')->default(false);
            $table->text('review_proof_link')->nullable();

            // Tổng duyệt
            $table->string('status')->default('in_progress'); // in_progress, pending_review, approved, needs_update
            $table->text('admin_notes')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intern_graduations');
    }
}
