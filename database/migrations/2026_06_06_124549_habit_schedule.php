<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('habit_schedule', function (Blueprint $table) {
            $table->id('id_schedule');
            $table->unsignedBigInteger('id_habit_tracker');
            $table->string('hari');
            $table->time('reminder_time');

            $table->foreign('id_habit_tracker')->references('id_habit_tracker')->on('habit_tracker')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
