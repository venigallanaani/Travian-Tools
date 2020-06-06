@extends('Layouts.incomings')

@section('body')
<div class="card float-md-left col-md-12 mt-1 p-0 shadow mb-5">
	<div class="card-header h5 py-2 bg-info text-white"><strong>Incomings List</strong></div>
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
        						<thead><tr class="header show"><th style="position:sticky; top:0px;" class="table-danger mx-1 text-center h5 py-1">Attackers</th></tr></thead>
        						@foreach($attackers as $attacker)
            						<tr class="header show"><td class="h6 py-1"><input class="id_attack" rel="attack" type="checkbox" value="{{$attacker['ID']}}"> {{$attacker['NAME']}}</tr>
                                @endforeach
        					</table>
    					</div>
    				</td>
    				<td>
    					<div style="height:250px; overflow-y:auto;" class="my-2">
        					<table class="table my-0 py-0 table-bordered">
        						<thead><tr class="header show"><th style="position:sticky; top:0px;" class="table-success mx-1 text-center h5 py-1">Defenders</th></tr></thead>
        						@foreach($defenders as $defender)
            						<tr class="header show"><td class="h6 py-1"><input class="id_defend" rel="defend" type="checkbox" value="{{$defender['ID']}}"> {{$defender['NAME']}}</td></tr>
                                @endforeach
        					</table>
    					</div>
    				</td>
    				<td>
    					<div style="height:250px; overflow-y:auto;" class="my-2">
        					<table class="table my-0 py-0 table-bordered">
        						<thead><tr class="header show"><td class="table-info mx-1 text-center h5 py-1">Actions</td></tr></thead>
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

		<table class="table mx-auto col-md-12 table-hover table-sm table-bordered shadow align-center" id="incTable">
			<thead class="thead-inverse bg-info text-white">
				<tr class="header show">					
					<th class="">Attacker</th>
					<th class="">Waves</th>
					<th class="">Defender</th>
					<th class="">Land Time</th>
					<th class="">Notice Time</th>
					<th class="">Start Time</th>										
					<th class="">Unit</th>
					<th class="">Tsq</th>
					<th class="">Boots</th>
					<th class="">Artifact</th>
					<th class="">Action</th>									
					<th class=""></th>
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
						
    			<tr class="{{$color}} show" id="{{$incoming['incid']}}" style="font-size:0.8em">    				
    				<td class="attack" rel="{{$incoming['att_id']}}"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['att_x']}}&y={{$incoming['att_y']}}" target="_blank"><strong>{{$incoming['att_player']}}</strong> 
    						({{$incoming['att_village']}}) </a></td>
					<td class=""><strong>{{$incoming['waves']}}</strong></td>					
    				<td class="defend" rel="{{$incoming['def_id']}}"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['def_x']}}&y={{$incoming['def_y']}}" target="_blank"><strong>{{$incoming['def_player']}}</strong>
    						 ({{$incoming['def_village']}})</a></td>
					<td class="" id="land">{{$incoming['landTime']}}</td>
				 	<td class="" id="notice">{{$incoming['noticeTime']}}</td>
			 		<td class="" id="start">...</td>   				
    				<td><select id="unit" style="width:6em" class="small">
    					@if($incoming['att_tribe']=='ROMAN')
    						<option @if($incoming['unit']==6) selected @endif value="6">6-Legionnaire</option>
    						<option @if($incoming['unit']==5) selected @endif value="5">5-Praetorian/Settler</option>
    						<option @if($incoming['unit']==7) selected @endif value="7">7-Imperian</option>
    						<option @if($incoming['unit']==14) selected @endif value="14">14-Equites Imperatoris</option>
    						<option @if($incoming['unit']==10) selected @endif value="10">10-Equites Caesaris</option>
    						<option @if($incoming['unit']==4) selected @endif value="4">4-Ram/Senator</option>
    						<option @if($incoming['unit']==3) selected @endif value="3">3-Catapult</option>
						@endif
						@if($incoming['att_tribe']=='TEUTON')
    						<option @if($incoming['unit']==7) selected @endif value="7">7-Maceman/Spearman</option>
    						<option @if($incoming['unit']==6) selected @endif value="6">6-Axeman</option>
    						<option @if($incoming['unit']==10) selected @endif value="10">10-Paladin</option>
    						<option @if($incoming['unit']==9) selected @endif value="9">9-Teutonic Knight</option>
    						<option @if($incoming['unit']==4) selected @endif value="4">4-Ram/Chief</option>
    						<option @if($incoming['unit']==3) selected @endif value="3">3-Catapult</option>
						@endif
						@if($incoming['att_tribe']=='GAUL')
    						<option @if($incoming['unit']==7) selected @endif value="7">7-Phalanx</option>
    						<option @if($incoming['unit']==6) selected @endif value="6">6-Swordsman</option>
    						<option @if($incoming['unit']==19) selected @endif value="19">19-Theutates Thunder</option>
    						<option @if($incoming['unit']==14) selected @endif value="14">16-Druidrider</option>
    						<option @if($incoming['unit']==13) selected @endif value="13">13-Haeduan</option>
    						<option @if($incoming['unit']==4) selected @endif value="4">4-Ram</option>
    						<option @if($incoming['unit']==3) selected @endif value="3">3-Catapult</option>
    						<option @if($incoming['unit']==5) selected @endif value="5">5-Chieftain</option>
						@endif
						@if($incoming['att_tribe']=='HUN')
    						<option @if($incoming['unit']==6) selected @endif value="6">6-Mercenray/Bowman</option>
    						<option @if($incoming['unit']==16) selected @endif value="16">16-Steppe Rider/Marksman</option>
    						<option @if($incoming['unit']==14) selected @endif value="14">14-Marauder</option>
    						<option @if($incoming['unit']==4) selected @endif value="4">4-Ram</option>
    						<option @if($incoming['unit']==3) selected @endif value="3">3-Catapult</option>
    						<option @if($incoming['unit']==5) selected @endif value="5">5-Logades</option>
						@endif
						@if($incoming['att_tribe']=='EGYPTIAN')
    						<option @if($incoming['unit']==7) selected @endif value="7">7-Salve Militia/Khopesh Warrior</option>
    						<option @if($incoming['unit']==6) selected @endif value="6">6-Ash Warden</option>
    						<option @if($incoming['unit']==15) selected @endif value="15">15-Anhur Guard</option>
    						<option @if($incoming['unit']==10) selected @endif value="10">10-Resheph Chariot</option>
    						<option @if($incoming['unit']==4) selected @endif value="4">4-Ram/Normach</option>
    						<option @if($incoming['unit']==3) selected @endif value="3">3-Catapult</option>
						@endif  						
    					</select>
    				</td>
    				<td><select id="tsq">
							<option @if($incoming['tsq']==0) selected @endif>0</option>		<option @if($incoming['tsq']==1) selected @endif>1</option>
							<option @if($incoming['tsq']==2) selected @endif>2</option>		<option @if($incoming['tsq']==3) selected @endif>3</option>
							<option @if($incoming['tsq']==4) selected @endif>4</option>		<option @if($incoming['tsq']==5) selected @endif>5</option>
							<option @if($incoming['tsq']==6) selected @endif>6</option>		<option @if($incoming['tsq']==7) selected @endif>7</option>
							<option @if($incoming['tsq']==8) selected @endif>8</option>		<option @if($incoming['tsq']==9) selected @endif>9</option>
							<option @if($incoming['tsq']==10) selected @endif>10</option>	<option @if($incoming['tsq']==11) selected @endif>11</option>
							<option @if($incoming['tsq']==12) selected @endif>12</option>	<option @if($incoming['tsq']==13) selected @endif>13</option>
							<option @if($incoming['tsq']==14) selected @endif>14</option>	<option @if($incoming['tsq']==15) selected @endif>15</option>
							<option @if($incoming['tsq']==16) selected @endif>16</option>	<option @if($incoming['tsq']==17) selected @endif>17</option>
							<option @if($incoming['tsq']==18) selected @endif>18</option>	<option @if($incoming['tsq']==19) selected @endif>19</option>	
							<option @if($incoming['tsq']==20) selected @endif>20</option>
    					</select>
    				</td>
    				<td><select id="boots" style="width:5em;" class="small">
    						<option @if($incoming['hero_boots']==0) selected @endif value="0">-----</option>
    						<option @if($incoming['hero_boots']==15) selected @endif value="15">Mercenary Boots</option>
    						<option @if($incoming['hero_boots']==20) selected @endif value="20">Warrior Boots</option>
    						<option @if($incoming['hero_boots']==25) selected @endif value="25">Archon Boots</option>    						
    					</select>
    				</td>
    				<td><select id="art" style="width:4em;" class="small">
							<option @if($incoming['hero_art']==8) selected @endif value="8">2X</option>
							<option @if($incoming['hero_art']==6) selected @endif value="6">1.5X</option>
							<option @if($incoming['hero_art']==4) selected @endif value="4">--</option>
							<option @if($incoming['hero_art']==3) selected @endif value="3">0.67X</option>
							<option @if($incoming['hero_art']==2) selected @endif value="2">0.5X</option>  						
    					</select>
    				</td>
    				<td class="type" rel="{{$incoming['ldr_sts']}}">
    					<select id="action" name="type" style="width:6em;" class="small">
    						<option @if($incoming['ldr_sts']=='NEW') selected @endif value="NEW">New</option>
    						<option @if($incoming['ldr_sts']=='THINKING') selected @endif value="THINKING">Thinking</option>
    						<option @if($incoming['ldr_sts']=='SCOUT') selected @endif value="SCOUT">Scouting</option>
    						<option @if($incoming['ldr_sts']=='SNIPE') selected @endif value="SNIPE">Snipe</option>
    						<option @if($incoming['ldr_sts']=='DEFEND') selected @endif value="DEFEND">Defend</option>
    						<option @if($incoming['ldr_sts']=='ARTEFACT') selected @endif value="ARTEFACT">Save Artefact</option>    						 						
    						<option @if($incoming['ldr_sts']=='FAKE') selected @endif value="FAKE">Fake</option>
    					</select>
    				</td>
    				<td><button class="badge badge-info" id="details" name="button" value="{{$incoming['dist']}}" type="submit"><i class="fas fa-angle-double-down px-1"></i></button></td>
    			</tr>
    			<tr style="display: none;background-color:#dbeef4;font-size: 0.8em" class="info">
    				<td colspan="3" class="py-1">
    					<p class="py-0 my-1 h6"><a href="/defense/attacker/{{$incoming['att_id']}}" target="_blank"><strong>Track Attacker <i class="fas fa-external-link-alt"></i></strong></a></p>
    					<p class="py-0 my-1"><strong>Hero XP - </strong>{{$incoming['hero']}}</p>
    					<p class="py-0 my-1"><strong>Player Notes - </strong><small>{{$incoming['comments']}}</small></p>
					</td>
					<td colspan="3" class="py-1">
						@if($incoming['VILLAGE']==null)
							<p class=""><strong>No Village Details</strong></p>
						@else
							<p class="py-0 my-1 h6">Village Details</p>
							<p class="py-0 my-1">
								<span class="px-1 py-0"><strong>Artifact</strong> - {{ucfirst(strtolower($incoming['VILLAGE']['artifact']))}}</span>
								@if($incoming['VILLAGE']['cap']==1)
									<span class="text-danger"><strong>Capital</strong></span>
								@endif
							</p>
							<p class="px-1 py-0"><strong>Village Type-</strong> {{ucfirst(strtolower($incoming['VILLAGE']['type']))}}</p>
						@endif					
					</td>
    				<td colspan="2" class="py-1">
    					@if($incoming['CFD']==null)
    						<p class="py-0 h6">CFD doesn't exists</p>
    						<p class="py-0"><a href="/defense/cfd" target="_blank"><strong>Create CFD</strong><i class="fas fa-external-link-alt"></i></a></p>
    					@else
    						<p class="py-0 my-1"><strong>CFD - </strong>{{number_format($incoming['CFD']['total'])}} ({{$incoming['CFD']['percent']}}%)</p>
    						<p class="py-0 my-1"><span class="px-1 py-0"><strong>Type -</strong> {{$incoming['CFD']['type']}}</span></p>
							<p class="py-0 my-1 h6"><a href="/defense/cfd/{{$incoming['CFD']['id']}}" target="_blank"><strong>Edit CFD</strong><i class="fas fa-external-link-alt"></i></a></p>
							
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
 	$("input:checkbox").click(function () {
 	    var showAll = true;		$('tr').not('.header').hide();
 	    $('input[type=checkbox]').each(function () {
 	        if ($(this)[0].checked) {
 	            showAll = false;	var status = $(this).attr('rel');	var value = $(this).val();            
 	            var row = $('td.' + status + '[rel="' + value + '"]').parent('tr');		row.show(); 	            
 	        }
 	    });
 	    if(showAll){	$('tr').show();		$('tr').not('.show').hide();	}
 	});
