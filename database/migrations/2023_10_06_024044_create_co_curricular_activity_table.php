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
        Schema::create('co_curricular_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('typeID');
            $table->foreign('typeID')->references('id')->on('cocurricular_activity_type');
            $table->foreignId('subtypeID');
            $table->foreign('subtypeID')->references('id')->on('cocurricular_activity_subtype');
            $table->foreignId('award_scopeID')->nullable();
            $table->foreign('award_scopeID')->references('id')->on('cocurricular_activity_award_scope');
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
        Schema::dropIfExists('co_curricular_activity');
    }
};
