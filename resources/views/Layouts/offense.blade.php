<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{{ asset('images/favicon.png') }}}">
        <title>{{session('title')}}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/images.css') }}" rel="stylesheet">
        <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
                	
    	<script type="text/javascript" src="{{ asset('js/d3.v3.js')	}}"></script>
		<script type="text/javascript" src="{{ asset('js/sankey.js')}}"></script>
		<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		
        @stack('extensions')        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        
    </head>
    <body onload="displayTime()">
        <header id="main-header" class="py-1 bg-dark text-white">
            <div class="container text-center">
            	<span class="h4">Offense Plan Editor </span>
            	<span class="small"> Travian Tools </span>               
            </div>
        </header>
        <header id="main-header" class="py-1 bg-info text-white">
            <div class="container">
            	<span class="h5 font-weight-bold d-inline-block px-5">Offense Plan : <span class="h6 font-italic">{{$plan->name}}</span></span>
            	<span class="h5 font-weight-bold d-inline-block float-right">
            		<a href="/offense/plan/edit/{{$plan->id}}">
     					<button class="btn btn-warning btn-sm px-4"><i class="fas fa-sync"></i> Refresh Plan</button>
 					</a>
				</span>
            </div>
        </header> 
        <div class="container">
	@foreach(['danger','success','warning','info'] as $msg)
		@if(Session::has($msg))
        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>{{ Session::get($msg) }}
            </div>
        @endif
    @endforeach	
        	@yield('content')
        </div>            
	
<!-- == Bootstrap additions == -->
		       
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>        
    </body>
    @stack('scripts')
</html>
