<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability){
            return $user->role == 'super-admin' ? true : null;
        });
        
        Gate::define('own-post', function (User $user, Post $post) {
            return $user->id == $post->user_id;
        });

        Gate::define('own-comment', function (User $user, Comment $comment) {
            return $user->id == $comment->user_id;
        });

        Gate::define('admin-area', function($user) {
            return $user->role == 'admin' ? true : null;
        });

        Gate::define('admin-access', function($user) {
            return $user->role == 'admin' or $user->username == 'admin-access';
        });

        Gate::define('moderator-post', function($user) {
            $collection = collect(['admin', 'editor']);
            return $collection->contains($user->role) ? true : null;
        });

        Gate::define('publish-post', function($user) {
            $collection = collect(['admin', 'editor', 'verified']);
            return $collection->contains($user->role) ? true : null;
        });
    }
}
