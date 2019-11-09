@extends('Plus.template')

@section('body')

	<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
		<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Call Troops Details</strong></div>
		<div class="card-text">
			<div class="text-center col-md-11 mx-auto my-2 p-0">
				<p class="h4 py-2"><strong>Troops Contribution of {{$troops[0]['player']}}</strong></p>
    		@foreach(['danger','success','warning','info'] as $msg)
    			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
                @endif
            @endforeach            
                <table class="table table-bordered table-hover col-md-12 mx-auto">
    				<tr>	
    					<th class="p-0">Village</th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[0]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[0]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[1]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[1]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[2]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[2]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[3]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[3]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[4]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[4]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[5]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[5]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[6]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[6]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[7]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[7]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[8]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[8]['image']}}"></th>
    					<th class="p-0" data-toggle="tooltip" data-placement="top" title="{{$units[9]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[9]['image']}}"></th>  
    				</tr>
    				@php
    					$upkeep=0;	$defInf=0;	$defCav=0;	$res=0;
    				@endphp
    				@foreach($troops as $troop)
    					@php
    						$upkeep+=$troop->upkeep;
    						$defInf+=$troop->def_inf;
    						$defCav+=$troop->def_cav;
    						$res+=$troop->resources;
    					@endphp
    					<tr class="">
    						<td class="py-1">{{$troop->village}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit01)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit02)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit03)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit04)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit05)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit06)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit07)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit08)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit09)}}</td>
    						<td class="py-1 px-0">{{number_format($troop->unit10)}}</td>
    					</tr>				
    				@endforeach
    				<tr>	
    					<td colspan="3" rowspan="2" class="p-0 text-center align-middle" data-toggle="tooltip" data-placement="top" title="Total Troops">
    						<img alt="" src="/images/x.gif" class="res upkeep">: <strong>{{number_format($upkeep)}}</strong></td>
    					<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Total Defense">
    						<img alt="" src="/images/x.gif" class="stats def">: {{number_format($defInf + $defCav)}}</td>
    					<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Resources">
    						<img alt="" src="/images/x.gif" class="res all">: {{number_format($res)}}</td>								
    				</tr>
    				<tr>
    					<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Infantry Defense">
    						<img alt="" src="/images/x.gif" class="stats dinf">: {{number_format($defInf)}}</td>
    					<td colspan="4" class="p-0 text-center" data-toggle="tooltip" data-placement="top" title="Cavalry Defense">
    						<img alt="" src="/images/x.gif" class="stats dcav">: {{number_format($defCav)}}</td>								
    				</tr>
    			</table>            
			</div>
		</div>		
	</div>
@endsection