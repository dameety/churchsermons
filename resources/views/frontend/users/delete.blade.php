@extends('frontend.layouts.base')

@section('title', 'Delete')

@section('content')


    <section class="hero is-small is-muted uk-section-muted">
        <div class="hero-body rm-bottom-padding">
            <div class="container">

                <div class="columns">

                    <div class="column uk-align-center rm-bottom-margin">
                        <img class="profile-img uk-display-inline-block" src="/uploads/profile.jpg" alt="">
                    </div>
                    <div class="column is-6">
                        <h4 class="is-bold uk-margin-large-top uk-text-muted">{{ $user->name }}</h4>
                        <h2 class="subtitle">
                            {{ $user->email }}
                        </h2>
                    </div>
                    <div class="column"></div>
                </div>

            </div>
        </div>
    </section>


    <section class="section is-small user-metrics rm-padding">
        <div class="container">
            <div class="columns">

                <div class="column is-3"></div>

                <div class="column">
                    <div class="columns">

                        <div class="column is-4">
                            <h5 class="uk-align-center metric focus-color"><span class="uk-text-muted">Joined:</span> 3 years ago</h5>
                        </div>

                        <div class="column is-4">
                            <h5 class="uk-align-center metric focus-color"><span class="uk-text-muted">10</span> Total Downloads</h5>
                        </div>

                        <div class="column is-4">
                            <h5 class="uk-align-center metric focus-color"><span class="uk-text-muted">26</span> Favourites</h5>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="section is-medium">
        <div class="container">
            <div class="columns">

                <div class="column is-3">

                    <nav class="panel">
                        <a href="{{ route('profile') }}" class="panel-block">
                            <span class="panel-icon">
                                <i class="fa fa-book"></i>
                            </span>
                            Profile Info
                        </a>
                        <a href="{{ route('upgradeAccount') }}" class="panel-block">
                            <span class="panel-icon">
                                <i class="fa fa-book"></i>
                            </span>
                            Upgrade account
                        </a>
                        <a href="{{ route('deleteAccount') }}" class="panel-block is-active">
                            <span class="panel-icon">
                                <i class="fa fa-book"></i>
                            </span>
                            Delete account
                        </a>
                    </nav>

                </div>

                <div class="column">
                    <div class="containerd">

                        <div class="">
                            <p>
                                A lot of information. about account deleton. The user data will be deleted and this action is not reversible.

                                A lot of information. about account deleton. The user data will be deleted and this action is not reversible.

                            </p>
                        </div>

                        <form role="form" method="POST" action="{{ route('deleteAccountAction') }}">
                        {{ csrf_field() }}

                            <div class="field is-grouped uk-margin-top">
                                <div class="control">
                                    <button type="submit" class="button is-primary uk-margin-small-right">Delete account</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>



@endsection