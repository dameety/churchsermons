@extends('frontend.layouts.master')

@section('title', 'Profile2')

@section('content')
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/home.css') }}">

    <div class="container page-heading-container">

        <div class="row page-heading-box">
            <h2 class="page-heading">
                Profile for: <small>{{Auth::user()->name}}</small>
            </h2>
        </div>

    </div>

    <div id="container" class="container container-mobile">

        <div class="row content-block">           

            <div class="col-sm-2 filter-box">
                    
                <a href="#" class="filters">
                    <h4> Profile </h4> 
                </a>
                <hr>
                <li class="{{ isActiveURL('/user/cards') }}">
                    <a href="{{ route('userCards') }}" class="filters">
                        <h4> Cards </h4> 
                    </a>
                </li>
                <hr>
                <a href="#" class="filters">
                    <h4> Subscription </h4> 
                </a>

            </div>



            {{-- right part --}}
            <div class="col-sm-10 sermon-col">

                <div class="form-group">

                    {{-- flash messages --}}
                    @include('flash::message')
                    {{-- the filter for responsive view --}}
                    @include('frontend.partials.filters')
                
                </div>
                

                <div class="panel">

                    {{-- Don not show this if cards = 0 --}}
                    <h2> Cards <small type="button" class="btn btn-primary" data-toggle="modal" data-target="#newCardModal"> + Add new card </small> </h2>
                    <br>

                    {{-- new card modal --}}
                    <div class="modal" id="newCardModal" tabindex="-1" role="dialog" aria-labelledby="new Card Modal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Insert Card Details</h4>
                                    <hr>
                                </div>
                                <div class="modal-body">
                                    <form role="form" method="POST" action="{{ route('newCard') }}">
                                    {{ csrf_field() }}

                                        <div class="form-group">
                                            <label for="Card Number">Card Number</label>
                                            <input type="text" name="cardNumber" minlength="5" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="Expiry year">Expiry year</label>
                                            <input type="text" name="expiryYear" maxlength="4" minlength="4" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="Expiry month">Expiry month</label>
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

                                        <div class="form-group">
                                            <label for="Cvc">Cvc</label>
                                            <input type="text" name="cvc" maxlength="3" minlength="3" class="form-control">
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-primary">Add this Card</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- listing all cards --}}
                    <div uk-grid>
                        @foreach ( $cards['data'] as $card )
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <div class="uk-card-body uk-text-center">
                                    <p><strong>Last 4 digits:</strong> {{ $card['last4'] }}</p>
                                    <p><strong>Expiry month:</strong> {{ $card['exp_month'] }}</p>
                                    <p><strong>Expiry year:</strong> {{ $card['exp_year'] }}</p>
                                </div>
                                <div class="uk-card-footer uk-text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> Update Card</button>
                                    <br>
                                    <form role="form" method="POST" action="{{ route('deleteCard', [ $card['id'] ]) }}">
                                    {{ csrf_field() }}
                                        <br>
                                        <button type="submit" class="btn btn-danger">Delete Card</button>
                                    </form>
                                </div>
                            </div>

                            <!-- update card Modal -->
                            <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Edit Card</h4>
                                            <hr>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ route('updateCard', [ $card['id'] ] ) }}">
                                            {{ csrf_field() }}

                                                <div class="form-group">
                                                    <label for="Expiry year">Expiry year</label>
                                                    <input type="text" name="exp_year" class="form-control" value="{{ $card['exp_year'] }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="Expiry month">Expiry month</label>
                                                    <input type="text" name="exp_month" class="form-control" value="{{ $card['exp_month'] }}">
                                                </div>

                                                <hr>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-block btn-primary">Save Changes</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                 </div>
                            </div>

                        </div>
                        
                    </div>


                </div>
                
            </div>


        </div>
            

    </div>




@endsection