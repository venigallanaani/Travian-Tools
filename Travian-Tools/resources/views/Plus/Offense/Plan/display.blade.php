@extends('layouts.opsPlan')

@section('content')

	<div class="my-1">
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
		<div class="float-md-left p-2 shadow rounded" >
    		<div class="mx-auto">
    			<svg id="sankeyChart" width="800" height="300" style="margin:auto"></svg>    		
    		</div>
		</div>	
	</div>
	@if(count($waves)==0)
	<div class="container">
		
		<p>No attacks added yet.</p>
	
	</div>	
	@else
	<div class="col-md-12 mx-auto text-center shadow">
		<table class="table table-hover table-sm small table-striped m-1">
			<tr class="bg-info text-white">
				<th class="col-md-2">Attacker</th>
				<th class="col-md-2">Target</th>
				<th class="col-md-1">Type</th>
				<th class="col-md-1">Waves</th>
				<th class="col-md-1">Troops</th>
				<th class="col-md-2">Land Time</th>
				<th class="col-md-2">Comments</th>
				<th></th>
			</tr>
		@foreach($waves as $wave)
			@php
				if($wave->type == 'Real'){	$color='text-danger';	}
				elseif($wave->type == 'Fake'){	$color='text-primary';	}
				else{	$color='text-dark';	}
			@endphp
			<tr>
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
				<td></td>
			</tr>			
		
		
		@endforeach	
		</table>
	</div>		
	
	@endif
	
	
	
	
	
	
@endsection
