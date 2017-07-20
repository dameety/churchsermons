lara@extends('frontend.layouts.master')

@section('title', 'Register')


@section('content')


    <div class="container-fluid register-container-body">
        
        <div class="container">
                

            <div class="register-body">

                <div class="row page-heeding-row">    
                    <h1 class="register-heading"> Register </h1>
                </div>


                <div class="row">
                    <div class="col-md-6 col-md-offset-3">

                        @include('frontend.partials._errors')

                        <div class="panel panel-default panel-color">
                            <div id="panel-color" class="panel-heading panel-color"> Fill the form below to get an account </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <input id="name" type="text" class="form-control panel-color" name="name" placeholder="name" value="{{ old('name') }}" required autofocus>

                                        </div>
                                    </div>


                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control panel-color" name="email" placeholder="email address" value="{{ old('email') }}" required autofocus>

                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control panel-color" name="password" placeholder="password" required>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input id="password-confirm" type="password" class="form-control panel-color" name="password_confirmation" placeholder="Confirm password" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-block btn-primary register-btn">
                                                Register
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            

            </div>

        </div>


    </div>



@endsection