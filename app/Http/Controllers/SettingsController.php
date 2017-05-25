<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = User::find(Auth::id());
        $invoices = $user->invoicesIncludingPending();
        return view('settings.billing.invoices', compact('invoices'));
    }

    public function plan()
    {
        $plans = Plan::all();
        $plan = Auth::user()->subscriptions;
        $user_plan = $plan[0];

        return view('settings.subscription.plan', compact('plans', 'user_plan'));
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
