@extends('Plus.template')

@section('body')

<!-- ================================= Main Content of the Resource Tasks in the Plus general Overview Menu ============================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Resource Tasks</strong></div>
			<div class="card-text">
    <!-- ==================================== List of tasks is progress ======================================= -->		
				<div class="text-center col-md-11 my-2 p-0">
					<table class="table align-middle small col-md-9  mx-auto">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Target</th>
    							<th class="col-md-1">Resources</th>
    							<th class="col-md-1">Pref</th>    							
    							<th class="col-md-1">%</th>
    							<th class="col-md-1">Target Time</th>
    							<th class="col-md-1"></th>    							
    						</tr>
						</thead>
						<tr>
							<td><a href="">
								<strong>player (village)</strong></a>
							</td>
							<td>10000</td>
							<td>All</td>							
							<td>0%</td>
							<td>16/10/2018 00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/plus/resource/1234">
								<i class="fa fa-angle-double-right"></i> Details</a>
							</td>
						</tr>
						<tr>
							<td><a href="">
								<strong>player (village)</strong></a>
							</td>
							<td>10000</td>
							<td>All</td>							
							<td>0%</td>
							<td>16/10/2018 00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/plus/resource/1234">
								<i class="fa fa-angle-double-right"></i> Details</a>
							</td>
						</tr>
						<tr>
							<td><a href="">
								<strong>player (village)</strong></a>
							</td>
							<td>10000</td>
							<td>All</td>							
							<td>0%</td>
							<td>16/10/2018 00:00:00</td>
							<td><a class="btn btn-outline-secondary" href="/plus/resource/1234">
								<i class="fa fa-angle-double-right"></i> Details</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
@endsection