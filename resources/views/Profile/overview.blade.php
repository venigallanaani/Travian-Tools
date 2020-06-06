@extends('Profile.template')
@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h5 py-2 bg-warning text-white">
			<strong>Account Overview</strong>
		</div>
		<div class="card-text p-4">
			<table class="table table-borderless mx-3 text-left col-md-6 mx-auto">
				<tr>
					<td class="py-1"><strong><span class="text-warning">User Name</span></strong></td>
					<td class="py-1">: {{Auth::user()->name}}</td>
				</tr>
				<tr>
					<td class="py-1"><strong><span class="text-warning">Email Address</span></strong></td>
					<td class="py-1">: {{Auth::user()->email}}</td>
				</tr>
			</table>
			
			<div class="py-5 col-md-8 mx-auto text-center">
				<p class="bg-warning h5 text-white card-header py-2">Profile Details</p>
				<form id="form" action="{{route('profileUpdate')}}" method="POST" class="text-center pb-3">
					{{ csrf_field() }}
        			<table class="table table-hover">
        				<tr>
        					<td class="text-right py-1" style="width:10em;"><strong>Skype ID:</strong></td>
        					<td class="text-left py-1" style="width:10em;"><input name="skype" value="{{ $profile['skype'] }}" style="border:1px"></td>
        				</tr>
        				<tr>
        					<td class="text-right py-1" style="width:10em;"><strong>Discord ID:</strong></td>
        					<td class="text-left py-1" style="width:10em;"><input name="discord" value="{{ $profile['discord'] }}" style="border:1px"></td>
        				</tr>
        				<tr>
        					<td class="text-right py-1" style="width:10em;"><strong>Date Format:</strong></td>
        					<td class="text-left py-1" style="width:10em;">
            					<select name="dateformat"  style="border:2px" class="small">
									<option value="Y-m-d H:i:s" 	@if($profile['dateformat']=='Y-m-d H:i:s') selected 	@endif>YYYY-MM-DD hh:mm:ss</option>
									<option value="m-d-Y H:i:s" 	@if($profile['dateformat']=='m-d-Y H:i:s') selected 	@endif>MM-DD-YYYY hh:mm:ss</option>
									<option value="d-m-y H:i:s" 	@if($profile['dateformat']=='d-m-y H:i:s') selected 	@endif>DD-MM-YYYY hh:mm:ss</option>
								</select>
        					</td>
        				</tr>
    				</table>
					<p class="text-center"><button class="btn btn-warning px-5 py-1" type="submit">Save</button></p>
    			</form>
			</div>
		</div>
	</div>
@endsection



