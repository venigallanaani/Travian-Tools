@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-warning text-white">
				<strong>Account Overview</strong>
			</div>
			<div class="card-text">
        		<div>
        			<table class="table table-borderless col-md-8 mx-auto mt-3">
        				<tr>
        					<td>
        						<table class="table table-borderless mx-3 text-left">
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Profile Name</span></strong></td>
        								<td class="py-1">: <a href="">Barca</a></td>
        							</tr>
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Rank</span></strong></td>
        								<td class="py-1">: 100</td>
        							</tr>
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Population</span></strong></td>
        								<td class="py-1">: 1234</td>
        							</tr>
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Villages</span></strong></td>
        								<td class="py-1">: 10</td>
        							</tr>
        						</table>
        					</td>
        					<td>        						
        						<table class="table table-borderless mx-3 text-left">
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Tribe</span></strong></td>
        								<td class="py-1">: Teuton</td>
        							</tr>
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Alliance Name</span></strong></td>
        								<td class="py-1">: <a href="">1812</a></td>
        							</tr>
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Dual Password</span></strong></td>
        								<td class="py-1">: ASDFG</td>
        							</tr>
        							<tr>
        								<td class="py-1"><strong><span class="text-warning">Plus Group</span></strong></td>
        								<td class="py-1">: <a href="">Group1</a></td>
        							</tr>
        						</table>
    						</td>
        				</tr>
        			</table>
        		</div>
        		
        		<div class="col-md-7 ml-5 text-center mt-3 float-md-left">
        			<table class="table table-bordered text-center table-sm">
        			   	<tr>        					
        					<td colspan="2" class="h4 text-white bg-warning"><strong>Ingame Links</strong></td>
        				</tr>
        				<tr>        					
        					<td class="h5"><a href=""><strong>Attack Points</strong></a></td>
        					<td class="h5"><a href=""><strong>Defense Points</strong></a></td>
        				</tr>
        			</table>        		

        			<table class="table table-bordered table-hover table-sm">
        				<thead class="thead">
        					<tr>
        						<th colspan="4" class="h4 text-white bg-warning"><strong>Villages</strong></th>
        					</tr>
        					<tr>
        						<th class="col-md-1">#</th>
        						<th class="col-md-4">Village Name</th>
        						<th class="col-md-1">Population</th>
        						<th class="col-md-1">Coordinates</th>
        					</tr>
        				</thead>
        				<tr>
        					<td>1</td>
        					<td class="text-left">01 thunderbolt</td>
        					<td>168</td>
        					<td><a href="">1|-46</a></td>
    					</tr>
    					<tr>
        					<td>2</td>
        					<td class="text-left">02 Barcelona</td>
        					<td>168</td>
        					<td><a href="">1|-46</a></td>
    					</tr>
    					<tr>
        					<td>3</td>
        					<td class="text-left">03 Alps</td>
        					<td>168</td>
        					<td><a href="">1|-46</a></td>
    					</tr>
        			</table>
        		</div>
        		
        		<div class="col-md-4 bg-secondary float-md-left mt-3 rounded h-50">
        			<p>Tribe Image -- tribe.png</p>
        		</div>
			</div>			
		</div>
	

@endsection