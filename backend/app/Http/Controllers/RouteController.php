<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\Http;


class RouteController extends Controller
{
    public function getRoute()
    {
        // Kiindulási pont (Örs vezér tere)
        $origin = "47.49903,19.12574"; // Örs vezér tere koordinátái (példa)
        
        // Célállomás (Nyugati pályaudvar)
        $destination = "47.511599,19.056994";

        // Autók lekérése az adatbázisból
        $cars = Car::all();

        // Waypoints előkészítése
        // Pl. "waypoints=optimize:true|47.497913,19.040236|47.506075,19.054341|..."
        $waypoints = 'optimize:true';
        foreach ($cars as $car) {
            $waypoints .= '|' . $car->gps_lat . ',' . $car->gps_lon;
        }

        // API Key
        $apiKey = 'AIzaSyBt2dTfggXDgUgNR9jdKL7xysDeKcy28Og';

        // Google Directions API hívás
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&waypoints=$waypoints&mode=driving&language=hu&key=$apiKey";

        $response = Http::get($url);
        $data = $response->json();

        return response()->json($data);
    }
}
