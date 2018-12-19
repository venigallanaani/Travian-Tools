@extends('Profile.template')
@section('body')

	<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
		<div class="card-header h4 py-2 bg-warning text-white">
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
			<div class="card shadow col-md-8 p-0 mx-auto">
				<div class="card-header h4 py-2 bg-warning text-white text-center">
					<strong>Contact Details</strong>
				</div>
				<div class="card-text">
					<table class="table table-hover col-md-12 text-center">
						<tr>
							<td class="text-right">Skype :</td>
							<td contenteditable="true" class="text-left">Chandra.v87</td>
						</tr>
						<tr>
							<td class="text-right">Discord :</td>
							<td contenteditable="true" class="text-left">Jag#3306</td>
						</tr>
						<tr>
							<td class="text-right">Phno :</td>
							<td contenteditable="true" class="text-left">XXXXXXXX</td>
						</tr>
					</table>
				</div>			
			</div>
		</div>
	</div>
@endsection