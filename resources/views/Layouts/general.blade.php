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
            		<span class="h3">Travian Tools Reports </span><small class="align-bottom">1.0</small>
            		
        		</a>
            </div>
        </nav>
        
        @yield('content')

        <div class="footer bg-secondary">
            <div class="container py-0">
                <table class="col-md-12">
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
    </body>
    @stack('scripts')
</html>
