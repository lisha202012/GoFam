<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('habit_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('habit_id'); 
            $table->date('date'); 
            $table->time('start_time'); 
            $table->time('end_time'); 
            $table->timestamps();

            $table->foreign('habit_id')->references('id')->on('habits')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('habit_schedules');
    }
};

