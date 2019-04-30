@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-warning text-white">
				<strong>Account Overview</strong>
			</div>
			<div class="card-text">
        		<div>
        			<table class="table table-borderless table-sm col-md-5 mx-auto my-3">
						<tr>
							<td class="py-0"><strong><span class="text-warning">Profile Name</span></strong></td>
							<td class="py-0">: <strong>{{$player->player}}</strong></td>
						</tr>
						<tr>
							<td class="py-0"><strong><span class="text-warning">Rank</span></strong></td>
							<td class="py-0">: {{$player->rank}}</td>
						</tr>
						<tr>
							<td class="py-0"><strong><span class="text-warning">Population</span></strong></td>
							<td class="py-0">: {{$player->population}} <small>({{$player->diffpop}})</small></td>
						</tr>
						<tr>
							<td class="py-0"><strong><span class="text-warning">Villages</span></strong></td>
							<td class="py-0">: {{$player->villages}}</td>
						</tr>
						<tr>
							<td class="py-0"><strong><span class="text-warning">Tribe</span></strong></td>
							<td class="py-0">: {{$account->tribe}}</td>
						</tr>
						<tr>
							<td class="py-0"><strong><span class="text-warning">Alliance Name</span></strong></td>
							<td class="py-0">: <a href="/finders/alliance/{{$player->alliance}}/1" target="_blank"><strong>{{$player->alliance}}</strong></a></td>
						</tr>
						<tr>
							<td class="py-0"><strong><span class="text-warning">Plus Group</span></strong></td>
                    	@if(Session::has('plus'))
                    		<td class="py-0">: <a href="/plus">{{Session::get('plus.name')}}</td>
                    	@else 	
                    		<td class="py-0">: </td>
                    	@endif
						</tr>        						
        			</table>
        		</div>
        		
        		<div class="col-md-8 text-center mt-3 mx-auto">
        			<table class="table table-bordered text-center table-sm">
        			   	<tr>        					
        					<td colspan="2" class="h4 text-white bg-warning"><strong>Ingame Links</strong></td>
        				</tr>
        				<tr>        					
        					<td class="h5"><a href="https://{{Session::get('server.url')}}/statistiken.php?id=0&idSub=1&name={{$player->player}}" target="_blank">
        						<strong>Attack Points</strong></a></td>
        					<td class="h5"><a href="https://{{Session::get('server.url')}}/statistiken.php?id=0&idSub=2&name={{$player->player}}" target="_blank">
        						<strong>Defense Points</strong></a></td>
        				</tr>
        			</table>        		

        			<table class="table table-bordered table-hover table-sm">
        				<thead class="thead">
        					<tr>
        						<th colspan="4" class="h4 text-white bg-warning"><strong>Villages</strong></th>
        					</tr>
        					<tr>
        						<th class="col-md-1">#</th>
        						<th class="col-md-4">Village Name</th>
        						<th class="col-md-1">Population</th>
        						<th class="col-md-1">Coordinates</th>
        					</tr>
        				</thead>
        				@foreach($villages as $index=>$village)
            				<tr>
            					<td>{{$index+1}}</td>
            					<td class="text-left">{{$village->village}}</td>
            					<td>{{$village->population}} <small>({{$village->diffPop}})</small></td>
            					<td><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$village->x}}&y={{$village->y}}" target="_blank">
            						{{$village->x}}|{{$village->y}}</a></td>
        					</tr>
    					@endforeach
        			</table>
        		</div>
			</div>			
		</div>
	

@endsection