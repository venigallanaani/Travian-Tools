@extends('Account.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
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
    			<div class="col-md-8 mx-auto my-4 rounded" style="background-color:#dbeef4;">
    				<p class="h4 text-center text-primary"><strong>Summary</strong></p>
        			<table class="table table-borderless">					
        				<tr>
        					<td class="py-1"><strong>Total Troops : </strong>{{$stats['upkeep']}}</td>
        					<td class="py-1"><strong>Troop/Pop Ratio : </strong>{{round($stats['upkeep']/$stats['pop'],1)}} : 1</td>
        				</tr>
        				<tr>
        					<td class="py-1"><strong>Offense Troops : </strong>{{$stats['offense']}} ({{$stats['offratio']}}%)</td>
        					<td class="py-1"><strong>Defense Troops : </strong>{{$stats['defense']}} ({{$stats['defratio']}}%)</td>
        				</tr>
        			</table>
    			</div>

        		<div class="text-center mx-2 ">
					<table class="table table-bordered col-md-10 p-0 table-sm small mx-auto">
						<tr class="text-warning font-weight-bold h6">
							<td class="px-0 py-1">Village</td>
							@foreach($units as $unit)
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}"></td>
							@endforeach
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></td> 
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Tournament Square"><img alt="" src="/images/x.gif" class="build tsq"></td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Village Type">Type</td>
							<!-- <td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Icons"></td>  -->
						</tr>
					@foreach($troops as $index=>$troop)
						<tr class="">
							<td class="p-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$troop['x']}}&y={{$troop['y']}}" target="_blank">
								{{$troop['village']}}</a></td>
							<td class="p-0">{{$troop['unit01']}}</td>
							<td class="p-0">{{$troop['unit02']}}</td>
							<td class="p-0">{{$troop['unit03']}}</td>
							<td class="p-0">{{$troop['unit04']}}</td>
							<td class="p-0">{{$troop['unit05']}}</td>
							<td class="p-0">{{$troop['unit06']}}</td>
							<td class="p-0">{{$troop['unit07']}}</td>
							<td class="p-0">{{$troop['unit08']}}</td>
							<td class="p-0">{{$troop['unit09']}}</td>
							<td class="p-0">{{$troop['unit10']}}</td>
							<td class="p-0">{{$troop['upkeep']}}</td>
							<td class="p-0">{{$troop['Tsq']}}</td>
							<td class="py-0">{{$troop['type']}}</td>
							<!-- <td class="py-0 px-0">
								<form>
									{{ csrf_field() }}
									<input id="skype" name="skype" style="display:none">
									<button class="btn p-0 m-0" type="submit" value=""><i class="far fa-save"></i></button>
								</form>
							</td>  -->
						</tr>
					@endforeach
						<tr class="font-weight-bold">
							<td class="px-0">Total</td>
							<td class="px-0">{{$stats['unit01']}}</td>
							<td class="px-0">{{$stats['unit02']}}</td>
							<td class="px-0">{{$stats['unit03']}}</td>
							<td class="px-0">{{$stats['unit04']}}</td>
							<td class="px-0">{{$stats['unit05']}}</td>
							<td class="px-0">{{$stats['unit06']}}</td>
							<td class="px-0">{{$stats['unit07']}}</td>
							<td class="px-0">{{$stats['unit08']}}</td>
							<td class="px-0">{{$stats['unit09']}}</td>
							<td class="px-0">{{$stats['unit10']}}</td>
							<td class="px-0"colspan="2" class="">{{$stats['upkeep']}}</td>
							<!-- <td></td>
							<td></td>  -->
						</tr>
        			</table>
        		</div>        		
			</div>	

			<div class="col-md-8 mx-auto rounded mb-5 pt-2" style="background-color:#dbeef4;">
				<form method="post" action="/account/troops/update">	
					{{ csrf_field() }}
    				<table>
    					<tr>
    						<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Troops Details</strong></p></td>
    					</tr>
    					<tr>
    						<td class="align-middle px-2">							
								<p><textarea rows="3" cols="25" required name="troopStr"></textarea>														
    						</td>
    						<td class="small font-italic align-middle px-2">
    							<p>Enter the Troops page data here</p>
    							
    						</td>
    					</tr>
    					<tr>
    						<td colspan="2" class="text-center"><p><button class="btn btn-primary"><strong>Update Troops</strong></button></p></td>	
						</tr>			
				</table>
				</form>
			</div>				
		</div>


@endsection