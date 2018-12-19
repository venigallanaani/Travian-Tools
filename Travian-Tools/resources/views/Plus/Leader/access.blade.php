@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Leader Access</strong></div>
			<div class="card-text">
<!-- ==========================Add player and add alliance options ============================== -->
				<div class="m-3">
					<div class="card card-header text-center h6 btn btn-block collapsed bg-warning shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
                		<p class="p-0 m-0">
                    		<i class="fa fa-plus"></i> <span class=""><strong>Add Player to Group</strong></span>
        			 	</p>
            		</div>
            		<div class="collapse" id="task" style="">
              			<div class="card card-body shadow">
    						<form action="/defense/cfd/create" method="POST" class="col-md-10 mx-auto text-center">
        						{{ csrf_field() }}        						
        						<p class="my-2">
        							<strong>Player Name <input type="text" name="player" size="15" required></strong>
        						</p>        						
        						<p class="my-2">
        							<button class="btn btn-info px-5" name="addPlayer"><strong>Add Player</strong></button>
        						</p> 						
    						</form>
              			</div>
            		</div>	
				</div>				
		<!-- ============================ Add success/failure notifications ============================== -->
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
		<!-- =========================== leadership Options control panel ================================ -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table table-hover table-sm table-bordered align-middle small">
						<thead class="bg-dark text-white">
    						<tr>
    							<th class="col-md-2" rowspan="2">Player</th>
    							<th class="col-md-2" rowspan="2">Account</th>
    							<th class="col-md-2" rowspan="2">Account</th>
    							<th class="col-md-1" rowspan="2">Plus</th>
    							<th colspan="6">Leadership Options</th>
    						</tr>
    						<tr class="">
    							<th class="col-md-1">Leader</th>
    							<th class="col-md-1">Defense</th>
    							<th class="col-md-1">Offense</th>
    							<th class="col-md-1">Resources</th>
    							<th class="col-md-1">Artifacts</th>
    							<th class="col-md-1">Wonder</th>
    						</tr>
						</thead>
						<tr class="">
							<td>Barca1</td>
							<td>Admin1</td>
							<td>Alliance1</td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="defense" checked></td>
							<td><input type="checkbox" name="offense" checked></td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="resource" checked></td>
							<td><input type="checkbox" name="artifact" checked></td>
							<td><input type="checkbox" name="wonder" checked></td>
						</tr>
						<tr class="">
							<td>Barca2</td>
							<td>Admin2</td>
							<td>Alliance2</td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="defense" checked></td>
							<td><input type="checkbox" name="offense" checked></td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="resource" checked></td>
							<td><input type="checkbox" name="artifact" checked></td>
							<td><input type="checkbox" name="wonder" checked></td>
						</tr>
						<tr class="">
							<td>Barca3</td>
							<td>Admin3</td>
							<td>Alliance3</td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="defense" checked></td>
							<td><input type="checkbox" name="offense" checked></td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="resource" checked></td>
							<td><input type="checkbox" name="artifact" checked></td>
							<td><input type="checkbox" name="wonder" checked></td>
						</tr>
						<tr>
							<td>Barca3</td>							
							<td>Admin3</td>
							<td>Alliance3</td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="defense" checked></td>
							<td><input type="checkbox" name="offense" checked></td>
							<td><input type="checkbox" name="leader" checked></td>
							<td><input type="checkbox" name="resource" checked></td>
							<td><input type="checkbox" name="artifact" checked></td>
							<td><input type="checkbox" name="wonder" checked></td>
						</tr>
					</table>
				</div>			
			</div>
@endsection
