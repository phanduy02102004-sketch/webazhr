<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestQuestionsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('test_questions')) {
            Schema::create('test_questions', function (Blueprint $table) {
                $table->id();
                $table->string('position_category')->default('general'); // frontend, backend, tester, uiux, marketing, ai, general
                $table->unsignedBigInteger('position_id')->nullable();
                $table->text('question');
                $table->text('option_a');
                $table->text('option_b');
                $table->text('option_c');
                $table->text('option_d');
                $table->char('correct_option', 1); // A, B, C, D
                $table->text('explanation')->nullable();
                $table->string('difficulty')->default('medium'); // easy, medium, hard
                $table->integer('points')->default(10);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('test_questions');
    }
}
