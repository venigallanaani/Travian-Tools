
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{session('title')}}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
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
                            <a href="/home" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="/finder" class="nav-link">Finders</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="/account" class="nav-link">Account</a>
                        </li>
                        <li class="nav-item px-2">
                            <a href="/plus" class="nav-link">Plus</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown mr-3">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> User</a>
                            <div class="dropdown-menu">
                                <a href="profile" class="dropdown-item"><i class="fa fa-user-circle"></i> Profile</a>
                                <a href="profile" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                                <a href="profile" class="dropdown-item"><i class="fas fa-server"></i> Servers</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout"><i class="fa fa-user-times"></i> Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header id="main-header" class="py-1 bg-info text-white">
            <div class="container">
                <p class="h3 font-weight-bold d-inline-block">Report</p>
                <div class="float-right">
                <div class="btn btn-light dropdown d-inline-block">
                    <a class="dropdown-toggle" data-toggle="dropdown">server name</a>
                    <div class="dropdown-menu">
                        <a href="servers.php" class="dropdown-item"><i class="fa fa-server"></i>Change Server</a>
                    </div>              
                </div>
                <p class="h6 d-inline-block px-2"><span id="clock"></span></p>
                </div>
            </div>
        </header>

        @yield('content')

        <div class="footer bg-secondary">
            <div class="container py-0">
                <table>
                    <tr class="font-weight-bold">
                        <td class="col-md-3"><a href="/contact" class="text-white">Contact</a></td>
                        <td class="col-md-3"><a href="/help" class="text-white">Help</a></td>
                        <td class="col-md-3"><a href="/report" class="text-white">Report</a></td>
                    </tr>
                </table>
            </div>
        </div>

<!-- == Bootstrap additions == -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
    </body>
</html>
