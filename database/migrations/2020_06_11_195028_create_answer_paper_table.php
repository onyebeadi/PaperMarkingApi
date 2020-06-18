<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerPaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_papers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marking_guide_id')->unsigned();
            $table->string('student_name');
            $table->string('subject_name');
            $table->string('answers');
            $table->integer('score')->unsigned();
            $table->timestamps();

            $table->foreign('marking_guide_id')
                ->references('id')
                ->on('marking_guides')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_paper');
    }
}
