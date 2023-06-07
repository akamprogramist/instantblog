<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Models\Money;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class PublicPostController extends Controller
{
    //Get latest and where live posts and paginate them
    public function index()
    {

        if (Auth::check()) {
            $authuser = Auth::user();
            if ($authuser->homepage == 1) {
                $following = auth()->user()->follows()->pluck('id');
                $posts = Post::whereIn('user_id', $following)
                    ->latest()
                    ->orWhere('user_id', $authuser->id)
                    ->wherePostLive(1)
                    ->paginate(30);
                return view('public.index', compact('posts'));
            }
        }

        $posts = Post::latest()
            ->wherePostLive(1)
            ->paginate(30);

        if (request()->wantsJson()) {
            return response()->json($posts);
        }

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

        return view('public.index', compact('posts', 'weather', 'money'));
    }

    //Show single post
    public function show(Post $post)
    {
        Post::find($post->id)->increment('counter');

        $nextid     = Post::where('id', '>', $post->id)->wherePostLive(1)->min('id');
        $previousid = Post::where('id', '<', $post->id)->wherePostLive(1)->max('id');

        if ($nextid) {
            $next = Post::find($nextid)->post_slug;
        } else {
            $next = null;
        }

        if ($previousid) {
            $previous = Post::find($previousid)->post_slug;
        } else {
            $previous = null;
        }

        $random = Post::inRandomOrder()
            ->wherePostLive(1)
            ->first()
            ->post_slug;

        $related = Post::inRandomOrder()
            ->wherePostLive(1)
            ->where('id', '!=', $post->id)
            ->take(5)
            ->get();

        if ($post->edit_id) {
            $editby = User::where('id', $post->edit_id)->first();
        } else {
            $editby = null;
        }

        return view('public.show', compact('post', 'next', 'previous', 'random', 'related', 'editby'));
    }
    //Show archives posts
    public function archives()
    {
        return view('public.archives');
    }
    //Show single archiveposts
    public function archiveposts(Request $request)
    {
        $month = request(['month']);

        $validator = Validator::make($month, [
            'month' => 'required|
            in:January,February,March,April,May,June,July,August,September,October,November,December',
        ]);

        if ($validator->fails()) {
            return redirect('/archives');
        }

        $posts = Post::latest()
            ->filter(request(['month', 'year']))
            ->wherePostLive(1)
            ->paginate(30);

        return view('public.archiveposts', compact('posts'));
    }
    //Find Popular contents
    public function popular()
    {
        $posts = Post::wherePostLive(1)
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->paginate(30);

        return view('public.popular', compact('posts'));
    }

    //Search content
    public function search(Request $request)
    {
        $s = $request->input('s');

        $posts = Post::latest()
            ->search($s)
            ->wherePostLive(1)
            ->paginate(30);

        return view('public.index', compact('posts'));
    }


    //Show single post for amp
    public function ampShow(Post $post)
    {
        $related = Post::inRandomOrder()
            ->wherePostLive(1)
            ->where('id', '!=', $post->id)
            ->take(5)
            ->get();

        return view('public.showamp', compact('post', 'related'));
    }

    public function showPage(Page $page)
    {
        return view('public.showpage', compact('page'));
    }

    public function feedControl()
    {
        $posts = Post::latest()
            ->wherePostLive(1)
            ->paginate(30);

        return response()
            ->view('public.feed', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }
}
