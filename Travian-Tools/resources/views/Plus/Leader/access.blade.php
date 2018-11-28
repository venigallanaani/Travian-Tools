@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Leader Access</strong></div>
			<div class="card-text">
<!-- ==========================Add player and add alliance options ============================== -->
				<div class="row m-3">
					<div class="col-md-6">
						<a href="#" class="btn btn-outline-warning btn-block p-3" data-toggle="modal" data-target="#addPlayerModal">
							<i class="fa fa-plus"></i> <strong>Add Player</strong></a>
					</div>
					<div class="col-md-6">
						<a href="#" class="btn btn-outline-primary btn-block p-3" data-toggle="modal" data-target="#addAllianceModal">
							<i class="fa fa-plus"></i> Add Alliance</a>
					</div>
				</div>	
				<div class="modal fade" id="addPlayerModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-warning">
								<h5 class="modal-title" id="addPlayerModalLabel">Add Player</h5>
								<button class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form>
									<div class="form-group">
										<label for="player" class="form-control-label">Player Name:</label>
										<input type="text" class="form-control">
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button class="btn btn-outline-primary" data-dismiss="modal">Add to Group</button>
							</div>
						</div>
					</div>				
				</div>		
				<div class="modal fade" id="addAllianceModal">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<h5 class="modal-title" id="addAllianceModalLabel">Add Alliance</h5>
								<button class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
								<form>
									<div class="form-group">
										<label for="alliance" class="form-control-label">Alliance Name:</label>
										<input type="text" class="form-control">
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button class="btn btn-outline-warning" data-dismiss="modal">Add to Group</button>
							</div>
						</div>
					</div>				
				</div>
		<!-- ============================ Add success/failure notifications ============================== -->
				<div class="alert alert-success text-center my-1 mx-5" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
  					</button>Successfully added to the group. 
				</div>
				<div class="alert alert-danger text-center my-1 mx-5" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
  					</button>Error encountered while adding the player to the group. 
				</div>
				<div class="alert alert-warning text-center my-1 mx-5" role="alert">
	  				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
  					</button>Player or Alliance not found. 
				</div>
		<!-- =========================== leadership Options control panel ================================ -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table table-hover table-sm table-bordered align-middle small">
						<thead class="bg-dark text-white">
    						<tr>
    							<th class="col-md-2" rowspan="2">Player</th>
    							<th class="col-md-2" rowspan="2">Account</th>
    							<th class="col-md-2" rowspan="2">Account</th>
    							<th class="col-md-1" rowspan="2">Plus</th>
    							<th colspan="6">Leadership Options</th>
    						</tr>
    						<tr class="">
    							<th class="col-md-1">Leader</th>
    							<th class="col-md-1">Defense</th>
    							<th class="col-md-1">Offense</th>
    							<th class="col-md-1">Resources</th>
    							<th class="col-md-1">Artifacts</th>
    							<th class="col-md-1">Wonder</th>
    						</tr>
						</thead>
						<tr class="">
							<td>Barca1</td>
							<td>Admin1</td>
							<td>Alliance1</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
						</tr>
						<tr class="">
							<td>Barca2</td>
							<td>Admin2</td>
							<td>Alliance2</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
						</tr>
						<tr class="">
							<td>Barca3</td>
							<td>Admin3</td>
							<td>Alliance3</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
						</tr>
						<tr>
							<td>Barca3</td>							
							<td>Admin3</td>
							<td>Alliance3</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
							<td>X</td>
						</tr>
					</table>
				</div>			
			</div>
@endsection
