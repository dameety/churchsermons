@extends('frontend.layouts.base')

@section('title', 'Reset Password')

@section('content')

    <section class="hero is-small">
        <div class="hero-body">
            <div class="container">

                <div class="column has-text-centered">
                    <h1 class="title is-3 uk-text-success">
                        Reset Password
                    </h1>
                </div>

                <div class="column is-8 uk-align-center">

                    @include('frontend.partials._errors')

                    <form role="form" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                        <div class="field">
                            <label class="label">Enter your email address</label>
                            <div class="control has-icons-left">
                                <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}" type="email" name="email" required autofocus>
                                <span class="icon is-left">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field is-grouped uk-margin-top">
                            <div class="control">
                                <button type="submit" class="button is-primary uk-margin-small-right">Proceed</button>
                            </div>
                            <div class="control uk-margin-small-top">
                                <a class="" href="{{ URL::previous() }}">Back to login</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>


@endsection