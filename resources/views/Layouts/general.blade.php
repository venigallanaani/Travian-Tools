<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{{ asset('images/favicon.png') }}}">
        <title>{{session('title')}}</title>
        <!-- Fonts -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/images.css') }}" rel="stylesheet">
        <link href="{{ asset('css/footer.css') }}" rel="stylesheet">	
        <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/moment-timezone.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/moment-timezone-with-data.js') }}" type="text/javascript"></script>
        @stack('extensions')        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        
    </head>
    <body>
    	<nav class="navbar p-0 font-weight-bold navbar-expand-md navbar-dark bg-dark align-middle">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>                
                <a href="/" class="navbar-brand mr-3">
            		<img id="logo" alt="" src="{{{ asset('images/favicon.png') }}}" width="42" height="30"> 	
            		<span class="h3">Travian Tools </span><small class="align-bottom">2.0</small>            		
        		</a>
        		<div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">                        
                        <li class="nav-item px-2">
                            <a href="{{ route('home') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('finders') }}" class="nav-link">Finders</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('account') }}" class="nav-link">Account</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('plus') }}" class="nav-link">Plus</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('reports') }}" class="nav-link">Reports</a>
                        </li>
                    </ul>
                    
            @if(!Auth::check())
                    <div class="navbar-nav ml-auto">
                        <div class="nav-item">
                            <a href="/login" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </div>                  
                    </div>
            @else
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown mr-3">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->name}}</a>
                            <div class="dropdown-menu">
                                <a href="/profile" class="dropdown-item"><i class="fa fa-user-circle"></i> Profile</a>
                                <a href="/profile/servers" class="dropdown-item"><i class="fas fa-cog"></i> Server Settings</a>
                                <a href="/logout" class="dropdown-item"><i class="fa fa-user-times"></i> Log Out</a>
                            </div>
                        </li>
                    </ul>
            @endif
                </div>
            </div>
        </nav>
        
        @yield('content')

        <div class="footer bg-secondary">
            <div class="container py-2">
                <table class="col-md-12 col-12">
                    <tr class="font-weight-bold">
                        <td><a href="/about" class="text-white">About</a></td>
                        <td><a href="/support" class="text-white">Support</a></td>                        
                        <td class="text-white text-right"><small>All rights to images belongs to Travian Games Gmbh.</small></td>
                    </tr>
                </table>
            </div>
        </div>
		
<!-- == Bootstrap additions == -->
		       
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script> 
        @if(Session::has('server'))
        <script>
            $(function(){
    	  		setInterval(function(){
        	  		var time = moment();
    		 		//$('#clock').html(time.tz('UTC').format('YYYY-MM-DD HH:mm:ss'));    
        	  		document.getElementById('clock').innerHTML = time.tz("{{ Session::get('server.tmz')}}").format('YYYY-MM-DD HH:mm:ss'); 		 		
    	  		},1000);
        	});	        	
        </script>
		@endif
    </body>
    @stack('scripts')
</html>
