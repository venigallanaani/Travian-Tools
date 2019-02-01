@extends('Layouts.opsPlan')

@section('content')

	<div class="my-1">
	@if(count($waves)>0)	
		<div class="float-md-left p-2 shadow rounded" >
    		<div class="mx-auto">
    			<svg id="sankeyChart" width="800" height="300" style="margin:auto"></svg> 			 		
    		</div>
		</div>
	@endif  
	
		<div class="d-inline float-md-left col-md-3 py-0 rounded">
			<table class="m-1 col-md-12 shadow my-1"  style="background-color:#dbeef4">
				<tr>
					<td class="col-md-8 text-right text-warning"><strong>Attackers : </strong></td>
					<td class="col-md-4"> {{$plan->attackers}}</td>
				</tr>
				<tr>
					<td class="col-md-8 text-right text-success"><strong>Targets : </strong></td>
					<td class="col-md-4">{{$plan->targets}}</td>
				</tr>
				<tr>
					<td class="col-md-8 text-right text-danger"><strong>Reals : </strong></td>
					<td class="col-md-4">{{$plan->real}}</td>
				</tr>
				<tr>
					<td class="col-md-8 text-right text-primary"><strong>Fakes : </strong></td>
					<td class="col-md-4">{{$plan->fake}}</td>
				</tr>
				<tr>
					<td class="col-md-8 text-right"><strong>Other : </strong></td>
					<td class="col-md-4">{{$plan->other}}</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="d-inline float-md-left col-md-12 mx-auto text-center shadow rounded mt-2">
		<table class="table table-hover table-sm small table-striped m-1" id="ops">
			<thead>
    			<tr class="bg-info text-white">
    				<th class="col-md-2">Attacker</th>
    				<th class="col-md-2">Target</th>
    				<th class="col-md-1">Type</th>
    				<th class="col-md-1">Waves</th>
    				<th class="col-md-1">Troops</th>
    				<th class="col-md-2">Land Time</th>
    				<th class="col-md-2">Comments</th>
    				<th><button class="badge badge-warning" id="newRow"><i class="fas fa-plus"></i></button></th>
    			</tr>
			</thead>
			<tbody>
		@foreach($waves as $wave)
			@php
				if($wave->type == 'Real'){	$color='text-danger';	}
				elseif($wave->type == 'Fake'){	$color='text-primary';	}
				elseif($wave->type == 'Cheif'){	$color='text-warning';	}
				elseif($wave->type == 'Scout'){	$color='text-success';	}
				else{	$color='text-dark';	}
			@endphp			
    			<tr id="{{$wave->id}}">
    				<td class="">
    					<strong><a href="/finder/player/{{$wave->a_player}}/1" target="_blank">{{$wave->a_player}}</a></strong>
    					<a href=""> ({{$wave->a_village}})</a>
    				</td>
    				<td class="">
    					<strong><a href="/finder/player/{{$wave->d_player}}/1" target="_blank">{{$wave->d_player}}</a></strong>
    					<a href=""> ({{$wave->d_village}})</a>
    				</td>
    				<td class="{{$color}}"><strong>{{$wave->type}}</strong></td>
    				<td><strong>{{$wave->waves}}</strong></td>
    				<td data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units {{$wave->unit}}"></td>
    				<td>{{$wave->landtime}}</td>
    				<td  class="text-left">{{$wave->comments}}</td>
    				<td><span><button class="badge badge-primary" id="editRow"><i class="far fa-edit"></i></button></span>
    					<span><button class="badge badge-danger" id="delRow"><i class="far fa-trash-alt"></i></button></span>
    				</td>
    			</tr>		

		@endforeach
				<tr>
					<td>X:<input name="a_x" id="a_x" type="text" size="2" required/> |Y:<input name="a_y" id="a_y" type="text" size="2" required/></td>
					<td>X:<input name="d_x" id="d_x" type="text" size="2" required/> |Y:<input name="d_y" id="d_y" type="text" size="2" required/></td>
					<td><select name="type" id="type">
							<option value="real">Real</option>
							<option value="fake">Fake</option>
							<option value="cheif">Cheif</option>
							<option value="scout">Scout</option>
							<option value="other">Other</option>
						</select>
					</td>
					<td><input name="waves" id="waves" type="text" size="2" /></td>
					<td><select name="unit" id="unit">
							<option value="1">Catapult</option>
							<option value="2">Rams</option>
							<option value="3">Cheif</option>
							<option value="4">Cavalry</option>
							<option value="5">Infantry</option>
						</select>
					</td>
					<td><input name="landtime" type="text" size="20" class="dateTimePicker" id="land" required/></td>
					<td><input name="comments" type="text" id="comment"/></td>
    				<td><span><button class="badge badge-primary" id="saveRow" onclick="addRow()">Save</button></span>
    				</td>
				</tr> 
			</tbody>
		</table>
	</div>
@endsection

@push('scripts')

<script type="text/javascript">
// Adds new line to the data
    $(document).ready(function(){
        $("#newRow").click(function(){
        	var markup ='<tr>'+
            				'<td>X:<input name="a_x" type="text" size="2" /> |Y:<input name="a_y" type="text" size="2" /></td>'+
            				'<td>X:<input name="d_x" type="text" size="2" /> |Y:<input name="d_y" type="text" size="2" /></td>'+
            				'<td><select name="type">'+
            						'<option value="real">Real</option>'+
            						'<option value="fake">Fake</option>'+
            						'<option value="cheif">Cheif</option>'+
            						'<option value="scout">Scout</option>'+
            						'<option value="other">Other</option>'+
            					'</select>'+
            				'</td>'+
            				'<td><input name="waves" type="text" size="2" /></td>'+
            				'<td><select name="units">'+
            						'<option value="1">Catapult</option>'+
            						'<option value="2">Rams</option>'+
            						'<option value="3">Cheif</option>'+
            						'<option value="4">Cavalry</option>'+
            						'<option value="5">Infantry</option>'+
            					'</select>'+
            				'</td>'+
            				'<td><input name="landtime" type="text" size="20" class="dateTimePicker"/></td>'+
            				'<td><input name="Comments" type="text" /></td>'+
            				'<td><span><button class="badge badge-primary" id="saveRow">Save</button></span>'+
            				'</td>'+
        				'</tr>';

            
            $("#ops tbody").append(markup);
        });
    });          

//deletes the attack from the plan
    $(function(){
    	$('#ops').on('click','#delRow',function(e){
			var wave= $(this).parents('tr').attr("id");	
			
			var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
		        {	console.log(xmlhttp.responseText);	}
		    };
		    xmlhttp.open("GET", "/offense/plan/delete/"+wave, true);
		    xmlhttp.send();		

            e.preventDefault();
          	$(this).parents('tr').remove();		
        });
   });

</script>
<script>
	function addRow(){
		var a_x = $("#a_x").val();				var a_y = $("#a_y").val();
        var d_x = $("#d_x").val();				var d_y = $("#d_y").val();
        var type = $("#type").val();			var waves = $("#waves").val();
        var unit = $("#unit").val();			var land = $("#land").val();	
        var comments = $("#comment").val();
        
        var wave = a_x+'|'+a_y+'|'+d_x+'|'+d_y+'|'+type+'|'+waves+'|'+unit+'|'+land+'|'+comments; 
        	      
        var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {	console.log(xmlhttp.responseText);	}
	    };
	    xmlhttp.open("GET", "/offense/plan/add/"+wave, true);
	    xmlhttp.send();	

	    alert(wave);
	}
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
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush