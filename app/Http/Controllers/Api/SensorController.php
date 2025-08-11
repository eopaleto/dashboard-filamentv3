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

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $validated
        ], 201);
    }

    public function get()
    {
        $flow = SensorKecepatanAliran::latest('waktu')->first();
        $turbidity = SensorKekeruhanAir::latest('waktu')->first();

        return response()->json([
            'flow_sensor' => [
                'nama_sensor' => $flow->nama_sensor ?? 'Flow Sensor',
                'kecepatan_aliran' => $flow->kecepatan_aliran ?? 0,
                'waktu' => $flow->waktu ?? null
            ],
            'turbidity_sensor' => [
                'nama_sensor' => $turbidity->nama_sensor ?? 'Turbidity Sensor',
                'kekeruhan_air' => $turbidity->kekeruhan_air ?? 0,
                'waktu' => $turbidity->waktu ?? null
            ]
        ]);
    }
}
