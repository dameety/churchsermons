@extends('frontend.layouts.base')

@section('title', 'Login')

@section('content')


    <section class="hero is-small">
        <div class="hero-body">
            <div class="container">

                <div class="column has-text-centered">
                    <h1 class="title is-3 uk-text-success">
                        Login To Your Account.
                    </h1>
                </div>

                <div class="column is-8 uk-align-center">

                    @include('frontend.partials._errors')

                    <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" required autofocus>
                                <span class="icon is-left">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control has-icons-left">
                                <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="password" name="password" required>
                                <span class="icon is-left">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field uk-margin-top">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="field is-grouped uk-margin-top">
                            <div class="control">
                                <button type="submit" class="button is-primary uk-margin-small-right">Proceed</button>
                            </div>
                            <div class="control uk-margin-small-top">
                                <a class="" href="{{ route('password.request') }}">Forgot Your Password?</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection