@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Tasks</strong></div>
			<div class="card-text">
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
    							<th class="col-md-1">land time</th>
    							<th class="col-md-1">Time left</th>
    							<th class="col-md-1"></th>    							
    						</tr>
						</thead>
						<tr>
							<td><a href="">
								<strong>player (village)</strong></a>
							</td>
							<td>10000</td>
							<td>Defend</td>
							<td>Active</td>
							<td class="text-danger"><strong>High</strong></td>
							<td>16/10/2018 00:00:00</td>
							<td>00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/plus/defense/1234">
								<i class="fa fa-angle-double-right"></i> Details</a>
							</td>
						</tr>
						<tr>
							<td><a href="">
								<strong>player (village)</strong></a>
							</td>
							<td>1000</td>
							<td>Snipe</td>
							<td>Active</td>
							<td class="text-warning"><strong>Medium</strong></td>
							<td>16/10/2018 00:00:00</td>
							<td>00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/plus/defense/1234">
								<i class="fa fa-angle-double-right"></i> Details</a>
							</td>
						</tr>
						<tr>
							<td><a href="">
								<strong>player (village)</strong></a>
							</td>
							<td>1000</td>
							<td>Defend</td>
							<td>Active</td>
							<td class="text-info"><strong>Low</strong></td>
							<td>16/10/2018 00:00:00</td>						
							<td>00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/plus/defense/1234">
								<i class="fa fa-angle-double-right"></i> Details</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

@endsection