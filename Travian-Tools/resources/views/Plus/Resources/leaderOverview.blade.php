@extends('Plus.template')

@section('body')

<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Resource Status</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
				<div class="m-3">
					<a href="#" class="btn btn-warning btn-block p-3" data-toggle="modal" data-target="#createCFDModal">
						<i class="fa fa-plus"></i> <strong>Create New Resource Push</strong></a>
				</div>	
				<div class="modal fade" id="createCFDModal">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header bg-warning">
								<h5 class="modal-title" id="createCFDModalLabel">Resource Push Details</h5>
								<button class="close" data-dismiss="modal">&times;</button>
							</div>
							<form action="/resource" method="POST">
								<div class="modal-body">
									{{ csrf_field() }}
									<div class="input-group py-1">
										<label for="xCor" class="input-group-prepend"><span class="input-group-text">X:</span></label>
											<input type="text" class="form-control col-md-2" required placeholder="" aria-label="" aria-describedby="basic-addon1"> | 
										<label for="yCor" class="input-group-prepend"><span class="input-group-text">Y:</span></label>
											<input type="text" class="form-control col-md-2" required placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>
									<div class="input-group py-1">
										<label for="landTime" class="input-group-prepend"><span class="input-group-text">Resources Needed:</span></label>
											<input type="text" required class="form-control col-md-3" required placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>									
									<div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="customRadioInline1" name="resType" selected class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline1"><img alt="all" src="/images/x.gif" class="res all"></label>
                                    </div>
									<div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="customRadioInline2" name="resType" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline2"><img alt="wood" src="/images/x.gif" class="res wood"></label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="customRadioInline3" name="resType" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline3"><img alt="clay" src="/images/x.gif" class="res clay"></label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="customRadioInline4" name="resType" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline4"><img alt="iron" src="/images/x.gif" class="res iron"></label>
                                    </div> 
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="customRadioInline5" name="resType" class="custom-control-input">
                                        <label class="custom-control-label" for="customRadioInline5"><img alt="crop" src="/images/x.gif" class="res crop"></label>
                                    </div>
									
									
									<div class="input-group py-1">
										<label for="targetTime" class="input-group-prepend"><span class="input-group-text">Target Time:</span></label>
											<input type="text" required class="form-control col-md-3" placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>
									<div class="input-group py-1">
										<label for="comments" class="input-group-prepend"><span class="input-group-text">Comments:</span></label>
											<textarea class="form-control" rows="5"></textarea>
									</div>								
								</div>
								<div class="modal-footer">
									<button class="btn btn-primary px-5" data-dismiss="modal" type="submit">Create Task</button>
								</div>
							</form>
						</div>
					</div>				
				</div>
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
        
    		@if(count($tasks)==0)
    			<p class="text-center h5 py-2">No resource tasks are active currently.</p>				
    		@endif
    <!-- ==================================== List of CFD is progress ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Target</th>
    							<th class="col-md-1">Resources</th>
    							<th class="col-md-1">Pref</th>
    							<th class="col-md-1">Status</th>
    							<th class="col-md-1">%</th>
    							<th class="col-md-1">Target Time</th>
    							<th class="col-md-1"></th>    							
    						</tr>
						</thead>
							@foreach($tasks as $task)
    						<tr>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player }}({{$task->village}})</strong></a>
    							</td>
    							<td>{{$task->res_total}}</td>
    							<td data-toggle="tooltip" data-placement="top" title="{{$task->type}}"><img alt="all" src="/images/x.gif" class="res {{$task->type}}"></td>							
    							<td>{{$task->status}}</td>
    							<td>{{$task->res_percent}}%</td>
    							<td>{{$task->target_time}}</td>
    							<td><a class="btn btn-outline-secondary" href="/resource/{{$task->task_id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach						
					</table>
				</div>
			</div>
		</div>

















@endsection