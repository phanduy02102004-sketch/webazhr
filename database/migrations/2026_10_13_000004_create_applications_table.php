<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('applications')) {
            Schema::create('applications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('candidate_id');
                $table->unsignedBigInteger('position_id');
                $table->string('application_code')->unique(); // e.g. AZ-2026-0732
                $table->string('cv_path');
                $table->string('cv_filename');
                $table->text('cover_letter')->nullable();
                $table->string('status')->default('applied'); // applied, screening, test_sent, tested, interviewing, offered, rejected
                $table->integer('stage_step')->default(1);
                $table->dateTime('interview_time')->nullable();
                $table->string('interview_type')->nullable(); // online, offline
                $table->string('interview_link')->nullable(); // Google Meet / Zoom link
                $table->string('interview_location')->nullable(); // 84 Nguyễn Hữu Dật, P. Hòa Cường, Q. Hải Châu, TP. Đà Nẵng
                $table->unsignedBigInteger('assigned_mentor_id')->nullable();
                $table->text('hr_note')->nullable();
                $table->text('mentor_note')->nullable();
                $table->text('rejection_reason')->nullable();
                $table->text('offer_details')->nullable();
                $table->timestamps();

                $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
                $table->foreign('position_id')->references('id')->on('internship_positions')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
