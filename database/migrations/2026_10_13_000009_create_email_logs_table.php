<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailLogsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('email_logs')) {
            Schema::create('email_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('application_id')->nullable();
                $table->string('recipient_email');
                $table->string('recipient_name');
                $table->string('template_code')->nullable();
                $table->string('subject');
                $table->longText('body_preview');
                $table->string('status')->default('sent');
                $table->timestamp('sent_at')->useCurrent();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('email_logs');
    }
}
