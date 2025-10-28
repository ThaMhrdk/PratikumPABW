<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $mahasiswas = [
            [
                'Lokasi Sensor' => 'Dayeuhkolot',
                'Ketinggian Air' => '20cm',
                'Curah Hujan' => "80mm",
                'Kelembapan Tanah'=> '40%',
            ],
        ];

        return view('home', compact('sensor'));
    }
}
