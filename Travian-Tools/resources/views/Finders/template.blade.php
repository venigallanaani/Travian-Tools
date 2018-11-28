@extends('layouts.general')

@section('content')
    <header id="main-header" class="py-1 bg-success text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Finders</p>
            <div class="float-right">
            <div class="btn btn-light dropdown d-inline-block">
                <a class="dropdown-toggle" data-toggle="dropdown">Server Name </a>
                <div class="dropdown-menu">
                    <a href="servers.php" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
                </div>              
            </div>
            <p class="h6 d-inline-block px-2"><span id="clock"></span></p>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="d-inline">
            <!-- ======================================= Finders Side menu =================================== -->
            <div class="list-group col-md-3 text-center text-white mt-1 float-md-left">
                <a class="list-group-item py-1 bg-dark h4">Finders Menu</a>
                <a href="/finder/player" class="list-group-item py-1 list-group-item-action bg-success text-white h5">Player Finder</a>
                <a href="/finder/alliance" class="list-group-item py-1 list-group-item-action bg-success text-white h5">Alliance Finder</a>
                <a href="/finder/inactive" class="list-group-item py-1 list-group-item-action bg-success text-white h5">Inactive Finder</a>
                <a href="/finder/natar" class="list-group-item py-1 list-group-item-action bg-success text-white h5">Natar Finder</a>
                <a href="/finder/neighbour" class="list-group-item py-1 list-group-item-action bg-success text-white h5">Neighbour Finder</a>
            </div>                      
        </div>
        <div class="float-md-left col-md-9 mt-1 p-0">
        @yield('body')
        </div>
    </div>

@endsection