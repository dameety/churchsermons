@extends('frontend.layouts.master')

@section('title', 'Upgrade')

@section('content')

     <link rel="stylesheet" href="{{ URL::asset('/css/frontend/form.css') }}">


    <div class="container page-heading-container">

        <div class="row page-heading-box">
            <h2 class="page-heading">

            Confirm Account Upgrade

            </h2>
        </div>

    </div>


    <div id="container" class="container container-mobile">


        <div class="row content-block">

            <div class="col-sm-2">
            </div>


            {{-- right part --}}
            <div class="col-sm-10">

                <div class="form-group">

                    {{-- flash messages --}}
                    @include('flash::message')
                    {{--  form errors --}}
                    @include('frontend.partials._errors')



                </div>

                <div class="panel">

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

                </div>


            </div>


        </div>


    </div>

@stop

@section('scripts');

@stop