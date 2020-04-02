@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Subscription</strong></div>
			<div class="card-text">			
		<!-- ============================ Add success/failure notifications ============================== -->
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
				<div class="container">
    	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                </div>
            @endif
        @endforeach
        <!-- =========================== Subscription details ================================ -->
    			<div class="col-md-10 card shadow p-0 my-2 mx-auto">
        			<div class="card-header h4 py-2 text-info">
        				<strong>Subscription Details</strong>
        			</div>
        			<div class="card-text h6 py-2">
        				<table class="table table-borderless">
        					<tr>            						
        						<td class="text-right py-1"><strong>Group Owner</strong></td>
        						<td class="text-left py-1">: {{$subscription->owner}} </td>
        					</tr>
        					<tr>            						
        						<td class="text-right py-1"><strong>Duration</strong></td>
        						<td class="text-left py-1">: {{$subscription->duration}} <small>days</small></td>
        					</tr>
        					<tr>            						
        						<td class="text-right py-1"><strong>End Date</strong></td>
        						<td class="text-left py-1">: {{$subscription->end_date}} </td>
        					</tr>
        				</table>				
        			</div>			
    			</div>
        
        <!-- =========================== Add to group link ================================ -->

        		<div class="col-md-10 mx-auto container rounded p-3 my-2 shadow" style="background-color:#dbeef4">            							
        			<strong><span class="blockquote">Plus Group Link: </span></strong><input type="text" id ="link" name="link" value="https://www.travian-tools.com/plus/join/{{$subscription->link}}" class="w-50"/>
        			<button class="btn btn-primary btn-sm px-2" onclick="copyLink()"> Copy Link </button>
        			<form action="/plus/join" method="post">
        				{{csrf_field()}}
        				<br/>
        				<button class="btn btn-warning px-3"><strong> Create New Link </strong></button>
    				</form>
        		</div>	 
        
	   <!-- =========================== leadership Options control panel ================================ -->		

    			<div class="card shadow col-md-10 p-0 my-2 mx-auto">
        			<div class="card-header h4 py-2 text-info">
        				<strong>Message of the day</strong>
        			</div>
        			<div class="card-text">
        				<table class="table table-hover col-md-12 text-center">
        					<tr>            						
        						<td contenteditable="true" class="text-left" id="messageEdit"> {{$subscription->message}} </td>
        					</tr>
        				</table>
        				<form id="form" action="/leader/subscription/message" method="POST" onsubmit="return getContent()" class="text-center pb-3">
        					{{ csrf_field() }}
        					<input id="message" name="message" style="display:none">
        					<button class="btn btn-info btn-lg px-5" type="submit">Post</button>						
        				</form>					
        			</div>			
    			</div>			

    			<div class="card shadow col-md-10 p-0 my-2 mx-auto">
        			<div class="card-header h4 py-2 text-info">
        				<strong>Group Options</strong>
        			</div>
        			<div class="card-text py-3">
        				<form action="/leader/subscription/options" method="POST" class="text-center">
            				{{ csrf_field() }}
								<div>
            						<p class="h6"><input type="checkbox" name="rank" @php if($subscription->rank== 1){echo 'checked';} @endphp /> Show player rankings</p>
            						<p class="h6">Select Group Timezone 
        								<select name="zone">
        									<option value="Pacific/Auckland" @php if($subscription->timezone == 'Pacific/Auckland'){echo 'selected';} @endphp>Pacific/Auckland (GMT +13)</option>
        									<option value="Pacific/Tarawa" @php if($subscription->timezone == 'Pacific/Tarawa'){echo 'selected';} @endphp>Pacific/Tarawa (GMT +12)</option>
        									<option value="Australia/Sydney" @php if($subscription->timezone == 'Australia/Sydney'){echo 'selected';} @endphp>Australia/Sydney (GMT +11)</option>
        									<option value="Australia/Brisbane" @php if($subscription->timezone == 'Australia/Brisbane'){echo 'selected';} @endphp>Australia/Brisbane (GMT +10)</option>
        									<option value="Asia/Tokyo" @php if($subscription->timezone == 'Asia/Tokyo'){echo 'selected';} @endphp>Asia/Tokyo (GMT +9)</option>
        									<option value="Asia/Shanghai" @php if($subscription->timezone == 'Asia/Shanghai'){echo 'selected';} @endphp>Asia/Shanghai (GMT +8)</option>
        									<option value="Asia/Jakarta" @php if($subscription->timezone == 'Asia/Jakarta'){echo 'selected';} @endphp>Asia/Jakarta (GMT +7)</option>
        									<option value="Asia/Dhaka" @php if($subscription->timezone == 'Asia/Dhaka'){echo 'selected';} @endphp>Asia/Dhaka (GMT +6)</option>
        									<option value="Asia/Karachi" @php if($subscription->timezone == 'Asia/Karachi'){echo 'selected';} @endphp>Asia/Karachi (GMT +5)</option>
        									<option value="Asia/Dubai" @php if($subscription->timezone == 'Asia/Dubai'){echo 'selected';} @endphp>Asia/Dubai (GMT +4)</option>
        									<option value="Europe/Moscow" @php if($subscription->timezone == 'Europe/Moscow'){echo 'selected';} @endphp>Europe/Moscow (GMT +3)</option>
        									<option value="Africa/Cairo" @php if($subscription->timezone == 'Africa/Cairo'){echo 'selected';} @endphp>Africa/Cairo (GMT +2)</option>
        									<option value="Europe/Budapest" @php if($subscription->timezone == 'Europe/Budapest'){echo 'selected';} @endphp>Europe/Budapest (GMT +1)</option>
        									<option value="Europe/London" @php if($subscription->timezone == 'Europe/London'){echo 'selected';} @endphp>Europe/London (GMT)</option>
        									<option value="Atlantic/Cape_Verde" @php if($subscription->timezone == 'Atlantic/Cape_Verde'){echo 'selected';} @endphp>Atlantic/Cape_Verde (GMT -1)</option>
        									<option value="America/Sao_Paulo" @php if($subscription->timezone == 'America/Sao_Paulo'){echo 'selected';} @endphp>America/Sao_Paulo (GMT -2)</option>
        									<option value="America/Bahia" @php if($subscription->timezone == 'America/Bahia'){echo 'selected';} @endphp>America/Bahia (GMT -3)</option>
        									<option value="America/Barbados" @php if($subscription->timezone == 'America/Barbados'){echo 'selected';} @endphp>America/Barbados (GMT -4)</option>
        									<option value="America/New_York" @php if($subscription->timezone == 'America/New_York'){echo 'selected';} @endphp>America/New_York (GMT -5)</option>
        									<option value="America/Chicago" @php if($subscription->timezone == 'America/Chicago'){echo 'selected';} @endphp>America/Chicago (GMT -6)</option>
        									<option value="AAmerica/Denver" @php if($subscription->timezone == 'America/Denver'){echo 'selected';} @endphp>America/Denver (GMT -7)</option>
        									<option value="America/Los_Angeles" @php if($subscription->timezone == 'America/Los_Angeles'){echo 'selected';} @endphp>America/Los_Angeles (GMT -8)</option>
        									<option value="America/Anchorage" @php if($subscription->timezone == 'America/Anchorage'){echo 'selected';} @endphp>America/Anchorage (GMT -9)</option>
        									<option value="Pacific/Honolulu" @php if($subscription->timezone == 'Pacific/Honolulu'){echo 'selected';} @endphp>Pacific/Honolulu (GMT -10)</option>
        								</select> 
            						</p>
            						<div class="my-3 h6">
                						<p class="h4 text-info">Group Notifications</p>
                						<p class="">
                							<span class="px-2"><input type="checkbox" name="discord" @if($subscription->discord== 1) checked @endif /> Discord </span>
                							<span class="px-2 text-danger"><input type="checkbox" name="slack" @if($subscription->slack== 1)checked @endif /> Slack (TBD) </span>
            							</p>
            						</div>
								</div>
        					<button class="btn btn-info btn-lg px-5" type="submit">Save</button>						
        				</form>					
        			</div>			
    			</div>
			</div>
		</div>
@endsection

@push('scripts')
        <script>
            function getContent() {
    			message=document.getElementById("messageEdit").innerHTML;
    			if(message=='<br>'){ message='';}
                document.getElementById("message").value = message;               
            }
    	</script>
    	<script>
            function copyLink() {
              var copyText = document.getElementById("link");
              copyText.select();
              document.execCommand("copy");
            }
        </script>
@endpush