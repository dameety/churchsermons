@extends('frontend.layouts.master')

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

                        <h1>Section</h1>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>

                    </div>
                </div>
            </li>
            <li>
                <div class="uk-section uk-section-large uk-dark uk-background-cover" style="background-image: url(/uploads/2.jpg)">
                    <div class="uk-container">

                        <h1>Section</h1>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>

                    </div>
                </div>
            </li>
            <li>
                <div class="uk-section uk-section-large uk-dark uk-background-cover" style="background-image: url(/uploads/2.jpg)">
                    <div class="uk-container">

                        <h1>Section</h1>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>

                    </div>
                </div>
            </li>
        </ul>
    </div>

    
    {{-- latest uploads --}}
    <div id="latest-uploads" class="uk-section uk-section-large uk-section-default">
        <div class="uk-container">

            <h1>Recent Uploads...</h1>
            <br>

            <div class="uk-grid-match uk-child-width-1-3@m" uk-grid>
                
                @foreach($sermons as $sermon)
                <div>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="/uploads/2.jpg" alt="">
                            </div>
                            <div class="topmost-bar-design"></div>
                            <div class="uk-card-body">

                                <p class="uk-card-title">@truncate($sermon->title, 21) <br> <small>Preached on: {{$sermon->created_at}}</small></p>
                            
                            </div>
                            <div class="uk-card-footer">
                          
                                <div class="col-sm-6 clickable" style="display:flex;justify-content:center;align-items:center;">
                                        <a href="{{ route('download', [ $sermon->slug]) }}"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
                                    </form>
                                
                                </div>

                                <div onclick="favouriteSermon()" class="col-sm-6 clickable" style="display:flex;justify-content:center;align-items:center;">
                                    <form method="POST" action="{{ route('favourite', [ $sermon->slug]) }}">
                                    {{ csrf_field() }}

                                        <i class="favourite fa fa-heart fa-2x" aria-hidden="true"></i>                                    
                                    </form>
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


    {{-- testimonials --}}
    <div id="testimonials" class="uk-section uk-section-large uk-light uk-section-primary">
        <div class="uk-container">

            <h1>Testimonials</h1>
            <br>
            <div class="testimonials">
                <ul>
                    @foreach($testimonials as $testimonial)
                        <li>
                            <blockquote cite="#">
                                <p class="uk-margin-small-bottom">
                                {{ $testimonial->body }}</p>
                                <footer> {{$testimonial->name}} <cite><a href="#">{{ $testimonial->location }}</a></cite></footer>
                            </blockquote>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

@endsection


@section('scripts');
    <script src="{{ URL::asset('/js/frontend/unslider-min.js') }}"></script>
    <script src="{{ URL::asset('/js/frontend/unslider-config.js') }}"></script>
@endsection
