@extends('Profile.template')
@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h4 py-2 bg-warning text-white">
			<strong>Servers Overview</strong>
		</div>
		<div class="card-text p-4">
			<div class="h3 container text-warning font-weight-bold">
				<p>Your Servers</p>
			</div>
		@if(count($profiles)>0)
			<form action="{{route('profileServers')}}/load" method="POST" class="col-md-12 mx-auto">
				{{csrf_field()}}
				<table class="table table-hover table-small small">
					<thead>
						<tr>
							<th>Server Name</th>
							<th>Start Date</th>
							<th>Days</th>
							<th>Account</th>
							<th>Type</th>
							<th></th>
						</tr>
					</thead>
				@foreach($profiles as $profile)
					<tr>
						<td>{{$profile['name']}}</td>
						<td>{{$profile['start_date']}}</td>
						<td>{{$profile['days']}}</td>
						<td><img data-toggle="tooltip" data-placement="top" title="{{$profile['tribe']}}" alt="" src="/images/x.gif" class="tribe {{$profile['tribe']}}"> 
							<strong>{{$profile['account']}}</strong></td>
						<td>{{ucfirst(strtolower($profile['status']))}}</td>
						<td><button class="btn btn-warning btn-sm" name="server" value="{{$profile['server_id']}}">
    							<i class="fa fa-angle-double-right"></i> Load Server</button>
						</td>
					</tr>
				@endforeach
				</table>			
			</form>	
		@else
			<div class="text-center h5">
				<p>No active profiles in Travian right now</p>
			</div>
		@endif		

		@if(count($servers)>0)
			<div class="h3 container text-warning font-weight-bold">
				<p>Available Servers</p>
			</div>
			<form action="{{route('profileServers')}}/load" method="POST" class="col-md-12 mx-auto">
				{{csrf_field()}}
				<table class="table table-hover table-small">
					<thead>
						<tr>
							<th>Server Name</th>
							<th>Country</th>
							<th>Start Date</th>
							<th>Days</th>
							<th>Time Zone</th>
							<th></th>
						</tr>
					</thead>
				@foreach($servers as $server)
					<tr>
						<td>{{$server->url}}</td>
						<td>{{$server->country}}</td>
						<td>{{$server->start_date}}</td>
						<td>{{$server->days}}</td>
						<td>{{$server->timezone}}</td>
						<td><button class="btn btn-warning btn-sm" name="server" value="{{$server->server_id}}">
    							<i class="fa fa-angle-double-right"></i> Load Server</button>
						</td>
					</tr>
				@endforeach
				</table>			
			</form>	
		@endif
		</div>
	</div>
	
@endsection

