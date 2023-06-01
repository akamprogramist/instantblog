<?php

namespace App\Models;
use App\Notifications\UserNotified;

trait Followable
{    
    public function follow(User $user)
    {
        $postData = [
            'title' => null,
            'slug' => null,
            'user' => auth()->user()->username,
            'type' => 'follow',
        ];

        $user->notify(new UserNotified($postData));
        return $this->follows()->save($user);
    }

    public function unfollow(User $user)
    {
        return $this->follows()->detach($user);
    }

    public function toggleFollow(User $user)
    {

        if ($this->following($user)) {
            return $this->unfollow($user);
        }

        return $this->follow($user);
    }

    public function following(User $user)
    {
        return $this->follows()
            ->where('following_user_id', $user->id)
            ->exists();
    }

    public function follows()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'user_id',
            'following_user_id'
        );
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class, 
            'follows', 
            'following_user_id', 
            'user_id'
        );
    }
}
