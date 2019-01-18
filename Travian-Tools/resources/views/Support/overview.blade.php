@extends('layouts.general')

@section('content')
	
    <header id="main-header" class="py-1 bg-info text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Report</p>
            <div class="float-right">
                <div class="btn btn-light dropdown d-inline-block">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                    	@if(Session::has('server'))
                    		{{ Session::get('server.url')}}
                    	@else 	{{ ' Select Server '}}
                    	@endif
    				</a>
                    <div class="dropdown-menu">
                        <a href="{{route('server')}}" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
                    </div>              
                </div>
            @if(Session::has('server'))
            	<p class="h6 d-inline-block px-2" data-toggle="tooltip" data-placement="top" title="Server Time"><span id="clock"></span></p>
        	@endif
            </div>
        </div>
    </header>

    <!-- ============================================ Report page body starts here ============================================ -->
	<div class="container mt-1">

		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach

		<div class="card col-md-12 p-1 shadow" style="background-color:#dbeef4;">
			<p class="h4 py-2 text-info mx-auto"><strong>Please Suggestions here</strong></p>
			<form class="mx-auto col-md-6" action="/support" method="post">
				{{ csrf_field() }}
				<div class="input-group py-1">
					<label for="subject" class="input-group-prepend"><span class="input-group-text">Subject:</span></label>
						<input type="text" name="subject" required class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
				</div>
				<div class="input-group py-1">
					<label for="email" class="input-group-prepend"><span class="input-group-text">Email Address:</span></label>
						<input type="text" name="email" required class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
				</div>
				<div class="input-group py-1">
					<label for="type" class="input-group-prepend"><span class="input-group-text">Type:</span></label>
						<select class="form-control col-md-3" name="type" aria-label="" aria-describedby="basic-addon1">
							<option value="suggest">Suggestion</option>
							<option value="defect">Defect</option>
							<option value="other">Other</option>
						</select>
				</div>
				<div class="input-group py-1">
					<label for="description" class="input-group-prepend"><span class="input-group-text">Description:</span></label>
						<textarea class="form-control" rows="8" name="description"></textarea>
				</div>
    			<div class="py-2 align-middle">
    				<button class="btn btn-primary px-5">Submit</button>
    			</div>
			</form>
		</div>		
	</div>
@endsection