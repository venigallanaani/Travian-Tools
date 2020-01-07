@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Call for {{$task['player']}} ({{$task['village']}})</strong></div>
			<div class="card-text">				
        <!-- ==================================== Defense Tasks Status ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">				
		          <!-- ====================== Defense Task Details ====================== -->
					<p class="h4"><strong>Defense Call Details</strong></p>
			   <!-- ========== Alert about the update =================================== -->
			   @php
			   		if($task['priority']=='high'){$color='text-danger';}
			   		elseif($task['priority']=='medium'){$color='text-warning';}
			   		elseif($task['priority']=='low'){$color='text-info';}
			   		else{$color='';}
			   @endphp
					<table class="table mx-auto col-md-8 table-borderless text-left">
						<tr>
							<td class="py-1"><strong>Target: <a href="https://{{Session::get('server.url')}}/karte.php?x={{$task['x']}}&y={{$task['y']}}" target="_blank">{{$task['player']}} ({{$task['village']}})</a></strong></td>
							<td class="py-1"><strong>Defense </strong>(<img alt="upkeep" src="/images/x.gif" class="res upkeep">): {{number_format($task['def_remain'])}}</td>							
						</tr>
						<tr>
							<td class="py-1"><strong>Type:</strong> {{ucfirst($task['type'])}}</td>
							<td class="py-1"><strong>Priority: <span class="{{$color}}">{{ucfirst($task['priority'])}}</span></strong></td>
						</tr>
						<tr>
							<td class="py-1"><strong>Land Time:</strong> {{$task['target_time']}}</td>
							<td class="py-1"><strong>Time Left: <span id="{{$task['task_id']}}"></span></strong></td>
						</tr>
						<tr>
							<td class=""><strong>Comments: </strong>{{$task['comments']}}</td>
							<td class=""><a href="/plus/defense/travel/{{$task->task_id}}"><button class="btn btn-info py-2">Calculate Travel Time</button></a></td>
						</tr>
					</table>
					
				@yield('travel')

				<!-- ================ Defense Troops Input data ========================== -->
					
					<form method="post" action="/plus/defense/{{$task->task_id}}">
						{{ csrf_field() }}
						<div  class="py-2 px-1 text-center rounded" style="background-color:#dbeef4" >
    						<p class="h5 text-info"><strong>Enter Your Defense</strong></p>
    						<div class="bg-white rounded">
        						<table class="table table-borderless col-md-11 mx-auto small">
        							<tr>
        								<td class="pr-0 pb-1">
        									<select name="village">
        										<option value="">--Select Village--</option>
        									@foreach($villages as $village)
        										<option value="{{$village['vid']}}">{{$village['village']}}</option>    									
    										@endforeach	
        									</select>
        								</td>
        								@foreach($units as $unit)
        									<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}"></td>
        								@endforeach    								
        							</tr>
        							<tr>
        								<td class="pr-0 pt-1"><input type="text" name="xCor" size="2" /> | <input type="text" name="yCor" size="2" /></td>
        								<td class="px-0 pt-1" ><input type="text" name="unit01" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit02" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit03" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit04" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit05" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit06" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit07" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit08" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit09" size="5" /></td>
        								<td class="px-0 pt-1"><input type="text" name="unit10" size="5" /></td>    								
        							</tr>
        						</table>
        						<table class="table table-borderless col-md-8 mx-auto text-left">
        							<tr>
        								<td><strong>Resources </strong>(<img alt="" src="/images/x.gif" class="res all">): <input type="text" name="res" size="10" /></td>
        								<td><button class="btn btn-warning px-5" name="submit"><strong>Submit</strong></button></td>
    								</tr>    									
        						</table>    						
    						</div>
						</div>
					</form>					
					
					<div class="my-3">
					@if(count($troops)>0)
						<p class="h5"><strong>Your Contributions</strong></p>
						<table class="table table-bordered table-hover col-md-10 mx-auto">
							<tr>	
								<th class="p-0">Village</th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[0]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[0]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[1]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[1]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[2]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[2]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[3]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[3]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[4]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[4]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[5]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[5]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[6]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[6]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[7]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[7]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[8]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[8]['image']}}"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[9]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[9]['image']}}"></th>  
							</tr>
							@php
								$upkeep=0;	$defInf=0;	$defCav=0;	$res=0;
							@endphp
							@foreach($troops as $troop)
								@php
    								$upkeep+=$troop->upkeep;
    								$defInf+=$troop->def_inf;
    								$defCav+=$troop->def_cav;
    								$res+=$troop->resources;
								@endphp
    							<tr class="">
    								<td class="py-1">{{$troop->village}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit01)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit02)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit03)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit04)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit05)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit06)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit07)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit08)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit09)}}</td>
    								<td class="py-1 px-0 small">{{number_format($troop->unit10)}}</td>
    							</tr>				
							@endforeach
							<tr>	
								<td colspan="3" rowspan="2" class="p-0 text-center align-middle" data-toggle="tooltip" data-placement="top" title="Total Troops">
									<img alt="" src="/images/x.gif" class="res upkeep">: <strong>{{number_format($upkeep)}}</strong></td>
								<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Total Defense">
									<img alt="" src="/images/x.gif" class="stats def">: {{number_format($defInf + $defCav)}}</td>
								<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Resources">
									<img alt="" src="/images/x.gif" class="res all">: {{number_format($res)}}</td>								
							</tr>
							<tr>
								<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Infantry Defense">
									<img alt="" src="/images/x.gif" class="stats dinf">: {{number_format($defInf)}}</td>
								<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Cavalry Defense">
									<img alt="" src="/images/x.gif" class="stats dcav">: {{number_format($defCav)}}</td>								
							</tr>
						</table>
					@endif
					</div>					
				</div>
			</div>
		</div>
@endsection

@push('scripts')
	<script>
        countDown("{{$task['task_id']}}","{{$task['target_time']}}","{{Session::get('timezone')}}");
	</script>


@endpush