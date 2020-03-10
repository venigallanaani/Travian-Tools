@extends('Layouts.incomings')

@section('body')
<div class="card float-md-left col-md-12 mt-1 p-0 shadow">
	<div class="card-header h4 py-2 bg-info text-white"><strong>Incomings List</strong></div>
@foreach(['danger','success','warning','info'] as $msg)
	@if(Session::has($msg))
    	<div class="alert alert-{{ $msg }} text-center my-1 mx-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>{{ Session::get($msg) }}
        </div>
    @endif
@endforeach			
	<div class="col-md-12 mt-2 mx-auto text-center">		
		@if(count($incomings)==0)			
		<p class="h5 pb-5 pt-2"> No incomings are entered by the group members</p>			
		@else
		
    		<table class="table col-md-8 mx-auto text-left table-borderless">
    			<tr class="header show">
    				<td>
    					<div style="height:250px; overflow-y:auto;" class="my-2">
        					<table class="table my-0 py-0 table-bordered">
        						<thead><tr class="header show"><th style="position:sticky; top:0px;" class="table-danger mx-1 text-center h4 py-1">Attackers</th></tr></thead>
        						@foreach($attackers as $attacker)
            						<tr class="header show"><td class="h6 py-1"><input class="id_attack" rel="attack" type="checkbox" value="{{$attacker['ID']}}"> {{$attacker['NAME']}}</tr>
                                @endforeach
        					</table>
    					</div>
    				</td>
    				<td>
    					<div style="height:250px; overflow-y:auto;" class="my-2">
        					<table class="table my-0 py-0 table-bordered">
        						<thead><tr class="header show"><th style="position:sticky; top:0px;" class="table-success mx-1 text-center h4 py-1">Defenders</th></tr></thead>
        						@foreach($defenders as $defender)
            						<tr class="header show"><td class="h6 py-1"><input class="id_defend" rel="defend" type="checkbox" value="{{$defender['ID']}}"> {{$defender['NAME']}}</td></tr>
                                @endforeach
        					</table>
    					</div>
    				</td>
    				<td>
    					<div style="height:250px; overflow-y:auto;" class="my-2">
        					<table class="table my-0 py-0 table-bordered">
        						<thead><tr class="header show"><td class="table-info mx-1 text-center h4 py-1">Actions</td></tr></thead>
        						<tr class="header show"><td class="h6 table-white py-1"><input class="id_type" rel="type" type="checkbox" value="NEW"> New</td></tr>
        						<tr class="header show"><td class="h6 table-info py-1"><input class="id_type" rel="type" type="checkbox" value="THINKING"> Thinking</td></tr>
        						<tr class="header show"><td class="h6 table-warning py-1"><input class="id_type" rel="type" type="checkbox" value="SCOUT"> Scouting</td></tr>
        						<tr class="header show"><td class="h6 table-success py-1"><input class="id_type" rel="type" type="checkbox" value="DEFEND"> Defend</td></tr>
        						<tr class="header show"><td class="h6 table-danger py-1"><input class="id_type" rel="type" type="checkbox" value="SNIPE"> Snipe</td></tr>
        						<tr class="header show"><td class="h6 table-primary py-1"><input class="id_type" rel="type" type="checkbox" value="ARTEFACT"> Save Artefact</td></tr>
        						<tr class="header show"><td class="h6 table-secondary py-1"><input class="id_type" rel="type" type="checkbox" value="FAKE"> Fake</td></tr>          						
        					</table>
    					</div>
    				</td>
    			</tr>
    		</table>

		<table class="table mx-auto col-md-12 table-hover table-sm table-bordered shadow">
			<thead class="thead-inverse bg-info text-white">
				<tr class="header show">
					<th class="">Attacker</th>
					<th class="">Noticed Time</th>
					<th class="">Defender</th>
					<th class="">Start Time</th>
					<th class="">Waves</th>					
					<th class="">Land Time</th>
					<th class="">Unit</th>
					<th class="">Tsq</th>
					<th class="">Action</th>					
					<th class="">Details</th>
				</tr>
			</thead>
			@foreach($incomings as $index=>$incoming)
				@php
					if		($incoming['ldr_sts']=='SCOUT')		{$color='table-warning';	}
					elseif	($incoming['ldr_sts']=='THINKING')	{$color='table-info';		}
					elseif	($incoming['ldr_sts']=='DEFEND')	{$color='table-success';	}	
					elseif	($incoming['ldr_sts']=='ARTEFACT')	{$color='table-primary';	}	
					elseif	($incoming['ldr_sts']=='SNIPE')		{$color='table-danger';		}
					elseif	($incoming['ldr_sts']=='FAKE')		{$color='table-secondary';	}								
					else	{	$color='table-white';	}					
				@endphp				
						
    			<tr class="{{$color}} h6 show" id="{{$incoming['incid']}}">
    				<td class="attack" rel="{{$incoming['att_id']}}"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['att_x']}}&y={{$incoming['att_y']}}" target="_blank"><strong>{{$incoming['att_player']}}</strong> 
    						({{$incoming['att_village']}}) </a></td>
					<td>{{$incoming['noticeTime']}}</td>
    				<td  class="defend" rel="{{$incoming['def_id']}}"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['def_x']}}&y={{$incoming['def_y']}}" target="_blank"><strong>{{$incoming['def_player']}}</strong>
    						 ({{$incoming['def_village']}})</a></td>
			 		<td>{{$incoming['landTime']}}</td>
    				<td>{{$incoming['waves']}}</td>
    				<td>{{$incoming['landTime']}}</td>
    				<td><select id="unit" style="width:5em"><option>0</option>
    						<option>Legion</option><option>Preat</option><option>Imperian</option><option>Scout</option><option>EI</option>
    						<option>EC</option><option>Ram</option><option>Cat</option><option>Senator</option><option>Settler</option>   						
    					</select>
    				</td>
    				<td><select id="tsq"><option>0</option>
    						<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
    						<option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>
    						<option>11</option><option>12</option><option>13</option><option>14</option><option>15</option>
    						<option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>    						
    					</select>
    				</td>
    				<td class="type" rel="{{$incoming['ldr_sts']}}"><select id="action" name="type">
    						<option @if($incoming['ldr_sts']=='NEW') selected @endif>New</option>
    						<option @if($incoming['ldr_sts']=='THINKING') selected @endif>Thinking</option>
    						<option @if($incoming['ldr_sts']=='SCOUT') selected @endif>Scouting</option>
    						<option @if($incoming['ldr_sts']=='SNIPE') selected @endif>Snipe</option>
    						<option @if($incoming['ldr_sts']=='DEFEND') selected @endif>Defend</option>
    						<option @if($incoming['ldr_sts']=='ARTEFACT') selected @endif>Save Artefact</option>    						 						
    						<option @if($incoming['ldr_sts']=='FAKE') selected @endif>Fake</option>
    					</select>
    				</td>
    				<td><button class="btn btn-info btn-sm" id="details" name="button" value="{{$index}}" type="submit"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></td>
    			</tr>
    			<tr style="display: none;background-color:#dbeef4" class="info">
    				<td colspan="2" class="py-1">
    					<p class="py-0 h5"><a href="/defense/attacker/{{$incoming['att_id']}}" target="_blank"><strong>Track Attacker <i class="fas fa-external-link-alt"></i></strong></a></p>
    					<p class="py-0 h6"><strong>Hero XP - </strong>{{$incoming['hero']}}</p>
    					<p class="py-0 h6"><strong>Notes - </strong><small>{{$incoming['comments']}}</small></p>
					</td>
					<td colspan="2" class="py-1">
						@if($incoming['VILLAGE']==null)
							<p class="h6"><strong>No Village Details</strong></p>
						@else
							<p class="py-0 h5">Village Details</p>
							<p class="py-0 h6">
								<span class="px-1 py-0"><strong>Artifact</strong> - {{ucfirst(strtolower($incoming['VILLAGE']['artifact']))}}</span>
								@if($incoming['VILLAGE']['cap']==1)
									<span class="py-0 px-1"><strong>Capital</strong></span>
								@endif
							</p>
							<p class="px-1 py-0"><strong>Village Type-</strong> {{ucfirst(strtolower($incoming['VILLAGE']['type']))}}</p>
						@endif					
					</td>
    				<td colspan="2" class="py-1">
    					@if($incoming['CFD']==null)
    						<p class="py-0 h6">CFD doesn't exists</p>
    						<p class="py-0 h5"><a href="/defense/cfd/{{$incoming['CFD']['id']}}" target="_blank"><strong>Create CFD</strong><i class="fas fa-external-link-alt"></i></a></p>
    					@else
    						<p class="py-0 h5"><strong>CFD - </strong>{{number_format($incoming['CFD']['total'])}} ({{$incoming['CFD']['percent']}}%)</p>
    						<p class="py-0 h6"><span class="px-1 py-0"><strong>Type -</strong> {{$incoming['CFD']['type']}}</span></p>
							<p class="py-0 h6"><a href="/defense/cfd/{{$incoming['CFD']['id']}}" target="_blank"><strong>Edit CFD</strong><i class="fas fa-external-link-alt"></i></a></p>
							
    					@endif
    				</td>
    				<td colspan="4" class="py-1 px-0">
    					<span class="h6">Updated by - <a href="/plus/member/{{$incoming['updated_by']}}" target="_blank">{{$incoming['updated_by']}}</a></span>
        				<form action="/defense/incomings/update/comments" method="POST">
        					{{csrf_field()}}
        					<textarea name="comments" rows="2" cols="20">{{$incoming['ldr_nts']}}</textarea> 
        					<button class="btn btn-sm btn-info" name="wave" value="{{$incoming['incid']}}" type="submit">Save</button>
    					</form>
    				</td>
    			</tr>
			@endforeach			
		</table>
		@endif			
	</div>
