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
            				<strong>Details</strong>
            			</div>
            			<div class="card-text h6 py-2">
            				<table class="table table-borderless">
            					<tr>            						
            						<td class="text-center py-1"><strong>Group Owner</strong></td>
            						<td class="text-left py-1">: {{$subscription->owner}} </td>
            					</tr>
            					<tr>            						
            						<td class="text-center py-1"><strong>Duration</strong></td>
            						<td class="text-left py-1">: {{$subscription->duration}} </td>
            					</tr>
            					<tr>            						
            						<td class="text-center py-1"><strong>End Date</strong></td>
            						<td class="text-left py-1">: {{$subscription->end_date}} </td>
            					</tr>
							@php
								if($days > 14){$color='text-success';}
								elseif($days <= 14){$color='text-warning';}
								elseif($days <= 7){$color='text-danger';}
								else{$color="";}																
							@endphp
            					<tr>            						
            						<td class="text-center py-1"><strong>Days Left</strong></td>
            						<td class="text-left py-1 {{$color}}">: <strong>{{$days}}</strong> </td>
            					</tr>
            				</table>				
            			</div>			
        			</div>
				</div>
        		<br/>
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
