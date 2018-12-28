@extends('Plus.template')

@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h4 py-2 bg-info text-white"><strong>Search Defense</strong></div>
		<div class="card-text">
	@foreach(['danger','success','warning','info'] as $msg)
		@if(Session::has($msg))
        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>{{ Session::get($msg) }}
            </div>
        @endif
    @endforeach		
    		<div class="text-center my-2">	
    			<form action="/defense/search" method="POST">
    				{{ csrf_field() }}
    				<p class="h5 py-1"><strong>X: <input name="xCor" type="text" size="5" required value="0"> | 
							Y: <input name="xCor" type="text" size="5" required value="0"></strong></p>
    				<p class="h5 py-1"><strong>Defense (<img alt="" src="/images/x.gif" class="res upkeep">): 
    						<input name="defNeed" type="text" size="10" required value="1000"></strong></p>
    				<p class="h5 py-1"><strong>Target Time: <input name="targetTime" type="text" size="15" required></strong></p>
    				<button class="btn btn-info btn-lg" name="search" type="submit">Search Defense</button>
    			</form>	
			</div>	
		</div>
	</div>
	
	@yield('results')

@endsection