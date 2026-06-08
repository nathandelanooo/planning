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
        Schema::create('habit_tracker', function (Blueprint $table) {
            $table->id('id_habit_tracker');
            $table->unsignedBigInteger('id_pengguna');
            $table->string('nama_habit');
            $table->text('kategori_habit');
            $table->string('status');
    

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_tracker');
    }
};
