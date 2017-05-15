<?php
/**
 * Created by PhpStorm.
 * User: dushaun
 * Date: 16/05/2017
 * Time: 00:10
 */

namespace App\Http\Controllers\Auth;

use Symfony\Component\HttpFoundation\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as Webhooks;

class WebhookController extends Webhooks
{

    /**
     * Handle a cancelled customer from a Stripe subscription.
     *
     * @param  array  $payload
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    protected function handleChargeFailed(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $user->subscriptions->filter(function ($subscription) use ($payload) {
                return $subscription->stripe_id === $payload['data']['object']['id'];
            })->each(function ($subscription) {
                $subscription->markAsCancelled();
            });
        }

        return new Response('Webhook Handled', 200);
    }

}