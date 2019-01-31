@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Artifact Capture Plan</strong></div>
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
<!-- ================================= Artifact Coordinates Input ========================= -->
				<div class="card col-md-8 mx-auto m-4 p-0 text-center">
					<div class="card-header m-0 p-0 bg-info text-white">
						<p class="h5">Hammer expectations for clear</p>
					</div>
					<div class="card-body">
						<table class="table table-borderless table-sm">
							<tr>
								<td>Small Artifact (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="small" size="5" required></td>
								<td>Large Artifact (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="large" size="5" required></td>
							</tr>
							<tr>
								<td>Unique Artifact (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="unique" size="5" required></td>				
							</tr>
						</table>
					</div>
				</div>
				
				<div class="card col-md-10 mx-auto p-0 m-0 text-center">
					<div class="card-header m-0 p-0 bg-info text-white">
						<p class="h5">Artifact Coordinates</p>
					</div>
					<div class="card-body">
						<table class="table table-sm small">
							<tr>
								<th>Artifact</th>
								<th>Description</th>
								<th>Coordinates</th>
								<th>Priority</th>
								<th></th>
							</tr>
							<tr>
								<td>Small Trainer</td>
								<td>1/2 troops training time</td>
								<td>X:<input type="text" name="x" size="5">|Y:<input type="text" name="y" size="5"></td>
								<td><strong>Priority: </strong>
        								<select name="priority">
        									<option value="high">High</option>
        									<option value="medium">Medium</option>
        									<option value="low">Low</option>
        									<option value="none">None</option>
        								</select> 
								</td>
							</tr>
							<tr>
								<td>Small Trainer</td>
								<td>1/2 troops training time</td>
								<td>X:<input type="text" name="x" size="5">|Y:<input type="text" name="y" size="5"></td>
								<td><strong>Priority: </strong>
        								<select name="priority">
        									<option value="high">High</option>
        									<option value="medium">Medium</option>
        									<option value="low">Low</option>
        									<option value="none">None</option>
        								</select> 
								</td>
							</tr>
							<tr>
								<td>Small Trainer</td>
								<td>1/2 troops training time</td>
								<td>X:<input type="text" name="x" size="5">|Y:<input type="text" name="y" size="5"></td>
								<td><strong>Priority: </strong>
        								<select name="priority">
        									<option value="high">High</option>
        									<option value="medium">Medium</option>
        									<option value="low">Low</option>
        									<option value="none">None</option>
        								</select> 
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				
			</div>
		</div>

@endsection
