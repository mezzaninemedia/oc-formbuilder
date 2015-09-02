<?php

namespace Mezzanine\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateActionsTable extends Migration
{
    public function up()
    {
        Schema::create('mezzanine_formbuilder_actions', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('form_id')->unsigned()->nullable()->index();
            $table->integer('sort_order')->default(99);
            $table->string('type');
            $table->string('name')->nullable();
            $table->json('data')->nullable();
            $table->json('conditions')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mezzanine_formbuilder_actions');
    }
}
