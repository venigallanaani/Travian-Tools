@extends('Layouts.general')

@section('content')

    <header id="main-header" class="py-1 bg-warning text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Servers</p>
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
	@foreach(['danger','success','warning','info'] as $msg)
		@if(Session::has($msg))
        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>{{ Session::get($msg) }}
            </div>
        @endif
    @endforeach
    <div class="container">
    	<p class="h4 py-2">Select Server</p>
    	<form action="\servers" method="POST">
    		{{ csrf_field() }}
    		<div class="py-2">
        		<div class="card card-header py-0">
            		<p class="collapsed" data-toggle="collapse" href="#Com" aria-expanded="false" aria-controls="Com">
                			<img alt="wo" src="/images/x.gif" class="res wood"> COM Servers</p>
        		</div>
        		<div class="collapse" id="Com" style="">
          			<div class="card card-body">
            			<p class="my-0 py-0">
            				<button class="btn btn-warning" type="submit" name="server" value="ts6angr1"><strong>ts6.anglosphere.travian.com</strong></button>
            				<button class="btn btn-warning" type="submit" name="server" value="ts1comr5"><strong>ts1.travian.com</strong></button>
        				</p>
          			</div>
        		</div>	
    		</div>

    		<div class="py-2">
        		<div class="card card-header py-0">
            		<p class="collapsed" data-toggle="collapse" href="#US" aria-expanded="false" aria-controls="US">
                			<img alt="wo" src="/images/x.gif" class="res clay"> US Servers</p>
        		</div>
        		<div class="collapse" id="US" style="">
          			<div class="card card-body">
            			<p class="my-0 py-0">
            				<button class="btn btn-warning" type="submit" name="server" value="ts2usr9"><strong>ts2.travian.us</strong></button>
            				<button class="btn btn-warning" type="submit" name="server" value="ts1usr7"><strong>ts1.travian.us</strong></button>
        				</p>
          			</div>
        		</div>	
    		</div>
    		
    	</form>   
    </div>
@endsection