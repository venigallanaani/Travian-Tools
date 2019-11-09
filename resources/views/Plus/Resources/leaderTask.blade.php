@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Resource Task Details</strong></div>
			<div class="card-text">				
        <!-- ==================================== Defense Tasks Status ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">				
		          <!-- ====================== Defense Task Details ====================== -->
					<p class="h5 py-2">Resource Task for <strong>{{$task[0]['player']}} <small>({{$task[0]['village']}})</small></strong></p>
        			
        			<!-- ===============Defense task details =========================== -->
					<table class="table mx-auto col-md-11 table-bordered text-center small" style="background-color:#dbeef4;">
						<form action="/resource/update" method="POST">
							{{ csrf_field() }}
							<tr>
								<td class="py-2">
									<p class="py-0"><strong>Resource Needed:</strong> <input type="text" name="resNeed" size="8" value="{{$task[0]['res_total']}}"/></p>									
									<p class="py-0"><strong>Target Time:</strong> <input type="text" name="targetTime" size="20" value="{{$task[0]['target_time']}}" class="dateTimePicker"/></p>
									<p class="py-0"><strong>Resource Type:</strong>
        								<input type="radio" name="resType" value="ALL" @php if($task[0]['type']=='all'){echo 'checked';} @endphp> <img alt="all" src="/images/x.gif" class="res all"> 
        								<input type="radio" name="resType" value="WOOD" @php if($task[0]['type']=='wood'){echo 'checked';} @endphp> <img alt="wood" src="/images/x.gif" class="res wood"> 
        								<input type="radio" name="resType" value="CLAY" @php if($task[0]['type']=='clay'){echo 'checked';} @endphp> <img alt="clay" src="/images/x.gif" class="res clay"> 
        								<input type="radio" name="resType" value="IRON" @php if($task[0]['type']=='iron'){echo 'checked';} @endphp> <img alt="iron" src="/images/x.gif" class="res iron"> 
        								<input type="radio" name="resType" value="CROP" @php if($task[0]['type']=='crop'){echo 'checked';} @endphp> <img alt="crop" src="/images/x.gif" class="res crop">
									</p>
									<p class="py-0"><strong>Comments:</strong>
										<textarea name="comments" class="form-control" rows="3">{{$task[0]['comments']}}</textarea>
									</p>
								</td>
								<td class="py-2">
									<p class="py-0"><strong>Resource Received:</strong> {{$task[0]['res_received']}} ({{$task[0]['res_percent']}}%) </p>
									<p class="py-0"><strong>Remaining Time: <span id="{{$task[0]['task_id']}}"></span></strong></p>
									<p class="py-0 my-2"><button class="btn btn-primary px-5" name="update" value="{{$task[0]['task_id']}}">Update Task</button></p>
									<p class="py-0 my-2"><button class="btn btn-success px-5" name="complete" value="{{$task[0]['task_id']}}">Mark as Complete</button></p>
									<p class="py-0 my-2"><button class="btn btn-warning px-5" name="delete" value="{{$task[0]['task_id']}}">Delete Task</button></p>
								</td>
							</tr>
						</form>		
					</table>
				<!-- ============================== Table of all the players and defense details =============================== -->
					<div class="my-5">
					@if(count($players)>0)
						<p class="h5 text-info"><strong>Player Contributions</strong></p>
						<table class="table table-bordered col-md-8 mx-auto table-hover">
							<tr class="bg-info text-white">
								<th class="py-1 h5">#</th>
								<th class="py-1 h5">Player</th>
								<th class="py-1 h5">%</th>
								<th class="py-1 h5">Resources</th>
							</tr>
							@foreach($players as $index=> $player)
    							<tr>		
    								<td class="py-1">{{$index+1}}</td>
    								<td class="py-1"><a href="{{route('findPlayer')}}/{{$player->player}}/1"><strong>{{$player->player}}</strong></a></td>
    								<td class="py-1">{{$player->percent}}%</td>
    								<td class="py-1">{{number_format($player->resources)}}</td>
    							</tr>
							@endforeach
						</table>
					@endif					
					</div>					
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
        countDown("{{$task[0]['task_id']}}","{{$task[0]['target_time']}}");
	</script>           

@endpush

@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endpush