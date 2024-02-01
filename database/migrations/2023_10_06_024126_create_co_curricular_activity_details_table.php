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
        Schema::create('co_curricular_activity_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreign('student_id')->references('id')->on('student_personal_details');
            $table->foreignId('cocurricular_id');
            $table->foreign('cocurricular_id')->references('id')->on('co_curricular_activity');
            $table->string('status');
            $table->date('status_update_date');
            $table->float('partialtotalPoints',8,2);
            $table->string('proof')->nullable();
            $table->string('grade_level')->references('grade_level')->on('student_personal_details');
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
        Schema::dropIfExists('co_curricular_activity_details');
    }
};
