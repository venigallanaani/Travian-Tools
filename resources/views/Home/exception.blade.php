@extends('Home.template')

@section('body')        
        
    <!-- ============================================ home page body starts here ============================================ -->
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
		
		@if(!Session::has('server'))
            <div class="alert alert-warning text-center my-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>You have not selected a server, <a href="{{route('server')}}" class="text-weight-bold"><strong>Select Server</strong></a>            
            </div>
    	@endif
        
        <div class="card">
        	<div>An Unexpected error has occurred, please try again later. If this issue continues to persist, contact admin@travian-tools.com</div>
        </div>
    </div>  
    
@endsection