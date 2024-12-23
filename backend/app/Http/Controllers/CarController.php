<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CarController extends Controller
{
    public function getRoute()
    {
        // Kiindulási pont (Örs vezér tere - példa koordináták)
        $origin = "47.49903,19.12574";

        // Célállomás (Nyugati pályaudvar)
        $destination = "47.511599,19.056994";

        // Autók lekérése az adatbázisból
        $cars = Car::all();

        // Waypoints előkészítése
        $waypoints = 'optimize:true';
        foreach ($cars as $car) {
            $waypoints .= '|' . $car->gps_lat . ',' . $car->gps_lon;
        }

        // Saját Google API kulcs ide:
        $apiKey = 'AIzaSyBt2dTfggXDgUgNR9jdKL7xysDeKcy28Og';

        // Google Directions API hívás
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&waypoints=$waypoints&mode=driving&language=hu&key=$apiKey";
        # AZ URL-t NE BONTSD SZÉT MERT ELSZÁLL!!!!
        $response = Http::get($url);
        $data = $response->json();

        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
