@extends('Layouts.general')

@section('content')
    <header id="main-header" class="py-1 bg-primary text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Calculators</p>            
        </div>
    </header>
        
    <div class="col-7 mx-auto">
        <div class="d-inline">
            <!-- ======================================= Finders Side menu =================================== -->
            <div class="list-group col-md-3 text-center text-white mt-1 float-md-left">
                <a class="list-group-item py-1 bg-dark h4">Calculators Menu</a>
                <a href="{{route('cropper')}}" class="list-group-item py-1 list-group-item-action bg-primary text-white h5">Cropper Development</a>
                <a href="{{route('calcRaid')}}" class="list-group-item py-1 list-group-item-action bg-primary text-white h5">Raid Calculator</a>   
                <a href="{{route('wheatScout')}}" class="list-group-item py-1 list-group-item-action bg-primary text-white h5">Wheat Scout</a>              
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
@endsection