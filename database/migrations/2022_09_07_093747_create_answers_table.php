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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("quiz_id")->references("id")->on("quizes");
            $table->foreignId("user_id")->references("id")->on("users");
            $table->string("user_ans",12)->nullable();
            $table->foreignId("question_id")->references("id")->on("questions");
            $table->boolean("is_correct")->default(0);
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
        Schema::dropIfExists('answers');
    }
};
