@extends('layouts.general')


@section('content')
    <?php 
        $_SESSION['PLUS']='Yes';
        unset($_SESSION['PLUS']);
    ?>
    
    <header id="main-header" class="py-1 bg-info text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Plus</p>
            <div class="float-right">
                <div class="btn btn-light dropdown d-inline-block">
                    <a class="dropdown-toggle" data-toggle="dropdown">
    					<?php if(isset($_SESSION['SERVER'])){ echo $_SESSION['SERVER']['URL'];}
    					       else { echo " Select Server ";}?>
    				</a>
                    <div class="dropdown-menu">
                        <a href="servers.php" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
                    </div>              
                </div>
            	<p class="h6 d-inline-block px-2"><span id="clock"></span></p>
            </div>
        </div>
    </header>

    <div class="container">

        <div class="d-inline float-md-left col-md-3">
            <!-- ======================================= Finders Side menu =================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Plus Menu</a>
                <a href="/plus" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>
                <a href="/plus/member" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Member Details</a>
                <a href="/plus/incoming" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Report Incomings</a>
                <a href="/plus/defense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Defense Tasks</a>
                <a href="/plus/offense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Offense Tasks</a>
                <a href="/plus/resource" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Resource Tasks</a>
            </div>   
        
        
            <!-- =================================== Plus Leader/Owner menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Leader Menu</a>
                <a href="/leader/access" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Access</a>
                <a href="/leader/subscription" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Subscription</a>
            </div>
                
            <!-- =================================== Defense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Defense Menu</a>
                <a href="/defense/incoming" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Incomings</a>
                <a href="/defense/cfd" class="list-group-item py-1 list-group-item-action bg-info text-white h5">CFD Status</a>
                <a href="/defense/search" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Defense</a>
            </div>
  
            <!-- =================================== Offense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Offense Menu</a>                 
                <a href="/offense/status" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Ops Status</a>
                <a href="/offense/troops" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Troops Details</a>
                <a href="/offense/archive" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Archive</a>                  
            </div>

            <!-- =================================== Resource menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Resource Menu</a>                
                <a href="/resource" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Push Status</a>
            </div>
        
        </div>

        @yield('body')

    </div>

@endsection