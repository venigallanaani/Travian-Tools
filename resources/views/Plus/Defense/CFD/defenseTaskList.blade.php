@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Tasks</strong></div>
			<div class="card-text">
    <!-- ==================================== List of CFD is progress ======================================= -->
				@if(count($tasks)==0)
					<p class="text-center h5 py-5">No defense tasks are active currently.</p>				
				@else
				
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
					<table class="table align-middle">
						<thead class="thead-inverse">
    						<tr>
    							<th class="">Player</th>
    							<th class="">Defense</th>
    							<th class="">Type</th>
    							<th class="">Priority</th>
    							<th class="">Land Time</th>
    							<th class="">Time left</th>
    							<th class=""></th>    							
    						</tr>
						</thead>
						@foreach($tasks as $task)
							@php
								if($task->priority=='high'){$color='text-danger';}
								elseif($task->priority=='medium'){$color='text-warning';}
								elseif($task->priority=='low'){$color='text-info';}
								else{$color="";}								
								
								if($task->type=='defend'){$bgcolor = '#dbeef4';	}
								elseif($task->type=='snipe'){$bgcolor = '#ffe6cc';	}
								elseif($task->type=='scout'){$bgcolor = '#ffff99';	}
								elseif($task->type=='stand'){$bgcolor = '#eeffcc';	}
								else{$bgcolor ='#e6e6e6';	}
								
							@endphp
    						<tr style="background-color:{{$bgcolor}};">
    							<td><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player}} ({{$task->village}})</strong></a>
    							</td>
    							<td>{{number_format($task->def_remain)}}</td>
    							<td><strong>{{ucfirst(strtolower($task->type))}}</strong></td>
    							<td class="{{$color}}"><strong>{{ucfirst($task->priority)}}</strong></td>
    							<td>{{$task->target_time}}</td>
    							<td><strong><span id="{{$task->task_id}}"></span></strong></td>
    							<td><a class="btn btn-outline-secondary" href="/plus/defense/{{$task->task_id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
				@endif
				
				@if(count($withdraws)>0)
					<div class="text-center mx-auto col-md-8 my-4">
						<p class="bg-warning h4 py-1"> Troops Withdrawl Request </p>
					@foreach($withdraws as $withdraw)
						<p class="h6"> Withdraw your reinforcements from <strong><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$task->x}}&y={{$task->y}}" target="_blank">{{$withdraw['PLAYER']}} ({{$withdraw['VILLAGE']}})</a></strong></p>		
					@endforeach	
					</div>			
				@endif
			</div>
		</div>
@endsection

@push('scripts')
	@if(count($tasks)>0)	
	<script>
		@foreach($tasks as $task)
			countDown("{{$task->task_id}}","{{$task->target_time}}","{{Session::get('timezone')}}");
		@endforeach
	</script>
	@endif

@endpush