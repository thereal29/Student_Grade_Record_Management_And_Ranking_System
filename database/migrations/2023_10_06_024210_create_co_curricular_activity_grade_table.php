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
        Schema::create('co_curricular_activity_grade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->foreign('student_id')->references('id')->on('student_personal_details');
            $table->foreignId('cocurdetails_id');
            $table->foreign('cocurdetails_id')->references('id')->on('co_curricular_activity_details');
            $table->float('finalTotalPoints',8,2);
            $table->float('cocurricularGrade',8,2);
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
        Schema::dropIfExists('co_curricular_activity_grade');
    }
};
