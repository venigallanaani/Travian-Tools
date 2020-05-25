@extends('Layouts.general')

@section('content')
    <header id="main-header" class="py-1 bg-primary text-white">
        <div class="container">
            <p class="h4 font-weight-bold d-inline-block">Calculators</p>            
        </div>
    </header>
        
    <div class="container mx-auto">
        <div class="d-inline">
            <!-- ======================================= Finders Side menu =================================== -->
            <div class="list-group text-center text-white mt-1 mx-1 float-md-left">
                <a class="list-group-item py-1 bg-dark h5">Calculators</a>
                <a href="{{route('cropper')}}" class="list-group-item py-1 list-group-item-action bg-primary text-white h6">Cropper Development</a>
                <a href="{{route('calcRaid')}}" class="list-group-item py-1 list-group-item-action bg-primary text-white h6">Raid Calculator</a>   
                <a href="{{route('wheatScout')}}" class="list-group-item py-1 list-group-item-action bg-primary text-white h6">Wheat Scout</a> 
                <a href="{{route('calcTrade')}}" class="list-group-item py-1 list-group-item-action bg-primary text-white h6">Trade Routes</a>             
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