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
    			<table class="text-center col-md-8 mx-auto my-3">
    				<tr>
    					<td colspan="2" class="h5">Plan: <span class="text-danger"><strong>{{$plan['name']}}</strong></span></td>
					</tr>
    				<tr>
    					<td><span class="text-info font-weight-bold">Created By: </span>{{$plan['create']}}</td>
    					<td><span class="text-info font-weight-bold">Updated By: </span>{{$plan['update']}}</td>
    				</tr>
    			</table>
    			<div class="text-center col-md-12 mx-auto my-3 px-2">
					<table class="table align-middle small table-sm table-hover">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Attacker</th>
    							<th class="col-md-2">Target</th>
    							<th class="col-md-1">Type</th>
    							<th class="col-md-1">Land time</th>
    							<th class="col-md-1">Waves</th>
    							<th class="col-md-1">Troops</th>    							
    							<th class="col-md-1">Start time</th>
    							<th class="col-md-1">Timer</th>
    							<th class="col-md-2">Comments</th>
    							<th class="col-md-1"></th>
    						</tr>
						</thead>
					@foreach($plan['waves'] as $wave)
						<tr>
							<td><a href="" target="_blank">
								<strong>{{$wave->a_village}}</strong></a>
							</td>
							<td><a href="" target="_blank">
								<strong>{{$wave->d_player}} ({{$wave->d_village}})</strong></a>
							</td>
							<td class="text-danger"><strong>{{$wave->type}}</strong></td>
							<td>{{$wave->landtime}}</td>
							<td><strong>{{$wave->waves}}</strong></td>
							<td><span data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="all" src="/images/x.gif" class="units {{$wave->unit}}"></td>
							<td>2019-01-30 00:00:00 </td>
							<td>00:00:00</td>
							<td>{{$wave->comments}}</td>
							<td>@if($wave->status==null)
								<a href="/plus/offense/yes/{{$wave->id}}"><button class="badge badge-success"><i class="fas fa-check"></i></button></a>
    							<a href="/plus/offense/no/{{$wave->id}}"><button class="badge badge-danger"><i class="fas fa-times"></i></button></a>
    							@else
    							{{$wave->status}}
    							@endif
							</td>							
						</tr>
					@if($wave->status=='Sent')
						<tr>
							<form method="post" action="/plus/offense/update">
								{{csrf_field()}}
    							<td colspan="5"><strong>Report: </strong><input type="text" name="report" size="40" value="{{$wave->report}}"/></td>
    							<td colspan="4"><strong>Notes: </strong><input type="text" name="notes" size="20" value="{{$wave->notes}}"/></td>
    							<td><button class="btn btn-info btn-sm px-3" type="submit" name="save" value="{{$wave->id}}">Save</button></td>
							</form>
						</tr>
					@endif
					@endforeach
					</table>  			
    			@endforeach
    			</div>
    		@endif
			</div>
		</div>
@endsection
