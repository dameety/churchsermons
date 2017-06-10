@extends('frontend.layouts.master')

@section('title', 'Profile')

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
                    
                <a href="{{ route('userCards') }}" class="filters">
                    <h4> Cards </h4> 
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
                

                {{-- profile form --}}
                <form role="form" method="POST" action="{{ route('profileUpdate', [$user->slug]) }}">
                {{ csrf_field() }}
                    
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" name="email" class="form-control" value="{{ $user->email }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="permission">Permision level</label>
                        <input type="text" name="permission" class="form-control" value="{{ $user->permission }}" disabled>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="password">Password <small>(please leave blank to retain your current password)</small></label>
                        <input type="password" name="password" class="form-control">
                    </div>

                        <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>

                </form>

                
            </div>


        </div>
            

    </div>




@endsection