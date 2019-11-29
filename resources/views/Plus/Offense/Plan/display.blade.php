@extends('Layouts.offense')

@section('content')
	
	<input name="plan" value="{{$plan->id}}" hidden/>
	<div class="my-1">		
	@if(count($waves)>0)	
		<div class="float-md-left p-2 shadow rounded" >
    		<div class="mx-auto">
    			<svg id="sankeyChart" width="800" height="300" style="margin:auto"></svg> 			 		
    		</div>
		</div>
	@endif  
	
		<div class="d-inline float-md-left py-0 m-3 rounded">
			<div class="px-3 py-3 shadow"  style="background-color:#dbeef4">
    			<table>
    				<tr>
    					<td class="text-warning"><strong>Attackers : </strong></td>
    					<td class=""> {{$plan->attackers}}</td>
    				</tr>
    				<tr>
    					<td class="text-success"><strong>Targets : </strong></td>
    					<td class=""> {{$plan->targets}}</td>
    				</tr>
    				<tr>
    					<td class="text-danger"><strong>Real : </strong></td>
    					<td class=""> {{$plan->real}}</td>
    				</tr>
    				<tr>
    					<td class="text-primary"><strong>Fake : </strong></td>
    					<td class=""> {{$plan->fake}}</td>
    				</tr>
    				<tr>
    					<td class=""><strong>Other : </strong></td>
    					<td class=""> {{$plan->other}}</td>
    				</tr>
    			</table>
			</div>
		</div>
	</div>
	
	
	<div class="d-inline float-md-left col-md-12 mx-auto text-center shadow rounded mt-2">
		<table class="table table-hover table-sm small table-striped m-1 py-2" id="ops">
			<thead>
    			<tr class="bg-info text-white">
    				<th class="">Attacker</th>
    				<th class="">Target</th>
    				<th class="">Type</th>
    				<th class="">Waves</th>
    				<th class="">Units</th>
    				<th class="">Land Time</th>
    				<th class="">Comments</th>
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
    					<strong><a href="{{route('findPlayer')}}/{{$wave->a_player}}/1" target="_blank">{{$wave->a_player}}</a></strong>
    					<a href=""> ({{$wave->a_village}})</a>
    				</td>
    				<td class="">
    					<strong><a href="{{route('findPlayer')}}/{{$wave->d_player}}/1" target="_blank">{{$wave->d_player}}</a></strong>
    					<a href=""> ({{$wave->d_village}})</a>
    				</td>
    				<td class="{{$color}}"><strong>{{$wave->type}}</strong></td>
    				<td><strong>{{$wave->waves}}</strong></td>
    				<td data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units {{$wave->unit}}"></td>
    				<td>{{$wave->landtime}}</td>
    				<td  class="text-center">{{$wave->comments}}</td>
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
							<option value="scout">Scout</option>
							<option value="other">Other</option>
						</select>
					</td>
					<td><input name="waves" id="waves" type="text" size="2" /></td>
					<td><select name="unit" id="unit">
							<option value="1">Catapult</option>
							<option value="2">Rams</option>
							<option value="4">Cavalry</option>
							<option value="5">Infantry</option>
						</select>
					</td>
					<td><input name="landtime" type="text" size="20" class="dateTimePicker" id="land" required/></td>
					<td><input name="comments" type="text" id="comment"/></td>
    				<td><button class="badge badge-primary" id="saveRow" type="button" onClick="addRow()">Save</button>
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
            				'<td>X:<input name="a_x" type="text" size="2" required/> |Y:<input name="a_y" type="text" size="2" required/></td>'+
            				'<td>X:<input name="d_x" type="text" size="2" required/> |Y:<input name="d_y" type="text" size="2" required/></td>'+
            				'<td><select name="type">'+
            						'<option value="real">Real</option>'+
            						'<option value="fake">Fake</option>'+
            						'<option value="scout">Scout</option>'+
            						'<option value="other">Other</option>'+
            					'</select>'+
            				'</td>'+
            				'<td><input name="waves" type="text" size="2" required/></td>'+
            				'<td><select name="units">'+
            						'<option value="1">Catapult</option>'+
            						'<option value="2">Rams</option>'+
            						'<option value="3">Cheif</option>'+
            						'<option value="4">Cavalry</option>'+
            						'<option value="5">Infantry</option>'+
            					'</select>'+
            				'</td>'+
            				'<td><input name="landtime" type="text" size="20" class="dateTimePicker" required/></td>'+
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });  
	function addRow(){
		var plan = $("#plan").val();
		var a_x = $("#a_x").val();				var a_y = $("#a_y").val();
        var d_x = $("#d_x").val();				var d_y = $("#d_y").val();
        var type = $("#type").val();			var waves = $("#waves").val();
        var unit = $("#unit").val();			var land = $("#land").val();	
        var comments = $("#comment").val();
        
        var wave = {{$plan->id}}+'|'+a_x+'|'+a_y+'|'+d_x+'|'+d_y+'|'+type+'|'+waves+'|'+unit+'|'+land+'|'+comments; 
        
        $.ajax({
            type:'POST',
            url:'/offense/plan/add',
            data:{ input : wave	},
            
            success:function(data){				
         	   	alert(data.success)
            }
         });  
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