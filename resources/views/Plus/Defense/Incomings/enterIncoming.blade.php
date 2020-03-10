@extends('Plus.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
	<div class="card-header h4 py-2 bg-info text-white"><strong>Enter Incomings</strong></div>
@foreach(['danger','success','warning','info'] as $msg)
	@if(Session::has($msg))
    	<div class="alert alert-{{ $msg }} text-center my-1 mx-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>{{ Session::get($msg) }}
        </div>
    @endif
@endforeach
	<div class="card-text my-3">
		<div class="col-md-10 mx-auto rounded pt-2 mb-2" style="background-color:#dbeef4;">
			<form method="post" action="/plus/incoming">
				{{csrf_field()}}
    			<table>
    				<tr>
    					<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Incoming Details</strong></p></td>
    				</tr>
    				<tr>
    					<td class="align-middle px-2">
    						<form>								
    							<textarea rows="3" cols="40" name="incStr" required></textarea>
    							<p class="text-center"><button class="btn btn-primary" type="submit">Enter Incomings</button></p>
    						</form>
    					</td>
    					<td class="align-top px-2 font-italic">
    						<p>Enter the incoming attacks details from rally point here <strong><a href="https://{{Session::get('server.url')}}/build.php?gid=16&tt=1&filter=1&subfilters=1" target="_blank">Link</a></strong></p>
    					</td>
    				</tr>			
    			</table>
			</form>
		</div>   			    			
	</div>
			
	<div class="col-md-12 mt-2 mx-auto text-center">
	@if((count($owaves) + count($swaves))==0)			
		<p class="text-center h5 py-5"> No incoming attacks saved for this profile</p>			
	@else	
		@if(count($owaves)>0)		
    		<table class="table mx-auto col-md-11 table-hover table-sm table-bordered">
    			<thead class="thead-inverse">
    				<tr>
    					<td class="h4 text-dark py-2 my-0 bg-warning" colspan="7"><strong>Your Incomings</strong></td>
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
    						
        			<tr class="{{$color}} h6">
        				<td><strong><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> ({{$wave->att_village}})</strong></td>
        				<td><strong>{{$wave->def_village}}</strong></td>    				
        				<td>{{$wave->landTime}}</td>
        				<td>{{$wave->waves}}</td>
        				<td><strong><span id="{{$wave->incid}}"></span></strong></td>
        				<td>@if($wave->ldr_sts == 'ARTEFACT')
        						Save Artefact
    						@else
        						{{ucfirst(strtolower($wave->ldr_sts))}}
        					@endif
    					</td>
        				<td><button class="btn btn-info btn-sm" id="details" name="button" value="" type="submit"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></td>
        			</tr>
        			<tr style="display: none;background-color:#dbeef4" class="text-center">
        				<form action="/plus/incoming/update" method="post">
							{{csrf_field()}}
            				<td colspan="3">
            					<p><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$wave->att_uid}}" target="_blank"><strong>Attacker Account Information <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p><textarea rows="3" cols="25" name="account"></textarea></p>
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
    					<td class="h4 py-2 my-0 bg-info text-white" colspan="7"><strong>Your Sitter Incomings</strong></td>
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
    						
        			<tr class="{{$color}} h6">
        				<td><strong><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> ({{$wave->att_village}})</strong></td>
        				<td><strong>{{$wave->def_village}}</strong></td>    				
        				<td>{{$wave->landTime}}</td>
        				<td>{{$wave->waves}}</td>
        				<td><strong><span id="{{$wave->incid}}"></span></strong></td>
        				<td>@if($wave->ldr_sts == 'ARTEFACT')
        						Save Artefact
    						@else
        						{{ucfirst(strtolower($wave->ldr_sts))}}
        					@endif
        				</td>
        				<td><button class="btn btn-info btn-sm" id="details" name="button" value="" type="submit"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></td>
        			</tr>
        			<tr style="display: none;background-color:#dbeef4" class="text-center">
        				<form action="/plus/incoming/update" method="post">
							{{csrf_field()}}
            				<td colspan="3">
            					<p><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$wave->att_uid}}" target="_blank"><strong>Attacker Account Information <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p><textarea rows="3" cols="25" name="account"></textarea></p>
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
@endpush