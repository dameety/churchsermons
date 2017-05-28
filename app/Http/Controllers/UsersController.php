<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Setting;
use Validator;
use App\User;
use Redirect;
use Session;
use Input;
use Auth;
use DB;
use Hash;
use Cartalyst\Stripe\Stripe;
use Stripe\Error\Card;
use Exception;



class UsersController extends Controller
{
    
    private $email;
    private $plan;
    private $stripe; 
    private $user_card_id;
    private $setting;
    private $user;

    public function __construct( ) {

        $setting = Setting::first();
        $this->user = Auth::user();
        $this->setting = Setting::first();
        $this->plan = $setting->plan_id;
        $this->stripe = new Stripe($setting->api_key);

    }

    public function usersPage () {
        return view('admin.users.users');

    }

    public function profile () {
        $user = Auth::user();
        return view('frontend.pages.profile', compact('user'));       
    }


    public function profileUpdate (Request $request) {

        $this->validate($request, [
            'name' => 'required|string',
        ]);

        $user = User::whereId(Auth::id())->first();            

        if ( $request->password !== null ) {    

            $user->name = $request->name;
            $user->email = Auth::user()->email;
            $user->password = Hash::make($request->password);
            $user->save();
            flash('Your profile has been updated successfully.');
            return back();

        } else if ( $request->password === null ) {

            $user->name = $request->name;
            $user->email = Auth::user()->email;
            $user->save();
            flash('Your profile has been updated successfully.');
            return back();

        }

    }

    public function getUserCards () {

        $cards = User::getUserCards();
        if( $cards === "" || $cards === null ) {
            return view('frontend.pages.nocard');
        } else {
            return view('frontend.pages.listcards', compact('cards'));
        }

    }

    public function getSubscription () {
        return view('frontend.pages.subscription');
    }

    public function createTokenFromCard ( $request ) {

        $token = $this->stripe->tokens()->create([
            'card' => [

                'number'    => $request->cardNumber,
                'exp_month' => $request->expiryMonth,
                'exp_year'  => $request->expiryYear,
                'cvc'       => $request->cvv,

            ],
        ]);
        $this->user_card_id = $token['card']['id'];
        return $token['id'];

    }


    public function createACustomer () {
        $user = Auth::user();
        $customer = $this->stripe->customers()->create([
            'email' => $user->email,
        ]);

        return $customer['id'];
    }


    public function createSubscription ($customerId, $token) {

        $subscription = $this->stripe->subscriptions()->create($customerId, [
            'plan' => $this->plan,
            'card' => $token
        ]);

        return $subscription['id'];
    }


    public function updateUserDetails ($customerId, $subscription) {

        $user = Auth::user();
        $user->card_id = $this->user_card_id;
        $user->customer_id = $customerId;
        $user->subscription_id = $subscription;
        $user->subscriptionStatus = "active";
        $user->permission = $this->plan;
        
        //notifiy admin or
        // use a loging package to log it
        // show the log to admin
        $user->save();

    }


    public function upgradeAccount () {
        return view('frontend.payment.form');
    }


