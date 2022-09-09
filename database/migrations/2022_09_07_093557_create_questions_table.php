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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("quiz_id")->references("id")->on("quizes");
            $table->string("question");
            $table->string("a",128);
            $table->string("b",128);
            $table->string("c",128);
            $table->string("d",128);
            $table->string("e",128)->nullable();
            $table->string("f",128)->nullable();
            $table->string("ans",12);
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
        Schema::dropIfExists('questions');
    }
};
