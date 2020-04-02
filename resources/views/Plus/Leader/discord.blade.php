@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Discord Settings</strong></div>
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
        
	   <!-- =========================== leadership Options control panel ================================ -->		
				<div class="mx-5 my-2 h5 text-center">
					<p>Enter your appropriate Discord Channel Webhooks links below</p>
					<p>How to find the Discord Webhooks? <a href="" target="_blank">Click here</a></p>
				</div>
				
    			<div class="col-md-10 mx-auto my-2">
    				<form action="/leader/discord" method="POST" autocomplete="off">
    					{{ csrf_field() }}
    					<table class="table table-borderless">
    						<tr class="">
    							<td colspan="2" class="text-success font-italic small pb-0">Webhook of the channel to post the defense related notifications like defense calls, reinforcement updates, troops withdraws etc for the players</td>    							
							</tr>
    						<tr class="">
    							<td class="text-right h6 pt-0 w-25 ">Defense Channel</td>
    							<td class="text-left h6 pt-0"><input type="text" name="def" {{$status}} class="w-75" value="{{$discord->def_link}}"></td>
							</tr>
							<tr class="text-success">
    							<td colspan="2" class="py-0 font-italic small">Webhook of the defense coordinators channel to post notifications like defense calls status, new incomings, hero changes etc</td>    							
							</tr>							
							<tr class="">
    							<td class="text-right h6 w-25 pt-0">DC Channel</td>
    							<td class="text-left h6 pt-0"><input type="text" name="def_ldr" {{$status}} class="w-75" value="{{$discord->ldr_def_link}}"></td>
							</tr>
							
							
							<tr><td></td><td></td></tr>
							
							<tr class="text-info">
    							<td colspan="2" class="text-left pb-0 font-italic small">Webhook of the channel to post the notifications related to resource pushes for the players</td>    							
							</tr>
							<tr class="">
    							<td class="text-right h6 w-25 pt-0">Resources Channel</td>
    							<td class="text-left h6 pt-0"><input type="text" name="res" {{$status}} class="w-75" value="{{$discord->res_link}}"></td>
							</tr>
							
							<tr><td></td><td></td></tr>
							
							<tr class="text-danger">
    							<td colspan="2" class="text-left pb-0 font-italic small">Webhook of the channel to post the offense related notifications like new Ops, Ops changes etc for the players</td>    							
							</tr>
							<tr class="">
    							<td class="text-right h6 w-25 pt-0">Ops Channel</td>
    							<td class="text-left h6 v"><input type="text" name="off" {{$status}} class="w-75" value="{{$discord->off_link}}"></td>
							</tr>
							<tr class="text-danger">
    							<td colspan="2" class="text-left py-0 font-italic small">Webhook of the offense coordinators channel to post notifications like Ops status, reports, waves status etc</td>    							
							</tr>
							<tr class="">
    							<td class="text-right h6 w-25 pt-0">OC Channel</td>
    							<td class="text-left h6 pt-0"><input type="text" name="off_ldr" {{$status}} class="w-75" value="{{$discord->ldr_off_link}}"></td>
							</tr>							
							
							<tr><td></td><td></td></tr>
							
							<tr class="text-primary">
    							<td colspan="2" class="text-left pb-0 font-italic small">Defense link to post the defense notifications like defense calls, updates etc for the players</td>    							
							</tr>
							<tr class="">
    							<td class="text-right h6 w-25 pt-0">Artifact Channel</td>
    							<td class="text-left h6 pt-0"><input type="text" name="art" {{$status}} class="w-75" value="{{$discord->art_link}}"></td>
							</tr>
							
							
							<tr><td></td><td></td></tr>
							
							<tr class="">
    							<td colspan="2" class="text-left pb-0 font-italic small">Defense link to post the defense notifications like defense calls, updates etc for the players</td>    							
							</tr>
							<tr class="">
    							<td class="text-right h6 w-25 pt-0">WW Channel</td>
    							<td class="text-left h6 pt-0"><input type="text" name="ww" {{$status}} class="w-75" style="" value="{{$discord->ww_link}}"></td>
							</tr>
							<tr class="">
    							<td colspan="2" class="text-left py-0 font-italic small">Defense link to post the defense notifications like defense calls, updates etc for the players</td>    							
							</tr>
							<tr class="">
    							<td class="text-right h6 w-25 pt-0">WW Coord Channel</td>
    							<td class="text-left h6 pt-0"><input type="text" name="ww_ldr" {{$status}} class="w-75" value="{{$discord->ldr_ww_link}}"></td>
							</tr>							
							
    					</table>
    					<div class="text-center">
    						<button class="btn btn-info btn-lg px-5" type="submit">Update Channels</button>	
    					</div>					
    				</form>			
    			</div>    			
			</div>
		</div>
@endsection
