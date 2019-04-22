@extends('Plus.Defense.Search.search')

@section('results')
	
	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Search Results</strong></div>
		<div class="card-text">	
		@if(count($troops)==0)
    		<div class="text-center my-2">	
				<p>No defense troops are found with given parameters</p>	
			</div>
		@else
			<div class="text-center my-2 col-md-11 mx-auto">	
				<table class="table table-sm table-hover m-2 table-bordered small">
					<thead>
						<tr>
							<th>Dist</th>
							<th>Village</th>
							<th>Player</th>
							<th colspan="10">Troops</th>
							<th data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></th>
							<th>Start Time</th>
						</tr>
					</thead>
				@foreach($troops as $troop)
					<tr>
						<td rowspan="2" class="align-middle"><strong>{{$troop['dist']}}</strong></td>
						<td rowspan="2" class="align-middle"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$troop['x']}}&y={{$troop['y']}}" target="_blank">
							{{$troop['village']}} ({{$troop['x']}}|{{$troop['y']}})</a></td>
						<td rowspan="2" class="align-middle"><a href="/finders/player/{{$troop['player']}}/1" target="_blank">
							{{$troop['player']}}</a></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][0]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][1]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][2]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][3]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][4]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][5]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][6]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][7]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][8]['image']}}"></td>
						<td class="px-1 py-0"><img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][9]['image']}}"></td>
						<td rowspan="2" class="align-middle"><strong>{{$troop['upkeep']}}</strong></td>
						<td rowspan="2" class="align-middle">{{$troop['startTime']}}</td>						
					</tr>
					<tr>
						<td class="px-1 py-0">{{$troop['unit01']}}</td>
						<td class="px-1 py-0">{{$troop['unit02']}}</td>
						<td class="px-1 py-0">{{$troop['unit03']}}</td>
						<td class="px-1 py-0">{{$troop['unit04']}}</td>
						<td class="px-1 py-0">{{$troop['unit05']}}</td>
						<td class="px-1 py-0">{{$troop['unit06']}}</td>
						<td class="px-1 py-0">{{$troop['unit07']}}</td>
						<td class="px-1 py-0">{{$troop['unit08']}}</td>
						<td class="px-1 py-0">{{$troop['unit09']}}</td>
						<td class="px-1 py-0">{{$troop['unit10']}}</td>
					</tr>
				@endforeach
				</table>	
			</div>
		
		@endif	
		</div>
	</div>

@endsection