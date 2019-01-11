@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Offense Plan - {{$plan->name}}</strong></div>
			<div class="card-text">
    <!-- ==================================== List of CFD is progress ======================================= -->
				
        		@foreach(['danger','success','warning','info'] as $msg)
        			@if(Session::has($msg))
        	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>{{ Session::get($msg) }}
                        </div>
                    @endif
                @endforeach	
                
                <div class="text-center col-md-8 mx-auto p-2">
                	<table class="table table-borderless table-sm text-left">
                		<tr>
                			<td class="align-middle">
                				<p><strong>Status : </strong>{{$plan->status}}</p>
                				<p><strong>Created By : </strong>{{$plan->create_by}}</p>
                				<p><strong>Updated By : </strong>{{$plan->update_by}}</p>
                			</td>
                			<td class="text-center align middle">
                				<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
                					<button class="btn btn-warning btn-sm px-5" name="deletePlan" value="{{$plan->id}}">Delete Plan</button>
            					</form>
                			</td>                			
                		</tr>                    		
                	</table>
                </div>
            @if(count($waves)==0)
            	<div class="text-center col-md-11 mx-auto my-2 p-0">
            		<p class="h5 my-5">No attacks are planned yet</p>
            	</div>            
            @else	
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
						@foreach($waves as $wave)
    						<tr>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player}} ({{$task->village}})</strong></a>
    							</td>
    							<td>{{$task->def_total}}</td>
    							<td><strong>{{$task->type}}</strong></td>
    							<td class="{{$color}}"><strong>{{$task->priority}}</strong></td>
    							<td>{{$task->target_time}}</td>
    							<td>00:00:00</td>
    							<td><a class="btn btn-outline-secondary" href="/plus/defense/{{$task->task_id}}">
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