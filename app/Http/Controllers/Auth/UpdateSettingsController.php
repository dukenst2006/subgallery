<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UpdateEmail;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\UpdateUsername;
use App\Plan;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateSettingsController extends Controller
{
    /**
     * Update user's username
     *
     * @param UpdateUsername $request
     */
    public function username(UpdateUsername $request)
    {
        $user = User::find($request->id);
        $user->username = $request->username;
        $user->save();
    }

    /**
     * Update user's email address
     * TODO Email Notification and Verification
     *
     * @param UpdateEmail $request
     */
    public function email(UpdateEmail $request)
    {
        $user = User::find($request->id);
        $user->email = $request->email;
        $user->save();
    }

    /**
     * Update user's password
     *
     * @param UpdatePassword $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(UpdatePassword $request)
    {
        $user = User::find($request->id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            return response()->json(["old_password" => ["The old password given doesn't match out copy"]], 422);
        }
    }

    /**
     * Update user's card credentials
     * TODO Email Notification to user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function card(Request $request)
    {
        try {
            $user = User::find($request->id);
            $token = $request->stripeToken;

            $user->updateCard($token);
        } catch (\Exception $e) {
            return response()->json(['status' => [$e->getMessage()]], 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invoices(Request $request)
    {
        $user = User::find($request->id);
        dd($user);
        $invoices = $user->json_invoices;

        return response()->json([
            'invoices' => $invoices
        ], 200);
    }

    /**
     * Swap a user's plan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function plan(Request $request)
    {
        $user = User::find($request->id);
        $plan = Plan::findByName($request->plan);

        if ($user->subscriptions[0]['stripe_plan'] !== $plan->name) {
            $user->subscription('primary')->swap($plan->name);
        } else {
            return response()->json(['status' => ['You\'re already subscribed to that plan']], 422);
        }
    }

    /**
     * Cancel user's subscription
     *
     * @param Request $request
     */
    public function cancel(Request $request)
    {
        $user = User::find($request->id);
        $user->subscription('primary')->cancel();
    }

    /**
     * Resume user's subscription
     *
     * @param Request $request
     */
    public function resume(Request $request)
    {
        $user = User::find($request->id);
        $user->subscription('primary')->resume();
    }
}
