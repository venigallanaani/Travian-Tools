@extends('Layouts.offense')

@section('content')        
        
    <!-- ============================================ home page body starts here ============================================ -->
    <div class="mx-auto mt-1">
    	<div id="loading" class="text-center h5 table-warning col-md-5 mx-auto py-3 rounded" style="display:none">
    		<span>Loading....please wait</span>
    	</div>
    	<div class="rounded">
    		<table class="table table-bordered">
    			<tr class="">
    				<td class="text-center" style="width:18em">
    					<form action="/offense/plan/additem" method="POST">
							{{csrf_field()}} 					
        					<div class="item rounded table-warning py-1 my-1 h6">
        						<p class="px-0 font-italic">Add Attacker</p>
        						<p class="px-0">X:<input type="number" name="x" required style="width:5em"> | Y:<input type="number" name="y" required style="width:5em"></p>
        						<button class="btn btn-info" type="submit" name="attack" value="{{$plan->id}}"">Add Attacker</button>        					
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
    					<div class="rounded table-info p-2 small" style="height:20em; overflow-y:auto;">
    						<p class="text-center h5 pb-1">Attackers List</p>
    						@if($attackers!==null)
    						@foreach($attackers as $attacker)
							<div id="attacker" class="attacker d-inline m-1 p-1 bg-white rounded float-left font-weight-bold">
    							<span id="name" class="">
									<a class="text-dark" href="{{route('findAlliance')}}/{{$attacker->alliance}}/1" target="_blank">[{{$attacker->alliance}}]</a> 
    								<a class="text-danger" href="{{route('findPlayer')}}/{{$attacker->player}}/1" target="_blank">{{$attacker->player}}</a> 
    								<a href="https://{{Session::get('server.url')}}/position_details.php?x={{$attacker->x}}&y={{$attacker->y}}" target="_blank">({{$attacker->village}}) ({{$attacker->x}}|{{$attacker->y}})</a> - 
    								<span class="text-danger">{{$attacker->real}}</span> | <span class="text-primary">{{$attacker->fake}}</span> | <span class="">{{$attacker->other}}</span>
    							</span> 
    							<button class="delitem badge badge-danger" value="{{$attacker->item_id}}" id="attacker"><i class="far fa-trash-alt"></i></button>
							</div>
    						@endforeach
    						@endif    					
						</div>		
    				</td>
    			</tr>
    		</table>
    	</div>
    	
    	<div class="mx-auto px-0">
		@if($targets==null)
			<p class="py-3 h5 text-center">No targets are added to the Offense plan</p>
		@else			
			@foreach($targets as $target)
				<div class="target card float-left d-inline mx-2 my-1" style="width:22em;">
					<p class="card-header h6 font-weight-bold py-1">
						<a class="text-dark" href="{{route('findAlliance')}}/{{$target['TARGET']->alliance}}/1" target="_blank">[{{$target['TARGET']->alliance}}]</a> 
						<a class="text-success" href="{{route('findPlayer')}}/{{$target['TARGET']->player}}/1" target="_blank">{{$target['TARGET']->player}}</a> 
						<a href="https://{{Session::get('server.url')}}/position_details.php?x={{$target['TARGET']->x}}&y={{$target['TARGET']->y}}" target="_blank">({{$target['TARGET']->village}}) ({{$target['TARGET']->x}}|{{$target['TARGET']->y}})</a> - 
						<span class="text-danger">{{$target['TARGET']->real}}</span> | <span class="text-primary">{{$target['TARGET']->fake}}</span> | <span class="">{{$target['TARGET']->other}}</span>
						<button class="delitem badge badge-danger" value="{{$target['TARGET']->item_id}}" id="target"><i class="far fa-trash-alt"></i></button>					
					</p>
					<div id="target" class="card-body p-1 m-0" style="height:15em; overflow-y:auto; background-color:#dbeef4">
					
					</div>
				</div>        		
    		@endforeach
		@endif
    		<div class="target card float-left d-inline mx-2 my-1" style="width:22em;">
    			<p class="card-header h6 font-weight-bold">Sample Target Panel</p>
    			<div id="target" class="card-body p-1 m-0" style="height:15em; overflow-y:auto; background-color:#dbeef4">
    				<div>
        				<div class="display mx-auto text-center rounded small" style="background-color:white;">
    						<table class="table table-bordered">
    							<tr>
    								<td class="py-0 h6">Jag (Danger!!)</td>
    								<td class="py-0">1</td>
    								<td class="py-0">Cat</td>
    								<td class="py-0 px-0"><button class="badge badge-primary" id="editwave"><i class="far fa-edit"></i></button></td>
    							</tr>
    							<tr>								
    								<td class="py-0" colspan="2">2020-04-20 00:00:00</td>
    								<td class="py-0">
    									<strong><span class="text-danger">Real</span></strong>										
    								</td>
    								<td class="py-0 px-0"><button class="badge badge-danger" id="delWave"><i class="far fa-trash-alt"></i></button></td>
    							</tr>
    						</table>
    					</div>
    					<div class="entry mx-auto text-center rounded small" style="background-color:white; display:none;">
    						<table class="table table-bordered">
    							<tr>
    								<td class="py-0 h6">Jag (Danger!!)</td>
    								<td class="py-0"><input type="number" min=1 value= 1 name="waves" style="width:2em; border:1px"></td>
    								<td class="py-0">Cat</td>
    								
    							</tr>
    							<tr>								
    								<td class="py-0" colspan="2">yyyy-MM-DD HH:mm:ss</td>
    								<td class="py-0">
    									<select name="type" style="width:4em; border:1px">
    										<option>Real</option>
    										<option>Fake</option>
    										<option>Ghost</option>
    										<option>Other</option>
    									</select>
    								</td>    								
    							</tr>
    							<tr class="">
    								<td class="py-0 px-3 text-left" colspan="2">Notes: <input type="text" name="notes" style="width:15em; border:1px"></td>
    								<td class="py-0 px-0"><button class="badge badge-success" id="savewave"><i class="fas fa-save"></i></button></td>
    							</tr>
    						</table>
    					</div>
    				</div>
    				
    				<div>
        				<div class="display mx-auto text-center rounded small" style="background-color:white;">
    						<table class="table table-bordered">
    							<tr>
    								<td class="py-0 h6">Jag (Danger!!)</td>
    								<td class="py-0">1</td>
    								<td class="py-0">Cat</td>
    								<td class="py-0 px-0"><button class="badge badge-primary" id="editwave"><i class="far fa-edit"></i></button></td>
    							</tr>
    							<tr>								
    								<td class="py-0" colspan="2">2020-04-20 00:00:00</td>
    								<td class="py-0">
    									<strong><span class="text-danger">Real</span></strong>										
    								</td>
    								<td class="py-0 px-0"><button class="badge badge-danger" id="delWave"><i class="far fa-trash-alt"></i></button></td>
    							</tr>
    						</table>
    					</div>
    					<div class="entry mx-auto text-center rounded small" style="background-color:white; display:none;">
    						<table class="table table-bordered">
    							<tr>
    								<td class="py-0 h6">Jag (Danger!!)</td>
    								<td class="py-0"><input type="number" min=1 value= 1 name="waves" style="width:2em; border:1px"></td>
    								<td class="py-0">Cat</td>
    								<td class="py-0 px-0"><button class="badge badge-primary" id="editwave"><i class="far fa-edit"></i></button></td>
    							</tr>
    							<tr>								
    								<td class="py-0" colspan="2">yyyy-MM-DD HH:mm:ss</td>
    								<td class="py-0">
    									<select name="type" style="width:4em; border:1px">
    										<option>Real</option>
    										<option>Fake</option>
    										<option>Ghost</option>
    										<option>Other</option>
    									</select>
    								</td>
    								<td class="py-0 px-0"><button class="badge badge-danger" id="delwave"><i class="far fa-trash-alt"></i></button></td>
    							</tr>
    						</table>
    					</div>
    				</div>				
                </div>
    		</div>    		  		
    	</div>
    </div>  
	<div class="container text-right small mb-5" style="clear:left">
		<p class="text-danger font-italic">Offense Planner created by Chandra</p>
	</div>
	  
@endsection

@push('scripts')
<script>
	$(document).on('click','.delitem',function(){
		$("#loading").toggle();
		
		var type = $(this).attr("id");	var id = $(this).val();
		var plan = $('meta[name="planId"]').attr('content');
		
		var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        	{	console.log(xmlhttp.responseText);		}
	    };
	    xmlhttp.open("GET", "/offense/plan/delitem/"+plan+"/"+type+"/"+id, true);
	    xmlhttp.send();
			    
	    setTimeout(function(){ location.reload(); }, 2000);
	    
	});
 </script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

	$(document).ready(function(){
		$(".attacker").css('cursor','grabbing');
		$(".attacker").draggable({
	        helper: 'clone'
	    });

	    $(".target").droppable({drop:function(event,ui){
		    	$("#target").append().text("added");
	    		alert("dropped");
	    	}
	    });
	});
</script>
<script>

        $("#editwave").click(function(){
			var div = $(this).closest("div.display");
			//div.css("background","yellow");
			var entry = div.siblings();
			entry.toggle();
			//entry.css("background","yellow");
			alert("clicked");
    		
        });
  
</script>
@endpush

@push('extensions')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<meta name="planId" content="{{$plan->id}}" />
@endpush