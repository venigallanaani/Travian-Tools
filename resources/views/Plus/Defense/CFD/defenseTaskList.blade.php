@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-10 mb-5 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Defense Tasks</strong></div>
			<div class="card-text">
    <!-- ==================================== List of CFD is progress ======================================= -->
				@if(count($tasks)==0)
					<p class="text-center h5 py-5">No defense tasks are active currently.</p>				
				@else
				
        		@foreach(['danger','success','warning','info'] as $msg)
        			@if(Session::has($msg))
        	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>{{ Session::get($msg) }}
                        </div>
                    @endif
                @endforeach	
                	
				<div class="text-center col-md-11 mx-auto my-2 p-0">					
					<table class="table align-middle" id="cfdtable">
						<thead class="thead-inverse h6">
    						<tr id="header" class="">
    							<th class="">Player</th>
    							<th class="">Village</th>
    							<th class="">Defense</th>
    							<th class="">Type</th>
    							<th class="">Priority</th>
    							<th class="">Land Time</th>
    							<th class="">Time left</th>
    							<th class=""></th>    							
    						</tr>
						</thead>
						@foreach($tasks as $task)
							@php
								if($task->priority=='high'){$color='text-danger';}
								elseif($task->priority=='medium'){$color='text-warning';}
								elseif($task->priority=='low'){$color='text-info';}
								else{$color="";}								
								
								if($task->type=='defend'){$bgcolor = '#dbeef4';	}
								elseif($task->type=='snipe'){$bgcolor = '#ffe6cc';	}
								elseif($task->type=='scout'){$bgcolor = '#ffff99';	}
								elseif($task->type=='stand'){$bgcolor = '#eeffcc';	}
								else{$bgcolor ='#e6e6e6';	}
								
							@endphp
    						<tr class="" style="font-size:0.8em; background-color:{{$bgcolor}};">
    							<td class="py-1 px-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->player}}</strong></a>
    							</td>
    							<td class="py-1 px-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$task->x}}&y={{$task->y}}" target="_blank">
    								<strong>{{$task->village}} ({{$task->x}}|{{$task->y}})</strong></a>
    							</td>
    							<td class="py-1 px-0">{{number_format($task->def_remain)}}</td>
    							<td class="py-1 px-0"><strong>{{ucfirst(strtolower($task->type))}}</strong></td>
    							<td class="{{$color}} py-1 px-0"><strong>{{ucfirst($task->priority)}}</strong></td>
    							<td id="target" class="py-1 px-0">{{$task->target_time}}</td>
    							<td id="timer" class="py-1 px-0 font-weight-bold">00:00:00</td>
    							<td class="py-1 px-0"><a class="btn btn-outline-secondary btn-sm py-0" href="/plus/defense/{{$task->task_id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
				@endif
				
				@if(count($withdraws)>0)
					<div class="text-center mx-auto col-md-8 my-4">
						<p class="bg-warning h4 py-1"> Troops Withdrawl Request </p>
					@foreach($withdraws as $withdraw)
						<p class="h6"> Withdraw your reinforcements from <strong><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$withdraw['X']}}&y={{$withdraw['Y']}}" target="_blank">{{$withdraw['PLAYER']}} ({{$withdraw['VILLAGE']}})</a></strong></p>		
					@endforeach	
					</div>			
				@endif
			</div>
		</div>
@endsection

@push('scripts')
	<script>
		$(document).ready(function(){		
    		setInterval(function(){
        		$('#cfdtable tr').each(function (i, row){
        			if(i>0){
        				var row = $(row);
        				if(row.attr("id") !== 'header'){
							var dist = new Date(row.find('#target').text()).getTime()-new Date(moment().tz("{{ Session::get('timezone') }}")).getTime();
							
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

@push('extensions')
	<meta name="timezone" content="{{ Session::get('timezone') }}" />
@endpush