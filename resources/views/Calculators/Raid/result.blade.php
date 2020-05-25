@extends('Calculators.Raid.display')

@section('result')
	<div class="card float-md-left my-1 p-0 col-md-12 shadow mb-5">
        <div class="card-header h5 py-1 bg-primary text-white col-md-12">
            <strong>Result</strong>
        </div>
        <div class="card-text mx-auto text-center mt-2 ">
			<p class="">Effective Cranny Capacity - <strong>{{number_format($result['CRANNY'])}}</strong></p>  			
		@if($result['UNITS']!==null)
			<p class="">Total Raidable Resources - <strong>{{number_format($result['RESOURCES'])}}</strong></p> 
			<div class="my-3">
				<p class="h5 text-primary"><strong>Raiding Troops</strong></p>
				<table class="table table-bordered table-hover small col-md-10 mx-auto">
						<tr>						
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][0]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][0]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][1]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][1]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][2]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][2]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][3]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][3]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][4]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][4]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][5]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][5]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][6]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][6]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][7]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][7]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][8]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][8]['IMAGE']}}"></th>
							<th class="px-2 py-1" data-toggle="tooltip" data-placement="top" title="{{$result['UNITS'][9]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$result['UNITS'][9]['IMAGE']}}"></th> 
						</tr>
						<tr class="h6">
							<td class="py-1">{{number_format($result['UNITS'][0]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][1]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][2]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][3]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][4]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][5]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][6]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][7]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][8]['VALUE'])}}</td>
							<td class="py-1">{{number_format($result['UNITS'][9]['VALUE'])}}</td>
						</tr>
				</table>
			</div>
    		<p class="small text-right px-5 text-primary font-italic">All the results are approximate values.</p>
		@else
			<p class="text-danger">Total Raidable Resources - <strong>{{number_format($result['RESOURCES'])}}</strong></p> 
		@endif
		</div>
	</div>

@endsection