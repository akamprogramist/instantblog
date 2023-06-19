<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserNotified;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function likePost($id)
    {
        // here you can check if post exists or is valid
        $post = Post::findorfail($id);
        $this->handleLike('App\Models\Post', $id, $post);
        return json_encode(shortNumber($post->likes()->count()));
    }


    public function getLikesCount($postId)
    {
        $post = Post::findOrFail($postId);
        $likesCount = $post->likes()->count();

        return response()->json(['likesCount' => $likesCount]);
    }

    public function handleLike($type, $id, $post)
    {
        $existing_like = Like::withTrashed()->whereLikeableType($type)->whereLikeableId($id)->whereUserId(Auth::id())->first();

        if (is_null($existing_like)) {
            Like::create([
                'user_id'       => Auth::id(),
                'likeable_id'   => $id,
                'likeable_type' => $type,
            ]);

            $postData = [
                'title' => $post->post_title,
                'slug' => $post->post_slug,
                'user' =>  auth()->user()->username,
                'type' => 'like',
            ];

            $foundUser = User::findorfail($post->user_id);
            $foundUser->notify(new UserNotified($postData));
        } else {
            if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            } else {
                $existing_like->restore();
            }
        }
    }
}
