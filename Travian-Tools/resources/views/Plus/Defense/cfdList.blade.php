@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Call Status</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
				<div class="m-3">
					<a href="#" class="btn btn-warning btn-block p-3" data-toggle="modal" data-target="#createCFDModal">
						<i class="fa fa-plus"></i> <strong>Create New Defense Calls</strong></a>
				</div>	
				<div class="modal fade" id="createCFDModal">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header bg-warning">
								<h5 class="modal-title" id="createCFDModalLabel">Defense Call Details</h5>
								<button class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form action="/defense/cfd" method="post">
									{{ csrf_field() }}
									<div class="input-group py-1">
										<label for="xCor" class="input-group-prepend"><span class="input-group-text">X:</span></label>
											<input type="text" class="form-control col-md-2" placeholder="" aria-label="" aria-describedby="basic-addon1"> | 
										<label for="yCor" class="input-group-prepend"><span class="input-group-text">Y:</span></label>
											<input type="text" class="form-control col-md-2" placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>
									<div>							
    									<div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline1" name="type" class="custom-control-input" value="DEFEND">
                                            <label class="custom-control-label" for="customRadioInline1">Defend</label>
                                        </div>
    									<div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline2" name="type" class="custom-control-input" value="SNIPE">
                                            <label class="custom-control-label" for="customRadioInline2">Snipe</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline3" name="type" class="custom-control-input" value="STAND">
                                            <label class="custom-control-label" for="customRadioInline3">Standing</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline4" name="type" class="custom-control-input" value="OTHER">
                                            <label class="custom-control-label" for="customRadioInline4">Other</label>
                                        </div> 		
									</div>
									<div class="input-group py-1">
										<label for="defNeed" class="input-group-prepend"><span class="input-group-text">Defense Needed:</span></label>
											<input type="text" required class="form-control col-md-3" placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>
									<div>
    									<div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline5" name="priority" class="custom-control-input" value="HIGH">
                                            <label class="custom-control-label" for="customRadioInline5"><span class="text-danger"><strong>High</strong></span></label>
                                        </div>
    									<div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline6" name="priority" class="custom-control-input" value="MEDIUM">
                                            <label class="custom-control-label" for="customRadioInline6"><span class="text-warning"><strong>Medium</strong></span></label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline7" name="priority" class="custom-control-input" value="LOW">
                                            <label class="custom-control-label" for="customRadioInline7"><span class="text-info"><strong>Low</strong></span></label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                        	<input type="radio" id="customRadioInline8" name="priority" class="custom-control-input" value="NONE">
                                            <label class="custom-control-label" for="customRadioInline8">None</label>
                                        </div>
                                    </div>	                                    
									<div class="input-group py-1">
										<label for="targetTime" class="input-group-prepend"><span class="input-group-text">Target Time:</span></label>
											<input type="text" required class="form-control col-md-3" placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>
									<div class="custom-control custom-checkbox">
                                      	<input type="checkbox" class="custom-control-input" id="customCheck1" name="resources">
                                      	<label class="custom-control-label" for="customCheck1">Resources Needed</label>
                                    </div>
									<div class="input-group py-1">
										<label for="comments" class="input-group-prepend"><span class="input-group-text">Comments:</span></label>
											<textarea class="form-control" rows="5"></textarea>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary px-5" data-dismiss="modal">Create Task</button>
							</div>
						</div>
					</div>				
				</div>
				<div class="alert alert-success text-center my-1 mx-5" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
  					</button>Resource push request created successfully 
				</div>
				<div class="alert alert-danger text-center my-1 mx-5" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
  					</button>Village not found at the entered coordinates 
				</div>
    <!-- ==================================== List of CFD is progress ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Player</th>
    							<th class="col-md-1">Defense</th>
    							<th class="col-md-1">Type</th>
    							<th class="col-md-1">Status</th>
    							<th class="col-md-1">Priority</th>
    							<th class="col-md-1">%</th>
    							<th class="col-md-1">land time</th>
    							<th class="col-md-1">Time left</th>
    							<th class="col-md-1"></th>    							
    						</tr>
						</thead>
						<tr>
							<td>player (village)</td>
							<td>10000</td>
							<td>Defend</td>
							<td>Active</td>
							<td class="text-danger"><strong>High</strong></td>
							<td>25%</td>
							<td>16/10/2018 00:00:00</td>
							<td>00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/defense/cfd/1234"><i class="fa fa-angle-double-right"></i> Details</a></td>
						</tr>
						<tr class="table-secondary">
							<td>player (village)</td>
							<td>1000</td>
							<td>Snipe</td>
							<td>Completed</td>
							<td class="text-warning"><strong>Medium</strong></td>
							<td>100%</td>
							<td>16/10/2018 00:00:00</td>
							<td>00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/defense/cfd/1234"><i class="fa fa-angle-double-right"></i> Details</a></td>
						</tr>
						<tr>
							<td>player (village)</td>
							<td>1000</td>
							<td>Defend</td>
							<td>Active</td>
							<td class="text-info"><strong>Low</strong></td>
							<td>25%</td>
							<td>16/10/2018 00:00:00</td>						
							<td>00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/defense/cfd/1234"><i class="fa fa-angle-double-right"></i> Details</a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>

@endsection