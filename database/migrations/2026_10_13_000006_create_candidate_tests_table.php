<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateTestsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('candidate_tests')) {
            Schema::create('candidate_tests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('application_id');
                $table->integer('total_questions')->default(0);
                $table->integer('correct_answers')->default(0);
                $table->decimal('score', 5, 2)->default(0);
                $table->integer('time_spent_seconds')->default(0);
                $table->boolean('passed')->default(false);
                $table->longText('answers_data')->nullable(); // JSON formatted
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();

                $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('candidate_tests');
    }
}
