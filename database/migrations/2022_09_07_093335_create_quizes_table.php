<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("picture");
            $table->tinyText("description");
            $table->tinyInteger("per_question_mark");
            $table->double("price",8,2)->default(0);
            $table->tinyInteger("time");
            $table->boolean("full_quiz_time")->default(0);
            $table->boolean("show_ans")->default(0);
            $table->boolean("show_each_ans");
            $table->tinyInteger("number_of_taken");
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
        Schema::dropIfExists('quizes');
    }
};