    public function upgradeAction (Request $request) {

        $this->validate($request, [
            'cardNumber' => 'required',
            'expiryMonth' => 'required|numeric',
            'expiryYear' => 'required|digits:4',
            'cvv' => 'required|digits:3',
        ]);

        try {
            //create a token
            $token = $this->createTokenFromCard($request);

            if (!isset($token)) {
                flash('Unsuccessful Operation. The payment token was not generated correctly. Please try again.')->error()->important();
                return back();
            }

            // create customer
            $customerId = $this->createACustomer();

            if (!isset($customerId)) {
                flash('Unsuccessful Operation. There was an issue creating your subscription accoount. Please try again.')->error()->important();
                return back();
            }

            // create subscription for the user
            $subscription = $this->createSubscription($customerId, $token);

            if (isset($subscription)) {
                
                // update the user database
                $this->updateUserDetails($customerId, $subscription);
  
                flash('Successful Operation. Your account has been successfully upgraded. Enjoy.')->success()->important();
                return back();

            } else {

                flash('Unsuccessful Operation. There was an issue upgrading your account. Please try again.')->error()->important();
                return back();

            }

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

        
    } // END OF THE CONTROLLER


    public function cancelSubscription (Request $request) {

        $user = Auth::user();
        $setting = Setting::first();
        // validate user input
        $this->validate($request, [
            'deactivate' => 'required',
        ]);

        if ( $user->subscriptionStatus === "cancelled" ) {

            flash('Unsuccessful Operation. You have no active subscription to cancel.')->error()->important();
            return back();

        }
        if( $request->deactivate === "yes" ) {
            //cancel sub
            $stripe = new Stripe($setting->api_key);
            try {

                $subscription = $stripe->subscriptions()->cancel($user->customer_id, $user->subscription_id);
                // upate user back to Standard user
                $user->permission = "Standard";
                $user->subscriptionStatus = "cancelled";
                //notifiy admin or
                // use a loging package to log it
                // show the log to admin
                $user->save();

                flash('Successful Operation. Your subscription has been canceled.')->success()->important();
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

        } else {
            flash('Unsuccessful Operation. Please choose yes to cancel your subscription.')->error()->important();
            return back();
        }


    }


    public function reactivateSubscription () {

        $user = Auth::user();
        $setting = Setting::first();

        $stripe = new Stripe($setting->api_key);

        try {
    
            // get the subscription and check if its still active
            $subscription = $stripe->subscriptions()->find($user->customer_id, $user->subscription_id);
            if( $subscription['status'] === "active" ) {
                
                $subscription = $stripe->subscriptions()->reactivate($user->customer_id, $user->subscription_id);

                // upgrade user to plan
                $user->permission = $setting->plan_name;
                $user->subscriptionStatus = "active";
                $user->save();


            } else {
                // create a new one if its not active how
                // check if user has a card on site
                $customer = $stripe->customers()->find($user->customer_id);
                $cardId = $customer['default_source'];
                if( isset($cardId ) ) {
                    // create new subscription using the found card
                    $subscription = $stripe->subscriptions()->create($user->customer_id, [
                        'plan' => $setting->plan_id,
                    ]);
                    // if created successfully...
                    if (isset($subscription['id'])) {
                
                        // update the user database
                        $user = Auth::user();
                        $user->subscription_id = $subscription['id'];
                        $user->subscriptionStatus = "active";
                        $user->permission = $setting->plan_name;
                        $user->save();

                        flash('Successful Operation. Your account has been successfully reactivated. Enjoy.')->success()->important();
                        return back();

                    } else {

                        flash('Unsuccessful Operation. There was an issue reactivating your account. Please try again.')->error()->important();
                        return back();

                    }


                } else { // do this if $cardId is not set .. 
                    return redirect(route('upgradeAccount'));
                }


            }


            flash('Successful Operation. Your subscription has been reactivated. Enjoy.')->success()->important();
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



    public function updateCard (Request $request, $id) {

        // validate user input
        $this->validate($request, [
            'exp_year' => 'required',
            'exp_month' => 'required'
        ]);


        $user = Auth::user();
        $setting = Setting::first();

        $stripe = new Stripe($setting->api_key);

        try {
    
            $card = $stripe->cards()->update($user->customer_id, $id, [
                'exp_year' => $request->exp_year,
                'exp_month' => $request->exp_month,
            ]);


            flash('Successful Operation. Your card details has been updated.')->success()->important();
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


    public function deleteCard (Request $request, $id) {


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


    public function newCard (Request $request) {

        // validate user input
        $this->validate($request, [
            'cardNumber' => 'required',
            'expiryMonth' => 'required|numeric',
            'expiryYear' => 'required|digits:4',
            'cvc' => 'required|digits:3',
        ]);

        
        //get stripe key from settings
        $setting = Setting::first();
        $stripe = new Stripe($setting->api_key);


        try {

            $token = $stripe->tokens()->create([
                'card' => [

                    'number'    => $request->cardNumber,
                    'exp_month' => $request->expiryMonth,
                    'exp_year'  => $request->expiryYear,
                    'cvc'       => $request->cvc,

                ],
            ]);

            if (!isset($token['id'])) {
                flash('Unsuccessful Operation. There was an issue creating your card token. Please try again.')->error()->important();
                return back();
            }

            // create the card
            $card = $stripe->cards()->create($user->customer_id, $token['id']);

            if (isset($card['id'])) {
                flash('Successful Operation. Your card has been added.')->success()->important();
                return back();
            }
            
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


}
