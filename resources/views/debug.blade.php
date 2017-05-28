@extends('admin.layout.adminlayout')

@section('title', 'Add Sermons')

@section('content')

		<main class="main">

		<!-- Breadcrumb -->
        <div class="breadcrumb">
	        <li class="breadcrumb-item">Someting here</li>	        
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
                            <form method="POST" action="{{ url('/admin/sermon/new') }}">
                            	{{ csrf_field() }}

                                <div class="">

                                    {{-- <label class="form-group form-image-container">
                                        <img class="form-image" src="/img/otherimage.jpg" alt="sermon art">                                      
                                    </label> --}}

                                    <label class="form-group">
                                    <figure class="imghvr-fade form-image-container" style="background-color: rgba(0, 0, 0, 0.5);">
                                        <img class="form-image" src="/img/otherimage.jpg" alt="sermon art">
                                        <figcaption>
                                            <input type="file" name="sermon-image" class="hide-class uk-float-right">
                                            <button type="btn button-default">Choose an image</button>
                                        </figcaption>
                                    </figure>
                                    </label>

                                    <div class="form-group">
                                        <input type="file" name="title" required="required" maxlength="40" class="form-control pull-right">
                                        <br>
                                    </div>


                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        <label for="Title">Title</label>
                                        <input type="text" name="title" required="required" maxlength="40" class="form-control" autofocus>
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('preacher') ? ' has-error' : '' }}">
                                        <label for="Preacher">Preacher</label>
                                        <input type="text" name="preacher" required="required" maxlength="30" class="form-control">
                                        @if ($errors->has('preacher'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('preacher') }}</strong>
                                            </span>
                                        @endif                                            
                                    </div>


                                    <div class="form-group {{ $errors->has('service_id') ? ' has-error' : '' }}">
                                        <label for="Service">Service</label>                   
                                        <select name="service_id" class="form-control input-sm">
                                            
                                        </select>

                                    </div>

                                    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        <label for="Category">Category</label>                        
                                        <select name="category_id" class="form-control input-sm">
                                            
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