</script>
<script>
	$(document).on('change','#action',function(e){
		e.preventDefault();  
		
		var sts = $(this).val();	var row = $(this).closest("tr");	var id = row.attr("id");	
		var col = $(this).closest("td");	row.removeClass();	
		
		if(sts == 'NEW')		{	row.addClass('show');					col.attr("rel","NEW");		}
		if(sts == 'SCOUT')		{	row.addClass('show table-warning');		col.attr("rel","SCOUT");	}
		if(sts == 'THINKING')	{	row.addClass('show table-info');		col.attr("rel","THINKING");	}
		if(sts == 'DEFEND')		{	row.addClass('show table-success');		col.attr("rel","DEFEND");	}
		if(sts == 'ARTEFACT')	{	row.addClass('show table-primary');		col.attr("rel","ARTEFACT");	}
		if(sts == 'SNIPE')		{	row.addClass('show table-danger');		col.attr("rel","SNIPE");	}
		if(sts == 'FAKE')		{	row.addClass('show table-secondary');	col.attr("rel","FAKE");		} 

	    var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {	console.log(xmlhttp.responseText);	}
	    };
	    xmlhttp.open("GET", "/defense/incomings/update/action/"+id+"/"+sts, true);		
	    xmlhttp.send();

	 	$("input:checkbox").click(function () {
	 	    var showAll = true;		$('tr').not('.header').hide();
	 	    $('input[type=checkbox]').each(function(){
	 	        if ($(this)[0].checked) {
	 	            showAll = false;	var status = $(this).attr('rel');	var value = $(this).val();
	 	            var row = $('td.' + status + '[rel="' + value + '"]').parent('tr');		row.show(); 	            
	 	        }
	 	    });
	 	    if(showAll){	$('tr').show();		$('tr').not('.show').hide();	}
	 	});
	});
