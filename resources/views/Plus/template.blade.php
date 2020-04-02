@extends('Layouts.general')

@section('content')    
    <header id="main-header" class="py-1 bg-info text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Plus</p>
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
            @if(Session::has('plus'))
            	<p class="h6 d-inline-block px-2" data-toggle="tooltip" data-placement="top" title="Group Time"><span id="clock">...</span></p>
        	@endif
            </div>
        </div>
    </header>
    
@guest
	<div class="container">
        <div class="alert alert-warning text-center my-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>Please <a href="{{route('login')}}" class="text-weight-bold"><strong>Login</strong></a> to access your account           
        </div>
    </div> 
@endguest

@auth
@if(!Session::has('server'))
	<div class="container">
        <div class="alert alert-warning text-center my-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>You have not selected a server, <a href="{{route('servers')}}" class="text-weight-bold"><strong>Select Server</strong></a>            
        </div>
    </div>
@else
@if(!Session::has('plus'))
	<div class="container">
		<div class="card shadow my-1">
			<div class="py-5 mx-auto">
				<p class="h5 py-1">You are not associated with any Plus group. Please contact Administrator to create a group.</p>
<!-- 				<p class="h6 py-1"><a href="/plus/creategroup" class="text-info"><strong>Click here</strong></a> to proceed to create a Plus group</p> -->
			</div>
		</div>		
	</div>
