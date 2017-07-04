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

            <form>
                <div class="group">
                    <label>
                        <span>Name</span>
                        <input name="cardholder-name" class="field" placeholder="Jane Doe" />
                    </label>
                </div>
                <div class="group">
                    <label>
                        <span>Card</span>
                        <div id="card-element" class="field"></div>
                    </label>
                </div>
                <button type="submit">Pay $25</button>
                <div class="outcome">
                    <div class="error" role="alert"></div>
                    <div class="success">
                        Success! Your Stripe token is <span class="token"></span>
                    </div>
                </div>
            </form>

        </div>

   </div>

@endsection


@section('scripts');
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('/js/frontend/payment-page.js') }}"></script>
@endsection