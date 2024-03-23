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
        Schema::create('character_evaluation_indicator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eval_id');
            $table->foreign('eval_id')->references('id')->on('character_evaluation');
            $table->string('description');
            $table->integer('order')->default(0)->nullable();
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
        Schema::dropIfExists('character_evaluation_indicator');
    }
};
