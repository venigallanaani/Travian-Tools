@extends('Layouts.incomings')

@section('body')

		<div class="card float-md-left col-md-12 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Incoming Hammer Tracking</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
					
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
    		
    			
    			<div class="card card-body m-0 p-2">
    				<table class="table col-md-6 mx-auto table-borderless align-center">
    					<tr>
    						<td class="py-5">
    							<p class="h5"><strong>Attacker 			- </strong><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$incomings[0]['att_uid']}}" target="_blank">{{$incomings[0]['att_player']}}</a></p>
    							<p class="h5"><strong>Village 			- </strong><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incomings[0]['att_x']}}&y={{$incomings[0]['att_y']}}" target="_blank">{{$incomings[0]['att_village']}}</a></p>
    							<p class="h5"><strong>Total waves 		- </strong>{{array_sum(array_column($incomings,'waves'))}}</p>    							
    							<p class="h5"><strong>Target Villages 	- </strong>{{count(array_unique(array_column($incomings,'def_vid')))}}</p>
    						</td>
    						<td>
    							<form action="/plus/incoming/update" method="post" style="background-color:#dbeef4" class="m-2 text-center p-2">
    								{{csrf_field()}}
									<p class="h5"><strong>Update Attacker Stats</strong></p>
									<p class="h6"><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$incomings[0]['att_uid']}}" target="_blank">Account Details <i class="fas fa-external-link-alt"></i></a></p>									
									<textarea rows="3" cols="30" name="account" required></textarea>
									<p class="small text-danger">Enter source code of the account page</p>
									<p><button type="submit" class="btn btn-small px-5 btn-primary"  name="att" value="{{$incomings[0]['att_id']}}">Update</button></p>
    							</form>    							
    						</td>
						</tr>
    				</table>
        		@if($report==null)
        			<p class="text-center text-danger h5">No reports of enemy hammer are saved</p>
        		@else        			        			
        			<table class="table table-bordered text-center col-md-8 mx-auto">
        				<thead>
            				<tr>
            					<td colspan="13" class="py-2 h6 bg-primary text-white">Enemy Hammer Report</td>
        					</tr>
            				<tr>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[0]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[0]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[1]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[1]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[2]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[2]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[3]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[3]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[4]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[4]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[5]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[5]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[6]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[6]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[7]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[7]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[8]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[8]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[9]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[9]['image']}}"></td>
            					<td class="px-0 py-1"><strong>Upkeep</strong></td>
            					<td class="px-0 py-1"><strong>Report Date</strong></td>
            					<td class="px-0 py-1"><strong>Report</strong></td>
            				</tr>
        				</thead>
        				<tr>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][0])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][1])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][2])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][3])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][4])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][5])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][6])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][7])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][8])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][9])}}</td>
        					<td class="px-0 py-0" >{{number_format($report['upkeep'])}}</td>
        					<td class="px-0 py-0" >{{$report['report_date']}}</td>
        					<td class="px-0 py-0" ><a href="/reports/{{$report['report']}}" target="_blank">Link <i class="fas fa-external-link-alt"></i></a></td>
        				</tr>
        			</table>
        			
        		@endif
    			</div>
    			
        		<div class="card card-body px-5">
        		@if(count($tracks)==0)
        			<p class="text-center text-primary h5">Attacker Stats information not stored</p>
        		@else
        			<table class="table text-center table-sm table-hover table-bordered">
        				<thead class="">
            				<tr>
            					<td colspan="6" class="py-2 h5 bg-warning">Attacker Tracking</td>
            				</tr>
    						<tr class="text-info font-weight-bold h5">
    							<td class="px-0">Hero XP</td>
    							<td class="px-0">Attack Points</td>
    							<td class="px-0">Defense Points</td>
    							<td class="px-0">Gear Change</td>
    							<td class="px-0">Saved Time</td>
    							<td class="px-0">Uploaded By</td>
    						</tr>
        				</thead>
						@foreach($tracks as $track)
							<tr class="">
								<td class="px-0 @if($track['exp_change']!=0) table-warning @endif">
									@if($track['exp']!=null)
										{{number_format($track['exp'])}} @if($track['exp_change']!=0) <strong>(+{{number_format($track['exp_change'])}})</strong> @endif
									@else
										N/A
									@endif
								</td>
								<td class="px-0 @if($track['attack_change']!=0) table-warning @endif">
									@if($track['attack']!=null)
										{{number_format($track['attack'])}} @if($track['attack_change']!=0) <strong>(+{{number_format($track['attack_change'])}})</strong> @endif
									@else
										N/A
									@endif									
								</td>
								<td class="px-0 @if($track['defense_change']!=0) table-warning @endif">
									@if($track['defense']!=null)
										{{number_format($track['defense'])}} @if($track['defense_change']!=0) <strong>(+{{number_format($track['defense_change'])}})</strong> @endif
									@else
										N/A
									@endif									
								</td>								
								<td class="px-0  @if($track['image_change']=='YES') table-danger @endif">
									@if($track['image_change']=='NO') 
										No Change									
									@else
										<strong><i class="fa fa-arrow-down" aria-hidden="true"></i> Changed <i class="fa fa-arrow-down" aria-hidden="true"></i></strong>
									@endif
								</td>

								<td class="px-0">{{$track['save_time']}}</td>
								<td class="px-0"><a href="/plus/member/{{$track['save_by']}}" target="_blank">{{$track['save_by']}}</a></td>
							</tr>
							@if($track['image_change']=='YES')
								<tr>
									<td colspan="6">
    									<span><img src="https://{{Session::get('server.url')}}{{$track['image_old']}}"></span> 
    										<i class="fa fa-arrow-right" aria-hidden="true"></i> 
    									<span><img src="https://{{Session::get('server.url')}}{{$track['image']}}"></span>									
									</td>
								</tr>
							@endif						
						@endforeach
        			</table>
    			@endif
        		</div>
        		
        		<div class="card card-body">
        			<table class="table text-center table-sm table-hover table-bordered">
        				<thead class="">
            				<tr>
            					<td colspan="8" class="py-2 h5 text-white bg-info">Incoming Waves</td>
            				</tr>
    						<tr class="text-info font-weight-bold h6">
    							<td class="px-0">Target</td>
    							<td class="px-0">Waves</td>
    							<td class="px-0">Land Time</td>
    							<td class="px-0">Start Time</td>
    							<td class="px-0">Noticed Time</td>
    							<td class="px-0">Status</td>
    							<td class="px-">Notes</td>
    						</tr>
        				</thead>
						@foreach($incomings as $incoming)
							<tr class="small h6">
								<td class="px-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['def_x']}}&y={{$incoming['def_y']}}" target="_blank">
									<strong>{{$incoming['def_player']}}</strong> ({{$incoming['def_village']}})</a></td>
								<td class="px-0">{{$incoming['waves']}}</td>
								<td class="px-0">{{$incoming['landTime']}}</td>
								<td class="px-0">TBD</td>
								<td class="px-0">{{$incoming['noticeTime']}}</td>
								<td class="px-0">{{ucfirst(strtolower($incoming['ldr_sts']))}}</td>
								<td class="px-0">{{$incoming['comments']}}</td>
							</tr>
						@endforeach
        			</table>
        		</div>
			</div>
		</div>

@endsection


