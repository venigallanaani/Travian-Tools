@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-10 mb-5 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Offense Plan - {{$plan->name}}</strong></div>
			<div class="card-text">
    <!-- ==================================== List of CFD is progress ======================================= -->
				
        		@foreach(['danger','success','warning','info'] as $msg)
        			@if(Session::has($msg))
        	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>{{ Session::get($msg) }}
                        </div>
                    @endif
                @endforeach	
                
                <div class="text-center col-md-8 mx-auto p-2">
                	<table class="table table-borderless table-sm text-left" style="font-size:0.9em">
                		<tr>
                			<td class="align-middle py-0">
                				<p class="py-0 my-1"><strong>Status : </strong>{{ucfirst(strtolower($plan->status))}}</p>
                				<p class="py-0 my-1"><strong>Created By : </strong>{{$plan->create_by}}</p>
                				<p class="py-0 my-1"><strong>Updated By : </strong>{{$plan->update_by}}</p>
                			</td>
                			<td class="text-center align middle">
            					<form action="/offense/archive/update" method="post" class="my-1">{{csrf_field()}}
        							<p class="my-1"><button class="btn btn-info btn-sm px-5" name="plan" value="{{$plan->id}}">Copy Plan</button></p>
            					</form>
                				<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
        							<p class="my-1"><button class="btn btn-danger btn-sm px-5" name="deletePlan" value="{{$plan->id}}">Delete Plan</button></p>
            					</form>
                			</td>                			
                		</tr>                    		
                	</table>
                </div>
            @if($sankeyData!=null)
                <div class="text-center col-md-8 mx-auto p-2">
                	<svg id="sankeyChart" width="800" height="500" style="margin:auto"></svg>                	
                </div>
            @endif
            @if(count($waves)==0)
            	<div class="text-center col-md-11 mx-auto my-2 p-0">
            		<p class="h5 my-5">No attacks are present in the archived plan</p>
            	</div>            
            @else	
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle">
						<thead class="thead-inverse h6">
    						<tr>
    							<th class="" style="width:8em">Attacker</th>
    							<th class="" style="width:8em">Target</th>
    							<th class="" style="width:8em">Land Time</th>
    							<th class="" style="width:4em">Type</th>    							
    							<th class="" style="width:3em">Waves</th>
    							<th class="" style="width:3em">Troops</th>
    							<th class="" style="width:8em">Notes</th>
    							<th class="" style="width:5em">Report</th>  							
    						</tr>
						</thead>
						@foreach($waves as $wave)
							@php
                            	if($wave->type == 'REAL'){	$color='text-danger';	}
                            	elseif($wave->type == 'FAKE'){	$color='text-primary';	}
                            	elseif($wave->type == 'CHIEF'){	$color='text-warning';	}
                            	elseif($wave->type == 'SCOUT'){	$color='text-success';	}
                            	else{	$color='text-dark';	}
                            @endphp	
    						<tr class="small">
    							<td class="py-0 align-middle"><a href="https://{{Session::get('server.url')}}/karte.php?x={{$wave->a_x}}&y={{$wave->a_y}}" target="_blank">
    								<strong>{{$wave->a_player}} ({{$wave->a_village}})</strong></a>
    							</td>
    							<td class="py-0 align-middle"><a href="https://{{Session::get('server.url')}}/karte.php?x={{$wave->d_x}}&y={{$wave->d_y}}" target="_blank">
    								<strong>{{$wave->d_player}} ({{$wave->d_village}})</strong></a>
    							</td>    							
    							<td class="py-0 align-middle">{{$wave->landtime}}</td>
    							<td class="{{$color}} py-0 align-middle"><strong>{{ucfirst(strtolower($wave->type))}}</strong></td>
    							<td class="py-0 align-middle">{{$wave->waves}}</td>
    							<td class="py-0 align-middle" data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units {{$wave->unit}}"></td>  							
    							<td class="py-0 align-middle small">{{$wave->notes}}</td>
    							<td class="py-0 align-middle">
    								@if($wave->report!=null)    								
    									<a href="{{$wave->report}}" target="_blank">Report</a>
    								@endif
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
			@endif
			</div>
		</div>
@endsection

@push('scripts')
    @if(!$sankeyData==null)
    	{{	createSankey($sankeyData)	}}
	@endif
@endpush