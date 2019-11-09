@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
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
				<div class="col-md-10 mx-auto my-2 py-0">
        			<div class="card shadow p-0 mx-auto">
            			<div class="card-header h4 py-2 text-info">
            				<strong>Subscription Details</strong>
            			</div>
            			<div class="card-text h6 py-2">
            				<table class="table table-borderless">
            					<tr>            						
            						<td class="text-center py-1"><strong>Group Owner</strong></td>
            						<td class="text-left py-1">: {{$subscription->owner}} </td>
            					</tr>
            					<tr>            						
            						<td class="text-center py-1"><strong>Duration</strong></td>
            						<td class="text-left py-1">: {{$subscription->duration}} <small>days</small></td>
            					</tr>
            					<tr>            						
            						<td class="text-center py-1"><strong>End Date</strong></td>
            						<td class="text-left py-1">: {{$subscription->end_date}} </td>
            					</tr>
            				</table>				
            			</div>			
        			</div>
				</div>	
        <!-- =========================== Add to group link ================================ -->
        		<div class="col-md-11 mx-auto py-3">
            		<div class="mx-auto container rounded p-3" style="background-color:#dbeef4">            							
            			<strong><span class="blockquote">Plus Group Link: </span></strong><input type="text" id ="link" name="link" value="https://www.travian-tools.com/plus/join/{{$subscription->link}}" class="w-50"/>
            			<button class="btn btn-primary btn-sm px-2" onclick="copyLink()"> Copy Link </button>
            			<form action="/plus/join" method="post">
            				{{csrf_field()}}
            				<br/>
            				<button class="btn btn-warning px-3"><strong> Create New Link </strong></button>
        				</form>
            		</div>	     		
        		</div>
		<!-- =========================== leadership Options control panel ================================ -->		
				<div class="col-md-11 mx-auto mb-5 p-0">
        			<div class="card shadow col-md-8 p-0 mx-auto">
            			<div class="card-header h4 py-2 text-info">
            				<strong>Message of the day</strong>
            			</div>
            			<div class="card-text">
            				<table class="table table-hover col-md-12 text-center">
            					<tr>            						
            						<td contenteditable="true" class="text-left col-md-6" id="messageEdit"> {{$subscription->message}} </td>
            					</tr>
            				</table>
            				<form id="form" action="/leader/subscription/message" method="POST" onsubmit="return getContent()" class="text-center pb-3">
            					{{ csrf_field() }}
            					<input id="message" name="message" style="display:none">
            					<button class="btn btn-info btn-lg px-5" type="submit">Post</button>						
            				</form>					
            			</div>			
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