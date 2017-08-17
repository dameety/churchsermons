<?php

namespace App\Http\Controllers;

use App\Models\User;
use Stripe\Error\Card;
use App\Models\Setting;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Stripe;
use App\Services\StripeService;
use App\Repositories\User\UserRepository;
use App\Http\Requests\StripeServiceRequest;

class UsersController extends Controller
{

    protected $user;
    protected $setting;
    protected $stripeService;

    public function __construct(UserRepository $user, StripeService $stripeService)
    {
        \Debugbar::disable();
        
        $this->user = $user;
        $this->setting = Setting::first();
        $this->stripeService = $stripeService;
    }

    public function usersPage()
    {
        return view('admin.users.users');
    }

    public function profile()
    {
        return view('frontend.pages.profile', [
            'user' => $this->user->authUser(),
        ]);
    }

    public function profileUpdate(UserValidatonRequest $request)
    {
        if ($request->password !== null) {
            $this->user->updateWithPassword($request);
        } else {
            $this->user->update($request);
        }
        flash('Your profile has been updated successfully.');

        return back();
    }

    public function getUserCards()
    {
        $cards = $this->user->authUser()->getUserCards();
        if ($cards === '' || $cards === null) {
            return view('frontend.pages.nocard');
        } else {
            return view('frontend.pages.listcards', compact('cards'));
        }
    }

    public function getSubscription()
    {
        return view('frontend.pages.subscription');
    }

    public function upgradeAccount()
    {
        return view('frontend.payment.form', [
            'user' => $this->user->authUser(),
        ]);
    }

    public function upgradeAction(StripeServiceRequest $request)
    {
        $this->stripeService->addUserToSubscription($request);
        return response()->json(['created', true]);
    }

    public function cancelSubscription(StripeServiceRequest $request)
    {
        if ($request->deactivate) {
            $this->stripeService->cancelSubscription();
            flash('Successful Operation. Your subscription has been canceled.')->success()->important();

            return back();
        } else {
            flash('Unsuccessful Operation. Please choose yes to cancel your subscription.')->error()->important();

            return back();
        }
    }

    public function reactivateSubscription()
    {
        $this->stripeService->reactivateSubscription();
        return response()->json(['', true]);
    }

    public function updateCard(StripeServiceRequest $request, $id)
    {
        $this->stripeService->updateCard($request);
        flash('Successful Operation. Your card details has been updated.')->success()->important();

        return back();
    }

    public function deleteCard(Request $request, $id)
    {
        $user = Auth::user();
        $setting = Setting::first();

        $stripe = new Stripe($setting->api_key);

        try {
            $card = $stripe->cards()->delete($user->customer_id, $id);
            flash('Successful Operation. Your card has been deleted.')->success()->important();

            return back();
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            Session::flash('cardError', $e->getMessage());

            return back();
        } catch (\Cartalyst\Stripe\Exception\InvalidRequestException $e) {
            Session::flash('invalidRequest', $e->getMessage());

            return back();
        } catch (\Cartalyst\Stripe\Exception\ServerErrorException $e) {
            Session::flash('serverError', $e->getMessage());

            return back();
        }
    }

    public function deleteAccount()
    {
        return view('frontend.users.delete', [
            'user' => $this->user->authUser(),
        ]);
    }
}
