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
        Schema::create('grades_per_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_subject_id');
            $table->foreign('student_subject_id')->references('id')->on('student_subject');
            $table->integer('firstQ')->default('0');
            $table->integer('secondQ')->default('0');
            $table->integer('thirdQ')->default('0');
            $table->integer('fourthQ')->default('0');
            $table->string('status')->default('Pending');
            $table->date('status_update_date');
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
        Schema::dropIfExists('grades_per_subject');
    }
};
