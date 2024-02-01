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
        Schema::create('ranking_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_per_advisory_id');
            $table->foreign('ranking_per_advisory_id')->references('id')->on('ranking_per_advisory');
            $table->foreignId('sy_id');
            $table->foreign('sy_id')->references('id')->on('school_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranking_report');
    }
};
