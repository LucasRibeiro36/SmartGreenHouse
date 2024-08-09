<?php

namespace App\Http\Controllers;

use App\Models\SoilSensorData;
use Illuminate\Http\Request;

class SoilSensorDataController extends Controller
{
    public function saveData(Request $request)
    {
        $tempSensorData = new SoilSensorData();
        $tempSensorData->moisture = $request->input('moisture');
        $tempSensorData->save();

        return response()->json(['message' => 'Data saved successfully'], 200);
    }

    public function showData()
    {
        $data = SoilSensorData::all();
        return view('soil_sensor_data.show', compact('data'));
    }

    public function getLatestData()
    {
        $data = SoilSensorData::orderBy('created_at', 'desc')->limit(1000)->get();

        return response()->json($data);
    }
}
