@extends('Plus.template')

@section('body')
	

<!-- =============================================Plus Overview=========================================== -->
    <div class="card float-md-left col-md-9 mt-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-info text-white">
            <strong>Member Contact Details</strong>
        </div>
        <div class="px-5 py-2 h5">
    		<table class="table table-borderless mx-auto col-md-8">
    			<tr>
    				<td class="text-left text-info py-2 font-weight-bold">Travian Profile </td>
    				<td class="text-left">: {{$name}}</td>
    			</tr>
    			<tr>
    				<td class="text-left py-2 text-info font-weight-bold">TT Account Name </td>
    				<td class="text-left">: {{Auth::user()->name}}</td>
    			</tr>
    			<tr>
    				<td class="text-left py-2 text-info font-weight-bold">Skype </td>
    				<td class="text-left">: {{$skype}}</td>
    			</tr>
    			<tr>
    				<td class="text-left py-2 text-info font-weight-bold">Discord </td>
    				<td class="text-left">: {{$discord}}</td>
    			</tr>
			</table>
        </div>

@endsection
