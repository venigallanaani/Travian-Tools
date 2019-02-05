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
    <div class="container">
        <div class="d-inline float-md-left col-md-3">
            <!-- ======================================= Finders Side menu =================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Plus Menu</a>
                <a href="/plus" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>
                <a href="/plus/members" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Member Details</a>
                <a href="/plus/rankings" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Rankings</a>
                <a href="/plus/incoming" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Report Incomings</a>
                <a href="/plus/defense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Defense Tasks</a>
                <a href="/plus/offense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Offense Tasks</a>
                <a href="/plus/resource" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Resource Tasks</a>
            </div>       
        @if(Session::get('plus.leader')==1)
            <!-- =================================== Plus Leader/Owner menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Leader Menu</a>
                <a href="/leader/access" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Access</a>
                <a href="/leader/subscription" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Subscription</a>
                <a href="/leader/rankings" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Rankings</a>
            </div>
        @endif   
        @if(Session::get('plus.defense')==1) 
            <!-- =================================== Defense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Defense Menu</a>
                <a href="/defense/incoming" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Incomings</a>
                <a href="/defense/cfd" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Defense Status</a>
                <a href="/defense/search" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Defense</a>                
            </div>
  		@endif
  		@if(Session::get('plus.offense')==1)
            <!-- =================================== Offense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Offense Menu</a>                 
                <a href="/offense/status" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Ops Status</a>
                <a href="/offense/troops" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Troops Details</a>
                <a href="/offense/search" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Offense</a>
                <a href="/offense/archive" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Archive</a>                  
            </div>
        @endif
		@if(Session::get('plus.resources')==1)
            <!-- =================================== Resource menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Resource Menu</a>                
                <a href="/resource" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Push Status</a>
            </div> 
        @endif
		@if(Session::get('plus.artifact')==2)
            <!-- =================================== Artifacts menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Artifacts Menu</a>                
                <a href="/artifact" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>                
                <a href="/artifact/list" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Artifact List</a>
                <a href="/artifact/request" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Requests</a>
                <a href="/artifact/capture" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Capture Plan</a>
            </div> 
        @endif
        </div>
        
        @yield('body')

    </div>
    @endif
@endif
@endif
@endauth


@endsection