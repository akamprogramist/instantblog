<?php

namespace App\Http\Controllers\Auth;

use App\Models\Followable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Post;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $authuser = Auth::user();
        $token = $authuser->createToken('AuthToken')->plainTextToken;
        $request->session()->regenerate();
        $request->session()->put('token', $token);
        $posts = Post::latest()
            ->wherePostLive(1)
            ->whereUserId($authuser->id)
            ->paginate(30);
        $followers = $authuser->followers()->paginate(30);
        $follows = $authuser->follows()->paginate(30);
        if (request()->wantsJson()) {
            return response()->json([
                'token' => $token,
                'authuser' => $authuser,
                'followers' => $followers,
                'follows' => $follows,
                'posts' => $posts
            ]);
        }
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        auth()->user()->tokens()->delete();
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/');
    }
}
