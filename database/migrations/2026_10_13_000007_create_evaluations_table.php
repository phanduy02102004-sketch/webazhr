<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('evaluations')) {
            Schema::create('evaluations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('application_id');
                $table->unsignedBigInteger('evaluator_id');
                $table->string('evaluator_name');
                $table->string('evaluator_role')->default('mentor'); // mentor, hr
                $table->decimal('technical_score', 3, 1)->default(0); // 0 - 10
                $table->decimal('logic_score', 3, 1)->default(0);     // 0 - 10
                $table->decimal('attitude_score', 3, 1)->default(0);  // 0 - 10
                $table->decimal('communication_score', 3, 1)->default(0); // 0 - 10
                $table->decimal('average_score', 3, 1)->default(0);   // 0 - 10
                $table->text('strengths')->nullable();
                $table->text('weaknesses')->nullable();
                $table->text('general_comment')->nullable();
                $table->string('recommendation')->default('consider'); // pass, consider, fail
                $table->timestamps();

                $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
}
