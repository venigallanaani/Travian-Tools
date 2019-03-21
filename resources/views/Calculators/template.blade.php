@extends('Layouts.general')

@section('content')
    <header id="main-header" class="py-1 bg-primary text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Calculators</p>
            
        </div>
    </header>
    
    <div class="container">
        <div class="d-inline">
            <!-- ======================================= Finders Side menu =================================== -->                   
        </div>
        <div class="float-md-left col-md-12 mt-1 p-0">
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