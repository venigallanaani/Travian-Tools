@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Offense Plans Status</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
					
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
        
    		@if(count($plans)==0)
    			<p class="text-center h5 py-2">No archive plans are available</p>				
    		@else
    <!-- ==================================== List of CFD is progress ======================================= -->		
				<div class="text-center col-md-10 mx-auto my-2 p-0">
					<table class="table align-middle small table-hover">
						<thead class="thead-inverse">
    						<tr>
    							<th class="col-md-1">Name</th>    							
    							<th class="col-md-1">Status</th>
    							<th class="col-md-1">Attackers</th>
    							<th class="col-md-1">Targets</th>
    							<th class="col-md-1">Waves</th>
    							<th class="col-md-1">Created By</th>
    							<th class="col-md-1"></th>    							
    						</tr>
						</thead>
						@foreach($plans as $plan)
    						<tr class="">
    							<td><strong>{{$plan->name}}</strong></td>
    							<td>{{$plan->status}}</td>
    							<td>{{$plan->attackers}}</td>
    							<td>{{$plan->targets}}</td>
    							<td><strong><span class="text-danger">{{$plan->real}}</span> | <span class="text-primary">{{$plan->fake}}</span></strong></td>    							
    							<td><a href="/plus/member/{{$plan->create_by}}">{{$plan->create_by}}</a></td>    							
    							<td><a class="btn btn-outline-secondary" href="/offense/status/{{$plan->id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a>
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
			@endif
			</div>
		</div>

@endsection