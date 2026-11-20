<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('email_templates')) {
            Schema::create('email_templates', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('title');
                $table->string('subject');
                $table->longText('body_html');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('email_templates');
    }
}
