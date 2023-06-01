<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowsController extends Controller
{
    public function store(User $user) {
        auth()
            ->user()
            ->toggleFollow($user);

        if (auth()->user()->following($user)) {
            return response()->json(['success'=> 'followed']);
        } else {
            return response()->json(['success'=> 'unfollowed']);
        }
    }
}
