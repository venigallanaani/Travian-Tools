@extends('Account.template')

@section('body')
		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-warning text-white">
				<strong>Troops Details</strong>
			</div>
			<div class="card-text">
    	@foreach(['danger','success','warning','info'] as $msg)
    		@if(Session::has($msg))
    			<div class="col-md-10 mx-auto">
                	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                </div>
            @endif
        @endforeach
    			<div class="col-md-8 mx-auto py-2 my-4 rounded" style="background-color:#dbeef4;">
    				<p class="h4 text-center text-primary"><strong>Summary</strong></p>
        			<table class="table table-borderless">					
        				<tr>
        					<td class="py-1"><strong>Total Troops : </strong>{{number_format($stats['upkeep'])}}</td>
        					<td class="py-1"><strong>Troop/Pop Ratio : </strong>{{round($stats['upkeep']/$stats['pop'],1)}} : 1</td>
        				</tr>
        				<tr>
        					<td class="py-1"><strong>Offense Troops : </strong>{{number_format($stats['offense'])}} ({{$stats['offratio']}}%)</td>
        					<td class="py-1"><strong>Defense Troops : </strong>{{number_format($stats['defense'])}} ({{$stats['defratio']}}%)</td>
        				</tr>
        			</table>
    			</div>
				<form action="{{route("accountTroops")}}/update" method="post">
					{{csrf_field()}}
            		<div class="text-center mx-2 ">
    					<table class="table table-bordered col-md-10 p-0 table-sm mx-auto">
    						<tr class="text-warning font-weight-bold h6">
    							<td class="px-1 py-1">Village</td>
    							@foreach($units as $unit)
    							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}"></td>
    							@endforeach
    							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></td> 
    							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Tournament Square"><img alt="" src="/images/x.gif" class="build tsq"></td>
    							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Icons">Type</td>
    						</tr>
    					@foreach($troops as $index=>$troop)
    						<tr class="align-center">
    							<td class="px-1 py-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$troop['x']}}&y={{$troop['y']}}" target="_blank">
    								{{$troop['village']}}</a></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_1" value="{{$troop['unit01']}}" type="text" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_2" value="{{$troop['unit02']}}" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_3" value="{{$troop['unit03']}}" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_4" value="{{$troop['unit04']}}" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_5" value="{{$troop['unit05']}}" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_6" value="{{$troop['unit06']}}" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_7" value="{{$troop['unit07']}}" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_8" value="{{$troop['unit08']}}" style="width:4em; border:1px" class="p-0 m-0 text-center"></td>
								<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_9" value="{{$troop['unit09']}}" style="width:2em; border:1px" class="p-0 m-0 text-center"></td>
    							<td class="p-0 m-0 small"><input name="{{$troop['vid']}}_10" value="{{$troop['unit10']}}" style="width:2em; border:1px" class="p-0 m-0 text-center"></td>
    							<td class="px-2 py-0 small"><strong>{{number_format($troop['upkeep'])}}</strong></td>
    							<td class="p-0 m-0 text-right  small"><input name="{{$troop['vid']}}_tsq" value="{{$troop['Tsq']}}" style="width:3em; border:1px" class="p-0 m-0" type="number" min=0 max=20></td>
    							<td class="p-0 small">
                					<select name="{{$troop['vid']}}_type"  style="width:6em; border:2px">
    									<option value="NONE" 	@if($troop['type']=='NONE') selected 	@endif><span class="text-danger">None</span></option>
    									<option value="SUPPORT" @if($troop['type']=='SUPPORT') selected @endif>Support</option>
    									<option value="SCOUT" 	@if($troop['type']=='SCOUT') selected 	@endif>Scout</option>
    									<option value="DEFENSE" @if($troop['type']=='DEFENSE') selected @endif>Defense</option>
    									<option value="OFFENSE" @if($troop['type']=='OFFENSE') selected @endif>Offense</option>
    									<option value="GHOST" 	@if($troop['type']=='GHOST') selected	@endif>Ghost</option>
    									<option value="WWH" 	@if($troop['type']=='WWH') selected 	@endif>WWK/WWR</option>
    								</select>
    							</td>
    						</tr>
    					@endforeach
    						<tr class="">
    							<td class="px-0 py-0 font-weight-bold">Total</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit01'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit02'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit03'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit04'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit05'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit06'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit07'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit08'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit09'])}}</td>
    							<td class="px-0 small font-weight-bold">{{number_format($stats['unit10'])}}</td>
    							<td class="px-0 font-weight-bold" colspan="3"><img alt="" src="/images/x.gif" class="res upkeep"> {{number_format($stats['upkeep'])}}</td>
    							<!-- <td></td>
    							<td></td>  -->
    						</tr>
            			</table>
            			<p><button class="btn btn-lg btn-warning"><strong>Update Troops</strong></button></p>
            		</div> 
        		</form>       		
			</div>	

			<div class="col-md-8 mx-auto rounded mb-5 pt-2" style="background-color:#dbeef4;">
				<form method="post" action="{{route('accountTroops')}}/parse">	
					{{ csrf_field() }}
    				<table class="mx-auto">
    					<tr>
    						<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Troops Details</strong></p></td>
    					</tr>
    					<tr>
    						<td class="align-middle px-2">							
								<p><textarea rows="3" cols="25" required name="troopStr"></textarea></p>														
    						</td>
    						<td class="small font-italic align-middle px-2">
    							<p>Enter the Troops page data here</p>    							
    						</td>
    					</tr>
    					<tr>
    						<td colspan="2" class="text-center"><p><button class="btn btn-primary"><strong>Parse Troops</strong></button></p></td>	
						</tr>			
					</table>
				</form>
			</div>				
		</div>
@endsection
