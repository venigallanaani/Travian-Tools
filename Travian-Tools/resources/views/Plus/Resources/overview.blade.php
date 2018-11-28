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
							<div class="modal-body">
								<form>
									<div class="input-group py-1">
										<label for="xCor" class="input-group-prepend"><span class="input-group-text">X:</span></label>
											<input type="text" class="form-control col-md-2" placeholder="" aria-label="" aria-describedby="basic-addon1"> | 
										<label for="yCor" class="input-group-prepend"><span class="input-group-text">Y:</span></label>
											<input type="text" class="form-control col-md-2" placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>
									<div class="input-group py-1">
										<label for="landTime" class="input-group-prepend"><span class="input-group-text">Resources Needed:</span></label>
											<input type="text" required class="form-control col-md-3" placeholder="" aria-label="" aria-describedby="basic-addon1">
									</div>
									<div class="input-group py-1">
										<label for="resType" class="input-group-prepend"><span class="input-group-text">Resource Preference:</span></label>
											<select class="form-control col-md-3" aria-label="" aria-describedby="basic-addon1">
												<option value="">Any</option>
												<option value="">Wood</option>
												<option value="">Clay</option>
												<option value="">Iron</option>
												<option value="">Crop</option>
											</select>
									</div>
									<div class="input-group py-1">
										<label for="targetTime" class="input-group-prepend"><span class="input-group-text">Target Time:</span></label>
											<input type="text" required class="form-control col-md-3" placeholder="" aria-label="" aria-describedby="basic-addon1">
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
    							<th class="col-md-1">Target</th>
    							<th class="col-md-1">Resources</th>
    							<th class="col-md-1">Pref</th>
    							<th class="col-md-1">Status</th>
    							<th class="col-md-1">%</th>
    							<th class="col-md-1">Target Time</th>
    							<th class="col-md-1"></th>    							
    						</tr>
						</thead>
						<tr>
							<td>player (village)</td>
							<td>10000</td>
							<td>All</td>
							<td>Active</td>
							<td>0%</td>
							<td>16/10/2018 00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="#"><i class="fa fa-angle-double-right"></i> Details</a></td>
						</tr>
						<tr>
							<td>player (village)</td>
							<td>10000</td>
							<td>All</td>
							<td>Active</td>
							<td>0%</td>
							<td>16/10/2018 00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="#"><i class="fa fa-angle-double-right"></i> Details</a></td>
						</tr>
						<tr>
							<td>player (village)</td>
							<td>10000</td>
							<td>All</td>
							<td>Active</td>
							<td>0%</td>
							<td>16/10/2018 00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="#"><i class="fa fa-angle-double-right"></i> Details</a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>

















@endsection