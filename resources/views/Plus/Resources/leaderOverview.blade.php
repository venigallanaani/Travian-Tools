@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Resource Status</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
        		<div class="m-3">
            		<div class="card card-header text-center h6 btn btn-block collapsed bg-warning shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
                		<p class="p-0 m-0">
                    		<i class="fa fa-plus"></i> <span class=""><strong>Create New Resource Push</strong></span>
        			 	</p>
            		</div>
            		<div class="collapse" id="task" style="">
              			<div class="card card-body shadow">
    						<form action="/resource/create" method="POST" class="col-md-8 mx-auto text-center" autocomplete="off">
        						{{ csrf_field() }}
        						<p class="my-2">
        							<strong>X: <input type="text" name="xCor" size="5" required> | Y: <input type="text" name="yCor" size="5" required></strong>
        						</p>
        						<p class="my-2">
        							<strong>Resources Needed: <input type="text" name="resNeed" size="8" required></strong>
        						</p>
        						<p class="my-2">
        							<strong>Target Time: <input type="text" name="targetTime" size="20" class="dateTimePicker"></strong>
        						</p>
    						    <p class="my-2">
        							<strong>Resource Type: </strong>
        								<input type="radio" name="resType" value="ALL" checked> <img alt="all" src="/images/x.gif" class="res all"> 
        								<input type="radio" name="resType" value="WOOD"> <img alt="wood" src="/images/x.gif" class="res wood"> 
        								<input type="radio" name="resType" value="CLAY"> <img alt="clay" src="/images/x.gif" class="res clay"> 
        								<input type="radio" name="resType" value="IRON"> <img alt="iron" src="/images/x.gif" class="res iron"> 
        								<input type="radio" name="resType" value="CROP"> <img alt="crop" src="/images/x.gif" class="res crop">
        						</p>
        						<p class="my-2">
        							<strong>Comments:</strong><textarea name="comments" class="form-control" rows="5"></textarea>
        						</p>
        						<p class="my-2">
        							<button class="btn btn-info px-5" name="createResTask"><strong>Create Task</strong></button>
        						</p> 						
    						</form>
              			</div>
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
        
    		@if(count($tasks)==0)
    			<p class="text-center h5 py-5">No resource tasks are currently active.</p>				
    		@else
    <!-- ==================================== List of Resources tasks is progress ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small">
						<thead class="thead-inverse">
    						<tr>
    							<th class="">Target</th>
    							<th class="">Resources</th>
    							<th class="">Pref</th>
    							<th class="">Status</th>
    							<th class="">%</th>
    							<th class="">Target Time</th>
    							<th class="">Time Left</th>
    							<th class=""></th>    							
    						</tr>
						</thead>
							@foreach($tasks as $task)
							@php
								if($task->status != 'ACTIVE'){$status="table-secondary";}
								else{$status='';}
							@endphp
    						<tr class="{{$status}}">
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player }} ({{$task->village}})</strong></a>
    							</td>
    							<td>{{number_format($task->res_total)}}</td>
    							<td data-toggle="tooltip" data-placement="top" title="{{$task->type}}"><img alt="all" src="/images/x.gif" class="res {{$task->type}}"></td>							
    							<td>{{ucfirst(strtolower($task->status))}}</td>
    							<td>{{$task->res_percent}}%</td>
    							<td>{{$task->target_time}}</td>
    							<td><strong><span id="{{$task->task_id}}"></span></strong></td>
    							<td><a class="btn btn-outline-secondary" href="/resource/{{$task->task_id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach						
					</table>
				</div>
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
	
	
	@if(count($tasks)>0)	
	<script>
		@foreach($tasks as $task)
			countDown("{{$task->task_id}}","{{$task->target_time}}","{{Session::get('timezone')}}");
		@endforeach
	</script>
	@endif   

@endpush

@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endpush
