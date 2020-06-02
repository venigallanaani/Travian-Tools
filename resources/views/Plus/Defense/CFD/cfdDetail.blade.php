@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-10 mb-5 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Defense Call Details</strong></div>
			<div class="card-text">				
        <!-- ==================================== Defense Tasks Status ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">				
		          <!-- ====================== Defense Task Details ====================== -->
					<p class="h5 py-2"><strong>Defense Call for {{$task->player}} ({{$task->village}})</strong></p>
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
					<table class="table mx-auto col-md-11 table-bordered text-center table-sm" style="font-size:0.9em;     background-color:#dbeef4;">
						<form action="/defense/cfd/update" method="POST" autocomplete="off">
							{{ csrf_field() }}
							<tr>
								<td class="py-2">									
									<p class="py-1 my-1"><strong>Defense Needed:</strong> <input type="text" name="defNeed" size="10" value="{{$task->def_total}}"/></p>
									<p class="py-1 my-1"><strong>Land Time:</strong> <input type="text" name="targetTime" size="20" value="{{$task->target_time}}" class="dateTimePicker"/></p>
									<p class="py-1 my-1"><strong>Remaining Time: <span id="{{$task->task_id}}"></span></strong></p>
									<p class="py-1 my-1"><strong>Defense Priority:</strong> 
    													<select name="priority">
    														<option value="high"  @if($task->priority == 'high') selected @endif>High</option>
    														<option value="medium" @if($task->priority == 'medium') selected @endif>Medium</option>
    														<option value="low" @if($task->priority == 'low') selected @endif>Low</option>
    														<option value="none" @if($task->priority == 'none') selected @endif>None</option>
    													</select></p>
	    							<p class="py-1 my-1"><strong>Defense Type:</strong> 
    													<select name="type">
    														<option value="defend" @if($task->type == 'defend') selected @endif>Defend</option>
    														<option value="snipe" @if($task->type == 'snipe') selected @endif>Snipe</option>
    														<option value="stand" @if($task->type == 'stand') selected @endif>Standing</option>
    														<option value="scout" @if($task->type == 'scout') selected @endif>Scout</option>
    														<option value="other" @if($task->type == 'other') selected @endif>Other</option>
														</select></p>	
									<p class="py-1 my-1"><strong><span class="align-top">Comments: </span></strong><textarea rows="2" name="comments">{{$task->comments}}</textarea></p>
									<p class="py-1 my-1"><input type="checkbox" name="crop" @if($task->crop==1) checked @endif><strong> Send Crop</strong></p>									
								</td>
								<td class="py-2">									
									<p class="py-1 my-1"><button class="btn btn-primary px-5 shadow btn-sm" name="update" value="{{$task->task_id}}">Update Task</button></p>
									@if($task->status=='ACTIVE')
										<p class="py-1 my-1"><button class="btn btn-success px-5 shadow btn-sm" name="complete" value="{{$task->task_id}}">Mark as Complete</button></p>
									@endif
									@if($task->status!='WITHDRAW')
										<p class="py-1 my-1"><button class="btn btn-warning px-5 shadow btn-sm" name="withdraw" value="{{$task->task_id}}">Withdraw Troops</button></p>
									@endif
									<p class="py-1 my-1"><button class="btn btn-danger px-5 shadow btn-sm" name="delete" value="{{$task->task_id}}">Delete Task</button></p>								
									<br>
									<p class="py-1 my-1"><strong>Created By:</strong> {{$task->created_by}}</p>
									<p class="py-1 my-1"><strong>Last Updated By:</strong> {{$task->updated_by}}</p>
								</td>
							</tr>
						</form>
					  	<tr class="py-2">
							<td class="py-0">								
								<p class="py-0 my-1"><strong>Defense Received(<img alt="" src="/images/x.gif" class="res upkeep">): </strong>{{number_format($task->def_received)}} ({{$task->def_percent}}%)</p>
								<p class="py-0 my-1"><strong>Defense Remaining(<img alt="" src="/images/x.gif" class="res upkeep">): </strong>{{number_format($task->def_remain)}}</p>
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Resources"><img alt="" src="/images/x.gif" class="res all"> : {{number_format($task->resources)}}</p>								
								
							</td>
							<td class="py-0">								
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Infantry Defense"><img alt="" src="/images/x.gif" class="stats dinf">: {{number_format($task->def_inf)}}</p>								
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Cavalry Defense"><img alt="" src="/images/x.gif" class="stats dcav">: {{number_format($task->def_cav)}}</p>
								<p class="py-0 my-1" data-toggle="tooltip" data-placement="top" title="Total Defense"><img alt="" src="/images/x.gif" class="stats def">: {{number_format($task->def_inf + $task->def_cav)}}</p>
							</td>
						</tr>					
					</table>
					<a href="/defense/cfd/travel/{{$task->task_id}}" target="_blank"><button class="btn btn-info shadow py-2 px-3">Find Available Defense</button></a>
	<!-- ===================== Displays the incoming troops and types ============================================ -->
				@if(count($tribes)>0)
					<div class="my-3">
						<p class="h5 text-info"><strong>Incoming Defense Troops</strong></p>
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
    								<th rowspan="2" class="h6">{{$tribeName}}</th>
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
    								<td class="py-1">{{number_format($tribe['unit_01'])}}</td>
    								<td class="py-1">{{number_format($tribe['unit_02'])}}</td>
    								<td class="py-1">{{number_format($tribe->unit_03)}}</td>
    								<td class="py-1">{{number_format($tribe->unit_04)}}</td>
    								<td class="py-1">{{number_format($tribe->unit_05)}}</td>
    								<td class="py-1">{{number_format($tribe->unit_06)}}</td>
    								<td class="py-1">{{number_format($tribe->unit_07)}}</td>
    								<td class="py-1">{{number_format($tribe->unit_08)}}</td>
    								<td class="py-1">{{number_format($tribe->unit_09)}}</td>
    								<td class="py-1">{{number_format($tribe->unit_10)}}</td>
    							</tr>
							@endforeach
						</table>
					</div>
				@endif
				<!-- ============================== Table of all the players and defense details =============================== -->
				@if(count($players)>0)
					<div class="my-3">
						<p class="h5 text-info"><strong>Player Contributions</strong></p>
						<table class="table table-bordered col-md-8 mx-auto table-hover shadow">
							<tr class="bg-info text-white">
								<th class="h6">#</th>
								<th class="h6">Player</th>
								<th class="h6">Defense</th>
								<th class="h6">Resources</th>
								<th class="h6"></th>
							</tr>
							@foreach($players as $index=>$player)
							<tr class="h6" style="font-size:0.9em">		
								<td class="py-1">{{$index+1}}</td>
								<td class="py-1"><a href="{{route('findPlayer')}}/{{$player->player}}/1" target="_blank">{{$player->player}}</a></td>
								<td class="py-1">{{number_format($player->upkeep)}}</td>
								<td class="py-1">{{number_format($player->res)}}</td>
								<td class="py-1"><a class="btn btn-sm btn-outline-secondary py-0" href="/defense/cfd/troops/{{$task->task_id}}/{{$player->uid}}">
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
        countDown("{{$task->task_id}}","{{$task->target_time}}","{{Session::get('timezone')}}");
	</script>        

@endpush

@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endpush