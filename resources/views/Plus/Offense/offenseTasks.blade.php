@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the Offense tasks list ================================= -->
		<div class="card float-md-left col-md-10 p-0 mb-5 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Offense Tasks</strong></div>
			<div class="card-text">
    <!-- ==================================== List of Ops in progress ======================================= -->
    		@if($ops==null)
    			<p class="text-center h5 py-5">No offense plans are available</p>
    		@else
			@foreach($ops as $plan)
			<div class="shadow m-1 rounded">
    			<table class="text-center col-md-8 mx-auto my-3">
    				<tr>
    					<td colspan="2" class="h5 py-2 table-info">Plan: <span class="text-danger"><strong>{{$plan['name']}}</strong></span></td>
					</tr>
    				<tr>
    					<td><span class="text-info font-weight-bold">Created By: </span>{{$plan['create']}}</td>
    					<td><span class="text-info font-weight-bold">Updated By: </span>{{$plan['update']}}</td>
    				</tr>
    			</table>
    			<div class="text-center col-md-12 mx-auto my-3 px-2">
					<table class="table align-middle table-sm table-hover" id="offensetask">
						<thead class="thead-inverse">
    						<tr style="font-size:0.9em" class="h6" id="header">
    							<th class="" style="width:6em">Village</th>
    							<th class="" style="width:10em">Target</th>    							
    							<th class="" style="width:8em">Land time</th>
    							<th class="" style="width:4em">Type</th>
    							<th class="" style="width:3em">Waves</th>
    							<th class="" style="width:3em">Troops</th>    							
    							<th class="" style="width:8em">Start time</th>
    							<th class="" style="width:10em">Notes</th>
    							<th class="" style="width:4em">Status</th>
    							<th class="" style="width:4em">Report</th>
    						</tr>
						</thead>
					@foreach($plan['waves'] as $wave)
						@php
                        	if($wave['type'] == 'REAL'){	$color='text-danger';	}
                        	elseif($wave['type'] == 'FAKE'){	$color='text-primary';	}
                        	elseif($wave['type'] == 'CHIEF'){	$color='text-warning';	}
                        	elseif($wave['type'] == 'SCOUT'){	$color='text-success';	}
                        	else{	$color='text-dark';	}
                        @endphp	
						<tr class="small" id="{{$wave['id']}}">
							<td class="align-middle px-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$wave['a_x']}}&y={{$wave['a_y']}}" target="_blank">
								<strong>{{$wave['a_village']}}</strong></a>
							</td>
							<td class="align-middle px-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$wave['d_x']}}&y={{$wave['d_y']}}" target="_blank">
								<strong>{{$wave['d_player']}} ({{$wave['d_village']}})</strong></a>
							</td>							
							<td class="align-middle px-0">{{$wave['landtime']}}</td>
							<td class="{{$color}} align-middle"><strong>{{ucfirst(strtolower($wave['type']))}}</strong></td>
							<td class="align-middle px-0"><strong>{{$wave['waves']}}</strong></td>
							<td class="align-middle px-0"><span data-toggle="tooltip" data-placement="top" title="{{$wave['name']}}"><img alt="all" src="/images/x.gif" class="units {{$wave['unit']}}"></td>
							<td class="align-middle px-0" id="start">{{$wave['starttime']}}</td>
							<td class="small align-middle px-0">{{$wave['notes']}}</td>
							<td class="align-middle px-0">
							@if($wave['timer']==0)
								<span id="timer" class="font-weight-bold" data-toggle="tooltip" data-placement="top" title="Send Time Countdown">00:00:00</span>
							@else
    							@if($wave['status']=="LAUNCH")
    								<span style="font-weight:bold;color:green">Launched</i></span>
    							@elseif($wave['status']=="MISS")
    								<span style="font-weight:bold;color:red">Missed</i></span>
    							@else
    								<button data-toggle="tooltip" data-placement="top" title="Sent" class="badge badge-success" id="sts" value="LAUNCH"><i class="fas fa-check"></i></button>
        							<button data-toggle="tooltip" data-placement="top" title="Not Sent" class="badge badge-danger" id="sts" value="MISS"><i class="fas fa-times"></i></button>
    							@endif
							@endif
							</td>
							<td class="align-middle"><input name="report" id="report" type="text" size="10" @if(strlen(trim($wave['report']))>0) value="{{$wave['report']}}" @endif></td>													
						</tr>
					@endforeach
					</table> 
				</div> 			
    			@endforeach
    			</div>
    		@endif
			</div>
		</div>
@endsection
@push('scripts')
	<script>    
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});   
        $(document).on('click','#sts',function(e){
            e.preventDefault();
            var sts = $(this).val();
			var wave = $(this).closest("tr").attr("id"); 
			var col = $(this).closest("td");			

			$.ajax({
		        type:'POST',
		        url:'/plus/offense/update',
		        data:{  id:wave,	name:'status',	value:sts      		
            	},
            	success:function(data){
        			if(sts=="LAUNCH"){	col.text('Launched');	col.css({'color':'green','font-weight':'bold'});	}
        			if(sts=="MISS"){	col.text('Missed');	col.css({'color':'red','font-weight':'bold'});		}
            	},
		        error:function(){
		        	alert('Something went wrong, please try again. Contact administrator, if the problem persists.');
		        }
		     });			
    	}); 

      	$(document).on('change','#report',function(e){
        	e.preventDefault();
			var report = $(this).val();
			var task = $(this).closest("tr").attr("id");
			
		    $.ajax({
		        type:'POST',
		        url:'/plus/offense/update',
		        data:{  id:task,	name:'report',	value:report
            	},
            	success:function(data){
					//alert(data.message);
            	},
		        error:function(){
		        	alert('Something went wrong, please try again. Contact administrator, if the problem persists.');
		        }
		     });
      	});
    	   	
    	$(document).ready(function(){       	
    		setInterval(function(){
        		$('#offensetask tr').each(function (i, row){
        			if(i>0){
        				var row = $(row);
        				var id = row.attr("id");
        				if(id !== 'header'){
							var start = row.find('#start').text();
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

@push('extensions')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush