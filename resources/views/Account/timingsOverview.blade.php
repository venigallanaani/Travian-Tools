@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="float-md-left col-md-10 mt-1 p-0">
			<div class="card-text">
		@foreach(['danger','success','warning','info'] as $msg)
    		@if(Session::has($msg))
    			<div class="col-md-10 mx-auto">
                	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                </div>
            @endif
        @endforeach
        		<div class="card shadow col-md-12 p-0 mx-auto mb-5">
    				<div class="card-header h5 py-2 bg-warning text-white text-center">
    					<strong>Online Timings</strong>
    				</div>
    				<div class="card-text">
    					<p class="h6 text-center py-2" id="time"></p>
    					<p class="h6 text-center py-2">
    						<span class="px-2 text-primary font-weight-bold" id="clock" data-toggle="tooltip" data-placement="top" title="Current Time">...</span>
    						Your Timezone:
    						<select id="zone" style="font-size:0.85em">
								<option value="Pacific/Auckland" @php if($timezone == 'Pacific/Auckland'){echo 'selected';} @endphp>Pacific/Auckland (GMT +13)</option>
								<option value="Pacific/Tarawa" @php if($timezone == 'Pacific/Tarawa'){echo 'selected';} @endphp>Pacific/Tarawa (GMT +12)</option>
								<option value="Australia/Sydney" @php if($timezone == 'Australia/Sydney'){echo 'selected';} @endphp>Australia/Sydney (GMT +11)</option>
								<option value="Australia/Brisbane" @php if($timezone == 'Australia/Brisbane'){echo 'selected';} @endphp>Australia/Brisbane (GMT +10)</option>
								<option value="Asia/Tokyo" @php if($timezone == 'Asia/Tokyo'){echo 'selected';} @endphp>Asia/Tokyo (GMT +9)</option>
								<option value="Asia/Shanghai" @php if($timezone == 'Asia/Shanghai'){echo 'selected';} @endphp>Asia/Shanghai (GMT +8)</option>
								<option value="Asia/Jakarta" @php if($timezone == 'Asia/Jakarta'){echo 'selected';} @endphp>Asia/Jakarta (GMT +7)</option>
								<option value="Asia/Dhaka" @php if($timezone == 'Asia/Dhaka'){echo 'selected';} @endphp>Asia/Dhaka (GMT +6)</option>
								<option value="Asia/Karachi" @php if($timezone == 'Asia/Karachi'){echo 'selected';} @endphp>Asia/Karachi (GMT +5)</option>
								<option value="Asia/Dubai" @php if($timezone == 'Asia/Dubai'){echo 'selected';} @endphp>Asia/Dubai (GMT +4)</option>
								<option value="Europe/Moscow" @php if($timezone == 'Europe/Moscow'){echo 'selected';} @endphp>Europe/Moscow (GMT +3)</option>
								<option value="Africa/Cairo" @php if($timezone == 'Africa/Cairo'){echo 'selected';} @endphp>Africa/Cairo (GMT +2)</option>
								<option value="Europe/Budapest" @php if($timezone == 'Europe/Budapest'){echo 'selected';} @endphp>Europe/Budapest (GMT +1)</option>
								<option value="Europe/London" @php if($timezone == 'Europe/London'){echo 'selected';} @endphp>Europe/London (GMT)</option>
								<option value="Atlantic/Cape_Verde" @php if($timezone == 'Atlantic/Cape_Verde'){echo 'selected';} @endphp>Atlantic/Cape_Verde (GMT -1)</option>
								<option value="America/Sao_Paulo" @php if($timezone == 'America/Sao_Paulo'){echo 'selected';} @endphp>America/Sao_Paulo (GMT -2)</option>
								<option value="America/Bahia" @php if($timezone == 'America/Bahia'){echo 'selected';} @endphp>America/Bahia (GMT -3)</option>
								<option value="America/Barbados" @php if($timezone == 'America/Barbados'){echo 'selected';} @endphp>America/Barbados (GMT -4)</option>
								<option value="America/New_York" @php if($timezone == 'America/New_York'){echo 'selected';} @endphp>America/New_York (GMT -5)</option>
								<option value="America/Chicago" @php if($timezone == 'America/Chicago'){echo 'selected';} @endphp>America/Chicago (GMT -6)</option>
								<option value="AAmerica/Denver" @php if($timezone == 'America/Denver'){echo 'selected';} @endphp>America/Denver (GMT -7)</option>
								<option value="America/Los_Angeles" @php if($timezone == 'America/Los_Angeles'){echo 'selected';} @endphp>America/Los_Angeles (GMT -8)</option>
								<option value="America/Anchorage" @php if($timezone == 'America/Anchorage'){echo 'selected';} @endphp>America/Anchorage (GMT -9)</option>
								<option value="Pacific/Honolulu" @php if($timezone == 'Pacific/Honolulu'){echo 'selected';} @endphp>Pacific/Honolulu (GMT -10)</option>
							</select>							
    					</p>    					
    					<table class="table table-bordered col-md-11 text-center mx-auto">
						@foreach($week as $day)
    						<tr>
								<td class="text-left h6 align-middle table-warning" rowspan="4" style="width:5em">{{ucfirst($day)}}</td>
								<td class="text-left h6 py-0 @if(in_array('1',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(1,'{{$day}}')" type="checkbox"  @if(in_array("1",$timings[$day])) checked @endif /> 00:00 - 01:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('5',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(5,'{{$day}}')" type="checkbox"  @if(in_array("5",$timings[$day])) checked @endif /> 04:00 - 05:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('9',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(9,'{{$day}}')" type="checkbox"  @if(in_array("9",$timings[$day])) checked @endif /> 08:00 - 09:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('13',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(13,'{{$day}}')" type="checkbox"  @if(in_array("13",$timings[$day])) checked @endif /> 12:00 - 13:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('17',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(17,'{{$day}}')" type="checkbox"  @if(in_array("17",$timings[$day])) checked @endif /> 16:00 - 17:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('21',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(21,'{{$day}}')" type="checkbox"  @if(in_array("21",$timings[$day])) checked @endif /> 20:00 - 21:00 
								</td>
							</tr>	
							<tr>
								<td class="text-left h6 py-0 @if(in_array('2',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(2,'{{$day}}')" type="checkbox"  @if(in_array("2",$timings[$day])) checked @endif /> 01:00 - 02:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('6',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(6,'{{$day}}')" type="checkbox"  @if(in_array("6",$timings[$day])) checked @endif /> 05:00 - 06:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('10',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(10,'{{$day}}')" type="checkbox"  @if(in_array("10",$timings[$day])) checked @endif /> 09:00 - 10:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('14',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(14,'{{$day}}')" type="checkbox"  @if(in_array("14",$timings[$day])) checked @endif /> 13:00 - 14:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('18',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(18,'{{$day}}')" type="checkbox"  @if(in_array("18",$timings[$day])) checked @endif /> 17:00 - 18:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('22',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(22,'{{$day}}')" type="checkbox"  @if(in_array("22",$timings[$day])) checked @endif /> 21:00 - 22:00 
								</td>
							</tr>	
							<tr>								
								<td class="text-left h6 py-0 @if(in_array('3',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(3,'{{$day}}')" type="checkbox"  @if(in_array("3",$timings[$day])) checked @endif /> 02:00 - 03:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('7',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(7,'{{$day}}')" type="checkbox"  @if(in_array("7",$timings[$day])) checked @endif /> 06:00 - 07:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('11',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(11,'{{$day}}')" type="checkbox"  @if(in_array("11",$timings[$day])) checked @endif /> 10:00 - 11:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('15',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(15,'{{$day}}')" type="checkbox"  @if(in_array("15",$timings[$day])) checked @endif /> 14:00 - 15:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('19',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(19,'{{$day}}')" type="checkbox"  @if(in_array("19",$timings[$day])) checked @endif /> 18:00 - 19:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('23',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(23,'{{$day}}')" type="checkbox"  @if(in_array("23",$timings[$day])) checked @endif /> 22:00 - 23:00 
								</td>
							</tr>	
							<tr>								
								<td class="text-left h6 py-0 @if(in_array('4',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(4,'{{$day}}')" type="checkbox"  @if(in_array("4",$timings[$day])) checked @endif /> 03:00 - 04:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('8',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(8,'{{$day}}')" type="checkbox"  @if(in_array("8",$timings[$day])) checked @endif /> 07:00 - 08:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('12',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(12,'{{$day}}')" type="checkbox"  @if(in_array("12",$timings[$day])) checked @endif /> 11:00 - 12:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('16',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(16,'{{$day}}')" type="checkbox"  @if(in_array("16",$timings[$day])) checked @endif /> 15:00 - 16:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('20',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(20,'{{$day}}')" type="checkbox"  @if(in_array("20",$timings[$day])) checked @endif /> 19:00 - 20:00 
								</td>
								<td class="text-left h6 py-0 @if(in_array('24',$duals[$day])) table-success @endif" style="font-size:0.8em;">
									<input onClick="updateTime(24,'{{$day}}')" type="checkbox"  @if(in_array("24",$timings[$day])) checked @endif /> 23:00 - 00:00 
								</td>
							</tr>	
							<tr><td colspan="7" class="py-1"></td></tr>								
						@endforeach
    					</table>		
    					<p class="small text-primary text-right px-5">Your dual's online coverage is highlighted in green</p>		
    				</div>			
    			</div>    			    			     		
			</div>			
		</div>
@endsection

@push('scripts')	
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('js/moment-timezone-with-data-2012-2022.min.js') }}"></script> 
    <script>
    	$(function(){                
            	setInterval(function(){
                	var timezone = $("#zone").val();
                	var now = moment().tz(timezone);
              		//var now = moment().tz("{{$timezone}}");
             		$('#clock').html(now.format("{{Session::get('dateFormatLong')}}"));
            	},1000);
    		});
	</script>
	<script>
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});  
	$(document).on('change','#zone',function(e){
		e.preventDefault();
		var zone = $(this).val();		
		$.ajax({
            type:'POST',
            url:'{{route("accountTimings")}}/update',
            data:{  zone:zone	},
            success:function(data){					
         	   	alert(data.success)
         	    //location.reload();
            }
         });	
	});

	function updateTime(time,day)
	{
	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {
	            console.log(xmlhttp.responseText);
	        }
	    };
	    xmlhttp.open("GET", "/account/timings/update/"+day+"/"+time, true);
	    xmlhttp.send();
	};
	</script>
	
@endpush
