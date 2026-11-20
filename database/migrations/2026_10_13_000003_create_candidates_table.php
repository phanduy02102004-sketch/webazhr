<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('candidates')) {
            Schema::create('candidates', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone');
                $table->string('university'); // Trường ĐH/CĐ
                $table->string('major'); // Ngành học
                $table->string('academic_year')->nullable(); // Năm 2, Năm 3, Năm 4, Mới tốt nghiệp
                $table->decimal('gpa', 3, 2)->nullable();
                $table->string('github_url')->nullable();
                $table->string('portfolio_url')->nullable();
                $table->string('working_shift')->default('flexible'); // morning, afternoon, fulltime, flexible
                $table->string('address')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
