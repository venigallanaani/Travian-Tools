@extends('Plus.Defense.CFD.defenseTask')

@section('travel')
	
	<div>
	@if($travels==null)
		
		<p class="py-3 h5 text-danger">No available units can make it to the defense call</p>
	
	@else
		<table class="table table-bordered table-sm">
			<thead>
				<tr>
					<td><strong>Village</strong></td>
				@foreach($units as $unit)
					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}"></td>
				@endforeach
					<td class="px-0 py-1"><strong>Travel Time</strong></td>
					<td class="px-0 py-1"><strong>Start Time</strong></td>
				</tr>
			</thead>
		@foreach($travels as $travel)
			<tr>
				<td class="px-0 py-1 font-weight-bold"><a href="https://{{Session::get('server.url')}}/karte.php?x={{$travel['X']}}&y={{$travel['Y']}}" target="_blank">{{$travel['VILLAGE']}}</a></td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][0])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][1])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][2])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][3])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][4])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][5])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][6])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][7])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][8])}}</td>
				<td class="px-0 py-1">{{number_format($travel['TROOPS'][9])}}</td>
				<td class="px-0 py-1 text-primary font-weight-bold">{{$travel['TRAVEL']}}</td>
				<td class="px-0 py-1 text-primary font-weight-bold">{{$travel['START']}}</td>
			</tr>
		@endforeach			
		</table>
	@endif
	</div>
		
@endsection
