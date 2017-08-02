@extends('frontend.layouts.base')

@section('title', 'Register')


@section('content')


    <section class="hero is-small">
            <div class="hero-body">
                <div class="container">

                    <div class="column has-text-centered">
                        <h1 class="title is-3 uk-text-success">
                            Fill the form below to get an account
                        </h1>
                    </div>

                    <div class="column is-8 uk-align-center">

                        @include('frontend.partials._errors')

                        <form role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                            <div class="field">
                                <label class="label">Name</label>
                                <div class="control has-icons-left">
                                    <input class="input {{ $errors->has('name') ? ' is-danger' : '' }}" type="text" name="name" value="{{ old('name') }}" required autofocus>
                                    <span class="icon is-left">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control has-icons-left">
                                    <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" value="{{ old('email') }}" required autofocus>
                                    <span class="icon is-left">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control has-icons-left">
                                    <input class="input {{ $errors->has('password') ? ' has-error' : '' }}" type="password" name="password" required>
                                    <span class="icon is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Confirm Password</label>
                                <div class="control has-icons-left">
                                    <input class="input {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" type="password" name="password_confirmation" required>
                                    <span class="icon is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                            </div>


                            <div class="field is-grouped uk-margin-top">
                                <div class="control">
                                    <button type="submit" class="button is-primary uk-margin-small-right">Create Account</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
    </section>

@endsection