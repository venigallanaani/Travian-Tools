@extends('Plus.template')

@section('body')
	

<!-- =============================================Plus Overview=========================================== -->
    <div class="card float-md-left col-md-9 mt-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-info text-white">
            <strong>Member Contact Details</strong>
        </div>
    @if($contact!=null)
        <div class="px-5 py-2 h5">
    		<table class="table table-borderless mx-auto col-md-8">
    			<tr>
    				<td class="text-left py-2 text-info font-weight-bold">Skype </td>
    				<td class="text-left">: {{$contact->skype}}</td>
    			</tr>
    			<tr>
    				<td class="text-left py-2 text-info font-weight-bold">Discord </td>
    				<td class="text-left">: {{$contact->discord}}</td>
    			</tr>
			</table>
        </div>
    @else
    	<div class="h4 text-center m-5">
    		<p>Contact information not found</p>
    	</div>    	
	@endif
@endsection
