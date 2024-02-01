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
        Schema::create('student_gpa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_per_subject_id');
            $table->foreign('grade_per_subject_id')->references('id')->on('grades_per_subject');
            $table->float('grade7',8,2)->nullable();
            $table->float('grade8',8,2)->nullable();
            $table->float('grade9',8,2)->nullable();
            $table->float('grade10',8,2)->nullable();
            $table->float('grade11',8,2)->nullable();
            $table->float('grade12',8,2)->nullable();
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
        Schema::dropIfExists('student_gpa');
    }
};