</script>
<script>
	$(document).on('change','#art',function(e){
		e.preventDefault();
		var id = $(this).closest("tr").attr("id");	var art=$(this).val();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {	console.log(xmlhttp.responseText);	}
	    };
	    xmlhttp.open("GET", "/defense/incomings/update/art/"+id+"/"+art, true);		
	    xmlhttp.send();
	    
	    var att=$(this).closest("tr").find(".attack").attr('rel');
        var row = $('td.attack[rel="' + att + '"]').parent('tr');		row.find('#art').val(art); 

		$('#incTable tr').each(function (i, row){
			if(i>0){
				var row = $(row);
				var rel = row.find(".attack").attr('rel');					
				if(rel == att){		
    				var time = startTime(row.find('#land').html(),row.find('#notice').html(),row.find('#details').val(),row.find('#unit').val(),row.find('#tsq').val(),row.find('#boots').val(),row.find('#art').val(),"{{Session::get('server.tsq')}}","{{Session::get('timezone')}}");
    				row.find("#start").html(time);
    				
    				var notice = new Date(row.find('#notice').html()).getTime();
    				var start = new Date(time).getTime();
    				if(notice-start<0){	
        				row.find("#start").css("color","red");		
    				}else{	
        				row.find("#start").css("color","black");	
    				}
				}
			}			
		}); 
	});
