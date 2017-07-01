@extends('frontend.layouts.master')

@section('title', 'Login')

@section('content')

    <div  class="container-fluid login-container-body">

        <div class="container">

            <div class="login-body">

                <div class="row page-heeding-row">
                    <h1 class="login-heading"> Login </h1>
                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">

                        @include('frontend.partials._errors')

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Fill the form below to access your account
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}


                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <input id="email" type="email" class="form-control" name="email" placeholder="email address" value="{{ old('email') }}" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="col-md-12">
                                            <input id="password" type="password" class="form-control" name="password" placeholder="password" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-block btn-primary">
                                                Login
                                            </button>
                                        </div>
                                    </div>

                                    <a class="btn btn-block btn-primary" id="forgot-password" href="{{ route('password.request') }}" role="button"> Forgot Your Password? Click here </a>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection