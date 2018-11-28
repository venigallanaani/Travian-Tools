@extends('Plus.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
	<div class="card-header h4 py-2 bg-info text-white"><strong>Enter Incomings</strong></div>
	<div class="card-text">
		<div class="col-md-10 mx-auto rounded my-3 pt-2" style="background-color:#dbeef4;">
			<table>
				<tr>
					<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Incoming Details</strong></p></td>
				</tr>
				<tr>
					<td class="align-middle px-2">
						<form>								
							<p><textarea rows="3" cols="40"></textarea>
							<p><button class="btn btn-primary">Enter Incomings</button></p>
						</form>
					</td>
					<td class="align-middle px-2 small font-italic">
						<p>Enter the Troops page data here</p>
					</td>
				</tr>			
			</table>
		</div>
    			
		<div class="border border-info p-0 my-1 col-md-11 mx-auto">
			<table class="table table-borderless p-0 m-0 text-center">
				<tr>
					<td class="col-md-3 p-1 m-0 text-danger"><strong>Attacker</strong></td>
					<td class="col-md-6 small p-1 m-0">
						<a href="">Hero XP: </a><input name="hxp" type="text" size='5'/>
						<a href="">Off points: </a><input name="off" type="text" size='5'/>
						<a href="">Def points: </a><input name="def" type="text" size='5'/>
					</td>
					<td class="col-md-3 p-1 m-0 text-success"><strong>Defender</strong></td>
				</tr>    
				<tr>
					<td class="col-md-3 small p-1 m-0"><a href=""><strong>Player(village)</strong></a></td>
					<td class="col-md-6 small p-1 m-0"><a href=""><strong>Hero Equipment Details</strong></a></td>
					<td class="col-md-3 small p-1 m-0"><a href=""><strong>Player(village)</strong></a></td>
				</tr> 
				<tr>
					<td class="col-md-3 small p-1 m-0"><strong>Waves: </strong>4</td>
					<td class="col-md-6 small p-1 m-0">
						<select>
							<option value="">--Select Helm--</option>
							<option value="">T1 helm</option>
							<option value="">T2 helm</option>
							<option value="">T3 helm</option>
						</select>
						<select>
							<option value="">--Select Chest--</option>
							<option value="">T1 Chest</option>
							<option value="">T2 Chest</option>
							<option value="">T3 Chest</option>
						</select>
						<select>
							<option value="">--Select Boots--</option>
							<option value="">T1 Boots</option>
							<option value="">T2 Boots</option>
							<option value="">T3 Boots</option>
						</select>
					</td>
					<td class="col-md-3 small p-1 m-0"><strong>Noticed Time</strong></td>
				</tr> 
				<tr>
					<td class="col-md-3 small p-1 m-0"><strong>Start Time</strong></td>
					<td class="col-md-6 small p-1 m-0">
						<select>
							<option value="">--Select Right hand--</option>
							<option value="">T1 weapon</option>
							<option value="">T2 weapon</option>
							<option value="">T3 weapon</option>
						</select>
						<select>
							<option value="">--Select Left hand--</option>
							<option value="">T1 sheild</option>
							<option value="">T2 sheild</option>
							<option value="">T3 sheild</option>
						</select>
						<button class="btn btn-primary py-0">Enter</button>
					</td>
					<td class="col-md-3  small p-1 m-0"><strong>Land Time</strong></td>
				</tr> 		    			
			</table>
		</div>    			    			
	</div>
			
	<div class="col-md-12 mt-5 mx-auto text-center">
		<p class="h4 text-dark py-2 my-0 bg-warning"><strong>Your Incomings</strong></p>
		<table class="table small mx-auto col-md-11 table-hover table-sm">
			<thead class="thead-inverse">
				<tr>
					<th class="col-md-1">Attacker</th>
					<th class="col-md-1">Defender</th>
					<th class="col-md-1">Waves</th>
					<th class="col-md-1">Land Time</th>
					<th class="col-md-1">Timer</th>
					<th class="col-md-1">Hero</th>
					<th class="col-md-1">Action</th>
				</tr>
			</thead>
			<tr class="table-danger">
				<td><a href=""><strong>player1 (village)</strong></a></td>
				<td><a href=""><strong>Defender (village)</strong></a></td>
				<td>4</td>
				<td>18/11/2018 00:00:00</td>
				<td>11:00:00</td>
				<td>No Change</td>
				<td><strong>Real</strong></td>
			</tr>
			<tr class="table-white">
				<td>player2 (village)</td>
				<td>Defender (village)</td>
				<td>4</td>
				<td>18/11/2018 00:00:00</td>
				<td>11:00:00</td>
				<td>Changed</td>
				<td>Fake</td>
			</tr>
		</table>			
	</div>
</div>			

@endsection