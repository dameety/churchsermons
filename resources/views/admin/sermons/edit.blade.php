@extends('admin.layout.adminlayout')

@section('title', 'Edit Sermon')

@section('content')

        <main class="main">

        <div class="breadcrumb">
            <li class="breadcrumb-item">Edit Sermon: {{$sermon->title}}</li>          
        </div>
        

        <div class="col-sm-7 uk-margin-auto">
            <div class="aanimated fadeIn">

                <div id="newSermonForm">
                    <div class="card">
                        <div class="card-header">
                            Fill in the sermon details
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ url('/admin/sermon/new') }}" enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}

                                <div>

                                    <div class="form-group">

                                        <vue-img-preview
                                            input-name="sermonImage"
                                            default-image="{{ $sermon->imageurl }}"
                                        ></vue-img-preview>

                                    </div>

                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label for="Title">Title</label>
                                        <input type="text" name="title" maxlength="40" value="{{ $sermon->title }}" class="form-control" required autofocus>
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="form-group{{ $errors->has('preacher') ? ' has-error' : '' }}">
                                        <label for="Preacher">Preacher</label>
                                        <input type="text" name="preacher" required="required" maxlength="30" value="{{ $sermon->preacher }}" class="form-control">
                                        @if ($errors->has('preacher'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('preacher') }}</strong>
                                            </span>
                                        @endif      
                                    </div>


                                    <div class="form-group {{ $errors->has('service_id') ? ' has-error' : '' }}">
                                        <label for="Service">Service</label>                   
                                        <select name="service_id" value="{{ $sermon->service_id }}" class="form-control input-sm">
                                            @foreach( $services as $service )
                                                <option value="{{ $service->id }}"> {{{ $service->name }}}  </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        <label for="Category">Category</label>                        
                                        <select name="category_id" value="{{ $sermon->category_id }}" class="form-control input-sm">
                                            @foreach( $categories as $category )
                                                <option value="{{ $category->id }}"> {{{ $category->name }}}  </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Date Preached</label>
                                        <input type="date" name="datepreached" value="{{ $sermon->datepreached }}" class="form-control input-sm">
                                    </div>
                                    

                                    <div class="form-group">
                                        <label>Status <small> This defaults to free</small> </label>
                                        <select type="select" name="status" class="form-control">
                                            <option value="free">Free</option>
                                            <option value="premium">Premium</option>
                                        </select>
                                    </div>
                                
                                </div>


                                <div>
                                    <hr>
                                    <button type="submit" class="btn btn-block btn-primary">
                                        Update Sermon
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        
    </main>

@endsection
