@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-10 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Offense Plans Status</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
				<div class="m-3">
            		<div class="card card-header text-center h6 btn btn-block collapsed bg-warning shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
                		<p class="p-0 m-0">
                    		<i class="fa fa-plus"></i> <span class=""><strong>Create New Offense Plan</strong></span>
        			 	</p>
            		</div>
            		<div class="collapse h6" id="task" style="">
              			<div class="card card-body shadow">
    						<form action="/offense/create" method="POST" class="col-md-10 mx-auto text-center" autocomplete="off">
        						{{ csrf_field() }}
        						<p class="my-2">
        							Plan Name: <input type="text" name="name" size="10" required>
        						</p>
        						<p class="my-2">
        							<button class="btn btn-info px-5" name="createOps">Create Plan</button>
        						</p> 						
    						</form>
              			</div>
            		</div>	
        		</div>		
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
    			<p class="text-center h6 py-3">No Offense plans are currently active.</p>				
    		@else
    <!-- ==================================== List of CFD is progress ======================================= -->		
				<div class="text-center col-md-10 mx-auto my-2 p-0">
					<table class="table align-middle table-hover small">
						<thead class="thead-inverse table-danger h6">
    						<tr>
    							<th class="">Plan Name</th>    							
    							<th class="">Status</th>
    							<th class="">Attackers</th>
    							<th class="">Targets</th>
    							<th class="">Waves</th>
    							<th class="">Created By</th>
    							<th class=""></th>    							
    						</tr>
						</thead>
						@foreach($plans as $plan)
    						<tr class="">
    							<td class="py-1">{{$plan->name}}</td>
    							<td class="py-1">{{ucfirst(strtolower($plan->status))}}</td>
    							<td class="py-1">{{$plan->attackers}}</td>
    							<td class="py-1">{{$plan->targets}}</td>
    							<td class="py-1"><strong>{{$plan->waves}} (
    								<span class="text-danger">{{$plan->real}}</span> | 
    								<span class="text-primary">{{$plan->fake}}</span> | 
    								{{$plan->other}} )</strong>
								</td>    							
    							<td class="py-1"><a href="/plus/member/{{$plan->create_by}}">{{$plan->create_by}}</a></td>    							
    							<td class="py-1"><small><a class="btn btn-outline-secondary btn-sm py-1" href="/offense/status/{{$plan->id}}">
    								<i class="fa fa-angle-double-right"></i> Details</a></small>
    							</td>
    						</tr>
						@endforeach
					</table>
				</div>
			@endif
			</div>
		</div>

@endsection