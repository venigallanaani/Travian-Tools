@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Tasks</strong></div>
			<div class="card-text">
    <!-- ==================================== List of CFD is progress ======================================= -->
				@if(count($tasks)==0)
					<p class="text-center h5 py-2">No defense tasks are active currently.</p>				
				@endif
				
        		@foreach(['danger','success','warning','info'] as $msg)
        			@if(Session::has($msg))
        	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>{{ Session::get($msg) }}
                        </div>
                    @endif
                @endforeach	
                	
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Player</th>
    							<th class="col-md-1">Defense</th>
    							<th class="col-md-1">Type</th>
    							<th class="col-md-1">Priority</th>
    							<th class="col-md-2">Land Time</th>
    							<th class="col-md-1">Time left</th>
    							<th class="col-md-1"></th>    							
    						</tr>
						</thead>
						@foreach($tasks as $task)
							@php
								if($task->priority=='high'){$color='text-danger';}
								elseif($task->priority=='medium'){$color='text-warning';}
								elseif($task->priority=='low'){$color='text-info';}
								else{$color="";}
							@endphp
    						<tr>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player}} ({{$task->village}})</strong></a>
    							</td>
    							<td>{{$task->def_total}}</td>
    							<td><strong>{{$task->type}}</strong></td>
    							<td class="{{$color}}"><strong>{{$task->priority}}</strong></td>
    							<td>{{$task->target_time}}</td>
    							<td><strong><span id="{{$task->task_id}}"></span></strong></td>
    							<td><a class="btn btn-outline-secondary" href="/plus/defense/{{$task->task_id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
@endsection

@push('scripts')
	@if(count($tasks)>0)	
	<script>
		@foreach($tasks as $task)
			countDown("{{$task->task_id}}","{{$task->target_time}}");
		@endforeach
	</script>
	@endif

@endpush