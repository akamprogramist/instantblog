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

        if (request()->wantsJson()) {
            return response()->json([
                'posts' => $posts,
            ]);
        }
        return view('public.index', compact('posts', 'tag'));
    }

    public function tags(Tag $tag)
    {
        $tag = Tag::all();
        if (request()->wantsJson()) {
            return response()->json([
                'tag' => $tag,
            ]);
        }
        return view('public.tags');
    }
}
