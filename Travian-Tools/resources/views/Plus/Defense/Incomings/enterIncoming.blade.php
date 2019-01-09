@extends('Plus.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
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
    							<p><textarea rows="3" cols="40" name="incStr" required></textarea>
    							<p class="text-center"><button class="btn btn-primary" type="submit">Enter Incomings</button></p>
    						</form>
    					</td>
    					<td class="align-top px-2 small font-italic">
    						<p>Enter the Rally point page data here</p>
    					</td>
    				</tr>			
    			</table>
			</form>
		</div>
    	<div class="my-2">
    		@foreach($drafts as $draft)		
    		<form class="border border-info p-0 my-1 col-md-11 mx-auto" action="/plus/incoming/update" method="post">
    			{{csrf_field()}}
    			<table class="table table-borderless p-0 m-0 text-center">
    				<tr>
    					<td class="col-md-3 p-1 m-0 text-danger"><strong>Attacker</strong></td>
    					<td class="col-md-6 small p-1 m-0">
    						<a href="">Hero XP: </a><input name="hxp" type="text" size='5'/>
    						<a href="http://travian.kirilloid.ru/items.php" target="_blank"><strong> Hero Equipment Details <i class="fas fa-external-link-alt"></i></strong></a>
    					</td>
    					<td class="col-md-3 p-1 m-0 text-success"><strong>Defender</strong></td>
    				</tr>    
    				<tr>
    					<td class="col-md-3 small p-1 m-0"><a href=""><strong>{{$draft->att_player}} ({{$draft->att_village}})</strong></a></td>
    					<td class="col-md-6 small p-1 m-0">
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
    					<td class="col-md-3 small p-1 m-0"><a href=""><strong>{{$draft->def_player}} ({{$draft->def_village}})</strong></a></td>
    				</tr> 
    				<tr>
    					<td class="col-md-3 small p-1 m-0"><strong>Waves: </strong>{{$draft->waves}}</td>
    					<td class="col-md-6 small p-1 m-0">
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
    					</td>
    					<td class="col-md-3 small p-1 m-0"><strong>Land Time</strong></td>
    				</tr> 
    				<tr>
    					<td class="col-md-3 small p-1 m-0"></td>
    					<td class="col-md-6 small p-1 m-0">Comments: <input name="comments" type="text" size="30">
    						<button class="btn btn-primary py-0" type="submit" name="incId" value="{{$draft->incid}}">Enter</button>
    					</td>
    					<td class="col-md-3  small p-1 m-0">{{$draft->landTime}}</td>
    				</tr> 		    			
    			</table>
    		</form> 
    		@endforeach
		</div>   			    			
	</div>
			
	<div class="col-md-12 mt-2 mx-auto text-center">
		<p class="h4 text-dark py-2 my-0 bg-warning"><strong>Your Incomings</strong></p>
		@if(count($saves)==0)			
		<p class="h5 pb-5 pt-2"> No incoming attacks saved for this profile</p>			
		@else			
		<table class="table small mx-auto col-md-11 table-hover table-sm">
			<thead class="thead-inverse">
				<tr>
					<th class="col-md-1">Attacker</th>
					<th class="col-md-1">Defender</th>
					<th class="col-md-1">Waves</th>
					<th class="col-md-1">Land Time</th>
					<th class="col-md-1">Timer</th>
					<th class="col-md-1">Hero</th>
					<th class="col-md-1">Action</th>
				</tr>
			</thead>
			@foreach($saves as $save)
				@php
					if($save->ldr_sts=='Attack'){ $color = 'table-danger';	}
					elseif($save->ldr_sts=='Fake'){$color='table-primary';}
					elseif($save->ldr_sts=='Thinking'){$color='table-warning';}					
					else{$color='table-white';}					
				@endphp				
						
    			<tr class="{{$color}}">
    				<td><a href="/finder/player/{{$save->att_player}}/1"><strong>{{$save->att_player}} ({{$save->att_village}})</strong></a></td>
    				<td><a href="/finder/player/{{$save->def_player}}/1"><strong>{{$save->def_player}} ({{$save->def_village}})</strong></a></td>
    				<td>{{$save->waves}}</td>
    				<td>{{$save->landTime}}</td>
    				<td>11:00:00</td>
    				<td>{{$save->hero}}</td>
    				<td>{{$save->ldr_sts}}</td>
    			</tr>
			@endforeach			
		</table>
		@endif			
	</div>
</div>			

@endsection