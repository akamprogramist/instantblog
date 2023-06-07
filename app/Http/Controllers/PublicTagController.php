<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tag;
use App\Models\Money;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Stevebauman\Location\Facades\Location;

class PublicTagController extends Controller
{
    public function index(Tag $tag)
    {
        $posts = $tag
            ->posts()
            ->orderBy('id', 'DESC')
            ->wherePostLive(1)
            ->paginate(30);
        /* $ip = $request->ip(); Dynamic IP address */
        $ip = '194.124.76.41'; /* Static IP address */
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
            $icon = $weatherData['current']['condition']['icon'];
            $text = $weatherData['current']['condition']['text'];
            $weather = ["icon" => $icon, "text" => $text, "location" => $location];
        } catch (Exception $e) {
            dd('error is in the api request');
        }

        $money = Money::where('id', 1)->first();
        return view('public.index', compact('posts', 'tag', 'weather', 'money'));
    }

    public function tags(Tag $tag)
    {
        $tag = Tag::all();
        if (request()->wantsJson()) {
            return response()->json($tag);
        }
        return view('public.tags');
    }
}
