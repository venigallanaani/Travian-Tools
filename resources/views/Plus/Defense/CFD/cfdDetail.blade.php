@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Call Details</strong></div>
			<div class="card-text">				
        <!-- ==================================== Defense Tasks Status ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">				
		          <!-- ====================== Defense Task Details ====================== -->
					<p class="h4 py-2"><strong>Defense Call for {{$task->player}} ({{$task->village}})</strong></p>
			   <!-- ========== Alert about the update =================================== -->		
        		@foreach(['danger','success','warning','info'] as $msg)
        			@if(Session::has($msg))
        	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>{{ Session::get($msg) }}
                        </div>
                    @endif
                @endforeach
        			<!-- ===============Defense task details =========================== -->
					<table class="table mx-auto col-md-11 table-bordered text-center table-sm" style="background-color:#dbeef4;">
						<form action="/defense/cfd/update" method="POST">
							{{ csrf_field() }}
							<tr>
								<td class="py-2">
									<p class="py-0"><strong>Defense Needed:</strong> <input type="text" name="defNeed" size="10" value="{{number_format($task->def_total)}}"/></p>
									<p class="py-0"><strong>Land Time:</strong> <input type="text" name="targetTime" size="20" value="{{$task->target_time}}" class="dateTimePicker"/></p>
									<p class="py-0"><strong>Defense Priority:</strong> 
    													<select name="priority">
    														<option value="{{$task->priority}}">{{$task->priority}}</option>
    														<option value="high">High</option>
    														<option value="medium">Medium</option>
    														<option value="low">Low</option>
    														<option value="none">None</option>
    													</select></p>
	    							<p class="py-0"><strong>Defense Type:</strong> 
    													<select name="type">
    														<option value="{{$task->type}}">{{$task->type}}</option>
    														<option value="defend">Defend</option>
    														<option value="snipe">Snipe</option>
    														<option value="scout">Scout</option>
    														<option value="other">Other</option>
														</select></p>	
									<p><strong><span class="align-top">Comments: </span></strong><textarea name="comments">{{$task->comments}}</textarea></p>							
								</td>
								<td class="py-2">
									<p class="py-0"><strong>Remaining Time: <span id="{{$task->task_id}}"></span></strong></p>
									<p class="py-0 my-1"><button class="btn btn-primary px-5" name="update" value="{{$task->task_id}}">Update Task</button></p>
									<p class="py-0 my-1"><button class="btn btn-success px-5" name="complete" value="{{$task->task_id}}">Mark as Complete</button></p>
									<p class="py-0 my-1"><button class="btn btn-warning px-5" name="delete" value="{{$task->task_id}}">Delete Task</button></p>
									<p></p>
									<p class="py-0 my-1"><strong>Created By:</strong> {{$task->created_by}}</p>
									<p class="py-0 my-1"><strong>Updated By:</strong> {{$task->updated_by}}</p>
								</td>
							</tr>
						</form>
					  	<tr class="py-2">
							<td class="py-0">								
								<p class="py-0 my-1"><strong>Defense Received(<img alt="" src="/images/x.gif" class="res upkeep">): </strong>{{number_format($task->def_received)}} ({{$task->def_percent}}%)</p>
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Total Defense"><img alt="" src="/images/x.gif" class="stats def">: {{$task->def_inf + $task->def_cav}}</p>
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Infantry Defense"><img alt="" src="/images/x.gif" class="stats dinf">: {{$task->def_inf}}</p>
							</td>
							<td class="py-0">								
								<p class="py-0 my-1"><strong>Defense Remaining(<img alt="" src="/images/x.gif" class="res upkeep">): </strong>{{number_format($task->def_remain)}}</p>
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Resources"><img alt="" src="/images/x.gif" class="res all"> : {{number_format($task->resources)}}</p>
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Cavalry Defense"><img alt="" src="/images/x.gif" class="stats dcav">: {{$task->def_cav}}</p>
							</td>
						</tr>					
					</table>
	<!-- ===================== Displays the incoming troops and types ============================================ -->
				@if(count($tribes)>0)
					<div class="my-3">
						<p class="h5 text-info"><strong>Incoming Troops</strong></p>
						<table class="table table-bordered table-hover small col-md-10 mx-auto">
							@foreach($tribes as $tribe)
								@php
									if($tribe['tribe_id'] == 1){ $tribeName='Roman';}
									elseif($tribe['tribe_id'] == 2){ $tribeName='Teuton';}
									elseif($tribe['tribe_id'] == 3){ $tribeName='Gaul';}
									elseif($tribe['tribe_id'] == 6){ $tribeName='Egyptian';}
									elseif($tribe['tribe_id'] == 7){ $tribeName='Hun';}
									else{ $tribeName='Nature';}
								@endphp
    							<tr>	
    								<th rowspan="2">{{$tribeName}}</th>
    								<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][0]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][0]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][1]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][1]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][2]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][2]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][3]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][3]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][4]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][4]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][5]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][5]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][6]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][6]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][7]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][7]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][8]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][8]['image']}}"></th>
									<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[$tribe['tribe_id']][9]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[$tribe['tribe_id']][9]['image']}}"></th> 
    							</tr>
    							<tr>
    								<td class="py-1">{{$tribe['unit_01']}}</td>
    								<td class="py-1">{{$tribe['unit_02']}}</td>
    								<td class="py-1">{{$tribe->unit_03}}</td>
    								<td class="py-1">{{$tribe->unit_04}}</td>
    								<td class="py-1">{{$tribe->unit_05}}</td>
    								<td class="py-1">{{$tribe->unit_06}}</td>
    								<td class="py-1">{{$tribe->unit_07}}</td>
    								<td class="py-1">{{$tribe->unit_08}}</td>
    								<td class="py-1">{{$tribe->unit_09}}</td>
    								<td class="py-1">{{$tribe->unit_10}}</td>
    							</tr>
							@endforeach
						</table>
					</div>
				@endif
				<!-- ============================== Table of all the players and defense details =============================== -->
				@if(count($players)>0)
					<div class="my-3">
						<p class="h5 text-info"><strong>Player Contributions</strong></p>
						<table class="table table-bordered col-md-8 mx-auto table-hover">
							<tr class="bg-info text-white">
								<th class="h5">#</th>
								<th class="h5">Player</th>
								<th class="h5">Defense</th>
								<th class="h5">Resources</th>
								<th class="h5"></th>
							</tr>
							@foreach($players as $index=>$player)
							<tr>		
								<td class="">{{$index+1}}</td>
								<td class="" href="/finder/player/{{$player->player}}/1" target="_blank">{{$player->player}}</td>
								<td class="">{{number_format($player->upkeep)}}</td>
								<td class="">{{number_format($player->res)}}</td>
								<td class=""><a class="btn btn-sm btn-outline-secondary" href="/defense/cfd/troops/{{$task->task_id}}/{{$player->uid}}">
    								<i class="fa fa-angle-double-right"></i> troops</a></td>
							</tr>
							@endforeach
						</table>					
					</div>
				@endif
				</div>
			</div>
		</div>

@endsection

@push('scripts')

	<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
	<script type="text/javascript">
        $(".dateTimePicker").datetimepicker({
            format: "yyyy-mm-dd hh:ii:ss",
            showSecond:true
        });
	</script>
	<script>
        countDown("{{$task->task_id}}","{{$task->target_time}}","{{ Session::get('server.tmz')}}");
	</script>        

@endpush

@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endpush