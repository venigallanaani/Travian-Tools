@extends('Plus.template')

@section('body')
		<div class="card float-md-left col-md-10 p-0 shadow mb-5">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Offense Plan - {{$plan->name}}</strong></div>
			<div class="card-text">
				
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach	
                
                <div class="text-center col-md-8 mx-auto p-2">
                	<table class="table table-borderless table-sm text-left" style="font-size:0.9em">
                		<tr>
                			<td class="align-middle py-0">
                				<p class="py-0"><strong>Status : </strong>{{ucfirst(strtolower($plan->status))}}</p>
                				<p class="py-0"><strong>Created By : </strong>{{$plan->create_by}}</p>
                				<p class="py-0"><strong>Updated By : </strong>{{$plan->update_by}}</p>
                			</td>
                			<td class="text-center align middle">
            					<p class="my-1"><a href="/offense/status/{{$plan->id}}">
                					<button class="btn btn-warning btn-sm px-4"><i class="fas fa-sync"></i> Refresh Plan</button>
            					</a></p>
                				<p class="my-1"><a href="/offense/plan/edit/{{$plan->id}}" target="_blank">
                					<button class="btn btn-primary btn-sm px-5">Edit Plan</button>
            					</a></p>
                				<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
                				@if(count($waves)!=0 && $plan->status =='DRAFT')
                					<p class="my-1"><button class="btn btn-success btn-sm px-5" name="publishPlan" value="{{$plan->id}}">Publish Plan</button></p>
            					@endif
            					@if($plan->status =='PUBLISH' || $plan->status == 'INPROGRESS')
            						<p class="my-1"><button class="btn btn-success btn-sm px-4" name="completePlan" value="{{$plan->id}}">Mark as Complete</button></p>
        						@endif
        							<p class="my-1"><button class="btn btn-danger btn-sm px-5" name="deletePlan" value="{{$plan->id}}">Delete Plan</button></p>
    							@if($plan->status == 'COMPLETE')
    								<p class="my-1"><button class="btn btn-secondary btn-sm px-5" name="archivePlan" value="{{$plan->id}}">Archive Plan</button></p>
								@endif
            					</form>
                			</td>                			
                		</tr>                    		
                	</table>
                </div>
            @if(count($waves)==0)
            	<div class="text-center col-md-11 mx-auto my-3">
            		<p class="h6">No attacks are planned yet</p>
            	</div>            
            @else	
        		<div class="p-2 shadow rounded mx-auto col-md-11" >
            		<svg id="sankeyChart" width="800" height="300" style="margin:auto"></svg>                		
                </div>
				<div class="text-center col-md-11 mx-auto my-5 p-0">
					<table class="table align-middle table-sm table-hover" id="offenseplan">
						<thead class="thead-inverse h6">
    						<tr>
    							<th style="width:7em" class="">Attacker</th>
    							<th style="width:7em" class="">Target</th>    							
    							<th style="width:6em" class="">Land Time</th>
    							<th style="width:4em" class="">Type</th>    							
    							<th style="width:2em" class="">Waves</th>
    							<th style="width:3em" class="">Units</th>
    							<th style="width:6em" class="">Notes</th>
    							<th style="width:4em" class="">Status</th>    							
    							<th style="width:4em" class="">Report</th>  							
    						</tr>
						</thead>
						@foreach($waves as $wave)
							@php
                            	if($wave['type'] == 'REAL'){	$color='text-danger';	}
                            	elseif($wave['type'] == 'FAKE'){	$color='text-primary';	}
                            	elseif($wave['type'] == 'CHIEF'){	$color='text-warning';	}
                            	elseif($wave['type'] == 'SCOUT'){	$color='text-success';	}
                            	else{	$color='text-dark';	}
                            @endphp	
    						<tr class="small" id="wave">
    							<td class="align-middle"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$wave['a_x']}}&y={{$wave['a_y']}}" target="_blank">
    								<strong>{{$wave['a_player']}}</strong> ({{$wave['a_village']}})</a>
    							</td>
    							<td class="align-middle"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$wave['d_x']}}&y={{$wave['d_y']}}" target="_blank">
    								<strong>{{$wave['d_player']}}</strong> ({{$wave['d_village']}})</a>
    							</td>    							
    							<td id="start" rel="{{$wave['starttime']}}" class="align-middle">{{$wave['landtime']}}</td>
    							<td class="{{$color}} align-middle"><strong>{{ucfirst(strtolower($wave['type']))}}</strong></td>
    							<td class="align-middle">{{$wave['waves']}}</td>
    							<td data-toggle="tooltip" data-placement="top" title="{{$wave['name']}}"><img alt="" src="/images/x.gif" class="units {{$wave['unit']}}"></td>
    							<td class="align-middle small">{{$wave['notes']}}</td>
    							<td class="align-middle">
    							@if($wave['timer']==1)
    								<span id="timer" class="font-weight-bold" data-toggle="tooltip" data-placement="top" title="Send Time Countdown">00:00:00</span>
    							@else
        							@if($wave['status']=="LAUNCH")
        								<span style="font-weight:bold;color:green">Launched</i></span>
        							@elseif($wave['status']=="MISS")
        								<span style="font-weight:bold;color:red">Missed</i></span>
        							@else
        								<span class="font-weight-bold" data-toggle="tooltip" data-placement="top" title="Send Time Countdown">00:00:00</span>
        							@endif
    							@endif
    							</td>							
    							<td class="align-middle">@if($wave['report']!=null)    								
    								<a href="{{$wave['report']}}" target="_blank"><strong>Link <i class="fas fa-external-link-alt small"></i></strong></a>
    								@endif
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
			@endif
			</div>
		</div>
@endsection
@push('scripts')
    @if($sankeyData!=null)
    	<script type="text/javascript" src="{{ asset('js/d3.v3.js')	}}"></script>
		<script type="text/javascript" src="{{ asset('js/sankey.js')}}"></script>
		<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    	{{	createSankey($sankeyData)	}}
	@endif
	
<script>
	$(document).ready(function(){       	
		setInterval(function(){
    		$('#offenseplan tr').each(function (i, row){
    			if(i>0){
    				var row = $(row);
    				var id = row.attr("id");
    				if(id == 'wave'){
						var start = row.find('#start').attr("rel");
						var dist = new Date(start).getTime()-new Date(moment()).getTime();
						
						if(dist<0){
    			      		row.find('#timer').text("00:00:00");
    			      		row.find('#timer').css('color','red');
    			      	}else{
    			      		var days = Math.floor(dist / (1000 * 60 * 60 * 24));
    			      		var hours = days * 24 + Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    			      		var mins = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
    			      		var secs = Math.floor((dist % (1000 * 60)) / 1000);

    			      		if(hours<10){	hours='0'+hours;	}
    			      		if(mins<10) {	mins='0'+mins;		}
    			      		if(secs<10) {	secs='0'+secs;		}
    			      		
    			      		row.find('#timer').text(hours+':'+mins+':'+secs);
    			      		row.find('#timer').css('color','blue');
    			      	}   						
    				}
    			}			
    		});	
		}, 1000);	
	});	
</script>
	
@endpush