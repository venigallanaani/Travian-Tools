@extends('Plus.template')

@section('body')

	<!-- =============================================Plus Overview=========================================== -->
    <div class="card float-md-left col-md-10 p-0 mb-5 shadow">
        <div class="card-header h5 py-2 bg-info text-white">
            <strong>Online Timings</strong>
        </div>
        <div class="card-text text-center">
        	<p class="h6 py-1">Account Name - <a href="{{route('findPlayer')}}/{{$name}}/1" target="_blank">{{$name}}</a>
            <div class="col-md-11 mx-auto my-2 p-0">
            	@if($accounts==null)
            		<p class="h6 text-danger py-2">Online timings are not set by the account holders</p>
            	@else
            	@foreach($accounts as $account)
            		<div class="shadow rounded">
            		<p class="h6 py-1">Player Name - <a href="/plus/member/{{$account['id']}}" target="_blank">{{$account['name']}}</a></p>
            		<table class="table table-bordered col-md-11 mx-auto">
            		@foreach($week as $day)
						<tr class="small">
							<td class="text-left h6 align-middle table-warning" rowspan="4">{{ucfirst($day)}}</td>
							<td class="py-0 @if(in_array('1',$account['timings'][$day])) table-success @endif">00:00 - 01:00</td>
							<td class="py-0 @if(in_array('5',$account['timings'][$day])) table-success @endif">04:00 - 05:00</td>
							<td class="py-0 @if(in_array('9',$account['timings'][$day])) table-success @endif">08:00 - 09:00</td>
							<td class="py-0 @if(in_array('13',$account['timings'][$day])) table-success @endif">12:00 - 13:00</td>
							<td class="py-0 @if(in_array('17',$account['timings'][$day])) table-success @endif">16:00 - 17:00</td>
							<td class="py-0 @if(in_array('21',$account['timings'][$day])) table-success @endif">20:00 - 21:00</td>
						</tr>
						<tr class="small">							
							<td class="py-0 @if(in_array('2',$account['timings'][$day])) table-success @endif">01:00 - 02:00</td>
							<td class="py-0 @if(in_array('6',$account['timings'][$day])) table-success @endif">05:00 - 06:00</td>
							<td class="py-0 @if(in_array('10',$account['timings'][$day])) table-success @endif">09:00 - 10:00</td>
							<td class="py-0 @if(in_array('14',$account['timings'][$day])) table-success @endif">13:00 - 14:00</td>
							<td class="py-0 @if(in_array('18',$account['timings'][$day])) table-success @endif">17:00 - 18:00</td>
							<td class="py-0 @if(in_array('22',$account['timings'][$day])) table-success @endif">21:00 - 22:00</td>
						</tr>
						<tr class="small">							
							<td class="py-0 @if(in_array('3',$account['timings'][$day])) table-success @endif">02:00 - 03:00</td>
							<td class="py-0 @if(in_array('7',$account['timings'][$day])) table-success @endif">06:00 - 07:00</td>
							<td class="py-0 @if(in_array('11',$account['timings'][$day])) table-success @endif">10:00 - 11:00</td>
							<td class="py-0 @if(in_array('15',$account['timings'][$day])) table-success @endif">14:00 - 15:00</td>
							<td class="py-0 @if(in_array('19',$account['timings'][$day])) table-success @endif">18:00 - 19:00</td>
							<td class="py-0 @if(in_array('23',$account['timings'][$day])) table-success @endif">22:00 - 23:00</td>
						</tr>
						<tr class="small">							
							<td class="py-0 @if(in_array('4',$account['timings'][$day])) table-success @endif">03:00 - 04:00</td>
							<td class="py-0 @if(in_array('8',$account['timings'][$day])) table-success @endif">07:00 - 08:00</td>
							<td class="py-0 @if(in_array('12',$account['timings'][$day])) table-success @endif">11:00 - 12:00</td>
							<td class="py-0 @if(in_array('16',$account['timings'][$day])) table-success @endif">15:00 - 16:00</td>
							<td class="py-0 @if(in_array('20',$account['timings'][$day])) table-success @endif">19:00 - 20:00</td>
							<td class="py-0 @if(in_array('24',$account['timings'][$day])) table-success @endif">23:00 - 00:00</td>
						</tr>	
						<tr><td colspan="7" class="py-1"></td></tr>
            		@endforeach            		
            		</table>
            		</div>
            	@endforeach
            	@endif					
			</div>
        </div>
    </div>
@endsection