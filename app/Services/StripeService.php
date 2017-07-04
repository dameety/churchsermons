<?php

namespace App\Services;

use Stripe;

class StripeService
{
    public function createPlan($request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_KEY'));

            Plan::create(array(
              'id'                   => $request->plan_id,
                'name'                 => $request->plan_name,
                'amount'               => $request->plan_amount,
                'currency'             => $request->plan_currency,
                'interval'             => $request->plan_interval,
            );
        } catch (Exception $e) {
            //
        }
    }

    public function cancelSubscription()
    {
        //
    }

    public function addUserToSubscription()
    {
        //
    }

    public function reactivateSubscription()
    {
        //
    }

    public function getUserCards()
    {
        //
    }

    public function updateCard()
    {
        //
    }
}
