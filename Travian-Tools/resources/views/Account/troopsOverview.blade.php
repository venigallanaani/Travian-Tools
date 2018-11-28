@extends('Account.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-warning text-white">
				<strong>Troops Details</strong>
			</div>
			<div class="card-text">
        		<div class="text-center mx-2 my-4">
					<table class="table table-bordered col-md-12 p-0 mw-100 table-sm">
						<tr class="text-primary font-weight-bold h5">
							<td class="pr-0 py-1">Village</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Clubswinger">t01</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Spearman">t02</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Axeman">t03</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Scout">t04</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Paladin">t05</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Teutonic Knight">t06</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Ram">t07</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Catapult">t08</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Cheif">t09</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Settler">t10</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Total Units">#</td> 
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Tournament Square">Tsq</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Village Type">Type</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Icons">Edit</td>
						</tr>
						<tr class="small">
							<td>01 Thunderbolt</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>10000</td>
							<td>10</td>
							<td>Offense</td>
							<td></td>
						</tr>
						<tr class="small">
							<td>02 Barca</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>1000</td>
							<td>10000</td>
							<td>10</td>
							<td>Offense</td>
							<td></td>
						</tr>
						<tr class="font-weight-bold">
							<td>Total</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td colspan="2" class="text-left">120000</td>
							<td></td>
							<td></td>
						</tr>
        			</table>
        		</div>        		
			</div>	
			<div class="col-md-8 mx-auto mb-3 rounded" style="background-color:#dbeef4;">
				<p class="h4 text-center text-primary"><strong>Summary</strong></p>
    			<table class="table table-borderless">					
    				<tr>
    					<td class="py-1"><strong>Total Troops : </strong>20000</td>
    					<td class="py-1"></td>
    				</tr>
    				<tr>
    					<td class="py-1"><strong>Offense Troops : </strong>10000 (50%)</td>
    					<td class="py-1"><strong>Defense Troops : </strong>10000 (50%)</td>
    				</tr>
    			</table>
			</div>	
			<div class="col-md-8 mx-auto rounded mb-5 pt-2" style="background-color:#dbeef4;">
				<table>
					<tr>
						<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Troops Details</strong></p></td>
					</tr>
					<tr>
						<td class="align-middle px-2">
							<form>								
								<p><textarea rows="5" cols="25"></textarea>
								<p><button class="btn btn-primary">Update Troops</button></p>
							</form>
						</td>
						<td class="small font-italic align-middle px-2">
							<p>Enter the Troops page data here</p>
						</td>
					</tr>			
				</table>
			</div>				
		</div>


@endsection