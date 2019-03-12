@extends('Layouts.general')

@section('content')
    <header id="main-header" class="py-1 bg-primary text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Calculators</p>
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
    
    <div class="container">
        <div class="d-inline">
            <!-- ======================================= Finders Side menu =================================== -->
            <div class="list-group col-md-3 text-center text-white mt-1 float-md-left">
                <a class="list-group-item py-1 bg-dark h4">Calculators Menu</a>
                <a href="/calculators/cropper" class="list-group-item py-1 list-group-item-action bg-light h5">Cropper Development</a>
            </div>                      
        </div>
        <div class="float-md-left col-md-9 mt-1 p-0">
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