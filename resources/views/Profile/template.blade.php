@extends('Layouts.general')

@section('content')

    <header id="main-header" class="py-1 bg-warning text-white">
        <div class="container">
            <p class="h4 font-weight-bold d-inline-block">Profile</p>
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
            @if(Session::has('server'))
            	<p class="h6 d-inline-block px-2" data-toggle="tooltip" data-placement="top" title="Server Time"><span id="clock"></span></p>
        	@endif
            </div>
        </div>
    </header>

    <div class="container mx-auto">
@auth
      <div class="d-inline">
          <!-- ======================================= Account Side menu =================================== -->
  			<div class="list-group text-center text-white mt-1 float-md-left mx-1">
				<a class="list-group-item py-1 bg-dark h5 px-5">Profile</a>
				<a href="{{route('profile')}}" class="list-group-item py-1 list-group-item-action bg-warning text-white h6">Overview</a>
				<a href="{{route('profileServers')}}" class="list-group-item py-1 list-group-item-action bg-warning text-white h6">My Servers</a>
  			</div>	
	    </div> 
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
                
		@yield('body')   
@endauth

@guest
        <div class="alert alert-warning text-center my-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>You are not logged into Travian Tools, <a href="{{route('login')}}" class="text-weight-bold"><strong>Sign In</strong></a>            
        </div>
@endguest            
    </div>
@endsection