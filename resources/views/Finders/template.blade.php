@extends('Layouts.general')

@section('content')
    <header id="main-header" class="py-1 bg-success text-white">
        <div class="container">
            <p class="h4 font-weight-bold d-inline-block">Finders</p>
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
            </div>
        </div>
    </header>
    
    <div class="container mx-auto" style="font-size: 0.8em">
        <div class="d-inline">
            <!-- ======================================= Finders Side menu =================================== -->
            <div class="list-group text-center text-white mt-1 mx-1 float-md-left">
                <a class="list-group-item py-1 bg-dark h5">Finders</a>
                <a href="{{route('findPlayer')}}" class="list-group-item py-1 list-group-item-action bg-success text-white h6">Player Finder</a>
                <a href="{{route('findAlliance')}}" class="list-group-item py-1 list-group-item-action bg-success text-white h6">Alliance Finder</a>
                <a href="{{route('findInactive')}}" class="list-group-item py-1 list-group-item-action bg-success text-white h6">Inactive Finder</a>
                <a href="{{route('findNatar')}}" class="list-group-item py-1 list-group-item-action bg-success text-white h6">Natar Finder</a>
                <a href="{{route('findNeighbour')}}" class="list-group-item py-1 list-group-item-action bg-success text-white h6">Neighbour Finder</a>
            </div>
        </div>
        <div class="float-md-left col-md-9 mt-1 p-0">
        @if(!Session::has('server'))
            <div class="alert alert-warning text-center my-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>You have not selected a server, <a href="{{route('servers')}}" class="text-weight-bold"><strong>Select Server</strong></a>            
            </div>
		@endif
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
        
        </div>
    </div>
	@stack('scripts')
@endsection