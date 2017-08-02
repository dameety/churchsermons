@extends('frontend.layouts.base')

@section('title', 'Favourites')

@section('content')


    <div class="uk-section uk-section-small uk-section-muted">
        <div class="uk-container">
            
            <div class="columns">
                <div class="column is-10 rm-margin-bottom">
                    <h1><strong>Favourites</strong></h1>
                </div>
            </div>
            
        </div>
    </div>

    @include('frontend.partials._errors')


    <div id="pattern-bg" class="uk-section uk-section-medium uk-section-default">
        <div class="uk-container">
            
            <div class="columns">
                <div class="column is-10 uk-align-center">

                    <div class="uk-grid-match uk-child-width-1-3@m" uk-grid uk-grid-parallax>
                        
                        @foreach($sermons as $sermon)
                        <div>
                            <div uk-scrollspy="cls:uk-animation-fade; repeat: true">
                                <div class="uk-card uk-card-default">
                                    <div class="uk-card-media-top">
                                        <img src="/uploads/2.jpg" alt="">
                                    </div>

                                    <div class="topmost-bar-design"></div>
                                    <div class="uk-card-body">
                                        <p class="uk-card-title card-title">@truncate($sermon->title, 21)
                                        </p>
                                        <p class="card-date">
                                            <small class="uk-text-muted">Preached on: {{$sermon->created_at}}</small>
                                        </p>
                                    </div>

                                    <div class="uk-card-footer">
                                        <div class="columns">

                                            <div class="column">
                                                <a href="{{ route('download', [ $sermon->slug]) }}"><i class="fa fa-download fa-2x uk-align-center uk-margin-small-bottom uk-margin-small-top" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="column">
                                                <fav-button
                                                    sermon = {{ $sermon->slug }}
                                                ></fav-button>
                                            </div>
                                        
                                        </div>
                                    </div>
                                    <div class="topmost-bar-design"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
            

        </div>
    </div>

@endsection