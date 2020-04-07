<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {

            $table->id('id');
            $table->string('title');
            $table->string('slug')->uniquie(); // Unique slug
            $table->text('body');
            $table->unsignedInteger('views')->default(0); // signed by 0 because when the question created no one seen or view already the question ( count the view of a question )
            $table->unsignedInteger('answers')->default(0); // signed by 0 because when the question created no one seen or view already the question ( count the view of a question )
            $table->integer('votes')->default(0); /// integer vbecause it can be negative unlike unsignedInteger
            $table->unsignedInteger('best_answer_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}