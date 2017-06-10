@extends('frontend.layouts.master')

@section('title', 'Sermons')

@section('content')
    <link rel="stylesheet" href="{{ URL::asset('/css/frontend/home.css') }}">

    <div class="container page-heading-container">

        <div class="row page-heading-box">
            @if($key === "category")
                <h2 class="page-heading">

                Browsing Category: {{ $slug }}

                </h2>
            @elseif($key === "service")
                <h2 class="page-heading">
                    Browsing Service: {{ $slug }}
                </h2>
            @endif
        </div>

    </div>

    <div id="container" class="container container-mobile">
        

        <div class="row content-block">
            
            {{-- left part --}}
            @include('frontend.partials.filters-desktop')
            


            {{-- right part --}}
            <div class="col-sm-10 sermon-col">

                <div class="form-group">


                    {{-- flash messages --}}
                    @include('flash::message')
                    {{-- the filter for responsive view --}}
                    @include('frontend.partials.filters')
                

                </div>

                @if($sermonCount === 0)

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <span uk-icon="icon: info; ratio: 5"></span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            @if($key === "category")
                            <p class="no-sermon">
                                No sermons in this category
                            </p>
                            @elseif($key === "service")
                            <p class="no-sermon">
                                No sermons for this service
                            </p>
                            @endif
                        </div>
                    </div>
                            
                @endif

                @foreach ($sermons as $sermon)

                    @include('frontend.partials.sermonbox')


                @endforeach

                <div class="pagination">
                    {{ $sermons->links() }}
                </div>
                
            </div>


        </div>
            

    </div>




@endsection