</script>
<script>
	$(document).on('change','#boots',function(e){
		e.preventDefault();
		var id = $(this).closest("tr").attr("id");	var boots=$(this).val();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {	console.log(xmlhttp.responseText);	}
	    };
	    xmlhttp.open("GET", "/defense/incomings/update/boots/"+id+"/"+boots, true);		
	    xmlhttp.send();	    
        
        var att=$(this).closest("tr").find(".attack").attr('rel');
        var row = $('td.attack[rel="' + att + '"]').parent('tr');        row.find('#boots').val(boots);

		$('#incTable tr').each(function (i, row){
			if(i>0){
				var row = $(row);
				var rel = row.find(".attack").attr('rel');					
				if(rel == att){		
					//alert(rel);	
    				var time = startTime(row.find('#land').html(),row.find('#notice').html(),row.find('#details').val(),row.find('#unit').val(),row.find('#tsq').val(),row.find('#boots').val(),row.find('#art').val(),"{{Session::get('server.tsq')}}","{{Session::get('timezone')}}","{{Session::get('dateFormatLong')}}",{{Session::get('server.speed')}});
    				row.find("#start").html(time);
    				
    				var notice = new Date(row.find('#notice').html()).getTime();
    				var start = new Date(time).getTime();
    				if(notice-start<0){	
        				row.find("#start").css("color","red");		
    				}else{	
        				row.find("#start").css("color","black");	
    				}
				}
			}			
		}); 
              
	});
