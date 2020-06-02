@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-10 mb-5 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Archived Plans</strong></div>
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
    			<p class="text-center h5 py-5">No offense plans are archived</p>				
    		@else
    <!-- ==================================== List of CFD is progress ======================================= -->		
				<div class="text-center col-md-10 mx-auto my-2 p-0">
					<table class="table align-middle table-hover">
						<thead class="thead-inverse">
    						<tr>
    							<th class="">Name</th>    							
    							<th class="">Attackers</th>
    							<th class="">Targets</th>
    							<th class="">Waves</th>
    							<th class="">Created By</th>
    							<th class="">Date</th>
    							<th class=""></th>    							
    						</tr>
						</thead>
						@foreach($plans as $plan)
    						<tr class="small">
    							<td class="align-middle"><strong>{{$plan->name}}</strong></td>
    							<td class="align-middle">{{$plan->attackers}}</td>
    							<td class="align-middle">{{$plan->targets}}</td>
    							<td class="align-middle"><strong><span class="text-danger">{{$plan->real}}</span> | <span class="text-primary">{{$plan->fake}}</span> | <span class="text-dark">{{$plan->other}}</span></strong></td>    							
    							<td class="align-middle"><a href="/plus/member/{{$plan->create_by}}">{{$plan->create_by}}</a></td>   
    							<td class="align-middle">{{explode(' ',$plan->updated_at)[0]}}</td> 							
    							<td class="align-middle"><a class="btn btn-outline-secondary btn-sm" href="/offense/archive/{{$plan->id}}">
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