<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use GuzzleHttp\Client;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        /* $ip = $request->ip(); Dynamic IP address */
        $ip = '130.193.208.91'; /* Static IP address */
        $userIp = Location::get($ip);

        // return dd($userIp);

        $location = $userIp->cityName;
        if (empty($location)) {
            dd('refresh the page');
        }

        $client = new Client();
        try {
            $response = $client->get('https://api.weatherapi.com/v1/current.json', [
                'query' => [
                    'key' => 'eb697c2037e24266a2093429230606',
                    'q' => $location
                ]
            ]);
            $weatherData = $response->getBody();
            $weatherData = json_decode($weatherData, true);

            if (isset($weatherData['error'])) {
                dd("the problem is in the api");
            }
            $humidity = $weatherData['current']['condition']['icon'];

            return dd($humidity, $location);
        } catch (Exception $e) {
            dd('error is in the api request');
        }
    }
}
