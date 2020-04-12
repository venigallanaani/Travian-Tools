@extends('Layouts.general')

@section('content')        
        
    <!-- ============================================ home page body starts here ============================================ -->
    <div class="container mx-auto mt-1">
    	<div class="rounded">
    		<table class="table table-bordered">
    			<tr class="">
    				<td class="text-center" style="width:20em">
    					<p class="h5">Add Attackers and Targets</p>
    					<div class="rounded table-warning py-1 my-1 h6">
        					<form action="POST" class="">
        						<p class="px-0">Add Attacker</p>
        						<p class="px-0">X:<input type="text" name="att_x" style="width:5em"> | Y:<input type="text" name="att_y" style="width:5em"></p>
        						<p class="px-0"><button class="btn btn-info" name="attacker">Add Attacker</button>
        					</form>
    					</div>
    					<div class="rounded table-success py-1 my-1 h6">
        					<form action="POST" class="">
        						<p class="px-0">Add Target</p>
        						<p class="px-0">X:<input type="text" name="att_x" style="width:5em"> | Y:<input type="text" name="att_y" style="width:5em"></p>
        						<p class="px-0"><button class="btn btn-info" name="attacker">Add Target</button>
        					</form>
    					</div> 
    				</td>
    				
    				<td class="">
    					<div class="rounded table-info p-2 small" style="height:20em; overflow-y:auto;">
    						<p class="text-center h6 pb-1">Attackers List</p>
    						
    						<div id="attacker" class="attacker d-inline m-1 p-1 bg-white rounded float-left font-weight-bold">
    							<span id="name" class="px-2">Jag (Danger!!) (62|27) - 
    								<span class="text-danger">4</span> | <span class="text-primary ">8</span> | <span class="">0</span>
    							</span> 
    							<button class="badge badge-danger" id="delRow"><i class="far fa-trash-alt"></i></button>
							</div>
							<div id="attacker" class="attacker d-inline m-1 p-1 bg-white rounded float-left font-weight-bold">
    							<span id="name" class="px-2">Classic (02.Akagi) (25|29) - 
									<span class="text-danger">4</span> | <span class="text-primary ">8</span> | <span class="">0</span>
    							</span> 
    							<button class="badge badge-danger" id="delRow"><i class="far fa-trash-alt"></i></button>
							</div>
							<div id="attacker" class="attacker d-inline m-1 p-1 bg-white rounded float-left font-weight-bold">
    							<span id="name" class="px-2">Yoink! (02 Gibby) (17|78) - 
    								<span class="text-danger">4</span> | <span class="text-primary ">8</span> | <span class="">0</span>    							
    							</span> 
    							<button class="badge badge-danger" id="delRow"><i class="far fa-trash-alt"></i></button>
							</div>
						</div>		
    				</td>
    			</tr>
    		</table>    	
    	</div>
    	
    	<div class="rounded mx-auto px-0">
    		<div class="target card float-left d-inline mx-2 my-1" style="width:22em;">
    			<p class="card-header h6 font-weight-bold">Verde (02 Buffon) (0|0) - 8|0|0</p>
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
    		<div class="target card float-left d-inline mx-2 my-1" style="width:22em;">
    			<p class="card-header h6 font-weight-bold">Windir (WW) - 0|16|0</p>
    			<div id="target" class="card-body" style="height:15em; overflow-y:auto;">                 
					
                </div>
    		</div>
    		<div class="target card float-left d-inline mx-2 my-1" style="width:22em;">
    			<p class="card-header h6 font-weight-bold">Blah (Blah) - 4|16|0</p>
    			<div id="target" class="card-body" style="height:15em; overflow-y:auto;">                 
					
                </div>
    		</div>    
    		<div class="target card float-left d-inline mx-2 my-1" style="width:22em;">
    			<p class="card-header h6 font-weight-bold">Blah (Blah) - 4|16|0</p>
    			<div id="target" class="card-body" style="height:15em; overflow-y:auto;">                 
					
                </div>
    		</div>   		
    	</div>
    </div>  
	<div class="container text-right small mb-5" style="clear:left">
		<p class="text-danger font-italic">Offense Planner created by Chandra</p>
	</div>
	  
@endsection

@push('scripts')
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

@endpush