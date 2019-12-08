@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Call Status</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
				<div class="m-3">
            		<div class="card card-header text-center h6 btn btn-block collapsed bg-warning shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
                		<p class="p-0 m-0">
                    		<i class="fa fa-plus"></i> <span class=""><strong>Create New Defense Task</strong></span>
        			 	</p>
            		</div>
            		<div class="collapse" id="task" style="">
              			<div class="card card-body shadow">
    						<form action="/defense/cfd/create" method="POST" class="col-md-10 mx-auto text-center">
        						{{ csrf_field() }}
        						<p class="my-2">
        							<strong>X: <input type="text" name="xCor" size="5" required> | Y: <input type="text" name="yCor" size="5" required></strong>
        						</p>
        						<p class="my-2">
        							<strong>Defense Needed(<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="defNeed" size="8" required></strong>
        						</p>
        						<p class="my-2"> 		
    								<strong>Land Time: <input type="text" name="targetTime" size="20" class="dateTimePicker">        									 
        						</p>
    						    <p class="my-2 col-md-12">
        							<strong>Priority: </strong>
        								<select name="priority">
        									<option value="high">High</option>
        									<option value="medium">Medium</option>
        									<option value="low">Low</option>
        									<option value="none">None</option>
        								</select> 
        							<strong> Type: </strong>
        								<select name="type">
        									<option value="defend">Defend</option>
        									<option value="snipe">Snipe</option>
        									<option value="stand">Standing</option>
        									<option value="scout">Scout</option>
        									<option value="other">Other</option>
        								</select>
        						</p>
        						<p class="my-2">
        							<strong>Comments:</strong><textarea name="comments" class="form-control" rows="5"></textarea>
        						</p>
        						<p class="my-2">
        							<button class="btn btn-info px-5" name="createDefTask"><strong>Create Task</strong></button>
        						</p> 						
    						</form>
              			</div>
            		</div>	
        		</div>		
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
        
    		@if((count($ctasks)+count($atasks))==0)
    			<p class="text-center h5 py-5">No CFDs are currently active.</p>				
    		@else
    <!-- ==================================== List of CFD is progress ======================================= -->		
    			@if(count($atasks)>0)
    			<div class="text-center py-3 h4">
					<p>Active CFDs List</p>    			
    			</div>
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle">
						<thead class="thead-inverse">
    						<tr>
    							<th class="">Player</th>
    							<th class="">Defense</th>
    							<th class="">Type</th>
    							<th class="">Priority</th>
    							<th class="">%</th>
    							<th class="">Land time</th>
    							<th class="">Time left</th>
    							<th class=""></th>    							
    						</tr>
						</thead>
						@foreach($atasks as $task)
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
    						<tr class="small" style="background-color:{{$bgcolor}};">
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player}} ({{$task->village}})</strong></a>
    							</td>
    							<td>{{number_format($task->def_total)}}</td>
    							<td><strong>{{strtoupper($task->type)}}</strong></td>
    							<td class="{{$color}}"><strong>{{ucfirst($task->priority)}}</strong></td>    							
    							<td>{{$task->def_percent}}%</td>
    							<td>{{$task->target_time}}</td>
    							<td><strong><span id="{{$task->task_id}}"></span></strong></td>
    							<td><a class="btn btn-outline-secondary" href="/defense/cfd/{{$task->task_id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
				@endif
				
				@if(count($ctasks)>0)
    			<div class="text-center py-3 h4">
					<p>Completed CFDs List</p>    			
    			</div>
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle">
						<thead class="thead-inverse">
    						<tr>
    							<th class="">Player</th>
    							<th class="">Defense</th>
    							<th class="">Type</th>
    							<th class="">Priority</th>
    							<th class="">%</th>
    							<th class="">Land time</th>
    							<th class=""></th>    							
    						</tr>
						</thead>
						@foreach($ctasks as $task)
							@php
								if($task->priority=='high'){$color='text-danger';}
								elseif($task->priority=='medium'){$color='text-warning';}
								elseif($task->priority=='low'){$color='text-info';}
								else{$color="";}
							@endphp
    						<tr class="small">
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player}} ({{$task->village}})</strong></a>
    							</td>
    							<td>{{number_format($task->def_total)}}</td>
    							<td><strong>{{strtoupper($task->type)}}</strong></td>
    							<td class="{{$color}}"><strong>{{ucfirst($task->priority)}}</strong></td>    							
    							<td>{{$task->def_percent}}%</td>
    							<td>{{$task->target_time}}</td>
    							<td><a class="btn btn-outline-secondary" href="/defense/cfd/{{$task->task_id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
				@endif				
			@endif
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
	
	@if(count($atasks)>0)	
	<script>
		@foreach($atasks as $task)
			countDown("{{$task->task_id}}","{{$task->target_time}}","{{Session::get('timezone')}}");
		@endforeach
	</script>
	@endif     

@endpush

@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endpush