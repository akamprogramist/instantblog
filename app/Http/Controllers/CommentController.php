<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\UserNotified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{
    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $attributes = request(['post_id', 'user_id', 'body', 'parent_id']);

        $validator = Validator::make($request->all(), [
            'body' => 'required',
        ]);

        if ($validator->passes()) {
        $attributes['user_id'] = Auth::user()->id;

        $data = Comment::create($attributes);

        $user = str_limit(Auth::user()->name, 10);
        $username = Auth::user()->username;

        if (substr( Auth::user()->avatar, 0, 4 ) === "http") {
            $avatar = Auth::user()->avatar;
        } else {
            $avatar = url('/') . '/images/' . Auth::user()->avatar;
        }

        $comid = $data->id;

        preg_match_all('/\B@(\w+)/', $request->body, $mentionedUsers);

        $post = Post::findOrFail($request->post_id);

        $postData = [
            'title' => $post->post_title,
            'slug' => $post->post_slug,
            'user' => $username,
            'type' => 'comment',
        ];

        foreach ($mentionedUsers[1] as $mentionedUser) {

            $replaced = Str::replaceFirst('@', '', $mentionedUser);

            $foundUser = User::where('username', $replaced)->first();

            if ($foundUser) {
               $foundUser->notify(new UserNotified($postData));
            }
            
        }

        $postOwner = User::findOrFail($post->user_id);
        $siteadmin = User::findOrFail(1);
        data_set($postData, 'type', 'newcomment');

        if ($postOwner->id != '1') {
            $postOwner->notify(new UserNotified($postData));
        }
        
        $siteadmin->notify(new UserNotified($postData));


        return response()->json(['success'=>$request->body, 'user'=>$user, 'username'=>$username, 'avatar'=>$avatar, 'comid'=>$comid ]);

        }

        return response()->json(['error'=>$validator->errors()->all()]);

    }

    public function show(Comment $comment)
    {
        //
    }

    public function edit(Comment $comment)
    {
        //
    }

    public function update(Request $request)
    {   
        $comment = Comment::findOrFail($request->id);

        $attributes = request(['body']);

        $validator = Validator::make($request->all(), [
            'body' => 'required',
        ]);

        if ($validator->passes()) {

        $comment->update($attributes);

        return response()->json(['success'=>$request->body]);

        }

        return response()->json(['error'=>$validator->errors()->all()]);

    }

    public function destroy(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        $comment->delete();

        if($comment->replies()) {
            $comment->replies()->delete();
        }
        
        return response()->json(['success'=>'Deleted']);
    }
}
