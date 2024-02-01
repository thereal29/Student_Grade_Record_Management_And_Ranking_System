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
        Schema::create('cocurricular_activity_subtype', function (Blueprint $table) {
            $table->id();
            $table->string('subtype');
            $table->double('point', 2);
            $table->foreignId('parentID');
            $table->foreign('parentID')->references('id')->on('cocurricular_activity_type');
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
        Schema::dropIfExists('cocurricular_activity_subtype');
    }
};
