@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the Offense tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Offense Tasks</strong></div>
			<div class="card-text">
    <!-- ==================================== List of Ops in progress ======================================= -->
    		@if($ops==null)
    			<p class="text-center h5 my-3">No offense plans are available</p>
    		@else
    			@foreach($ops as $plan)
    			<p class="text-center h5 my-3">Plan: <span class="text-danger"><strong>{{$plan->name}}</strong></span></p>
    			<p class="text-center h6 my-3">Created By: {{$plan->create}}	Updated By:{{$plan->update}}</p>
    			<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small table-sm">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Attacker</th>
    							<th class="col-md-1">Target</th>
    							<th class="col-md-1">Type</th>
    							<th class="col-md-1">Waves</th>
    							<th class="col-md-1">Troops</th>
    							<th class="col-md-1">Land time</th>
    							<th class="col-md-1">Start time</th>
    							<th class="col-md-1">CountDown</th>
    							<th class="col-md-2">Comments</th>
    							<th class="col-md-1"></th>
    						</tr>
						</thead>
					@foreach($plan['waves'] as $waves)
						<tr>
							<td><a href="">
								<strong>{{$plan->a_village}}</strong></a>
							</td>
							<td><a href="">
								<strong>{{$plan->d_player}} ({{$plan->d_village}})</strong></a>
							</td>
							<td class="text-danger"><strong>{{$plan->type}}</strong></td>
							<td><strong>{{$plan->waves}}</strong></td>
							<td>{{$plan->unit}}</td>
							<td>{{$plan->landtime}}</td>
							<td>Start Time</td>
							<td>00:00:00</td>
							<td>{{$plan->comments}}</td>
						</tr>
					@endforeach
					</table>  			
    			@endforeach
    			</div>
    		@endif
				<!-- <p class="text-center h5 my-3">Plan: <span class="text-danger"><strong>Default Name 1</strong></span></p>	
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small table-sm">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Attacker</th>
    							<th class="col-md-1">Target</th>
    							<th class="col-md-1">Type</th>
    							<th class="col-md-1">Waves</th>
    							<th class="col-md-1">Troops</th>
    							<th class="col-md-1">Land time</th>
    							<th class="col-md-1">Start time</th>
    							<th class="col-md-1">CountDown</th>
    							<th class="col-md-2">Comments</th>
    							<th class="col-md-1"></th>
    						</tr>
						</thead>
						<tr>
							<td><a href="">
								<strong>village</strong></a>
							</td>
							<td><a href="">
								<strong>village (Target)</strong></a>
							</td>
							<td class="text-danger"><strong>Real</strong></td>
							<td>4</td>
							<td><span data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="all" src="/images/x.gif" class="units t08"></td>
							<td>16/12/2018 00:00:00</td>
							<td>15/12/2018 00:00:00</td>
							<td>24:00:00</td>
							<td>Crop lock</td>
							<td><img alt="all" src="/images/x.gif" class="res clock"></td>
						</tr>
						<tr>
							<td><a href="">
								<strong>village</strong></a>
							</td>
							<td><a href="">
								<strong>village (Target)</strong></a>
							</td>
							<td class="text-primary"><strong>Fake</strong></td>
							<td>4</td>
							<td><span data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="all" src="/images/x.gif" class="units t08"></td>
							<td>16/12/2018 00:00:00</td>
							<td>15/12/2018 00:00:00</td>
							<td>24:00:00</td>
							<td>Crop lock</td>
							<td><img alt="all" src="/images/x.gif" class="res clock"><img alt="all" src="/images/x.gif" class="res clock"></td>
						</tr>
						<tr>
							<td><a href="">
								<strong>village</strong></a>
							</td>
							<td><a href="">
								<strong>village (Target)</strong></a>
							</td>
							<td class="text-warning"><strong>Cheif</strong></td>
							<td>4</td>
							<td><span data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="all" src="/images/x.gif" class="units t08"></td>
							<td>16/12/2018 00:00:00</td>
							<td>15/12/2018 00:00:00</td>
							<td>24:00:00</td>
							<td>Crop lock</td>
							<td><img alt="all" src="/images/x.gif" class="res clock"></td>
						</tr>
						<tr>
							<td><a href="">
								<strong>village</strong></a>
							</td>
							<td><a href="">
								<strong>village (Target)</strong></a>
							</td>
							<td class="text-dark"><strong>Scout</strong></td>
							<td>4</td>
							<td><span data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="all" src="/images/x.gif" class="units t08"></td>
							<td>16/12/2018 00:00:00</td>
							<td>15/12/2018 00:00:00</td>
							<td>24:00:00</td>
							<td>Crop lock</td>
							<td><img alt="all" src="/images/x.gif" class="res clock"></td>
						</tr>
					</table>
				</div> -->
			</div>
		</div>

@endsection