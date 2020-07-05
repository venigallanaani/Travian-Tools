@extends('Plus.template')

@section('body')
<div class="card float-md-left col-md-10 mb-5 p-0 shadow">
	<div class="card-header h5 py-2 bg-info text-white"><strong>Enter Incomings</strong></div>
@foreach(['danger','success','warning','info'] as $msg)
	@if(Session::has($msg))
    	<div class="alert alert-{{ $msg }} text-center my-1 mx-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>{{ Session::get($msg) }}
        </div>
    @endif
@endforeach
	<div class="my-2 mx-5">
		<div class="card card-header text-center h6 btn btn-block collapsed bg-info shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
    		<p class="p-0 m-0 text-white">
        		<i class="fa fa-plus"></i> <span class=""><strong>Enter Incomings Manually</strong></span>
		 	</p>
		</div>
		<div class="collapse" id="task" style="font-size:0.9em">
  			<div class="card card-body shadow">
				<form action="/plus/incoming" method="POST" class="text-center" autocomplete="off">
					{{ csrf_field() }}
					<table class="col-md-10 mx-auto table table-bordered">
						<tr class="h6">
							<td class="table-success">Your Details</td>
							<td class="table-danger">Attacker Information</td>
						</tr>
						<tr>
							<td class="align-middle">
								<p class="h6 pb-0">
									<select name="village" style="width:10em; font-size:0.9em">
										<option value="">--Select Village--</option>
									@foreach($villages as $village)
										<option value="{{$village['vid']}}">{{$village['village']}}</option>
									@endforeach
									</select>
								</p>
								<p class="py-0 h6" style="font-size:0.9em"><input type="text" name="form" value="true" hidden>or</p>
								<p class="h6 pt-0">X: <input type="number" style="width:4em" name="t_x"> | Y: <input type="number" style="width:4em" name="t_y"></p>
								<p class="h6 py-1">Waves: <input type="number" style="width:3em" name="waves" min=1 value=1></p>
							</td>
							<td class="align-middle">
								<p class="h6">X: <input type="number" style="width:4em" name="a_x" required> | Y: <input type="number" style="width:4em" name="a_y" required></p>
								<p class="h6">Land Time: <input type="text" name="targetTime" size="20" class="dateTimePicker"></p>
								<p class="h6">Comments: <textarea rows="3" cols="20" name="comments"></textarea></p>
							</td>
						</tr>
					</table>					
					<p class="my-1 h6">
						<button class="btn btn-info px-4"><strong>Enter Incomings</strong></button>
					</p> 						
				</form>
  			</div>
		</div>	
	</div>
        		
	<div class="card-text my-3">
		<div class="col-md-10 mx-auto rounded pt-2 mb-2" style="background-color:#dbeef4;">
			<form method="post" action="/plus/incoming">
				{{csrf_field()}}
    			<table class="table table-borderless">
    				<tr>
    					<td colspan="2" class="py-1"><p class="h5 text-primary text-center"><strong>Input Incoming Details</strong></p></td>
    				</tr>
    				<tr>
    					<td colspan="2" class="py-1 font-italic"><p class="h6 text-center">Enter the incoming attacks details from rally point here <strong><a href="https://{{Session::get('server.url')}}/build.php?gid=16&tt=1&filter=1&subfilters=1" target="_blank">Link</a></strong></p></td>
    				</tr>
    				<tr>
    					<td class="align-middle px-2 py-1">    						    						
							<textarea rows="3" cols="40" name="incStr" required></textarea>							
    					</td>
    					<td class="align-top px-2">
    						<span class="h6"><input type="text" name="form" value="false" hidden></span>
    						<p class="h6"><input type="checkbox" name="scout"> Active Scout Artifact</p>
    						<p class=""><button class="btn btn-primary" type="submit">Enter Incomings</button></p>
    					</td>
    				</tr>			
    			</table>
			</form>
		</div>   			    			
	</div>
			
	<div class="col-md-12 mt-2 mx-auto text-center">
	@if((count($owaves) + count($swaves))==0)			
		<p class="text-center h6 py-3"> No incoming attacks saved for this profile</p>			
	@else	
		@if(count($owaves)>0)		
    		<table class="table mx-auto col-md-11 table-hover table-sm table-bordered">
    			<thead class="thead-inverse">
    				<tr>
    					<td class="h5 text-dark py-2 my-0 bg-warning" colspan="7"><strong>Your Incomings</strong></td>
    				</tr>
    				<tr>
    					<th class="h6">Attacker</th>
    					<th class="h6">Target</th>					
    					<th class="h6">Land Time</th>
    					<th class="h6">Waves</th>
    					<th class="h6">Timer</th>
    					<th class="h6">Action</th>
    					<th></th>
    				</tr>
    			</thead>
    			@foreach($owaves as $wave)
    				@php
    					if		($wave->ldr_sts=='SCOUT')		{$color='table-warning';	}
    					elseif	($wave->ldr_sts=='THINKING')	{$color='table-info';		}
    					elseif	($wave->ldr_sts=='DEFEND')		{$color='table-success';	}	
    					elseif	($wave->ldr_sts=='ARTEFACT')	{$color='table-primary';	}	
    					elseif	($wave->ldr_sts=='SNIPE')		{$color='table-danger';		}
    					elseif	($wave->ldr_sts=='FAKE')		{$color='table-secondary';	}								
    					else	{	$color='table-white';	}					
					@endphp				
    						
        			<tr class="{{$color}}" style="font-size: 0.9em">
        				<td class=""><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> ({{$wave->att_village}})</td>
        				<td class="">{{$wave->def_village}}</td>    				
        				<td>{{$wave->landTime}}</td>
        				<td>{{$wave->waves}}</td>
        				<td class=""><span id="{{$wave->incid}}"></span></td>
        				<td>@if($wave->ldr_sts == 'ARTEFACT')
        						Save Artefact
    						@else
        						{{ucfirst(strtolower($wave->ldr_sts))}}
        					@endif
    					</td>
        				<td><button class="badge badge-info" id="details" name="button" value="" type="submit"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></td>
        			</tr>
        			<tr style="display: none;background-color:#dbeef4" class="text-center">
        				<form action="/plus/incoming/update" method="post">
							{{csrf_field()}}
            				<td colspan="3">
            					<p><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$wave->att_uid}}" target="_blank"><strong>Attacker Account Information <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p class="py-0"><textarea rows="3" cols="25" name="account"></textarea></p>
            					<p class="small py-0 text-danger">Enter source code of the account page</p>
            				</td>
            				<td colspan="4" class="py-2">
        						<p class="">
        							<strong>Notes : </strong><textarea rows="3" cols="25" name="comments">{{$wave->comments}}</textarea>
        						</p>
            					<p><button class="btn btn-sm btn-primary px-3" name="wave" value="{{$wave->incid}}" type="submit">UPDATE</button></p>
            				</td>
        				</form>
        			</tr>
    			@endforeach			
    		</table>		
		@endif
		
		@if(count($swaves)>0)
			@if(count($owaves)>0)		
    		<table class="table mx-auto col-md-11 table-hover table-sm table-bordered">
    			<thead class="thead-inverse">
    				<tr>
    					<td class="h5 py-2 my-0 bg-info text-white" colspan="7"><strong>Your Sitter Incomings</strong></td>
    				</tr>
    				<tr>
    					<th class="">Attacker</th>
    					<th class="">Target</th>					
    					<th class="">Land Time</th>
    					<th class="">Waves</th>
    					<th class="">Timer</th>
    					<th class="">Action</th>
    					<th></th>
    				</tr>
    			</thead>
    			@foreach($swaves as $wave)
    				@php
    					if		($wave->ldr_sts=='SCOUT')		{$color='table-warning';	}
    					elseif	($wave->ldr_sts=='THINKING')	{$color='table-info';		}
    					elseif	($wave->ldr_sts=='DEFEND')		{$color='table-success';	}	
    					elseif	($wave->ldr_sts=='ARTEFACT')	{$color='table-primary';	}	
    					elseif	($wave->ldr_sts=='SNIPE')		{$color='table-danger';		}
    					elseif	($wave->ldr_sts=='FAKE')		{$color='table-secondary';	}								
    					else	{	$color='table-white';	}				
    				@endphp				
    						
        			<tr class="{{$color}}" style="font-size:0.8em">
        				<td class="h6"><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> <a href="https://{{Session::get('server.url')}}/position_details.php?" target="_blank">({{$wave->att_village}})</a></td>
        				<td class="h6">{{$wave->def_village}}</td>    				
        				<td>{{$wave->landTime}}</td>
        				<td>{{$wave->waves}}</td>
        				<td class="h6"><span id="{{$wave->incid}}"></span></td>
        				<td>@if($wave->ldr_sts == 'ARTEFACT')
        						Save Artefact
    						@else
        						{{ucfirst(strtolower($wave->ldr_sts))}}
        					@endif
        				</td>
        				<td><button class="btn btn-info btn-sm" id="details" name="button" value="" type="submit"><i class="fas fa-angle-double-down px-1"></i></button></td>
        			</tr>
        			<tr style="display: none;background-color:#dbeef4" class="text-center">
        				<form action="/plus/incoming/update" method="post">
							{{csrf_field()}}
            				<td colspan="3">
            					<p><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$wave->att_uid}}" target="_blank"><strong>Attacker Account Information <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p class="py-0"><textarea rows="3" cols="25" name="account"></textarea></p>
            					<p class="small py-0 text-danger">Enter source code of the account page</p>
            				</td>
            				<td colspan="4" class="py-2">
        						<p class="">
        							<strong>Notes : </strong><textarea rows="3" cols="25" name="comments">{{$wave->comments}}</textarea>
        						</p>
            					<p><button class="btn btn-sm btn-primary px-3" name="wave" value="{{$wave->incid}}" type="submit">UPDATE</button></p>
            				</td>
        				</form>
        			</tr>
    			@endforeach			
    		</table>		
		@endif
		@endif
	@endif			
	</div>
</div>
@endsection

@push('scripts')
	@if(count($swaves)>0)	
	<script>
		@foreach($swaves as $wave)
			countDown("{{$wave->incid}}","{{$wave->landTime}}","{{Session::get('timezone')}}");
		@endforeach
	</script>
	@endif
	@if(count($owaves)>0)	
	<script>
		@foreach($owaves as $wave)
			countDown("{{$wave->incid}}","{{$wave->landTime}}","{{Session::get('timezone')}}");
		@endforeach
	</script>
	@endif
	
	<script>
    $(document).on('click','#details',function(e){
        e.preventDefault();  
    
        var col= $(this).closest("td");
        var id= col.find('#details').val();

		var row = $(this).closest('tr').next('tr');
		row.toggle('500');
    
    });

</script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript">
    $(".dateTimePicker").datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss",
        showSecond:true
    });
</script> 
@endpush
@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
	<meta name="timezone" content="{{ Session::get('timezone') }}" />
@endpush