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
        Schema::create('class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_subject_id');
            $table->foreign('student_subject_id')->references('id')->on('student_subject');
            $table->foreignId('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculty_staff_personal_details');
            $table->foreignId('sy_id');
            $table->foreign('sy_id')->references('id')->on('school_year');
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
        Schema::dropIfExists('class');
    }
};
