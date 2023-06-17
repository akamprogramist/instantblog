<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-area');
        $this->middleware('can:admin-secret', ['only' => ['adminProfile']]);
    }
    public function index()
    {
        $users = User::where('id', '!=', '1')
            ->orderBy('id', 'ASC')
            ->paginate(30);
        return view('posts.users', compact('users'));
    }


    public function edit($username)
    {
        $user = User::where('id', '!=', '1')->whereUsername($username)->firstOrFail();
        return view('posts.profileedit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $attributes = request([
            'name',  'username', 'avatar', 'cover', 'email', 'website', 'facebook',
            'twitter', 'instagram', 'linkedin', 'rolechange', 'role', 'status'
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
                    'min:5',
                ],

                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
            ]);

            if ($request->rolechange === 'normal') {
                $attributes['role'] = null;
            } else {
                $attributes['role'] = $request->rolechange;
            }

            if ($request->hasFile('avatar')) {
                $postimage = $request->file('avatar');
                $filename = time() . '.' . $postimage->getClientOriginalExtension();
                Image::make($postimage)->resize(100, 100)->save(public_path('/images/' . $filename));
                // Upload the file to Google Cloud Storage
                $storage = Storage::disk('gcs');
                $storage->put('images/' . $filename, file_get_contents(public_path('/images/' . $filename)));

                // Get the public URL of the file
                $url = $storage->url('images/' . $filename);
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

        session()->flash('message', __('admin.userupdated'));

        return redirect('/users');
    }

    public function show($username)
    {
        $user = User::where('id', '!=', '1')->whereUsername($username)->firstOrFail();
        return view('posts.userdelete', compact('user'));
    }

    public function destroy($id)
    {
        //Delete single user
        $user = User::findOrFail($id);
        $user->comments()->delete();
        $user->posts()->delete();
        $user->delete();

        session()->flash('message', __('admin.userdeleted'));
        return redirect('/users');
    }

    public function adminProfile()
    {
        $admin = User::where('id', 1)->first();
        return view('posts.adminprofile', compact('admin'));
    }

    public function adminUpdate(Request $request, $id)
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
                    'min:5',
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

        session()->flash('message', __('admin.adminupdated'));

        return redirect('/adminprofile');
    }
}
