@extends('frontend.layouts.master')

@section('title', 'Card')

@section('content')
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/home.css') }}">

    <div class="container page-heading-container">

        <div class="row page-heading-box">
            <h2 class="page-heading">
                Cards
            </h2>
        </div>

    </div>

    <div id="container" class="container container-mobile">

        <div class="row content-block">           

            <div class="col-sm-2 filter-box">
                    
                <a href="{{ route('userCards') }}" class="filters">
                    <h4> <strong>Cards</strong> </h4> 
                </a>
                <hr>
                <a href="{{ route('userSubscription') }}" class="filters">
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
                

                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <span uk-icon="icon: info; ratio: 5"></span>
                    </div>
                </div>

                <br>
                
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        
                        <p class="no-sermon">
                            You have no card on this account.
                        </p>

                    </div>
                </div>

                
            </div>


        </div>
            

    </div>




@endsection