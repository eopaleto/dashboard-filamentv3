<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sensor_kecepatan_aliran', function (Blueprint $table) {
            $table->string('status')->after('waktu');
        });
    }

    public function down(): void
    {
        Schema::table('sensor_kecepatan_aliran', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
