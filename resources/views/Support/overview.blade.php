@extends('Layouts.general')

@section('content')
	
    <header id="main-header" class="py-1 bg-info text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Support</p>
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
			<p class="h4 py-2 text-info mx-auto"><strong>Please enter suggestions here</strong></p>
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
    				<button class="btn btn-info px-5"><strong>Submit</strong></button>
    			</div>
			</form>
		</div>		
	</div>
@endsection