@extends('Home.template')

@section('body')        
        
    <!-- ============================================ home page body starts here ============================================ -->
    <div class="container mt-1">
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
		
		@if(!Session::has('server'))
            <div class="alert alert-warning text-center my-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>You have not selected a server, <a href="{{route('server')}}" class="text-weight-bold"><strong>Select Server</strong></a>            
            </div>
    	@endif
        
        <div class="card-columns">
            <div class="card shadow">
                <div class="card-body">
                @if(Auth::check())
                	<p class="h5">Welcome {{Auth::user()->name}}</p>
                @else
                	<p class="h5">Welcome to Travian Tools</p>
                @endif
                </div>
            </div>
            <div class="card shadow">
                <p class="card-header h4 text-success font-weight-bold">Finders</p>
                <div class="card-body">                 
                    <p>Finders help you search the Travian to find different objects you need.</p>
                    <table>
                        <tr><td><a href="{{route('findPlayer')}}" class="text-success font-weight-bold">Player Finder</a></td></tr>
                        <tr><td><a href="{{route('findAlliance')}}" class="text-success font-weight-bold">Alliance Finder</a></td></tr>
                        <tr><td><a href="{{route('findInactive')}}" class="text-success font-weight-bold">Inactive Finder</a></td></tr>
                        <tr><td><a href="{{route('findNatar')}}" class="text-success font-weight-bold">Natar Finder</a></td></tr>
                        <tr><td><a href="{{route('findNeighbour')}}" class="text-success font-weight-bold">Neighbour Finder</a></td></tr>
                    </table>
                </div>
            </div>
            <div class="card shadow">
                <p class="card-header h4 text-primary font-weight-bold">Calculators</p>
                <div class="card-body">                 
                    <p>Calculators to help with different aspects of the game</p>
                    <table>
                        <tr><td><a href="{{route('cropper')}}" class="text-primary font-weight-bold">Cropper Development</a></td></tr>
                        <tr><td><a href="{{route('wheatScout')}}" class="text-primary font-weight-bold">Wheat Scout</a></td></tr>
                    </table>
                </div>
            </div>
<!--             <div class="card shadow"> -->
<!--                 <p class="card-header h4 text-info font-weight-bold">Plus</p> -->
<!--                 <div class="card-body"> -->
<!--                    	@guest -->
<!--                     	<p><a href="/login"><strong>Sign In</strong></a> to access the Plus group</p> -->
<!--                     @endguest -->
<!--                     <p> Plus menu offers different options and tasks for the group to work efficiently.</p> -->
<!--                     <table> -->
<!--                         <tr><td><a href="/plus/members" class="text-info font-weight-bold">Member Details</a></td></tr> -->
<!--                         <tr><td><a href="/plus/incoming" class="text-info font-weight-bold">Enter Incomings</a></td></tr> -->
<!--                         <tr><td><a href="/plus/defense" class="text-info font-weight-bold">Defense Tasks</a></td></tr> -->
<!--                         <tr><td><a href="/plus/offense" class="text-info font-weight-bold">Offense Tasks</a></td></tr> -->
<!--                         <tr><td><a href="/plus/resource" class="text-info font-weight-bold">Resource Tasks</a></td></tr> -->
<!--                     </table> -->
<!--                 </div> -->
<!--             </div> -->
            <div class="card shadow">
                <p class="card-header h4 text-warning font-weight-bold">Account</p>
                <div class="card-body">
                	@guest
                    	<p><a href="/login"><strong>Sign In</strong></a> to access you account details.</p>
                    @endguest
                    <p>Account Details can be displayed here.</p>
                    <table>
                        <tr><td><a href="/account" class="text-warning font-weight-bold">Account Overview</a></td></tr>
                        <tr><td><a href="/account/troops" class="text-warning font-weight-bold">Troops Details</a></td></tr>
                        <tr><td><a href="/account/hero" class="text-warning font-weight-bold">Hero Details</a></td></tr>
                        <tr><td><a href="/account/alliance" class="text-warning font-weight-bold">Alliance Overview</a></td></tr>
                    </table>
                </div>
            </div>  
<!--             <div class="card shadow"> -->
<!--                 <p class="card-header h4 text-secondary font-weight-bold">Useful Links</p> -->
<!--                 <div class="card-body"> -->
<!--                     <p>External links to help you.</p> -->
<!--                     <table> -->
<!--                         <tr><td><a href="http://travian.kirilloid.ru/warsim2.php" target="_blank" class="text-primary font-weight-bold">Combat Simulator</a></td></tr> -->
<!--                         <tr><td><a href="http://travian.kirilloid.ru/war.php#s=1.44&func=cu%2Ft" target="_blank" class="text-primary font-weight-bold">Unit Attributes</a></td></tr> -->
<!--                         <tr><td><a href="http://travian.kirilloid.ru/build.php#mb=1&s=1.44" target="_blank" class="text-primary font-weight-bold">Building Calculator</a></td></tr> -->
<!--                         <tr><td><a href="" target="_blank" class="text-primary font-weight-bold">Cropper Development</a></td></tr> -->
<!--                         <tr><td><a href="http://travian.kirilloid.ru/villages_res.php#s=1.44&fl=10,10,10,10&fs=31" target="_blank" class="text-primary font-weight-bold">Resource Calculator</a></td></tr> -->
<!--                     </table> -->
<!--                 </div> -->
<!--             </div>                       -->
        </div>
    </div>  
    
@endsection