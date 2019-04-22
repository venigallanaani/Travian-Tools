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
						<thead class="bg-info text-white">
    						<tr>
    							<th class="align-middle" rowspan="2">#</th>
    							<th class="align-middle" rowspan="2">Player</th>
    							<th class="align-middle" rowspan="2">Account</th>
    							<th colspan="5">Rankings</th>
    						</tr>
    						<tr class="">
    							<th>Population</th>
    							<th>Troops</th>
    							<th>Offense</th>
    							<th>Defense</th> 
    							<th>Hero</th>
    						</tr>
						</thead>	
				@if(!$players==null)
					@foreach($players as $index=>$player)
						<tr>	
							<td>{{$index+1}}</td>										
							<td><a href="/finders/player/{{$player['player']}}/1" target="_blank">{{$player['player']}}</a></td>
							<td><a href="/plus/member/{{$player['account']}}" target="_blank">{{$player['account']}}</a></td>				
            				<td><strong>{{$player['pop'][0]->rank}}</strong> ({{$player['pop'][0]->value}})</td>
            				<td><strong>{{$player['total'][0]->rank}}</strong> ({{$player['total'][0]->value}})</td>
            				<td><strong>{{$player['off'][0]->rank}}</strong> ({{$player['off'][0]->value}})</td>
            				<td><strong>{{$player['def'][0]->rank}}</strong> ({{$player['def'][0]->value}})</td>
            				<td><strong>{{$player['hero'][0]->rank}}</strong> ({{$player['hero'][0]->exp}})</td>
            			</tr>
					@endforeach	
				@endif
					</table>
				</div>	
			</div>
		</div>
@endsection

