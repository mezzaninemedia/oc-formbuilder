<?php

namespace Mezzanine\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('mezzanine_formbuilder_submissions', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('form_id')->unsigned()->nullable()->index();
            $table->datetime('submitted_at')->nulable();
            $table->string('key')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('url')->nullable();
            $table->json('input')->nullable();
            $table->json('raw_input')->nullable();
            $table->string('search_terms')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mezzanine_formbuilder_submissions');
    }
}
