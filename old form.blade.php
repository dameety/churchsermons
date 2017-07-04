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
                {{-- <div class="panel">

                    <form role="form" method="POST" action="{{ route('upgradeAction') }}">
                    {{ csrf_field() }}

                        <div class="form-group">
                            <label for="Card Number">Card Number: 4242424242424242 </label>
                            <input type="text" name="cardNumber" class="form-control" maxlength="25" required>
                        </div>


                        <div class="row">

                            <div class="form-group col-sm-6 {{ $errors->has('expiryMonth') ? ' has-error' : '' }}">
                                <label for="expiryMonth">Expiry Month: choose june</label>

                                <select class="form-control" name="expiryMonth" required>
                                    <option value=""></option>
                                    <option value="1"> January  </option>
                                    <option value="2"> February  </option>
                                    <option value="3"> Match  </option>
                                    <option value="4"> April  </option>
                                    <option value="5"> May  </option>
                                    <option value="6"> June  </option>
                                    <option value="7"> July  </option>
                                    <option value="8"> August  </option>
                                    <option value="9"> September  </option>
                                    <option value="10"> October  </option>
                                    <option value="11"> November  </option>
                                    <option value="12"> December  </option>
                                </select>
                            </div>

                            <div class="form-group col-sm-3">
                                <label for="expiryYear">Expiry Year: 2017</label>
                                <input type="text" name="expiryYear" class="form-control" minlength="4" maxlength="4" required>
                            </div>

                            <div class="form-group col-sm-3">
                                <label for="Cvv">Cvv:314</label>
                                <input type="text" name="cvv" class="form-control" minlength="3" maxlength="3" required>
                            </div>

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary"> Upgrade My Account </button>
                        </div>

                    </form>

                </div> --}}

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


{{--             <div class="col-sm-2">
            </div>


            <div class="col-sm-10">

                <div class="form-group">

                    @include('flash::message')
                    @include('frontend.partials._errors')

                </div>

            </div> --}}

        {{-- </div> --}}

    </div>

@endsection


@section('scripts');
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('/js/frontend/payment-page.js') }}"></script>
@endsection