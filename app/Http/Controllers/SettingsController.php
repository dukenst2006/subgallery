<?php

namespace App\Http\Controllers;

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
        return view('settings.subscription.card');
    }
}
