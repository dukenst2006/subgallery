<?php

namespace App\Http\Controllers;

use App\Plan;
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
        $this->middleware('subscribed')->except('account', 'card');
    }

    public function account()
    {
        return view('settings.account');
    }

    /**
     * Return page for card options.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function card()
    {
        return view('settings.billing.card');
    }

    public function invoices()
    {
        return view('settings.billing.invoices');
    }

    public function plan()
    {
        $plans = Plan::all();

        return view('settings.subscription.plan', compact('plans'));
    }

    public function cancel()
    {
        return view('settings.subscription.cancel');
    }

    public function resume()
    {
        return view('settings.subscription.resume');
    }
}
