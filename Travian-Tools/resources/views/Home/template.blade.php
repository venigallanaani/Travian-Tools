@extends('layouts.general')

@section('content')
    <header id="main-header" class="py-1 bg-secondary text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Home</p>
            <div class="float-right">
                <div class="btn btn-light dropdown d-inline-block">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                    	@if(Session::has('server'))
                    		{{ Session::get('server.url')}}
                    	@else 	{{ ' Select Server '}}
                    	@endif
    				</a>
                    <div class="dropdown-menu">
                        <a href="/servers" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
                    </div>              
                </div>
            	<p class="h6 d-inline-block px-2"><span id="clock"></span></p>
            </div>
        </div>
    </header>
    @yield('body')
@endsection


    
