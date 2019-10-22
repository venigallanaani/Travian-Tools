@extends('Calculators.WheatScout.display')

@section('result')
	<div class="card float-md-left my-1 p-0 col-md-12 shadow mb-5">
        <div class="card-header h4 py-2 bg-primary text-white col-md-12">
            <strong>Result</strong>
        </div>
        <div class="card-text mx-auto text-center mt-2">
        	<table class="table table-borderless mx-auto">
        		<tr>
        			<td class="py-1 px-5">Crop Difference - <img alt="" src="/images/x.gif" class="res upkeep"> <strong>{{number_format($result['DIFF'])}}</strong></td>   
        			<td class="py-1 px-5">Crop Difference/Hr - <img alt="" src="/images/x.gif" class="res upkeep"> <strong>{{number_format($result['CONS'])}}</strong></td>       			
        		</tr>
        		<tr>
        			<td class="py-1 px-5">Defense Upkeep - <img alt="" src="/images/x.gif" class="res upkeep"> <strong>{{number_format($result['DEFUP']*$result['ARTY'])}}</strong></td>
        			<td class="py-1 px-5">Reinforcements Upkeep - <img alt="" src="/images/x.gif" class="res upkeep"> <strong>{{number_format($result['REINUP']*$result['ARTY'])}}</strong></td>
        		</tr>
        		<tr>
        			<td colspan="2" class="py-1"><strong>Total Upkeep of units present in village - <img alt="" src="/images/x.gif" class="res upkeep"> {{number_format(($result['DEFUP'] + $result['REINUP'])*$result['ARTY'])}}</strong></td>
        			
        		</tr>
        	</table>
        	@if(count($result['CROP'])==1)
        	<table class="mx-auto my-2">
        		<tr>
        			<td colspan="2" class="text-danger"><strong><h4>Troops Away</h4></strong></td>
        		</tr>
        		<tr>
        			<td class="px-2"><img alt="" src="/images/x.gif" class="res upkeep"><strong> 
        			@if((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $result['CROP']['PROD'])/$result['ARTY'])-$result['POP']>0)
        				{{number_format((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $result['CROP']['PROD'])/$result['ARTY'])-$result['POP'])}}
    				@else
    					0
					@endif
        			</strong></td>
        			<td class="px-2"><img alt="" src="/images/x.gif" class="res upkeep"><strong> 
        			@if(((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $result['CROP']['PROD'])*1.25)/$result['ARTY'])-$result['POP']>0)
        				{{number_format(((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $result['CROP']['PROD'])*1.25)/$result['ARTY'])-$result['POP'])}}
        			@else
        				0
    				@endif	
    				</strong><span class="small font-italic text-primary"> (with Travian Plus)</span></td>
        		</tr>
        	</table>
        	@else
			<p><strong><h4><span class="text-danger">Troops Away (<img alt="" src="/images/x.gif" class="res upkeep">)</span></h4></strong></p>        			
        	<table class="mx-auto my-2 table table-bordered table-hover">
        		<tr>
        			<td class="text-primary p-1"><strong>Field Level</strong></td>
        			<td class="text-primary p-1"><strong>Normal</strong></td>
        			<td class="text-primary p-1"><strong>With Travian Plus</strong></td>
        		</tr>
        		@foreach($result['CROP'] as $level)
        		<tr>
        			<td class="p-1">{{$level['FIELD']}}</td>
        			<td class="p-1"> 
        				@if((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $level['PROD'])/$result['ARTY'])-$result['POP']>0)
        					{{number_format((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $level['PROD'])/$result['ARTY'])-$result['POP'])}}
        				@else 
        					0
        				@endif
    				</td>
        			<td class="p-1"> 
        				@if(((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $level['PROD'])*1.25)/$result['ARTY'])-$result['POP']>0)
        					{{number_format(((($result['CONS'] - $result['DEFUP'] - $result['REINUP'] + $level['PROD'])*1.25)/$result['ARTY'])-$result['POP'])}}
    					@else
    						0
						@endif
    				</td>
        		</tr>
        		@endforeach
        	</table>       	
        	@endif
    		<p class="small text-right px-5 text-primary font-italic">All the results are approximate values.</p>
		</div>
	</div>

@endsection