<?php

namespace App\Services;

use Stripe;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Setting\SettingRepository;

class StripeService
{
    protected $setting;

    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    public function createPlan($slug, $request)
    {
        Stripe::setApiKey(env('STRIPE_KEY'));

        Plan::create(array(
            'id'                   => $request->plan_id,
            'name'                 => $request->plan_name,
            'amount'               => $request->plan_amount,
            'currency'             => $request->plan_currency,
            'interval'             => $request->plan_interval
        )); 

        $this->setting->stripePlan($slug, $request);

        return response()->json(['created', true]);
    }

    public function addUserToSubscription($request)
    {
        $setting = $this->setting->first();
        Auth::user()->newSubscription('main', $setting->plan_interval)->create($request->stripeToken);
    }

    public function cancelSubscription()
    {
        Auth::user()->subscription('main')->cancel();
    }

    public function reactivateSubscription()
    {
        if (Auth::user()->subscription('main')->onGracePeriod()) {
            Auth::user()->subscription('main')->resume();
        } else {
            return redirect()->to('/upgradeAccount');
        }
    }

    public function getUserCards()
    {
        //
    }

    public function updateCard($request)
    {
        Auth::user()->updateCard($request->stripeToken);
    }
}
