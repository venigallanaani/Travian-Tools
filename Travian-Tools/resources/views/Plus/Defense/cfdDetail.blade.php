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
        				</button>Failed to update the tasks. 
        			</div>
        			<div class="alert alert-success text-center my-1 mx-5" role="alert">
          				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        					<span aria-hidden="true">&times;</span>
        				</button>Defense Task is updated successfully 
        			</div>
        			
        			<!-- ===============Defense task details =========================== -->
					<table class="table mx-auto col-md-11 table-borderless text-center small rounded" style="background-color:#dbeef4;">
						<form action="/defense/cfd/12345" method="POST">
    						<tr>
    							<td class="pt-1 pb-0"><strong>Created By:</strong> Account Name</td>
    							<td class="pt-1 pb-0"><strong>Last Updated By:</strong> Account Name</td>
    						</tr>
    						<tr>
    							<td class="pt-1 pb-0"><strong>Defense Needed:</strong> <input type="text" name="defNeed" size="5" value="10000"/></td>
    							<td class="pt-1 pb-0"><strong>Defense Received: </strong>5000</td>
    						</tr>
    						<tr>
    							<td class="pt-1 pb-0"><strong>Land Time:</strong> <input type="text" name="defNeed" size="15" value="15/11/2018 00:00:00"/></td>
    							<td class="pt-1 pb-0"><strong>Defense Remaining: </strong>5000</td>
    						</tr>
    						<tr>
    							<td class="pt-1 pb-0"><strong>Defense Priority:</strong> 
    								<select>
    									<option>High</option>
    									<option>Medium</option>
    									<option>Low</option>
    								</select>
    							</td>
    							<td class="pt-1 pb-0"><strong>Infantry Defense: </strong>5000</td>
    						</tr>
    						<tr>
    							<td class="pt-1 pb-0"><strong>Defense Type:</strong> 
    								<select>
    									<option>Defend</option>
    									<option>Snipe</option>
    									<option>Scout</option>
    									<option>Other</option>
    								</select>
    							</td>
    							<td class="pt-1 pb-0"><strong>Cavalry Defense: </strong>5000</td>
    						</tr>
    						<tr>
    							<td class="pt-1 pb-0"><strong>Remaining Time: <span class="text-primary">10:12:00</span></strong></td>
    							<td class="pt-1 pb-0"><strong>Resources: </strong>5000</td>
    						</tr>
    						<tr>
    							<td colspan="2">
    								<button class="btn btn-primary px-5" name="update">Update Task</button>
    								<button class="btn btn-success px-5" name="complete">Mark as Complete</button>
    								<button class="btn btn-warning px-5" name="delete">Delete Task</button>
    							</td>
    						</tr>
						</form>
					</table>

					<!-- ===================== Displays the incoming troops and types ============================================ -->
					<div class="my-5">
						<p class="h5 text-info"><strong>Incoming Defense</strong></p>
						<table class="table table-bordered table-hover small col-md-10 mx-auto">
							<tr>	
								<th rowspan="2">Teuton</th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Clubswinger"><img alt="" src="/images/x.gif" class="units t01"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Spearman"><img alt="" src="/images/x.gif" class="units t02"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Axeman"><img alt="" src="/images/x.gif" class="units t03"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Scout"><img alt="" src="/images/x.gif" class="units t04"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Paladin"><img alt="" src="/images/x.gif" class="units t05"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Teutonic Knight"><img alt="" src="/images/x.gif" class="units t06"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Ram"><img alt="" src="/images/x.gif" class="units t07"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units t08"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Cheif"><img alt="" src="/images/x.gif" class="units t09"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Settler"><img alt="" src="/images/x.gif" class="units t10"></th>  
							</tr>
							<tr>
								<td class="py-1">1000</td>
								<td class="py-1">100</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
							</tr>
							<tr>
								<th rowspan="2">Roman</th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Phalanx"><img alt="" src="/images/x.gif" class="units r01"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="SwordMan"><img alt="" src="/images/x.gif" class="units r02"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Scout"><img alt="" src="/images/x.gif" class="units r03"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="TT"><img alt="" src="/images/x.gif" class="units r04"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Druid"><img alt="" src="/images/x.gif" class="units r05"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Hauden"><img alt="" src="/images/x.gif" class="units r06"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Ram"><img alt="" src="/images/x.gif" class="units r07"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units r08"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Cheif"><img alt="" src="/images/x.gif" class="units r09"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Settler"><img alt="" src="/images/x.gif" class="units r10"></th>  
							</tr>
							<tr>
								<td class="py-1">1000</td>
								<td class="py-1">100</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
							</tr>
							<tr>
								<th rowspan="2">Gaul</th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Phalanx"><img alt="" src="/images/x.gif" class="units g01"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="SwordMan"><img alt="" src="/images/x.gif" class="units g02"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Scout"><img alt="" src="/images/x.gif" class="units g03"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="TT"><img alt="" src="/images/x.gif" class="units g04"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Druid"><img alt="" src="/images/x.gif" class="units g05"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Hauden"><img alt="" src="/images/x.gif" class="units g06"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Ram"><img alt="" src="/images/x.gif" class="units g07"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="" src="/images/x.gif" class="units g08"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Cheif"><img alt="" src="/images/x.gif" class="units g09"></th>
								<th class="p-0" data-toggle="tooltip" data-placement="top" title="Settler"><img alt="" src="/images/x.gif" class="units g10"></th>  
							</tr>
							<tr>
								<td class="py-1">1000</td>
								<td class="py-1">100</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
								<td class="py-1">1000</td>
							</tr>
						</table>
					</div>
				<!-- ============================== Table of all the players and defense details =============================== -->
					<div class="my-5">
						<p class="h5 text-info"><strong>Player Contributions</strong></p>
						<table class="table table-bordered col-md-8 mx-auto table-hover">
							<tr class="bg-info text-white">
								<th class="py-1 h5">#</th>
								<th class="py-1 h5">Player</th>
								<th class="py-1 h5">Defense</th>
								<th class="py-1 h5">%</th>
								<th class="py-1 h5">Resources</th>
							</tr>
							<tr>		
								<td class="py-1">1</td>
								<td class="py-1">Barca</td>
								<td class="py-1">1500</td>
								<td class="py-1">15%</td>
								<td class="py-1">1000</td>
							</tr>
							<tr>		
								<td class="py-1">2</td>
								<td class="py-1">Tyr</td>
								<td class="py-1">1250</td>
								<td class="py-1">12.5%</td>
								<td class="py-1">1000</td>
							</tr>
							<tr>		
								<td class="py-1">3</td>
								<td class="py-1">Neo</td>
								<td class="py-1">1000</td>
								<td class="py-1">10%</td>
								<td class="py-1">1000</td>
							</tr>
						</table>					
					</div>
					
				</div>
			</div>
		</div>

@endsection