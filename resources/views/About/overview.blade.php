@extends('Layouts.general')

@section('content')
	
    <header id="main-header" class="py-1 bg-warning text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">About</p>
            <div class="float-right">
                <div class="btn btn-light dropdown d-inline-block">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                    	@if(Session::has('server'))
                    		{{ Session::get('server.url')}}
                    	@else 	{{ ' Select Server '}}
                    	@endif
    				</a>
                    <div class="dropdown-menu">
                        <a href="/servers" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
                    </div>              
                </div>
            @if(Session::has('server'))
            	<p class="h6 d-inline-block px-2" data-toggle="tooltip" data-placement="top" title="Server Time"><span id="clock"></span></p>
        	@endif
            </div>
        </div>
    </header>

    <!-- ============================================ home page body starts here ============================================ -->
    <div class="container my-1">
        <div class="card col-md-4 float-md-left">
        	<img class="card-img-top" src="img_avatar1.png" alt="Card image" style="width:100%">
            <div class="card-body">
                <h4 class="card-title">Chandra</h4>
                <div class="card-text">
                	<p class='font-italic h6'>Admin/Support</p>
                	<p class='my-0'><strong>Email : </strong>admin@travian-tools.com</p>
                	<!--  Plus only details -->
                	<p class='my-0 font-italic'><strong>Skype : </strong>chandra.v87</p>
                	<p class='my-0 font-italic'><strong>Discord : </strong>Jag#3306</p>                	
        		</div>                
            </div>
        </div>
	</div>

@endsection