@extends('Plus.template')

@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h4 py-2 bg-info text-white"><strong>Offense Troops List</strong></div>
		<div class="card-text">
	@foreach(['danger','success','warning','info'] as $msg)
		@if(Session::has($msg))
        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>{{ Session::get($msg) }}
            </div>
        @endif
    @endforeach
    		
		@if(count($troops)==0)
    		<div class="text-center my-2">	
				<p>No offense troops are found</p>	
			</div>
		@else
			<div class="text-center my-2 col-md-11 mx-auto">	
				<table class="table table-sm table-hover m-2 table-bordered small">
					<thead class="bg-info text-white">
						<tr>
							<th></th>
							<th>Player</th>
							<th>Village</th>							
							<th colspan="10">Troops</th>
							<th data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></th>
							<th class="py-0 px-1"data-toggle="tooltip" data-placement="top" title="Tournament Square"><img alt="" src="/images/x.gif" class="build tsq"></th>
							<th>Last Update</th>							
						</tr>
					</thead>
				@foreach($troops as $index=>$troop)
					<tr>
						<td rowspan="2" class="align-middle">{{$index+1}}</td>
						<td rowspan="2" class="align-middle"><a href="/finder/player/{{$troop['player']}}/1" target="_blank">
							<strong>{{$troop['player']}}</strong></a></td>
						<td rowspan="2" class="align-middle"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$troop['x']}}&y={{$troop['y']}}" target="_blank">
							<strong>{{$troop['village']}} ({{$troop['x']}}|{{$troop['y']}})</strong></a></td>						
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][0]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][0]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][1]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][1]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][2]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][2]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][3]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][3]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][4]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][4]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][5]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][5]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][6]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][6]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][7]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][7]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][8]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][8]['image']}}"></td>
						<td class="px-1 py-0" data-toggle="tooltip" data-placement="top" title="{{$tribes[$troop['tribe']][9]['name']}}">
							<img alt="" src="/images/x.gif" class="units {{$tribes[$troop['tribe']][9]['image']}}"></td>
						<td rowspan="2" class="align-middle"><strong>{{$troop['upkeep']}}</strong></td>						
						<td rowspan="2" class="align-middle">{{$troop['tsq']}}</td>
						<td rowspan="2" class="align-middle">{{$troop['update']}}</td>
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