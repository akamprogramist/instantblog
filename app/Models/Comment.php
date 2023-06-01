<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('id', 'asc');
    }

    public function getBodyAttribute($value)
    {
        return $this->attributes['body'] = preg_replace('/(\@\w+)/', '<strong>$1</strong>', $value);
    }

}
