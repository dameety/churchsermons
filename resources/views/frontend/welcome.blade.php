@extends('frontend.layouts.base')

@section('title', 'Welcome')

@section('styles')

    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/unslider.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/unslider-dots.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/welcome.css') }}">

@endsection

@section('content')

    {{-- slider --}}
    <div class="banner">
        <ul>
            <li>
                <div class="uk-section uk-section-large uk-dark uk-background-cover" style="background-image: url(/uploads/2.jpg)">
                    <div class="uk-container">

                        <h1 class="title uk-text-bold">Section</h1>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>

                    </div>
                </div>
            </li>
            <li>
                <div class="uk-section uk-section-large uk-dark uk-background-cover" style="background-image: url(/uploads/2.jpg)">
                    <div class="uk-container">

                        <h1 class="title uk-text-bold">Section</h1>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>

                    </div>
                </div>
            </li>
            <li>
                <div class="uk-section uk-section-large uk-dark uk-background-cover" style="background-image: url(/uploads/2.jpg)">
                    <div class="uk-container">

                        <h1 class="title uk-text-bold">Section</h1>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>

                    </div>
                </div>
            </li>
        </ul>
    </div>

    
    <div id="latest-uploads" class="uk-section uk-section-medium uk-section-default">
        <div class="uk-container">
            
            <div class="columns">
                <div class="column is-10 uk-align-center">
                    <h1 class="title uk-text-bold uk-text-muted uk-margin-large-bottom" uk-scrollspy="cls:uk-animation-fade; repeat: true">
                    Recent Uploads...
                    </h1>

                    <div class="uk-grid-match uk-child-width-1-3@m" uk-grid>
                        
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


    <div id="testimonials" class="uk-section uk-section-medium uk-light testimonials-bg">
        <div class="uk-container">
            <div class="columns">
                <div class="column is-10 uk-align-center">
                    <h1 class="title uk-text-bold head">Testimonials</h1>
                    <br>
                    <div class="testimonials">
                        <ul>
                            @foreach($testimonials as $testimonial)
                                <li>
                                    <blockquote cite="#">
                                        <p class="uk-margin-small-bottom sub">
                                            {{ $testimonial->body }}
                                        </p>
                                        <footer>
                                            {{$testimonial->name}}
                                            <cite>
                                                <a href="#" class="sub">{{ $testimonial->location }}</a>
                                            </cite>
                                        </footer>
                                    </blockquote>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script src="{{ asset('/js/frontend/unslider-min.js') }}"></script>
    <script src="{{ asset('/js/frontend/unslider-config.js') }}"></script>
@endsection
