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
		<p class="h5 pb-5 pt-2"> No incoming attacks saved for this profile</p>			
		@else			
		<table class="table mx-auto col-md-12 table-hover table-sm table-bordered shadow">
			<thead class="thead-inverse bg-info text-white">
				<tr>
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
					if($incoming['ldr_sts']=='Attack'){ $color = 'table-danger';	}
					elseif($incoming['ldr_sts']=='Fake'){$color='table-primary';}
					elseif($incoming['ldr_sts']=='Thinking'){$color='table-warning';}					
					else{$color='table-white';}					
				@endphp				
						
    			<tr class="{{$color}} small" id="{{$incoming['incid']}}">
    				<td><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['att_x']}}&y={{$incoming['att_y']}}" target="_blank"><strong>{{$incoming['att_player']}}</strong> 
    						({{$incoming['att_village']}}) </a></td>
					<td>{{$incoming['noticeTime']}}</td>
    				<td><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['def_x']}}&y={{$incoming['def_y']}}" target="_blank"><strong>{{$incoming['def_player']}}</strong>
    						 ({{$incoming['def_village']}})</a></td>
			 		<td></td>
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
    				<td><select id="action" name="type">
    						<option @if($incoming['ldr_sts']=='New') selected @endif>New</option>
    						<option @if($incoming['ldr_sts']=='Thinking') selected @endif>Thinking</option>
    						<option @if($incoming['ldr_sts']=='Attack') selected @endif>Attack</option>
    						<option @if($incoming['ldr_sts']=='Fake') selected @endif>Fake</option>    						
    						<option @if($incoming['ldr_sts']=='Other') selected @endif>Other</option>
    					</select>
    				</td>    				
    				<td><button class="btn btn-info btn-sm" id="details" name="button" value="{{$index}}" type="submit"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></td>
    			</tr>
    			<tr style="display: none;background-color:#dbeef4">
    				<td colspan="3" class="py-2">
    					<p class="py-0"><a href="/defense/attacker/{{$incoming['att_id']}}" target="_blank"><strong>Track Attacker <i class="fas fa-external-link-alt"></i></strong></a></p>
    					<p class="py-0"><strong>Hero XP - </strong>{{$incoming['hero']}}</p>
    					<p class="py-0"><strong>Notes - </strong><small>{{$incoming['comments']}}</small></p>
					</td>

    				<td colspan="7" class="py-2">
    					@if($incoming['CFD']==null)
        					<form action="/defense/incomings/cfd" method="post">
        						{{csrf_field()}}
        						<p class="py-0 h6"><strong>CFD Details</strong></p>
        						<p class="py-0"><strong>Defense Needed - </strong><input name="def" type="number" required style="width:5em" min="0">
        							<strong>Type - </strong>
            							<select name="type">
        									<option value="defend">Defend</option>
        									<option value="snipe">Snipe</option>
        									<option value="other">Other</option>
        								</select>    						
        						</p>
        						<p class="py-0"><button class="btn btn-sm btn-info" name="wave" value="{{$incoming['incid']}}" type="submit">Create CFD</button>
        					</form>	
    					@else
							<p class="py-0 h6"><a href="/defense/cfd/{{$incoming['CFD']['id']}}" target="_blank"><strong>CFD Details </strong><i class="fas fa-external-link-alt"></i></a></p>
							<p class="py-0">
								<span class="px-3 py-0"><strong>Total-</strong> {{number_format($incoming['CFD']['total'])}}</span>
								<span class="px-3 py-0"><strong>Type -</strong> {{$incoming['CFD']['type']}}</span>							
							</p>
							<p class="py-0"><strong>Filled -</strong> {{number_format($incoming['CFD']['filled'])}} ({{$incoming['CFD']['percent']}}%)</p>
    					@endif
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

		var wave = $(this).closest("tr");
		var id= wave.attr("id");
        var vid = wave.find('td:eq(1)').attr("id");
		
        
		var tsq = wave.find('td:eq(7)').find('select#tsq').val();
        
        alert(id);
	});
</script>
<script>
	$(document).on('change','#action',function(e){
		e.preventDefault();  
		
		var sts = $("#action option:selected").text();

		var col = $(this).closest('td');
		var row = $("#action option:selected").closest("tr");		
		
		if(sts == 'New'){
			row.addClass('table-primary');
		}
		if(sts == 'Thinking'){
			row.addClass('table-info');
		}
		if(sts == 'Fake'){
			row.addClass('table-success');
		}
		if(sts == 'Attack'){
			row.addClass('table-danger');
		}
		if(sts == 'Other'){
			row.addClass('table-secondary');
		}
        
        alert(sts);
	});

</script>
@endpush


