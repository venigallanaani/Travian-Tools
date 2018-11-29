@extends('Plus.template')

@section('body')

<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Defense Calls for Player (village)</strong></div>
			<div class="card-text">				
        <!-- ==================================== Defense Tasks Status ======================================= -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">				
		          <!-- ====================== Defense Task Details ====================== -->
					<p class="h4"><strong>Defense Call Details</strong></p>
			   <!-- ========== Alert about the update =================================== -->		
        			<div class="alert alert-danger text-center my-1 mx-5" role="alert">
          				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
        				</button>Village not found at the entered coordinates 
        			</div>
        			<div class="alert alert-success text-center my-1 mx-5" role="alert">
          				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
        				</button>Defense Task is updated successfully 
        			</div>
					<table class="table mx-auto col-md-10 table-borderless text-left">
						<tr>
							<td><strong>Target:</strong> Player (Village)</td>
							<td><strong>Land Time:</strong> 15/11/2018 00:00:00</td>
						</tr>
						<tr>
							<td><strong>Defense </strong>(<img alt="upkeep" src="/images/x.gif" class="res upkeep">): 10,000</td>
							<td><strong>Time Left: <span class="text-info">12:44:00</span></strong></td>
						</tr>
					</table>

				<!-- ================ Defense Troops Input data ========================== -->
					
					<form class="py-2 px-1 text-center rounded" style="background-color:#dbeef4">
						<p class="h5 text-info"><strong>Input Your Defense</strong></p>
						<div class="bg-white rounded">
    						<table class="table table-borderless col-md-11 mx-auto small">
    							<tr>
    								<td class="pr-0 pb-1">
    									<select>
    										<option>--select village--</option>
    										<option>Village 1</option>
    										<option>Village 2</option>
    									</select>
    								</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Clubswinger">t01</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Spearman">t02</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Axeman">t03</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Scout">t04</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Paladin">t05</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Teutonic Knight">t06</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Ram">t07</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Catapult">t08</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Cheif">t09</td>
    								<td class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Settler">t10</td>    								
    							</tr>
    							<tr>
    								<td class="pr-0 pt-1"><input type="text" name="xcor" size="2" /> | <input type="text" name="ycor" size="2" /></td>
    								<td class="px-0 pt-1" ><input type="text" name="unit01" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit02" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit03" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit04" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit05" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit06" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit07" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit08" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit09" size="5" /></td>
    								<td class="px-0 pt-1"><input type="text" name="unit10" size="5" /></td>    								
    							</tr>
    						</table>
    						<table class="table table-borderless col-md-8 mx-auto p-1 text-left">
    							<tr>
    								<td><strong>Resources: </strong><input type="text" name="resource" size="10" /></td>
    								<td><button class="btn btn-warning px-5"><strong>Submit</strong></button></td>
								</tr>    									
    						</table>    						
						</div>
					</form>
					
					<div class="my-3">
						<p class="h5"><strong>Your Contributions</strong></p>
						<table class="table table-hover">
							<thead  class="thead-inverse">
								<tr>
    								<th class="pr-0 pb-1">Village</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Clubswinger">t01</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Spearman">t02</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Axeman">t03</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Scout">t04</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Paladin">t05</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Teutonic Knight">t06</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Ram">t07</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Catapult">t08</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Cheif">t09</th>
    								<th class="px-0 pb-1" data-toggle="tooltip" data-placement="top" title="Settler">t10</th>  
								</tr>
							</thead>
							<tr>
								<td class="pr-0 pb-1 pt-0">village 1</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">100</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
							</tr>
							<tr>
								<td class="pr-0 pb-1 pt-0">village 2</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">100</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
								<td class="pr-0 pb-1 pt-0">0</td>
							</tr>
							<tr>
								<td colspan="6" class="pr-0 py-1"><strong>Total Defense:</strong> 200</td>
								<td colspan="5"  class="pr-0 py-1 text-left"><strong>Infantry Defense:</strong> 1000</td>
							</tr>
							<tr>
								<td colspan="6" class="pr-0 py-1"><strong>Resources:</strong> 1000</td>
								<td colspan="5"  class="pr-0 py-1 text-left"><strong>Cavalry Defense:</strong> 2000</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
@endsection