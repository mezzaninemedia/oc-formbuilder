<?php

namespace Mezzanine\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('mezzanine_formbuilder_fields', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('form_id')->unsigned()->nullable()->index();
            $table->integer('sort_order')->default(99);
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('field_type')->nullable();
            $table->string('validation')->nullable();
            $table->string('default')->nullable();
            $table->string('group_classes')->nullable();
            $table->string('label_classes')->nullable();
            $table->string('input_classes')->nullable();
            $table->string('input_extra')->nullable();
            $table->text('values')->nullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('starts_new_row')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mezzanine_formbuilder_fields');
    }
}
