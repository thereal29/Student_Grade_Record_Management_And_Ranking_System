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
        Schema::create('ranking_batch_population', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_report_id');
            $table->foreign('ranking_report_id')->references('id')->on('ranking_report');
            $table->integer('rank_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranking_batch_population');
    }
};
