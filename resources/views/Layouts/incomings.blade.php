@extends('Layouts.general')

@section('content')    
    <header id="main-header" class="py-1 bg-info text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Plus</p>
            <div class="float-right">
                <div class="btn btn-light dropdown d-inline-block">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                    	@if(Session::has('server'))
                    		{{ Session::get('server.url')}}
                    	@else 	{{ ' Select Server '}}
                    	@endif
    				</a>
                    <div class="dropdown-menu">
                        <a href="{{route('servers')}}" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
                    </div>              
                </div>
            @if(Session::has('plus'))
            	<p class="h6 d-inline-block px-2" data-toggle="tooltip" data-placement="top" title="Group Time"><span id="clock">...</span></p>
        	@endif
            </div>
        </div>
    </header>
    
@guest
	<div class="container">
        <div class="alert alert-warning text-center my-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>Please <a href="{{route('login')}}" class="text-weight-bold"><strong>Login</strong></a> to access your account           
        </div>
    </div> 
@endguest

@auth
@if(!Session::has('server'))
	<div class="container">
        <div class="alert alert-warning text-center my-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>You have not selected a server, <a href="{{route('server')}}" class="text-weight-bold"><strong>Select Server</strong></a>            
        </div>
    </div>
@else
@if(!Session::has('plus'))
	<div class="container">
		<div class="card shadow my-1">
			<div class="py-5 mx-auto">
				<p class="h5 py-1">You are not associated with any Plus group.</p>
				<p class="h6 py-1"><a href="/plus/creategroup" class="text-info"><strong>Click here</strong></a> to proceed to create a Plus group</p>
			</div>
		</div>		
	</div>
@else
	@if(Session::get('plus.plus')!=1)
	<div class="container">
		<div class="card shadow my-1">
			<div class="py-5 mx-auto">
				<p class="h5 py-1">Access denied to Plus group, please contact the group leader.</p>    				
			</div>
		</div>		
	</div>
	@else
    <div class="col-7 col-md-7 mx-auto">
        
        @yield('body')

    </div>
    @endif
@endif
@endif
@endauth


	@push('scripts')
		<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script> 
        <script type="text/javascript" src="{{ asset('js/moment-timezone-with-data-2012-2022.min.js') }}"></script> 
        <script>        	
            $(function(){                
    	  		setInterval(function(){
        	  		var now = moment().tz("{{Session::get('timezone')}}");
    		 		$('#clock').html(now.format('YYYY-MM-DD HH:mm:ss'));    		 		
    	  		},1000);
        	});
         </script>
    @endpush
@endsection