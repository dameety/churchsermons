@extends('admin.layout.adminlayout')

@section('title', 'Add Sermons')

@section('content')

        <main class="main">

        <div class="breadcrumb">
            <li class="breadcrumb-item">Creating A New Sermon</li>
        </div>


        <div class="col-sm-7 uk-margin-auto">
            <div class="aanimated fadeIn">

                <!-- the form to fill sermon info -->
                <div id="newSermonForm">
                    <div class="card">
                        <div class="card-header">
                            Fill in the sermon details
                        </div>
                        <div class="card-block">
                            <form method="POST" action="{{ url('/admin/sermon/new') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="hidden" name="stagedsermonslug" value="{{ $slug }}">

                                <div>

                                    <div class="form-group sermon-image-container">
                                        <vue-img-preview
                                            input-name="sermonImage"
                                        ></vue-img-preview>
                                    </div>

                                    <br>
                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label for="Title">Title</label>
                                        <input type="text" name="title" maxlength="40" value="{{ $title }}" class="form-control" required autofocus>
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('preacher') ? ' has-error' : '' }}">
                                        <label for="Preacher">Preacher</label>
                                        <input type="text" name="preacher" maxlength="30" class="form-control" required>
                                        @if ($errors->has('preacher'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('preacher') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group {{ $errors->has('service_id') ? ' has-error' : '' }}">
                                        <label for="Service">Service</label>
                                        <select name="service_id" class="form-control input-sm">
                                            @foreach( $services as $service )
                                                <option value="{{ $service->id }}"> {{{ $service->name }}}  </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        <label for="Category">Category</label>
                                        <select name="category_id" class="form-control input-sm">
                                            @foreach( $categories as $category )
                                                <option value="{{ $category->id }}"> {{{ $category->name }}}  </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Date Preached</label>
                                        <input type="date" name="datepreached" class="form-control input-sm">
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
                                        Save Sermon
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
