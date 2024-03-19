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
            $table->string('grade_level');
            $table->integer('firstQ')->default('0')->nullable();
            $table->string('statusFirstQ')->default('To Be Encoded');
            $table->string('date_submitted_firstQ');
            $table->string('date_approved_firstQ');
            $table->integer('secondQ')->default('0')->nullable();
            $table->string('statusSecondQ')->default('To Be Encoded');
            $table->string('date_submitted_secondQ');
            $table->string('date_approved_secondQ');
            $table->integer('thirdQ')->default('0')->nullable();
            $table->string('statusThirdQ')->default('To Be Encoded');
            $table->string('date_submitted_thirdQ');
            $table->string('date_approved_thirdQ');
            $table->integer('fourthQ')->default('0')->nullable();
            $table->string('statusFourthQ')->default('To Be Encoded');
            $table->string('date_submitted_fourthQ');
            $table->string('date_approved_fourthQ');
            $table->float('cumulative_gpa',8,2)->nullable();
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
