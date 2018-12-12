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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        
    </head>
    <body onload="displayTime()">
        <nav class="navbar p-0 font-weight-bold navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="/" class="navbar-brand mr-3"><span class="h3">Travian Tools </span><small class="align-bottom"><small>1.0</small></small></a>
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
                    </ul>                    
            @if(!Auth::user())
                    <div class="navbar-nav ml-auto">
                        <div class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </div>                  
                    </div>
                    
                    <!-- Login Modal -->
                    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header  bg-info text-white">
                                    <h4 class="modal-title" id="loginModalLabel">Log In</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/login" method="POST">
                                    	{{@csrf_field()}}
                                        <div class="form-group">
                                            <label for="userName" class="form-control-label" class="form-control">User Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="Password" class="form-control-label" class="form-control">Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <p><button type="button" class="btn btn-info"><span class="mx-5 h6">Login</span></button></p>
                                    </form>

                                </div>
                                <div class="modal-footer">                              
                                    <p><a type="button" class="btn btn-success mx-2" href="/forgetpassword">Forgot Password ?</a>
                                        <a type="button" class="btn btn-primary text-white mx-2" href="{{ route('register') }}">Sign Up</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
            @else
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown mr-3">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->name}}</a>
                            <div class="dropdown-menu">
                                <a href="/profile" class="dropdown-item"><i class="fa fa-user-circle"></i> Profile</a>
                                <a href="/profile/settings" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                                <a href="/logout" class="dropdown-item"><i class="fa fa-user-times"></i> Log Out</a>
                            </div>
                        </li>
                    </ul>

            @endif
                </div>
            </div>
        </nav>

        @yield('content')

        
        <!-- div class="footer bg-secondary">
            <div class="container py-0">
                <table>
                    <tr class="font-weight-bold">
                        <td class="col-md-3"><a href="/about" class="text-white">About</a></td>
                        <td class="col-md-3"><a href="/help" class="text-white">Help</a></td>
                        <td class="col-md-3"><a href="/report" class="text-white">Suggestions</a></td>
                    </tr>
                </table>
            </div>
        </div -->
        
<!-- == Bootstrap additions == -->
        <script src="{{ asset('js/script.js')}}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
    </body>
</html>
