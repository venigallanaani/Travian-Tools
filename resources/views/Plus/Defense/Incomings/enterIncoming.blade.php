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
    	<div class="my-2">
    		@if(count($drafts)>0)
    		<p class="h4 text-center mx-2 text-dark py-2 my-0 bg-info"><strong>Newly Uploaded Incomings</strong></p>
    		@endif
    		@foreach($drafts as $draft)		
    		<form class="border border-info p-0 my-1 col-md-11 mx-auto" action="/plus/incoming/update" method="post">
    			{{csrf_field()}}
    			<table class="table table-borderless p-0 m-0 text-center table-sm">
    				<tr>
    					<td class="p-1 m-0 text-danger"><strong>Attacker <a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$draft->att_uid}}" target="_blank"><i class="fas fa-external-link-alt"></i></a></strong></td>
    					<td class="p-1 m-0">
    						<select	name="right">
    							<option value="">--Select Right hand--</option>
    							<option value="">T1 weapon</option>
    							<option value="">T2 weapon</option>
    							<option value="">T3 weapon</option>
    						</select>
    						<select name="left">
    							<option value="">--Select Left hand--</option>
    							<option value="">T1 sheild</option>
    							<option value="">T2 sheild</option>
    							<option value="">T3 sheild</option>
    						</select>
    						<a href="http://travian.kirilloid.ru/items.php" target="_blank"><strong>Hero Equipment <i class="fas fa-external-link-alt"></i></strong></a>
    					</td>
    					<td class="p-1 m-0"><strong>Waves: </strong>{{$draft->waves}}</td>
    				</tr>    
    				<tr>
    					<td class="p-1 m-0"><strong><a href="{{route('findPlayer')}}/{{$draft->att_player}}/1" target="_blank">{{$draft->att_player}}</a> ({{$draft->att_village}})</strong></td>
    					<td class="p-1 m-0">
    						<select name="helm">
    							<option value="">--Select Helm--</option>
    							<option value="">T1 helm</option>
    							<option value="">T2 helm</option>
    							<option value="">T3 helm</option>
    						</select>
    						<select name="chest">
    							<option value="">--Select Chest--</option>
    							<option value="">T1 Chest</option>
    							<option value="">T2 Chest</option>
    							<option value="">T3 Chest</option>
    						</select>
    						<select	name="boot">
    							<option value="">--Select Boots--</option>
    							<option value="">T1 Boots</option>
    							<option value="">T2 Boots</option>
    							<option value="">T3 Boots</option>
    						</select>
    					</td>
    					<td class="p-1 m-0"><strong>Land Time</strong></td>
    				</tr> 
    				<tr>
    					<td class="p-1 m-0 text-success"><strong>Defender <a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$draft->def_uid}}" target="_blank"><i class="fas fa-external-link-alt"></i></a></strong></td>	    					
    					<td class="p-1 m-0" rowspan="2">
								<strong>Attacker Account: </strong><textarea rows="2" cols="40" name="accData"></textarea>    						

    					</td>
    					<td class="p-1 m-0">{{$draft->landTime}}</td>
    				</tr> 
    				<tr>    					
    					<td class="p-1 m-0"><strong><a href="{{route('findPlayer')}}/{{$draft->def_player}}/1" target="_blank">{{$draft->def_player}}</a> ({{$draft->def_village}})</strong></td>

    					<td class="p-1 m-0"><button class="btn btn-primary py-1 px-5" type="submit" name="incId" value="{{$draft->incid}}">Save</button></td>
    				</tr> 		    			
    			</table>
    		</form> 
    		@endforeach
		</div>   			    			
	</div>
			
	<div class="col-md-12 mt-2 mx-auto text-center">
	@if((count($owaves) + count($swaves))==0)			
		<p class="text-center h5 py-5"> No incoming attacks saved for this profile</p>			
	@else	
		@if(count($owaves)>0)
		<p class="h4 text-dark py-2 my-0 bg-warning"><strong>Your Incomings</strong></p>		
		<table class="table mx-auto col-md-11 table-hover table-sm">
			<thead class="thead-inverse">
				<tr>
					<th class="">Attacker</th>
					<th class="">Target</th>
					<th class="">Waves</th>
					<th class="">Land Time</th>
					<th class="">Timer</th>
					<th class="">Action</th>
					<th></th>
				</tr>
			</thead>
			@foreach($owaves as $wave)
				@php
					if($wave->ldr_sts=='Attack'){ $color = 'table-danger';	}
					elseif($wave->ldr_sts=='Fake'){$color='table-primary';}
					elseif($wave->ldr_sts=='Thinking'){$color='table-warning';}					
					else{$color='table-white';}					
				@endphp				
						
    			<tr class="{{$color}} small">
    				<td><strong><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> ({{$wave->att_village}})</strong></td>
    				<td><strong>{{$wave->def_village}}</strong></td>
    				<td>{{$wave->waves}}</td>
    				<td>{{$wave->landTime}}</td>
    				<td><strong><span id="{{$wave->incid}}"></span></strong></td>
    				<td>{{$wave->ldr_sts}}</td>
    				<td><button class="badge badge-primary" type="button" id="update">Submit</button>
    			</tr>
			@endforeach			
		</table>
		@endif
		
		@if(count($swaves)>0)
		<div class="my-3">	
			<p class="h4 text-dark py-2 my-0 bg-info"><strong>Your Sitter Incomings</strong></p>			
    		<table class="table mx-auto col-md-11 table-hover table-sm">
    			<thead class="thead-inverse">
    				<tr>
    					<th class="">Attacker</th>
    					<th class="">Target</th>
    					<th class="">Waves</th>
    					<th class="">Land Time</th>
    					<th class="">Timer</th>
    					<th class="">Action</th>
    					<th></th>
    				</tr>
    			</thead>
    			@foreach($swaves as $wave)
    				@php
    					if($wave->ldr_sts=='Attack'){ $color = 'table-danger';	}
    					elseif($wave->ldr_sts=='Fake'){$color='table-primary';}
    					elseif($wave->ldr_sts=='Thinking'){$color='table-warning';}					
    					else{$color='table-white';}					
    				@endphp				
    						
        			<tr class="{{$color}} small">
        				<td><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> ({{$wave->att_village}})</td>
        				<td>{{$wave->def_village}}</td>
        				<td>{{$wave->waves}}</td>
        				<td>{{$wave->landTime}}</td>
        				<td><strong><span id="{{$wave->incid}}"></span></strong></td>
        				<td>{{$wave->ldr_sts}}</td>
        				<td><button class="badge badge-primary" type="button" id="update">submit</button>
        			</tr>
    			@endforeach			
    		</table>
		</div>
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
@endpush