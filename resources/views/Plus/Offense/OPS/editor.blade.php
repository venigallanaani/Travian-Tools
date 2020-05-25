@extends('Layouts.offense')

@section('content')        
        
    <!-- ============================================ home page body starts here ============================================ -->
    <div class="mx-auto mt-1">
    	<div class="rounded">
    		<table class="table table-bordered" style="position:sticky;top:0;">
    			<tr class="">
    				<td class="text-center" style="width:18em">
    					<form action="/offense/plan/additem" method="POST">
							{{csrf_field()}} 					
        					<div class="item rounded table-danger py-1 my-1 h6">
        						<p class="px-0 font-italic">Add Attacker</p>
        						<p class="px-0">X:<input type="number" name="x" required style="width:5em"> | Y:<input type="number" name="y" required style="width:5em"></p>
        						<button class="btn btn-info" type="submit" name="attack" value="{{$plan->id}}">Add Attacker</button>        					
        					</div>
    					</form>
    					<form action="/offense/plan/additem" method="POST">
							{{csrf_field()}}
        					<div class="item rounded table-success py-1 my-1 h6">
        						<p class="px-0 font-italic">Add Target</p>
        						<p class="px-0">X:<input type="number" name="x" required style="width:5em"> | Y:<input type="number" name="y" required style="width:5em"></p>
        						<button class="btn btn-info" type="submit" name="target" value="{{$plan->id}}">Add Target</button>
        					</div> 
    					</form>
    				</td>
    				
    				<td class="">
    					<div class="rounded table-info p-2 small" style="height:20em; overflow-y:auto;" id="attackers">
    						<p class="text-center h5 pb-1">Attackers List</p>
					@if($attackers!==null)
						@foreach($attackers as $attacker)
							<div id="{{$attacker['item_id']}}" rel="{{$attacker['item_id']}}" class="attacker d-inline m-1 p-1 bg-white rounded float-left font-weight-bold">
    							<span id="name" class="">
									<a class="text-dark" href="{{route('findAlliance')}}/{{$attacker['alliance']}}/1" target="_blank">[{{$attacker['alliance']}}]</a> 
    								<a class="text-danger" href="{{route('findPlayer')}}/{{$attacker['player']}}/1" target="_blank">{{$attacker['player']}}</a> 
    								<a href="https://{{Session::get('server.url')}}/position_details.php?x={{$attacker['x']}}&y={{$attacker['y']}}" target="_blank">({{$attacker['village']}}) ({{$attacker['x']}}|{{$attacker['y']}})</a> - 
    								<span id="real" class="text-danger">{{$attacker['real']}}</span> | <span id="fake" class="text-primary">{{$attacker['fake']}}</span> | <span id="other" class="">{{$attacker['other']}}</span>
    							</span> 
    							<button class="delitem badge badge-danger" value="{{$attacker['item_id']}}" id="attacker"><i class="far fa-trash-alt"></i></button>
							</div>
						@endforeach
					@endif    					
						</div>		
    				</td>
    			</tr>
    		</table>
    	</div>
    	
    	<div id="loading" class="text-center h5 table-warning col-md-5 mx-auto py-3 rounded" style="display:none">
    		<span><i class="fas fa-spinner fa-spin"></i> Loading....please wait</span>
    	</div>
    	
    	<div class="mx-auto px-0">
		@if($targets==null)
			<p class="py-3 h5 text-center">No targets are added to the Offense plan</p>
		@else			
			@foreach($targets as $target)
				<div class="target card float-left d-inline mx-2 my-1" style="width:25em;font-size: 0.85em" id="{{$target['item_id']}}">
					<p class="card-header font-weight-bold py-1" style="font-size: 0.9em">
						<a class="text-dark" href="{{route('findAlliance')}}/{{$target['alliance']}}/1" target="_blank">[{{$target['alliance']}}]</a> 
						<a class="text-success" href="{{route('findPlayer')}}/{{$target['player']}}/1" target="_blank">{{$target['player']}}</a> 
						<a href="https://{{Session::get('server.url')}}/position_details.php?x={{$target['x']}}&y={{$target['y']}}" target="_blank">({{$target['village']}}) ({{$target['x']}}|{{$target['y']}})</a> - 
						<span class="text-danger" id="real">{{$target['real']}}</span> | 
						<span class="text-primary" id="fake">{{$target['fake']}}</span> | 
						<span class="" id="other">{{$target['other']}}</span>
						<button class="delitem badge badge-danger" value="{{$target['item_id']}}" id="target"><i class="far fa-trash-alt"></i></button>					
					</p>
					<div id="workspace" class="card-body p-1 m-0" style="height:15em; overflow-y:auto; background-color:#dbeef4">
				@if($target['WAVES']!==null)
					@foreach($target['WAVES'] as $wave)
    					<div>
            				<div class="display mx-auto text-center rounded small my-0" id="{{$wave['a_id']}}"
            					@if($wave['status']=='NEW') style="background-color: #eaf818;"	@else style="background-color:white;" @endif>
        						<table class="table table-bordered my-1">
        							<tr>
        								<td class="py-0 h6">{{$wave['a_player']}} ({{$wave['a_village']}})</td>
        								<td class="py-0" id="waves" style="font-weight: bold">{{$wave['waves']}}</td>
										<td class="px-0 py-0" data-toggle="tooltip" data-placement="top" title="{{$units[$wave['a_tribe']][$wave['unit']]}}">
											<img alt="" src="/images/x.gif" class="units {{$wave['unit']}}"></td>
        								<td class="py-0 px-0"><button class="badge badge-primary editwave" id="" value={{$wave['id']}}><i class="far fa-edit"></i></button></td>
        							</tr>
        							<tr>								
        								<td class="py-0" colspan="2" id="landTime">{{$wave['landtime']}}</td>
        								<td class="py-0">
        									<strong>
        									@if($wave['type']=="REAL")<span id="type" style="color:red">{{ucfirst(strtolower($wave['type']))}}</span>
        									@elseif($wave['type']=="FAKE")<span id="type" style="color:blue">{{ucfirst(strtolower($wave['type']))}}</span>
        									@else<span id="type">{{ucfirst(strtolower($wave['type']))}}</span>@endif        									
        									</strong>										
        								</td>
        								<td class="py-0 px-0"><button class="badge badge-danger delwave" id="delwave" value={{$wave['id']}}><i class="far fa-trash-alt"></i></button></td>
        							</tr>
        						</table>
        					</div>
        					<div class="entry mx-auto text-center rounded small" style="background-color:white; display:none;">
        						<form autocomplete="off">
            						<table class="table table-bordered">
            							<tr>
            								<td class="py-0 h6">{{$wave['a_player']}} ({{$wave['a_village']}})</td>
            								<td class="py-0 px-0"><input type="number" id="waves" min=1 value={{$wave['waves']}} name="waves" style="width:2em; border:1px"></td>
            								<td class="py-0">
            									<select id="unit" name="unit" style="width:5em; border:1px">
            								@if($wave['a_tribe']=='ROMAN')            									
            										<option value="r01" @if($wave['unit']=="r01") selected @endif>Legionnaire</option>   			
            										<option value="r02" @if($wave['unit']=="r02") selected @endif>Praetorian</option>
            										<option value="r03" @if($wave['unit']=="r03") selected @endif>Imperian</option>   			
            										<option value="r04" @if($wave['unit']=="r04") selected @endif>Equites Legati</option>
        											<option value="r05" @if($wave['unit']=="r05") selected @endif>Equites Imperatoris</option>   	
        											<option value="r06" @if($wave['unit']=="r06") selected @endif>Equites Caesaris</option>
            										<option value="r07" @if($wave['unit']=="r07") selected @endif>Battering Ram</option>   		
            										<option value="r08" @if($wave['unit']=="r08") selected @endif>Fire Catapult</option>
            										<option value="r09" @if($wave['unit']=="r09") selected @endif>Senator</option>   				
            										<option value="r10" @if($wave['unit']=="r10") selected @endif>Settler</option>
        									@elseif($wave['a_tribe']=='GAUL')
            										<option value="g01" @if($wave['unit']=="g01") selected @endif>Phalanx</option>   		
            										<option value="g02" @if($wave['unit']=="g02") selected @endif>Swordsman</option>
            										<option value="g03" @if($wave['unit']=="g03") selected @endif>Pathfinder</option>   	
            										<option value="g04" @if($wave['unit']=="g04") selected @endif>Theutates Thunder</option>
            										<option value="g05" @if($wave['unit']=="g05") selected @endif>Druidrider</option>   	
            										<option value="g06" @if($wave['unit']=="g06") selected @endif>Haeduan</option>
            										<option value="g07" @if($wave['unit']=="g07") selected @endif>Ram</option>   			
            										<option value="g08" @if($wave['unit']=="g08") selected @endif>Trebuchet</option>
    												<option value="g09" @if($wave['unit']=="g09") selected @endif>Chieftain</option>   	
    												<option value="g10" @if($wave['unit']=="g10") selected @endif>Settler</option>
        									@elseif($wave['a_tribe']=='TEUTON')
            										<option value="t01" @if($wave['unit']=="t01") selected @endif>Maceman</option>   		
            										<option value="t02" @if($wave['unit']=="t02") selected @endif>Spearman</option>
            										<option value="t03" @if($wave['unit']=="t03") selected @endif>Axeman</option>   		
            										<option value="t04" @if($wave['unit']=="t04") selected @endif>Scout</option>
            										<option value="t05" @if($wave['unit']=="t05") selected @endif>Paladin</option>   		
            										<option value="t06" @if($wave['unit']=="t06") selected @endif>Teutonic Knight</option>
            										<option value="t07" @if($wave['unit']=="t07") selected @endif>Ram</option>   			
            										<option value="t08" @if($wave['unit']=="t08") selected @endif>Catapult</option>
            										<option value="t09" @if($wave['unit']=="t09") selected @endif>Chief</option>   		
            										<option value="t10" @if($wave['unit']=="t10") selected @endif>Settler</option>
        									@elseif($wave['a_tribe']=='HUN')
            										<option value="h01" @if($wave['unit']=="h01") selected @endif>Mercenary</option>   	
            										<option value="h02" @if($wave['unit']=="h02") selected @endif>Bowman</option>
            										<option value="h03" @if($wave['unit']=="h03") selected @endif>Spotter</option>   		
            										<option value="h04" @if($wave['unit']=="h04") selected @endif>Steppe Rider</option>
            										<option value="h05" @if($wave['unit']=="h05") selected @endif>Marksman</option>   	
            										<option value="h06" @if($wave['unit']=="h06") selected @endif>Marauder</option>
        											<option value="h07" @if($wave['unit']=="h07") selected @endif>Ram</option>   			
        											<option value="h08" @if($wave['unit']=="h08") selected @endif>Catapult</option>
            										<option value="h09" @if($wave['unit']=="h09") selected @endif>Logades</option>   		
            										<option value="h10" @if($wave['unit']=="h10") selected @endif>Settler</option>
        									@elseif($wave['a_tribe']=='EGYPTIAN')
            										<option value="e01" @if($wave['unit']=="e01") selected @endif>Slave Militia</option>   	
            										<option value="e02" @if($wave['unit']=="e02") selected @endif>Ash Warden</option>
            										<option value="e03" @if($wave['unit']=="e03") selected @endif>Khopesh Warrior</option>   	
            										<option value="e04" @if($wave['unit']=="e04") selected @endif>Sopdu Explorer</option>
            										<option value="e05" @if($wave['unit']=="e05") selected @endif>Anhur Guard</option>   		
            										<option value="e06" @if($wave['unit']=="e06") selected @endif>Resheph Chariot</option>
            										<option value="e07" @if($wave['unit']=="e07") selected @endif>Ram</option>   				
            										<option value="e08" @if($wave['unit']=="e08") selected @endif>Stone Catapult</option>
            										<option value="e09" @if($wave['unit']=="e09") selected @endif>Nomarch</option>   			
            										<option value="e10" @if($wave['unit']=="e10") selected @endif>Settler</option>
            								@endif    								
            								</td>        								
            							</tr>
            							<tr>								
            								<td class="py-0" colspan="2"><strong>Land Time: </strong><input required id="landTime" style="width:10em;" name="landTime" value="{{$wave['landtime']}}" class="dateTimePicker"></td>
            								<td class="py-0">
            									<select id="type" name="type" style="width:4em; border:1px">
            										<option value="REAL" @if($wave['type']=="REAL") selected @endif>Real</option>
            										<option value="FAKE" @if($wave['type']=="FAKE") selected @endif>Fake</option>
            										<option value="CHIEF" @if($wave['type']=="CHIEF") selected @endif>Chief</option>
            										<option value="GHOST" @if($wave['type']=="GHOST") selected @endif>Ghost</option>
            										<option value="SCOUT" @if($wave['type']=="SCOUT") selected @endif>Scout</option>
            										<option value="OTHER">Other</option>
            									</select>
            								</td>    								
            							</tr>
            							<tr class="">
            								<td class="py-0 px-3 text-left" colspan="2"><strong>Notes: </strong><input id="notes" type="text" name="notes" style="width:15em;" @if(strlen(trim($wave['notes']))>0) value="{{$wave['notes']}}" @endif></td>
            								<td class="py-0 px-0"><button class="badge badge-success savewave" type="submit" id="savewave" value={{$wave['id']}}><i class="fas fa-save"></i></button></td>
            							</tr>
            						</table>
        						</form>
        					</div>
        				</div>
					@endforeach
				@endif					
					</div>
				</div>       		
    		@endforeach
		@endif    		 		  		
    	</div>
    </div>  
	<div class="container text-right small mb-5" style="clear:left">
		<p class="text-primary font-italic">Offense Planner created by Chandra</p>
	</div>
	  
@endsection

@push('scripts')
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<meta name="planId" content="{{$plan->id}}" />
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
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush