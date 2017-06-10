@extends('frontend.layouts.master')

@section('title', 'Contact')

@section('content')

    @if (count($errors) > 0)
        <div class="ui error message">
            @foreach ($errors -> all() as $error)
                <strong> <li> {{$error}} </li> </strong>
            @endforeach
        </div>
    @endif

    @if (Session::has('contactMessageSent'))
        <div class="card-block">
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{!! Session::get('contactMessageSent') !!}</p>
            </div>
        </div>
    @endif


@stop


@section('scripts');


@stop