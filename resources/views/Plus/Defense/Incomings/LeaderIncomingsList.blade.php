@extends('Plus.Defense.Incomings.Template')

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
		<table class="table small mx-auto col-md-12 table-hover table-sm">
			<thead class="thead-inverse">
				<tr>
					<th class="col-md-1">Attacker</th>
					<th class="col-md-1">Start Time</th>
					<th class="col-md-1">Defender</th>
					<th class="col-md-1">Land Time</th>
					<th class="col-md-1">Waves</th>					
					<th class="col-md-1">Noticed Time</th>
					<th class="col-md-1">Hero</th>
					<th class="col-md-1">Tsq</th>
					<th class="col-md-1">Action</th>
					<th class="col-md-1">Updated By</th>
					<th class="col-md-2">Comments</th>
				</tr>
			</thead>
			@foreach($incomings as $incoming)
				@php
					if($incoming->ldr_sts=='Attack'){ $incoming = 'table-danger';	}
					elseif($incoming->ldr_sts=='Fake'){$incoming='table-primary';}
					elseif($incoming->ldr_sts=='Thinking'){$incoming='table-warning';}					
					else{$color='table-white';}					
				@endphp				
						
    			<tr class="{{$color}}" id={{$incoming->incid}}>
    				<td><a href="/finder/player/{{$incoming->att_player}}/1"><strong>{{$incoming->att_player}}</strong> 
    						({{$incoming->att_village}})</a></td>
					<td></td>
    				<td><a href="/finder/player/{{$incoming->def_player}}/1"><strong>{{$incoming->def_player}}</strong>
    						 ({{$incoming->def_village}})</a></td>
			 		<td>{{$incoming->landTime}}</td>
    				<td>{{$incoming->waves}}</td>
    				<td>{{$incoming->noticeTime}}</td>
    				<td>{{$incoming->hero}}</td>
    				<td><select><option>0</option>
    						<option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
    						<option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>
    						<option>11</option><option>12</option><option>13</option><option>14</option><option>15</option>
    						<option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>    						
    					</select>
    				</td>
    				<td><select name="type">
    						<option @if($incoming->ldr_sts=='New') selected @endif>New</option>
    						<option @if($incoming->ldr_sts=='Mark') selected @endif>Mark</option>
    						<option @if($incoming->ldr_sts=='Attack') selected @endif>Attack</option>
    						<option @if($incoming->ldr_sts=='Fake') selected @endif>Fake</option>
    						<option @if($incoming->ldr_sts=='Thinking') selected @endif>Thinking</option>
    						<option @if($incoming->ldr_sts=='Other') selected @endif>Other</option>
    					</select>
    				</td>
    				<td>{{$incoming->updated_by}}</td>
    				<td><input type="text" name="comment"></td>
    			</tr>
			@endforeach			
		</table>
		@endif			
	</div>
</div>			

@endsection