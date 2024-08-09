<?php

namespace App\Http\Controllers;

use App\Models\TempSensorData;
use Illuminate\Http\Request;

class TempSensorDataController extends Controller
{
    public function saveData(Request $request)
    {
        $tempSensorData = new TempSensorData();
        $tempSensorData->humidity = $request->input('humidity');
        $tempSensorData->temperature_celsius = $request->input('temperature_celsius');
        $tempSensorData->temperature_fahrenheit = $request->input('temperature_fahrenheit');
        $tempSensorData->heat_index_celsius = $request->input('heat_index_celsius');
        $tempSensorData->heat_index_fahrenheit = $request->input('heat_index_fahrenheit');
        $tempSensorData->save();

        return response()->json(['message' => 'Data saved successfully'], 200);
    }

    public function showData()
    {
        $data = TempSensorData::all();
        return view('temp_sensor_data.show', compact('data'));
    }
    public function showGraphData(){
        $data = TempSensorData::all();
        return view('temp_sensor_data.graph', compact('data'));
    }
    public function getLatestData()
    {
        $data = TempSensorData::orderBy('created_at', 'desc')->limit(500)->get();

        return response()->json($data);
    }
}
