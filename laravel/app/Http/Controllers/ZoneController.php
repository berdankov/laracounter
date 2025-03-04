<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZoneController extends Controller
{
    public function getClientsInZone()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode('testovt@cronwell.com:@#egxcv123'),
        ])->post('http://172.16.50.153/api/Services/SelectClientsInZone', [
            'installationId' => 1,
            'serviceId' => 1,
            'userSelectionMode' => 2
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $count = count($data); // Количество людей в зоне
            return response()->json(['count' => $count]);
        }

        return response()->json(['error' => 'Unable to fetch data'], 500);
    }
}
