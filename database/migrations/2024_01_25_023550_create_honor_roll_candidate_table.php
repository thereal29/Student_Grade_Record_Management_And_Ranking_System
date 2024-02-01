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
        Schema::create('honor_roll_candidate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id');
            $table->foreign('promotion_id')->references('id')->on('promotion_candidate');
            $table->float('academic_performace',8,2);
            $table->float('evaluation_grade',8,2);
            $table->float('totalGPA',8,2);
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
        Schema::dropIfExists('honor_roll_candidate');
    }
};
