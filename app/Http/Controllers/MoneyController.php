<?php

namespace App\Http\Controllers;

use App\Models\Money;
use Illuminate\Http\Request;

class MoneyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-area');
    }

    public function index()
    {
        $money = Money::where('id', 1)->first();
        return view('money.index', compact('money'));
    }
    public function update($id)
    {
        $money = Money::findOrFail($id);

        $attributes = request([
            'money_usd', 'money_iqd'
        ]);

        $money->update($attributes);

        session()->flash('message', 'Todays Money Updated!');

        return redirect('/admin');
    }
}
