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
        Schema::create('faculty_staff_personal_details', function (Blueprint $table) {
            $table->id();
            $table->string('university_number', 50)->unique('university_number');
            $table->string('firstname', 100);
            $table->string('middlename', 100);
            $table->string('lastname', 100);
            $table->enum('gender', ['Male', 'Female']);
            $table->string('phone_number', 20);
            $table->string('home_address', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_staff_personal_details');
    }
};
