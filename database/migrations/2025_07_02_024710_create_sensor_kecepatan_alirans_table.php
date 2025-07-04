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
        Schema::create('sensor_kecepatan_aliran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sensor');
            $table->float('kecepatan_aliran');
            $table->timestamp('waktu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_kecepatan_alirans');
    }
};