</div>	
@endsection

@push('scripts')
<script>
    $(document).on('click','#details',function(e){
        e.preventDefault();    
        var col= $(this).closest("td");
        var id= col.find('#details').val();
		var row = $(this).closest('tr').next('tr');
		row.toggle('500');
    });
</script>
<script>
	$(document).on('change','#tsq',function(e){
		e.preventDefault();
		var wave = $(this).closest("tr");	var id= wave.attr("id");	var vid = wave.find('td:eq(1)').attr("id");		
        //var tsq = wave.find('td:eq(8)').find('select #tsq').val();
        var tsq=$(this).val();
        
        //alert(id+'|||||'+tsq);
	});
</script>
<script>
	$(document).on('change','#action',function(e){		
		e.preventDefault();  
		
		var sts = $(this).val();	var row = $(this).closest("tr");	var id = row.attr("id");		
		
		if(sts == 'New'){			row.removeClass();	row.addClass('h6');					}
		if(sts == 'Scouting'){		row.removeClass();	row.addClass('h6 table-warning');	}
		if(sts == 'Thinking'){		row.removeClass();	row.addClass('h6 table-info');		}
		if(sts == 'Defend'){		row.removeClass();	row.addClass('h6 table-success');	}
		if(sts == 'Save Artefact'){	row.removeClass();	row.addClass('h6 table-primary');	}
		if(sts == 'Snipe'){			row.removeClass();	row.addClass('h6 table-danger');		}
		if(sts == 'Fake'){			row.removeClass();	row.addClass('h6 table-secondary');	} 

	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {
	            console.log(xmlhttp.responseText);
	        }
	    };
	    xmlhttp.open("GET", "/defense/incomings/update/"+id+"/"+sts, true);
	    xmlhttp.send();
		
        //alert(sts);
	});
</script>
<script>
 	$("input:checkbox").click(function () {
 	    var showAll = true;
 	    $('tr').not('.header').hide();
 	    $('input[type=checkbox]').each(function () {
 	        if ($(this)[0].checked) {
 	            showAll = false;
 	            var status = $(this).attr('rel');
 	            var value = $(this).val();            
 	            var row = $('td.' + status + '[rel="' + value + '"]').parent('tr');
 	            row.show(); 	            
 	        }
 	    });
 	    if(showAll){
 	        $('tr').show();
 	        $('tr').not('.show').hide();
 	    }
 	});
</script> 
@endpush


