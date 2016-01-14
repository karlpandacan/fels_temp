<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_word', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned()->index();
            $table->integer('word_id')->unsigned()->index();
            $table->integer('word_answered_id')->unsigned()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lesson_word');
    }
}
