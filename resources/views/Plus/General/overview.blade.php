@extends('Plus.template')

@section('body')
	<!-- =============================================Plus Overview=========================================== -->
    <div class="card float-md-left col-md-10 p-0 shadow">
        <div class="card-header h5 py-2 bg-info text-white">
            <strong>Plus Overview</strong>
        </div>
        <div class="card-text p-3 h6">
            <p>Welcome to Plus group - <span class="text-info"><strong>{{Session::get('plus.name')}}</strong></span></p>
            <br>
            <div class="card mx-auto">
            	<div class="card-header py-2 text-info h5">
            		<strong>Message of the day</strong>
            	</div>
            	<div class="card-body py-2 px-5">
            	@if(strlen(trim($subscription->message))>0)
            		<p class="card-text font-italic h6">{{$subscription->message}}</p>
            		<p class="small text-info h6"><strong>{{$subscription->message_update}} ({{$subscription->message_date}})</strong></p>
        		@else
        			<br/><br/>
        		@endif
            	</div>
            </div>
            <br>
            <div class="card mx-auto">
            	<div class="card-header py-2 text-info h5">
            		<strong>Group Status</strong>
            	</div>
            	<div class="card-body px-5">							
				@if($counts['inc']>0)				
					<p><strong>{{$counts['inc']}} <a href="/plus/incoming" class="text-info">Incoming attacks</strong></a> on your account</p>
				@else
					<p>No Incoming attacks on your account</p>
				@endif
				
				@if($counts['def']>0)				
					<p><strong>{{$counts['def']}} <a href="/plus/defense" class="text-info">Defense Calls</strong></a> are in progress</p>
				@else
					<p>No Defense Calls are currently active</p>
				@endif
				
				@if($counts['off']>0)
					<p><strong>{{$counts['off']}} <a href="/plus/offense" class="text-info">Offense Waves</strong></a> are planned for your account</p>
				@else
					<p>No Offense plans are currently active</p>
				@endif	
				
				@if($counts['res']>0)				
					<p><strong>{{$counts['res']}} <a href="/plus/resource" class="text-info">Resource Tasks</strong></a> are active</p>
				@else
					<p>No Resource tasks are currently active</p>
				@endif
            	</div>
            </div>           
        </div>
    </div>
    	
@endsection