<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:moderator-post');
    }

    public function index()
    {
        //Get latest and where live posts and paginate them
        $posts = Post::orderBy('id', 'DESC')
            ->wherePostLive(1)
            ->simplePaginate(30);

        return view('posts.index', compact('posts'));
    }

    public function unpublished()
    {
        //Get latest and where unpublished posts and paginate them
        $posts = Post::orderBy('id', 'DESC')
            ->wherePostLive(0)
            ->simplePaginate(30);

        return view('posts.unpublished', compact('posts'));
    }

    public function publishpost(Request $request)
    {   
        Post::whereIn('id', [$request->id])->update(['post_live' => 1]);
        session()->flash('message', __('messages.new.postpublished'));
        return redirect('/home');
    }

    public function multiple(Request $request)
    {
        if ($request->mulbtn === 'Delete') {
            if ($request->multiple > 0) {
                $posts = Post::findOrFail($request->multiple);
                foreach ($posts as $post) {
                    if(!empty($post->post_media)) {
                        $filename = public_path().'/uploads/'.$post->post_media;
                        $delete_success = \File::delete($filename);
                    }
                    if ($post->contents) {
                        foreach ($post->contents as $item) {
                            if ($item->embed) {
                                $item->embed->delete();
                            }
                            if ($item->type == 'image') {
                                $filename = public_path().'/uploads/'.$item->body;
                                $delete_success = \File::delete($filename);
                            }
                        }
                    }
                    $post->tags()->detach();
                    $post->contents()->delete();
                }
                Post::destroy($request->multiple);

                session()->flash('message',  __('messages.postdeleted'));
                return redirect('/contents');
            } else {
                session()->flash('error', __('messages.new.selectcheck'));
                return redirect('/contents');
            }
        } elseif ($request->mulbtn === 'Unpublish') {
            if ($request->multiple > 0) {
                Post::whereIn('id', $request->multiple)->update(['post_live' => 0]);

                session()->flash('message', __('messages.new.postunpublished'));
                return redirect('/contents');
            } else {
                session()->flash('error', __('messages.new.selectcheck'));
                return redirect('/contents');
            }
        } elseif ($request->mulbtn === 'Publish') {
            if ($request->multiple > 0) {
                Post::whereIn('id', $request->multiple)->update(['post_live' => 1]);

                session()->flash('message', __('messages.new.postpublished'));
                return redirect('/contents');
            } else {
                session()->flash('error', __('messages.new.selectcheck'));
                return redirect('/contents');
            }
        }
    }
}
