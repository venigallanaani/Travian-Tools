@extends('Plus.template')

@section('body')

	<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
		<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Call Troops Details</strong></div>
		<div class="card-text">
			<div class="text-center col-md-11 mx-auto my-2 p-0">
				<p class="h4 py-2">Defense in reach of CFD for Village-{{$task->village}} (Player-{{$task->player}})</p>
				<p class="h5 py-2">Target Time- <span class="text-primary">{{$task->target_time}}</span></p>
    		@foreach(['danger','success','warning','info'] as $msg)
    			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
                @endif
            @endforeach
        	
        	@if($villages == null)
        		<p class="py-3 h5 text-danger">No available units can make it to the defense call</p>
        	@else
                <table class="table table-sm table-bordered align-center table-hover col-md-12 shadow">
                	<thead class="font-weight-bold bg-info text-white">
                    	<tr>
                    		<td class="px-1 py-1">Player</td>
                    		<td class="px-1 py-1">Village</td>
                    		<td colspan="10" class="px-1 py-1">Troops</td>
                    		<td class="px-1 py-1">Total (<img alt="" src="/images/x.gif" class="res upkeep">)</td>
                    		<td class="px-1 py-1">Travel time</td>
                    		<td class="px-1 py-1">Start Time</td>
                    	</tr>
                	</thead>
            	@foreach($villages as $village)
            		<tr class="">
            			<td rowspan="2" class="px-1 py-1"><a href="{{route('findPlayer')}}/{{$village['PLAYER']}}/1" target="_blank">{{$village['PLAYER']}}</a></td>
            			<td rowspan="2" class="px-1 py-1"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$village['X']}}&y={{$village['Y']}}" target="_blank">{{$village['VILLAGE']}}</a></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][0]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][0]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][1]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][1]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][2]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][2]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][3]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][3]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][4]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][4]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][5]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][5]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][6]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][6]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][7]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][7]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][8]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][8]['IMAGE']}}"></td>
            			<td class="py-0 px-1" data-toggle="tooltip" data-placement="top" title="{{$village['UNITS'][9]['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$village['UNITS'][9]['IMAGE']}}"></td>            			
            			<td rowspan="2" class="px-1 py-1">{{number_format($village['UPKEEP'])}}</td>
            			<td rowspan="2" class="px-1 py-1">{{$village['TRAVEL']}}</td>
            			<td rowspan="2" class="px-1 py-1">{{$village['START']}}</td>            	
        			</tr>
        			<tr>
        				<td class="p-0">{{number_format($village['TROOPS'][0])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][1])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][2])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][3])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][4])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][5])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][6])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][7])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][8])}}</td>
        				<td class="p-0">{{number_format($village['TROOPS'][9])}}</td>
        			</tr>
            	@endforeach 
                </table>
            @endif
			</div>
		</div>		
	</div>
@endsection