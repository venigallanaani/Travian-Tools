@extends('Layouts.general')

@section('content')

    <header id="main-header" class="py-1 bg-warning text-white">
        <div class="container">
            <p class="h4 font-weight-bold d-inline-block">Servers</p>
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
    	<p class="h5 pt-2 text-center">Select Server</p>
    	<form action="{{route('servers')}}" method="POST">
    		{{ csrf_field() }}
    		@foreach($servers as $index=>$domains)
        		<div class="py-2">
                	<div class="card card-header text-center btn btn-block bg-warning collapsed shadow text-dark my-2" data-toggle="collapse" href="#{{$index}}" aria-expanded="false" aria-controls="{{$index}}">
                		<p class="p-1 m-0 h6 font-weight-bold">
                    		<span class="text-uppercase">{{$index}}</span> Servers <small><i class="fa fa-angle-double-down"></i></small>
            		 	</p>
            		</div>
            		<div class="collapse" id="{{$index}}" style="">
              			<div class="card card-body">
                			<p class="my-0 px-2">
            				@foreach($domains as $server)
				  				<button class="btn btn-outline-warning text-dark" type="submit" name="server" value="{{$server->server_id}}">
                  					<span class="h6">{{$server->url}} <small>({{$server->days}} days)</small></span>
                				</button>                				
            				@endforeach
            				</p>
              			</div>
            		</div>	
        		</div>
    		@endforeach
    	</form>
		
    </div>
@endsection