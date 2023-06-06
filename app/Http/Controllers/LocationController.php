<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        /* $ip = $request->ip(); Dynamic IP address */
        $ip = '48.188.144.248'; /* Static IP address */
        $currentUserInfo = Location::get($ip);

        return dd($currentUserInfo);
    }
}
