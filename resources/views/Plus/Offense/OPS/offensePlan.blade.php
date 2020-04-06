@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow mb-5">
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
                				<p class="py-0"><strong>Status : </strong>{{ucfirst(strtolower($plan->status))}}</p>
                				<p class="py-0"><strong>Created By : </strong>{{$plan->create_by}}</p>
                				<p class="py-0"><strong>Updated By : </strong>{{$plan->update_by}}</p>
                			</td>
                			<td class="text-center align middle">
                				<p class="my-0"><a href="/offense/plan/edit/{{$plan->id}}" target="_blank">
                					<button class="btn btn-primary btn-sm px-5">Edit Plan</button>
            					</a></p>
            					<p class="my-1"><a href="/offense/plan2/edit/{{$plan->id}}" target="_blank">
                					<button class="btn btn-primary btn-sm px-5">Edit Plan 2</button>
            					</a></p>
                				<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
                				@if(count($waves)!=0 && $plan->status =='DRAFT')
                					<p class="my-1"><button class="btn btn-success btn-sm px-5" name="publishPlan" value="{{$plan->id}}">Publish Plan</button></p>
            					@endif
            					@if($plan->status =='PUBLISH' || $plan->status == 'INPROGRESS')
            						<p class="my-1"><button class="btn btn-success btn-sm px-5" name="completePlan" value="{{$plan->id}}">Mark as Complete</button></p>
        						@endif
        							<p class="my-1"><button class="btn btn-warning btn-sm px-5" name="deletePlan" value="{{$plan->id}}">Delete Plan</button></p>
    							@if($plan->status == 'COMPLETE')
    								<p class="my-1"><button class="btn btn-secondary btn-sm px-5" name="archivePlan" value="{{$plan->id}}">Archive Plan</button></p>
								@endif
            					</form>
                			</td>                			
                		</tr>                    		
                	</table>
                </div>
            @if(count($waves)==0)
            	<div class="text-center col-md-11 mx-auto my-3">
            		<p class="h6">No attacks are planned yet</p>
            	</div>            
            @else	
        		<div class="float-md-left p-2 shadow rounded mx-auto" >
                	<div class="mx-auto">
                		<svg id="sankeyChart" width="800" height="300" style="margin:auto"></svg> 			 		
                	</div>
                </div>
				<div class="text-center col-md-11 mx-auto my-5 p-0">
					<table class="table align-middle small">
						<thead class="thead-inverse h6">
    						<tr>
    							<th class="">Attacker</th>
    							<th class="">Target</th>
    							<th class="">Type</th>
    							<th class="">Land Time</th>
    							<th class="">Waves</th>
    							<th class="">Units</th>
    							<th class="">Status</th>    							
    							<th class="">Comments</th>
    							<th class="">Report</th>  							
    						</tr>
						</thead>
						@foreach($waves as $wave)
							@php
                            	if($wave->type == 'Real'){	$color='text-danger';	}
                            	elseif($wave->type == 'Fake'){	$color='text-primary';	}
                            	elseif($wave->type == 'Cheif'){	$color='text-warning';	}
                            	elseif($wave->type == 'Scout'){	$color='text-success';	}
                            	else{	$color='text-dark';	}
                            @endphp	
    						<tr>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$wave->a_x}}&y={{$wave->a_y}}" target="_blank">
    								<strong>{{$wave->a_player}}</strong> ({{$wave->a_village}})</a>
    							</td>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$wave->d_x}}&y={{$wave->d_y}}" target="_blank">
    								<strong>{{$wave->d_player}}</strong> ({{$wave->d_village}})</a>
    							</td>
    							<td class="{{$color}}"><strong>{{$wave->type}}</strong></td>
    							<td>{{$wave->landtime}}</td>
    							<td>{{$wave->waves}}</td>
    							<td data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units {{$wave->unit}}"></td>
    							<td>{{$wave->status}}</td>    							
    							<td>{{$wave->comments}}</td>
    							<td>@if($wave->report!=null)    								
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
    	<script type="text/javascript" src="{{ asset('js/d3.v3.js')	}}"></script>
		<script type="text/javascript" src="{{ asset('js/sankey.js')}}"></script>
		<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    	{{	createSankey($sankeyData)	}}
	@endif
@endpush