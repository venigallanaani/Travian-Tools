@extends('Layouts.general')

@section('content')

    <header id="main-header" class="py-1 bg-warning text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Account</p>
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
    <div class="container">
    	@if(!Session::has('server'))
    	<div class="alert alert-warning text-center my-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>You have not selected a server, <a href="{{route('server')}}" class="text-weight-bold"><strong>Select Server</strong></a>            
        </div>
        @else
      	<div class="d-inline">
          <!-- ======================================= Account Side menu =================================== -->
  			<div class="list-group col-md-3 text-center text-white mt-1 float-md-left">
				<a class="list-group-item py-1 bg-dark h4">Account Menu</a>
				<a href="/account" class="list-group-item py-1 list-group-item-action bg-warning text-white h5">Overview</a>
				<a href="/account/support" class="list-group-item py-1 list-group-item-action bg-warning text-white h5">Sitters & Duals</a>
				<a href="/account/troops" class="list-group-item py-1 list-group-item-action bg-warning text-white h5">Troops Details</a>
				<a href="/account/hero" class="list-group-item py-1 list-group-item-action bg-warning text-white h5">Hero Details</a>
				<a href="/account/alliance" class="list-group-item py-1 list-group-item-action bg-warning text-white h5">Alliance</a>
  			</div>	
	    </div> 
	    	
		@yield('body')	 
  	@endif         
    </div>    
    @endauth
    
@endsection