@else
	@if(Session::get('plus.plus')!=1)
	<div class="container">
		<div class="card shadow my-1">
			<div class="py-5 mx-auto">
				<p class="h5 py-1">Access denied to Plus group, please contact the group leader.</p>    				
			</div>
		</div>		
	</div>
	@else
    <div class="col-7 mx-auto">
        <div class="d-inline float-md-left col-md-3">
            <!-- ======================================= Plus Side menu =================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Plus Menu</a>
                <a href="/plus" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>
                <a href="/plus/members" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Member Details</a>
                <a href="/plus/rankings" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Rankings</a>
                <a href="/plus/incoming" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Report Incomings</a>
                <a href="/plus/defense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Defense Tasks</a>
                <a href="/plus/offense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Offense Tasks</a>
                <a href="/plus/resource" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Resource Tasks</a>
                <a href="/plus/reports" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Group Reports</a>
            </div>      
             
        @if(Session::get('plus.leader')==1 and Session::get('menu')!=1)
            <!-- =================================== Plus Leader/Owner menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('leader')">Leader Menu <i class="fas fa-angle-down"></i></a> 
                <div id="leader" style="display:none">               
                    <a href="/leader/subscription" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Subscription</a>
                    <a href="/leader/access" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Access</a>
                    <a href="/leader/rankings" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Rankings</a>
                    <a href="/leader/discord" class="list-group-item py-1 list-group-item-action bg-info text-white h5" disabled>Discord Settings</a>
                </div>
            </div>
        @endif
        @if(Session::get('plus.leader')==1 and Session::get('menu')==1)
            <!-- =================================== Plus Leader/Owner menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Leader Menu</a> 
                <div id="leader">               
                    <a href="/leader/subscription" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Subscription</a>
                    <a href="/leader/access" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Access</a>
                    <a href="/leader/rankings" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Rankings</a>
                    <a href="/leader/discord" class="list-group-item py-1 list-group-item-action bg-info text-white h5" disabled>Discord Settings</a>
                </div>
            </div>
        @endif  
        @if((Session::get('plus.leader')==1 or Session::get('plus.scout')==1 or Session::get('plus.defense')==1 or Session::get('plus.offense')==1
        		or Session::get('plus.resources')==1 or Session::get('plus.artifact')==1 or Session::get('plus.wonder')==1) and Session::get('menu')!=2)
            <!-- =================================== Scouts menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('scout')">Reports Menu <i class="fas fa-angle-down"></i></a>
                <div id="scout" style="display:none">
                    <a href="/plus/ldrrpts" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Reports</a>
                    <a href="/plus/reports/hammers" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Hammer Tracking</a>
                    <a href="/plus/reports/scouts" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Scout Requests</a>   
                </div>             
            </div>
  		@endif 
  		@if((Session::get('plus.leader')==1 or Session::get('plus.scout')==1 or Session::get('plus.defense')==1 or Session::get('plus.offense')==1
        		or Session::get('plus.resources')==1 or Session::get('plus.artifact')==1 or Session::get('plus.wonder')==1) and Session::get('menu')==2)
            <!-- =================================== Scouts menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4" >Reports Menu</a>
                <div id="scout">
                    <a href="/plus/ldrrpts" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Reports</a>
                    <a href="/plus/reports/hammers" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Hammer Tracking</a>
                    <a href="/plus/reports/scouts" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Scout Requests</a>   
                </div>             
            </div>
  		@endif 
        @if(Session::get('plus.defense')==1 and Session::get('menu')!=3) 
            <!-- =================================== Defense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('defense')">Defense Menu <i class="fas fa-angle-down"></i></a>
                <div id="defense" style="display:none">
                    <a href="/defense/incomings" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Incomings</a>
                    <a href="/defense/cfd" class="list-group-item py-1 list-group-item-action bg-info text-white h5">CFD Status</a>
                    <a href="/defense/search" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Defense</a>   
                </div>             
            </div>
  		@endif
        @if(Session::get('plus.defense')==1 and Session::get('menu')==3) 
            <!-- =================================== Defense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4">Defense Menu</a>
                <div id="defense">
                    <a href="/defense/incomings" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Incomings</a>
                    <a href="/defense/cfd" class="list-group-item py-1 list-group-item-action bg-info text-white h5">CFD Status</a>
                    <a href="/defense/search" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Defense</a>   
                </div>             
            </div>
  		@endif
  		@if(Session::get('plus.offense')==1 and Session::get('menu')!=4)
            <!-- =================================== Offense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('offense')">Offense Menu <i class="fas fa-angle-down"></i></a>  
                <div id="offense" style="display:none">               
                    <a href="/offense/status" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Offense Plans</a>
                    <a href="/offense/troops" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Hammers</a>
                    <a href="/offense/search" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Offense</a>
                    <a href="/offense/archive" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Plans Archive</a> 
                </div>                 
            </div>
        @endif
  		@if(Session::get('plus.offense')==1 and Session::get('menu')==4)
            <!-- =================================== Offense menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4" >Offense Menu</a>  
                <div id="offense">               
                    <a href="/offense/status" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Offense Plans</a>
                    <a href="/offense/troops" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Hammers</a>
                    <a href="/offense/search" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Search Offense</a>
                    <a href="/offense/archive" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Plans Archive</a> 
                </div>                 
            </div>
        @endif
		@if(Session::get('plus.resources')==1 and Session::get('menu')!=5)
            <!-- =================================== Resource menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('resource')">Resource Menu <i class="fas fa-angle-down"></i></a>
                <div id="resource" style="display:none">
                	<a href="/resource" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Push Status</a>
            	</div>
            </div> 
        @endif
        @if(Session::get('plus.resources')==1 and Session::get('menu')==5)
            <!-- =================================== Resource menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('resource')">Resource Menu <i class="fas fa-angle-down"></i></a>
                <div id="resource" style="display:none">
                	<a href="/resource" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Push Status</a>
            	</div>
            </div> 
        @endif
		@if(Session::get('plus.artifact')==1 and Session::get('menu')!=6)
            <!-- =================================== Artifacts menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('artifact')">Artifacts Menu <i class="fas fa-angle-down"></i></a> 
                <div id="artifact" style="display:none">
                    <a href="{{route('ldrArt')}}" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>                
                    <a href="{{route('ldrArt')}}/schedule" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Rotation</a>
                    <a href="{{route('ldrArt')}}/hammers" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Artifact Hammers</a>
                    <a href="{{route('ldrArt')}}/capture" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Capture Plan</a>
                </div>
            </div> 
        @endif
        @if(Session::get('plus.artifact')==1 and Session::get('menu')==6)
            <!-- =================================== Artifacts menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('artifact')">Artifacts Menu <i class="fas fa-angle-down"></i></a> 
                <div id="artifact" style="display:none">
                    <a href="{{route('ldrArt')}}" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>                
                    <a href="{{route('ldrArt')}}/schedule" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Rotation</a>
                    <a href="{{route('ldrArt')}}/hammers" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Artifact Hammers</a>
                    <a href="{{route('ldrArt')}}/capture" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Capture Plan</a>
                </div>
            </div> 
        @endif
		@if(Session::get('plus.wonder')==1 and Session::get('menu')!=7)
            <!-- =================================== Artifacts menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('wonder')">Wonder Menu <i class="fas fa-angle-down"></i></a>  
                <div id="wonder" style="display:none">              
                    <a href="/wonder" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>                
                    <a href="/wonder/crop" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Crop Tool</a>
                    <a href="/wonder/defense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Wonder Defense</a>
                    <a href="/wonder/offense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">WWR/WWK</a>   
                </div>              
            </div> 
        @endif
        @if(Session::get('plus.wonder')==1 and Session::get('menu')==7)
            <!-- =================================== Artifacts menu ================================== -->
            <div class="list-group text-center text-white mt-1">
                <a class="list-group-item py-1 bg-dark h4"  onclick="toggleMenu('wonder')">Wonder Menu <i class="fas fa-angle-down"></i></a>  
                <div id="wonder" style="display:none">              
                    <a href="/wonder" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Overview</a>                
                    <a href="/wonder/crop" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Crop Tool</a>
                    <a href="/wonder/defense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">Wonder Defense</a>
                    <a href="/wonder/offense" class="list-group-item py-1 list-group-item-action bg-info text-white h5">WWR/WWK</a>   
                </div>              
            </div> 
        @endif
        	<div class="text-center text-white mb-5">
        	</div>
        </div>
        
        @yield('body')

    </div>
    @endif
@endif
@endif
@endauth
	@push('scripts')
		<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script> 
        <script type="text/javascript" src="{{ asset('js/moment-timezone-with-data-2012-2022.min.js') }}"></script> 
        <script>        	
            $(function(){                
    	  		setInterval(function(){
        	  		var now = moment().tz("{{Session::get('timezone')}}");
    		 		$('#clock').html(now.format('YYYY-MM-DD HH:mm:ss'));    		 		
    	  		},1000);
        	});
         </script>
    @endpush

@endsection