@extends('frontend.layouts.master')

@section('title', 'Welcome')

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/unslider.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/unslider-dots.css') }}">
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

            <h1>Latest Uploads...</h1>
            <br>

            <div class="uk-grid-match uk-child-width-1-3@m" uk-grid>
                <div>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="/uploads/2.jpg" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">Media Top</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                            </div>
                            <div class="uk-card-footer uk-card-hover">
                                <a href="#" class="uk-button uk-button-text">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="/uploads/2.jpg" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">Media Top</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                            </div>
                            <div class="uk-card-footer uk-card-hover">
                                <a href="#" class="uk-button uk-button-text">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-media-top">
                                <img src="/uploads/2.jpg" alt="">
                            </div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">Media Top</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                            </div>
                            <div class="uk-card-footer uk-card-hover">
                                <a href="#" class="uk-button uk-button-text">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <li>
                        <blockquote cite="#">
                            <p class="uk-margin-small-bottom">The blockquote element represents content that blockquote element represents content that is quoted from another source, optionally with a citation which must be within a footer or cite element.</p>
                            <footer>Someone famous in <cite><a href="#">Source Title</a></cite></footer>
                        </blockquote>
                    </li>
                    <li>
                        <blockquote cite="#">
                            <p class="uk-margin-small-bottom">The blockquote element represents content blockquote element represents content that that is quoted from another source, optionally with a citation which must be within a footer or cite element.</p>
                            <footer>Someone famous in <cite><a href="#">Source Title</a></cite></footer>
                        </blockquote>
                    </li>
                    <li>
                        <blockquote cite="#">
                            <p class="uk-margin-small-bottom">The blockquote element represents content that blockquote element represents content that is quoted from another source, optionally with a citation which must be within a footer or cite element.</p>
                            <footer>Someone famous in <cite><a href="#">Source Title</a></cite></footer>
                        </blockquote>
                    </li>
                </ul>
            </div>

        </div>
    </div>

@endsection


@section('scripts');
    <script src="{{ URL::asset('/js/frontend/unslider-min.js') }}"></script>
    <script src="{{ URL::asset('/js/frontend/unslider-config.js') }}"></script>
@endsection