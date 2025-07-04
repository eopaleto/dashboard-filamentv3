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
        Schema::table('sensor_kekeruhan_air', function (Blueprint $table) {
            $table->string('status')->after('waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sensor_kekeruhan_air', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
