@extends('Profile.template')
@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h5 py-2 bg-warning text-white">
			<strong>Servers Overview</strong>
		</div>
		<div class="card-text p-4">
		@if(count($profiles)>0)			
				<table class="table table-hover table-small text-center" style="font-size:0.9em">
					<thead class="h6">
						<tr class="table-warning">
							<th class="py-1">Server Name</th>
							<th class="py-1">Start Date</th>
							<th class="py-1">Days</th>
							<th class="py-1">Account</th>
							<th class="py-1">Type</th>
							<th class="py-1">Plus Group</th>
							<th class="py-1"></th>
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
						<td><button class="badge badge-warning" id="details" name="button" value=""><i class="fas fa-angle-double-down px-1"></i></td>
					</tr>
					<tr style="display: none; background-color:#dbeef4">
						<td>
							<form action="{{route('profileServers')}}/load" method="POST">
								{{csrf_field()}}
								<button class="btn btn-success" name="server" value="{{$profile['server_id']}}"><i class="fa fa-angle-double-right"></i> <strong>Load Server</strong></button>
							</form>
						</td>
						<td colspan="3"><a href="{{route('accountDelete')}}"><button class="btn btn-warning"><strong>Delete Account</strong></button></a></td>
						<td colspan="2">
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
