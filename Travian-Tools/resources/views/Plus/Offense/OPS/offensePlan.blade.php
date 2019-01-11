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
                	<table class="table table-borderless table-sm text-left">
                		<tr>
                			<td class="align-middle">
                				<p><strong>Status : </strong>{{$plan->status}}</p>
                				<p><strong>Created By : </strong>{{$plan->create_by}}</p>
                				<p><strong>Updated By : </strong>{{$plan->update_by}}</p>
                			</td>
                			<td class="text-center align middle">
                				<a href="/offense/plan/edit/{{$plan->id}}" target="_blank">
                					<button class="btn btn-primary btn-sm px-5">Edit Plan</button>
            					</a>
        					@if(count($waves)!=0 && $plan->status =='DRAFT')
                				<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
                					<button class="btn btn-success btn-sm px-5" name="publishPlan" value="{{$plan->id}}">Publish Plan</button>
            					</form>
        					@endif
        					@if($plan->status =='PUBLISH' || $plan->status == 'INPROGRESS')
                				<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
                					<button class="btn btn-success btn-sm px-5" name="completePlan" value="{{$plan->id}}">Mark as Complete</button>
            					</form>
        					@endif
                				<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
                					<button class="btn btn-warning btn-sm px-5" name="deletePlan" value="{{$plan->id}}">Delete Plan</button>
            					</form>
        					@if($plan->status == 'COMPLETE')
        						<form action="/offense/status/update" method="post" class="my-1">{{csrf_field()}}
                					<button class="btn btn-secondary btn-sm px-5" name="archivePlan" value="{{$plan->id}}">Archive Plan</button>
            					</form>
        					@endif
                			</td>                			
                		</tr>                    		
                	</table>
                </div>
            @if(count($waves)==0)
            	<div class="text-center col-md-11 mx-auto my-2 p-0">
            		<p class="h5 my-5">No attacks are planned yet</p>
            	</div>            
            @else	
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table align-middle small">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Attacker</th>
    							<th class="col-md-1">Target</th>
    							<th class="col-md-1">Type</th>
    							<th class="col-md-1">Waves</th>
    							<th class="col-md-1">Troops</th>
    							<th class="col-md-1">Status</th>
    							<th class="col-md-1">Land Time</th>
    							<th class="col-md-1">Timer</th>
    							<th class="col-md-2">Comments</th>     							
    						</tr>
						</thead>
						@foreach($waves as $wave)
    						<tr>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$wave->a_x}}&y={{$wave->a_y}}" target="_blank">
    								<strong>{{$wave->a_player}} ({{$wave->a_village}})</strong></a>
    							</td>
    							<td><a href="https://{{Session::get('server.url')}}/karte.php?x={{$wave->d_x}}&y={{$wave->d_y}}" target="_blank">
    								<strong>{{$wave->d_player}} ({{$wave->d_village}})</strong></a>
    							</td>
    							<td>{{$wave->type}}</td>
    							<td>{{$wave->waves}}</td>
    							<td data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units {{$wave->unit}}"></td>
    							<td>{{$wave->status}}</td>
    							<td>{{$wave->landtime}}</td>
    							<td>00:00:00</td>
    							<td>{{$wave->comments}}</td>
    						</tr>
						@endforeach
					</table>
				</div>
			@endif
			</div>
		</div>
@endsection