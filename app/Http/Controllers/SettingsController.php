<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('subscribed')->except('card');
    }

    /**
     * Return page for card options.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function card()
    {
        $subscribed = User::find(5)->subscribed('premium');
        dd($subscribed);

        return view('settings.subscription.card');
    }
}
