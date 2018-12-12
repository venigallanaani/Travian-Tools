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
                        <a href="{{route('server')}}" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
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
    	<form action="/servers" method="POST">
    		{{ csrf_field() }}
    		@foreach($servers as $index=>$country)
        		<div class="py-2">
            		<div class="card card-header my-0 h5">
                		<p class="collapsed" data-toggle="collapse" href="#{{$index}}" aria-expanded="false" aria-controls="{{$index}}">
                    		<span class="text-uppercase">{{$index}}</span> Servers <small><i class="fa fa-angle-double-down"></i></small>
        			 	</p>
            		</div>
            		<div class="collapse" id="{{$index}}" style="">
              			<div class="card card-body">
                			<p class="my-0 py-0">
                				@foreach($country as $server)
                					<button class="btn btn-warning" type="submit" name="server" value="{{$server->server_id}}"><strong>{{$server->url}} <small>({{$server->days}} days)</small></strong></button>                				
                				@endforeach
            				</p>
              			</div>
            		</div>	
        		</div>
    		@endforeach
    	</form>   
    </div>
@endsection