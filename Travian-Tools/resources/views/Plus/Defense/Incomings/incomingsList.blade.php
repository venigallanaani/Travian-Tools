@extends('Plus.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
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
					<th class="col-md-1">Updated By</th>
				</tr>
			</thead>
			@foreach($incomings as $incoming)
				@php
					if($incoming->ldr_sts=='Attack'){ $incoming = 'table-danger';	}
					elseif($incoming->ldr_sts=='Fake'){$incoming='table-primary';}
					elseif($incoming->ldr_sts=='Thinking'){$incoming='table-warning';}					
					else{$color='table-white';}					
				@endphp				
						
    			<tr class="{{$color}}">
    				<td><a href="/finder/player/{{$incoming->att_player}}/1"><strong>{{$incoming->att_player}}</strong></a> 
    						({{$incoming->att_village}})</td>
    				<td><a href="/finder/player/{{$incoming->def_player}}/1"><strong>{{$incoming->def_player}}</strong></a>
    						 ({{$incoming->def_village}})</td>
    				<td>{{$incoming->waves}}</td>
    				<td>{{$incoming->landTime}}</td>
    				<td>11:00:00</td>
    				<td>{{$incoming->hero}}</td>
    				<td>{{$incoming->ldr_sts}}</td>
    				<td>{{$incoming->updated_by}}</td>
    			</tr>
			@endforeach			
		</table>
		@endif			
	</div>
</div>			

@endsection