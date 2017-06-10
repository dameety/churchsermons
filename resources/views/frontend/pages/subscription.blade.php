@extends('frontend.layouts.master')

@section('title', 'Card')

@section('content')
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/home.css') }}">

    <div class="container page-heading-container">

        <div class="row page-heading-box">
            <h2 class="page-heading">
                Subscription
            </h2>
        </div>

    </div>

    <div id="container" class="container container-mobile">

        <div class="row content-block">           

            <div class="col-sm-2 filter-box">
                    
                <a href="{{ route('userCards') }}" class="filters">
                    <h4> Cards </h4> 
                </a>
                <hr>
                <a href="{{ route('userSubscription') }}" class="filters">
                    <h4> <strong> Subscription </strong> </h4> 
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

                    {{-- subscription --}}
                    <form class="form" method="POST" action="{{ route('cancelSubscription') }}">
                    {{ csrf_field() }}

                        <h2> Subscription: <small>ACTIVE</small> </h2>
                        <hr>

                        <div class="form-group">
                            <label>Do you want to cancel your subscription?</label>

                            <select class="form-control" name="deactivate" required>
                                <option value=""></option>
                                <option value="no"> No  </option>
                                <option value="yes"> Yes  </option>
                            </select>

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Cancel My Subscription
                            </button>
                        </div>

                    </form>

                </div>
                
            </div>


        </div>
            

    </div>




@endsection