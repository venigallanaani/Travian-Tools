@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the CFD tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Offense Plan - {{$plan->name}}</strong></div>
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
                	<svg id="sankeyChart" width="800" height="500" style="margin:auto"></svg>                	
                </div>
            @if(count($waves)==0)
            	<div class="text-center col-md-11 mx-auto my-2 p-0">
            		<p class="h5 my-5">No attacks are present in the archived plan</p>
            	</div>            
            @else	
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small">
						<thead class="thead-inverse">
    						<tr>
    							<th class="">Attacker</th>
    							<th class="">Target</th>
    							<th class="">Type</th>
    							<th class="">Land Time</th>
    							<th class="">Waves</th>
    							<th class="">Troops</th>
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
    								<strong>{{$wave->a_player}} ({{$wave->a_village}})</strong></a>
    							</td>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$wave->d_x}}&y={{$wave->d_y}}" target="_blank">
    								<strong>{{$wave->d_player}} ({{$wave->d_village}})</strong></a>
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
    	{{	createSankey($sankeyData)	}}
	@endif
@endpush