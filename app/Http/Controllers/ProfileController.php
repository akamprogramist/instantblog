<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'followers', 'following']]);
    }

    public function index(Request $request)
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['message' => 'Missing token'], 401);
        }
        $token = $request->session()->get('token');
        $authuser = Auth::user();
        if (Gate::allows('moderator-post')) {
            $posts = Post::orderBy('id', 'DESC')
                ->wherePostLive(0)
                ->simplePaginate(15);
        } else {
            $posts = Post::orderBy('id', 'DESC')
                ->whereUserId(auth()->user()->id)
                ->wherePostLive(0)
                ->simplePaginate(15);
        }
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
        return view('home', compact('posts'));
    }

    public function show($username)
    {
        $user = User::whereUsername($username)->firstOrFail();

        $posts = Post::latest()
            ->wherePostLive(1)
            ->whereUserId($user->id)
            ->paginate(30);

        $point = Post::wherePostLive(1)
            ->select('user_id')
            ->whereUserId($user->id)
            ->withCount('likes')
            ->get();
        $followers = $user->followers()->paginate(30);
        $follows = $user->follows()->paginate(30);
        if (request()->wantsJson()) {
            return response()->json([
                'followers' => $followers,
                'follows' => $follows,
                'posts' => $posts,
                'user' => $user,
                'point' => $point
            ]);
        }
        return view('public.profile', compact('user', 'posts', 'point'));
    }

    public function usernotifications()
    {
        $count = auth()->user()->notifications()->count();

        $deleteNot = auth()->user()->notifications()->latest()->take($count)->skip(30)->get()->each(function ($row) {
            $row->delete();
        });

        $notifications = auth()->user()->notifications()->limit(30)->get();

        auth()->user()->unreadNotifications->markAsRead();
        return view('member.notifications', compact('notifications'));
    }

    public function delnotifications()
    {
        auth()->user()->notifications()->delete();

        session()->flash('message', __('messages.comments.notdeleted'));

        return redirect('/notifications');
    }

    public function edit($username)
    {
        $user = User::findOrFail(auth()->id());

        $point = Post::wherePostLive(1)
            ->select('user_id')
            ->whereUserId($user->id)
            ->withCount('likes')
            ->get();

        return view('member.profileedit', compact('user', 'point'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $attributes = request([
            'name',  'username', 'avatar', 'cover', 'email', 'website', 'facebook',
            'twitter', 'instagram', 'linkedin'
        ]);

        if ($request->password) {
            $this->validate(request(), [
                'password' => 'required|min:6|confirmed',
            ]);

            $user->password = bcrypt(request('password'));
            $user->save();
        } else {

            $this->validate(request(), [
                'name' => 'required|max:255',
                'username' => [
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
            ]);


            if ($request->hasFile('avatar')) {
                $postimage = $request->file('avatar');
                $filename = time() . '.' . $postimage->getClientOriginalExtension();
                Image::make($postimage)->resize(100, 100)->save(public_path('/images/' . $filename));

                // Upload the file to Google Cloud Storage
                $storage = Storage::disk('gcs');
                $storage->put('images/' . $filename, file_get_contents(public_path('/images/' . $filename)));

                // Get the public URL of the file
                $url = $storage->url('images/' . $filename);

                // Update the user's avatar attribute with the public URL
                $attributes['avatar'] = $url;
            } else {
                $attributes['avatar'] = $user->avatar;
            }
            if ($request->hasFile('cover')) {
                $postimage = $request->file('cover');
                $filename = time() . '.' . $postimage->getClientOriginalExtension();
                Image::make($postimage)->resize(1440, 200)->save(public_path('/uploads/' . $filename));
                // Upload the file to Google Cloud Storage
                $storage = Storage::disk('gcs');
                $storage->put('uploads/' . $filename, file_get_contents(public_path('/uploads/' . $filename)));

                // Get the public URL of the file
                $url = $storage->url('uploads/' . $filename);
                $attributes['cover'] = $url;
            } else {
                $attributes['cover'] = $user->cover;
            }

            $user->update($attributes);
        }

        session()->flash('message', __('messages.new.profileupdated'));

        return redirect('/home');
    }

    public function confirm()
    {
        $user = User::findOrFail(auth()->id());
        return view('posts.deleteaccount', compact('user'));
    }

    public function destroy($id)
    {
        //Delete user account
        $user = User::findOrFail($id);
        $user->comments()->delete();
        $user->posts()->delete();
        $user->delete();

        session()->flash('message', __('messages.new.userdeleted'));
        return redirect('/login');
    }

    public function followers(User $user)
    {
        $point = Post::wherePostLive(1)
            ->select('user_id')
            ->whereUserId($user->id)
            ->withCount('likes')
            ->get();

        $followers = $user->followers()->paginate(30);
        if (request()->wantsJson()) {
            return response()->json([
                'followers' => $followers,
                'user' => $user,
                'point' => $point
            ]);
        }
        return view('public.followers', compact('user', 'point', 'followers'));
    }

    public function following(User $user)
    {
        $point = Post::wherePostLive(1)
            ->select('user_id')
            ->whereUserId($user->id)
            ->withCount('likes')
            ->get();

        $follows = $user->follows()->paginate(30);
        if (request()->wantsJson()) {
            return response()->json([
                'follows' => $follows,
                'user' => $user,
                'point' => $point
            ]);
        }
        return view('public.following', compact('user', 'point', 'follows'));
    }

    public function homepage(Request $request)
    {
        User::whereIn('id', [$request->id])->update(['homepage' => $request->homepage]);
        session()->flash('message', __('messages.new.profileupdated'));
        return redirect('/home');
    }
}
