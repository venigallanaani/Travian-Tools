@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-10 mb-5 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>{{$channel}} Settings</strong></div>
			<div class="card-text">			
		<!-- ============================ Add success/failure notifications ============================== -->
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
				<div class="container">
    	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                </div>
            @endif
        @endforeach
        
	   <!-- =========================== leadership Options control panel ================================ -->		
				<div class="my-2 h6 text-center">
					<p class="my-4">Plus group is not subscribed for the {{$channel}} Notifications</p>
					<p class="my-4"><a href="/leader/subscription">Enable {{$channel}} Notifications</a></p>
				</div>   			   			
			</div>
		</div>
@endsection
