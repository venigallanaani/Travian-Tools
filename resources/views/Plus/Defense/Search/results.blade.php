@extends('Plus.Defense.Search.search')

@section('results')
	
	<div class="card float-md-left col-md-10 mb-5 mt-1 p-0 shadow">
		<div class="card-header h5 py-2 bg-info text-white"><strong>Defense Search Results</strong></div>
		<div class="card-text">	
		@if(count($troops)==0)
    		<div class="text-center my-2 py-2 text-danger">	
				<p class="h6">No defense troops are found with given parameters</p>	
			</div>
		@else
			<div class="text-center my-2 col-md-11 mx-auto">	
				<table class="table table-sm table-hover m-2 table-bordered small">
					<thead>
						<tr class="h6">
							<th>Distance</th>
							<th>Player</th>
							<th>Village</th>
							<th colspan="10">Troops</th>
							<th data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></th>
						@if($target != null)
							<th>Start Time</th>
						@endif
						</tr>
					</thead>
				@foreach($troops as $troop)
					<tr>
						<td rowspan="2" class="align-middle">{{round($troop['dist'],2)}}</td>
						<td rowspan="2" class="align-middle"><strong><a href="{{route('findPlayer')}}/{{$troop['player']}}/1" target="_blank">{{$troop['player']}}</a></strong></td>
						<td rowspan="2" class="align-middle"><strong><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$troop['x']}}&y={{$troop['y']}}" target="_blank">
							{{$troop['village']}} ({{$troop['x']}}|{{$troop['y']}})</a></strong></td>											
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
						<td rowspan="2" class="align-middle"><strong>{{number_format($troop['upkeep'])}}</strong></td>
					@if($target !=null)
						<td rowspan="2" class="align-middle">{{$troop['start']}}</td>		
					@endif				
					</tr>
					<tr>
						<td class="px-1 py-0">{{number_format($troop['units'][0])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][1])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][2])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][3])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][4])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][5])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][6])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][7])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][8])}}</td>
						<td class="px-1 py-0">{{number_format($troop['units'][9])}}</td>
					</tr>
				@endforeach
				</table>	
			</div>
		
		@endif	
		</div>
	</div>

@endsection