</script>
<script>
	$(document).on('change','#tsq',function(e){
		e.preventDefault();
		var id = $(this).closest("tr").attr("id");	var tsq=$(this).val();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {	console.log(xmlhttp.responseText);	}
	    };
	    xmlhttp.open("GET", "/defense/incomings/update/tsq/"+id+"/"+tsq, true);		
	    xmlhttp.send();	    
        
        var att=$(this).closest("tr").find(".attack").attr('rel');
        var row = $('td.attack[rel="' + att + '"]').parent('tr');		row.find('#tsq').val(tsq);

		$('#incTable tr').each(function (i, row){
			if(i>0){
				var row = $(row);
				var rel = row.find(".attack").attr('rel');					
				if(rel == att){		
    				var time = startTime(row.find('#land').html(),row.find('#notice').html(),row.find('#details').val(),row.find('#unit').val(),row.find('#tsq').val(),row.find('#boots').val(),row.find('#art').val(),"{{Session::get('server.tsq')}}","{{Session::get('timezone')}}","{{Session::get('dateFormatLong')}}",{{Session::get('server.speed')}});
    				row.find("#start").html(time);
    				
    				var notice = new Date(row.find('#notice').html()).getTime();
    				var start = new Date(time).getTime();
    				if(notice-start<0){	
        				row.find("#start").css("color","red");		
    				}else{	
        				row.find("#start").css("color","black");	
    				}
				}
			}			
		});       
	});
</script>
<script>
	$(document).on('change','#unit',function(e){
		e.preventDefault();
		var row = $(this).closest("tr")
		var id = row.attr("id");	var unit=$(this).val();
		//alert(id+'|||||'+boots);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
	        {	console.log(xmlhttp.responseText);	}
	    };
	    xmlhttp.open("GET", "/defense/incomings/update/unit/"+id+"/"+unit, true);		
	    xmlhttp.send();	

		var time = startTime(row.find('#land').html(),row.find('#notice').html(),row.find('#details').val(),row.find('#unit').val(),row.find('#tsq').val(),row.find('#boots').val(),row.find('#art').val(),"{{Session::get('server.tsq')}}","{{Session::get('timezone')}}","{{Session::get('dateFormatLong')}}",{{Session::get('server.speed')}});
		row.find("#start").html(time);
		
		var notice = new Date(row.find('#notice').html()).getTime();
		var start = new Date(time).getTime();
		if(notice-start<0){	row.find("#start").css("color","red");		
		}else{	row.find("#start").css("color","black");	}
	});
</script>
<script>	
	$(document).ready(function(){
		$('#incTable tr').each(function (i, row){
			if(i>0){
				var row = $(row);
				var id = '"'+row.attr("id")+'"';
				if(id !== '"undefined"'){
    				var time = startTime(row.find('#land').html(),row.find('#notice').html(),row.find('#details').val(),row.find('#unit').val(),row.find('#tsq').val(),row.find('#boots').val(),row.find('#art').val(),"{{Session::get('server.tsq')}}","{{Session::get('timezone')}}","{{Session::get('dateFormatLong')}}",{{Session::get('server.speed')}});
    				row.find("#start").html(time);
    				
    				var notice = new Date(row.find('#notice').html()).getTime();
    				var start = new Date(time).getTime();
    				if(notice-start<0){	row.find("#start").css("color","red");		
    				}else{	row.find("#start").css("color","black");	}
				}
			}			
		});		
	});
</script>
@endpush


