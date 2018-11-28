@extends('Account.template')
@section('body')

    <div class="card float-md-left col-md-9 mt-1 p-0 shadow">
    	<div class="card-header h4 py-2 bg-warning text-white">
    		<strong>Hero Details</strong>
    	</div>
    	<div class="card-text">
    		<div class="alert alert-success text-center my-1 mx-5" role="alert">
    	  		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
      			</button>
    			<strong>Hero data is successfully updated.</strong>
    		</div>
    		<div class="col-md-12 mx-auto m-5">
    			<table class="p-0 m-0 col-md-12">
    				<tr>
    					<td class="col-md-5">
    						<table class="mx-auto">
        						<tr>
        							<td class="p-0 text-primary"><strong>Name</strong></td><td>: Barca</td>
        						</tr>
        						<tr>
        							<td class="p-0 text-primary"><strong>Level</strong></td><td>: 12</td>
        						</tr>
        						<tr>
        							<td class="p-0 text-primary"><strong>Experience</strong></td><td>: 1234</td>
        						</tr>
        						<tr>
        							<td class="p-0 text-primary"><strong>Fighting Strength</strong></td><td>: 4300 (40)</td>
        						</tr>
        						<tr>
        							<td class="p-0 text-primary"><strong>Offense Bonus</strong></td><td>: 0% (0)</td>
        						</tr>
        						<tr>
        							<td class="p-0 text-primary"><strong>Defense Bonus</strong></td><td>: 0% (0)</td>
        						</tr>
        						<tr>
        							<td class="p-0 text-primary"><strong>Resources</strong></td><td>: 4</td>
        						</tr>
        					</table>
    					</td>
    					<td class="col-md-7 bg-secondary m-2">
    		        		<div class="">
                    			<p>Hero Points Pie Chart here</p>
                    		</div>
    					</td>
    				</tr>
    			</table>					
    		</div>        		
    		<div class="col-md-9 mx-auto rounded mb-5 pt-2 px-10" style="background-color:#dbeef4;">
    			<table>
    				<tr>
    					<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Hero Details</strong></p></td>
    				</tr>
    				<tr>
    					<td class="align-middle px-2">
    						<form>								
    							<p><textarea rows="5" cols="25"></textarea>
    							<p><button class="btn btn-primary">Update Hero</button></p>
    						</form>
    					</td>
    					<td class="align-middle px-2 small font-italic">
    						<p>Enter the Troops page data here</p>
    					</td>
    				</tr>			
    			</table>
    		</div>
    	</div>							
    </div>



@endsection