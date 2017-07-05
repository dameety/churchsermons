@extends('frontend.layouts.master')

@section('title', 'Upgrade')

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/payment-page.css') }}">
@endsection

@section('content')


    <div class="container page-heading-container">

        <div class="row page-heading-box">
            <h2 class="page-heading">

                Account Upgrade

            </h2>
        </div>

    </div>


    <div id="container" class="container container-mobile">

        <div class="col-md-8 col-md-offset-2">

            <form role="form" method="POST" action="{{ route('upgradeAction') }}">
            {{ csrf_field() }}

                <input name="stripeToken" type="hidden" type="text"/>

                <div class="group">
                    <label>
                        <span>Name on card</span>
                        <input name="cardholder-name" class="field" placeholder="Jane Doe" required/>
                    </label>
                </div>

                <div class="group">
                    <label>
                        <span>Card Details</span>
                        <div id="card-element" class="field"></div>
                    </label>
                </div>

                <div class="outcome">
                    <div class="error" role="alert"></div>
                </div>

                <button id="pay-button" type="submit">Pay $25</button>


            </form>

        </div>

   </div>

@endsection


@section('scripts');
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('/js/frontend/payment-page.js') }}"></script>
@endsection