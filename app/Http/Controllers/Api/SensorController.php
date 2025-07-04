<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorKecepatanAliran;
use App\Models\SensorKekeruhanAir;

class SensorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flow_sensor.nama_sensor' => 'required|string',
            'flow_sensor.kecepatan_aliran' => 'required|numeric',
            'turbidity_sensor.nama_sensor' => 'required|string',
            'turbidity_sensor.kekeruhan_air' => 'required|numeric',
        ]);

        SensorKecepatanAliran::create([
            'nama_sensor' => $validated['flow_sensor']['nama_sensor'],
            'kecepatan_aliran' => $validated['flow_sensor']['kecepatan_aliran'],
            'waktu' => now(),
        ]);

        SensorKekeruhanAir::create([
            'nama_sensor' => $validated['turbidity_sensor']['nama_sensor'],
            'kekeruhan_air' => $validated['turbidity_sensor']['kekeruhan_air'],
            'waktu' => now(),
        ]);

        return response()->json(['message' => 'Data dari dua sensor berhasil disimpan.'], 201);
    }
}
