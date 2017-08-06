@extends('frontend.layouts.base')

@section('title', 'My Account')

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


    <section class="section is-small">
        <div class="container">
            <div class="columns">

                <div class="column is-3">
                    <p>Menu wll be here
                    </p>
                </div>

                <div class="column">
                    <div class="columns">

                        <h1>all content will be here</h1>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <div id="pattern-bg" class="uk-section uk-section-medium uk-section-default uk-margin-large-bottom">
        <div class="uk-container uk-margin-large-bottom">
            
            <div class="columns uk-margin-bottom">
                <div class="column is-10 uk-align-center">

                </div>
            </div>
            
        </div>
    </div>

@endsection