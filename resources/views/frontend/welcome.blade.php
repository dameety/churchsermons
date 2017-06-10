@extends('frontend.layouts.master')

@section('title', 'Welcome')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('/css/frontend/welcome.css') }}">


    <div class="jumbotron">


        <div class="container">

            <div class="owl-carousel owl-theme">

                @foreach ($urls as $url)
                    <div class="slider-div">
                        <img src="{{ ($url) }}" class="sliderImage" alt="react native">
                    </div>
                @endforeach
        
            </div>

        </div>


    </div>

   

@stop


@section('scripts');

    

@stop
