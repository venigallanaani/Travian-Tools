@extends('Profile.template')
@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h4 py-2 bg-warning text-white">
			<strong>Servers Overview</strong>
		</div>
		<div class="card-text p-4">
		@if(count($profiles)>0)			
				<table class="table table-hover table-small text-center">
					<thead class="">
						<tr>
							<th>Server Name</th>
							<th>Start Date</th>
							<th>Days</th>
							<th>Account</th>
							<th>Type</th>
							<th>Plus Group</th>
							<th></th>
						</tr>
					</thead>
				@foreach($profiles as $profile)
					<tr>
						<td>{{$profile['name']}}</td>
						<td>{{$profile['start_date']}}</td>
						<td>{{$profile['days']}}</td>
						<td><img data-toggle="tooltip" data-placement="top" title="{{$profile['tribe']}}" alt="" src="/images/x.gif" class="tribe {{$profile['tribe']}}"> 
							<strong> {{$profile['account']}}</strong></td>
						<td>{{ucfirst(strtolower($profile['status']))}}</td>
						<td>
							@if($profile['plus']==null)
								NA
							@else
								{{$profile['plus']}}
							@endif
						</td>
						<td><button class="btn btn-warning btn-sm" id="details" name="button" value=""><i class="fa fa-arrow-down" aria-hidden="true"></i></td>
					</tr>
					<tr style="display: none; background-color:#dbeef4">
						<td>
							<form action="{{route('profileServers')}}/load" method="POST">
								{{csrf_field()}}
								<button class="btn btn-success" name="server" value="{{$profile['server_id']}}"><i class="fa fa-angle-double-right"></i> <strong>Load Server</strong></button>
							</form>
						</td>
						<td colspan="2"><a href="{{route('accountDelete')}}"><button class="btn btn-warning"><strong>Delete Account</strong></button></a></td>
						<td colspan="3">
							@if($profile['plus']==null)
								<button class="btn btn-info" disabled><strong>Leave Plus Group</strong></button>
							@else
								<a href="{{route('plusLeave')}}"><button class="btn btn-info"><strong>Leave Plus Group</strong></button></a>
							@endif
						</td>
						<td></td>
					</tr>
				@endforeach
				</table>
		@else
			<div class="text-center h5">
				<p>No active profiles in Travian right now</p>
			</div>
		@endif

		</div>
	</div>
	
@endsection

@push('scripts')
	<script>
    $(document).on('click','#details',function(e){
        e.preventDefault();  
    
        var col= $(this).closest("td");
        var id= col.find('#details').val();

		var row = $(this).closest('tr').next('tr');
		row.toggle('500');
    
    });

	</script>
@endpush
