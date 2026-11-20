<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipPositionsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('internship_positions')) {
            Schema::create('internship_positions', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('department');
                $table->string('category')->default('general'); // frontend, backend, tester, uiux, marketing, ai
                $table->string('location')->default('Đà Nẵng');
                $table->string('type')->default('part_time'); // part_time, full_time, flexible
                $table->integer('quantity')->default(3);
                $table->string('stipend')->default('3.000.000đ - 5.000.000đ / tháng');
                $table->string('experience_required')->default('Không yêu cầu kinh nghiệm, ưu tiên sinh viên năm 3, 4');
                $table->text('summary')->nullable();
                $table->longText('description')->nullable();
                $table->longText('requirements')->nullable();
                $table->longText('benefits')->nullable();
                $table->string('mentor_name')->nullable();
                $table->date('deadline')->nullable();
                $table->boolean('is_featured')->default(false);
                $table->string('status')->default('open'); // open, closed
                $table->integer('views_count')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('internship_positions');
    }
}
