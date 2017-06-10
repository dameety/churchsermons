@extends('frontend.layouts.master')

@section('title', 'Reset Form')


@section('content')


    <div class="container-fluid reset-container-body">
        
        <div class="container">
                

            <div class="resets-body">

                <div class="row page-heeding-row">    
                    <h1 class="reset-heading"> Reset Password </h1>
                </div>


                <div class="row">
                    <div class="col-md-6 col-md-offset-3">


                        @include('frontend.partials._errors')


                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Fill the form below to reset your password.
                            </div>
                            
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                                    {{ csrf_field() }}

                                    <input type="hidden" name="token" value="{{ $token }}">


                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" placeholder="email address" value="{{ $email or old('email') }}" required autofocus>

                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control" name="password" placeholder="password" required>

                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-block btn-primary register-btn">
                                                Reset Password
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