@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Rankings</strong></div>
			<div class="card-text">			
		<!-- ============================ Add success/failure notifications ============================== -->
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
				<div class="container">
    	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                </div>
            @endif
        @endforeach
		<!-- =========================== leadership Options control panel ================================ -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table table-hover table-sm table-bordered align-middle small">
						<thead class="bg-dark text-white">
    						<tr>
    							<th class="align-middle" rowspan="2">#</th>
    							<th class="col-md-2 align-middle" rowspan="2">Player</th>
    							<th class="col-md-2 align-middle" rowspan="2">Account</th>
    							<th class="col-md-2 align-middle" rowspan="2">Alliance</th>
    							<th colspan="5">Rankings</th>
    						</tr>
    						<tr class="">
    							<th class="col-md-1">Population</th>
    							<th class="col-md-1">Troops</th>
    							<th class="col-md-1">Offense</th>
    							<th class="col-md-1">Defense</th>    							
    							<th class="col-md-1">Hero</th>
    						</tr>
						</thead>	
				@if(!$players==null)
					@foreach($players as $index=>$player)
						<tr>	
							<td>{{$index+1}}</td>										
							<td><a href="/finder/player/{{$player['account']}}/1" target="_blank">{{$player['account']}}</a></td>
							<td><a href="/plus/member/{{$player['user']}}" target="_blank">{{$player['user']}}</a></td>
							<td><a href="/finder/alliance/{{$player['alliance']}}/1" target="_blank">{{$player['alliance']}}</a></td>					
            				<td class="font-weight-bold"></td>
            				<td class="font-weight-bold"></td>
            				<td class="font-weight-bold"></td>
            				<td class="font-weight-bold"></td>
            				<td class="font-weight-bold"></td>				       
            			</tr>
					@endforeach	
				@endif			
						<tr>	
							<td>1</td>										
							<td><a href="/finder/player/Barca/1" target="_blank">Barca</a></td>
							<td><a href="/plus/member/admin" target="_blank">admin</a></td>
							<td><a href="/finder/alliance/1776/1" target="_blank">1776</a></td>					
            				<td class="font-weight-bold">1</td>
            				<td class="font-weight-bold">1</td>
            				<td class="font-weight-bold">1</td>
            				<td class="font-weight-bold">1</td>
            				<td class="font-weight-bold">1</td>			       
            			</tr>
					</table>
				</div>			
			</div>
		</div>
@endsection

