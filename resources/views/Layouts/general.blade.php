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
        @stack('extensions')        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        
    </head>
    <body>
        <nav class="navbar p-0 font-weight-bold navbar-expand-md navbar-dark bg-dark align-middle">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- <a href="/" class="navbar-brand mr-3"><span class="h3">Travian Tools </span><small class="align-bottom"><small>1.0</small></small></a> -->
                <a href="/" class="navbar-brand mr-3">
            		<img id="logo" alt="" src="{{{ asset('images/favicon.png') }}}" width="42" height="30"> 	
            		<span class="h3">Travian Tools </span><small class="align-bottom"><small>beta</small></small>
        		</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item px-2">
                            <a href="{{ route('home') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="{{ route('finder') }}" class="nav-link">Finders</a>
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

  <!--      
        <div class="footer bg-secondary">
            <div class="container py-0">
                <table>
                    <tr class="font-weight-bold">
                        <td class="col-md-3"><a href="/about" class="text-white">About</a></td>
                        <td class="col-md-3"><a href="/help" class="text-white">Help</a></td>
                        <td class="col-md-3"><a href="/support" class="text-white">Suggestions</a></td>
                    </tr>
                </table>
            </div>
        </div>
        
 == Bootstrap additions == -->
      
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script> 
        <script type="text/javascript" src="{{ asset('js/moment-timezone.min.js') }}"></script>  
        <script type="text/javascript" src="{{ asset('js/moment-timezone-with-data.min.js') }}"></script> 
        
        <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>          
        <script>
            $(function(){
    	  		setInterval(function(){
    		 		$('#clock').html(moment().format('YYYY-MM-DD HH:mm:ss'));    		 		
    	  		},500);
        	});	        	
        </script>
		@stack('scripts')
    </body>
</html>
