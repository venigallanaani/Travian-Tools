@extends('Calculators.template')

@section('body')

<!-- =================================== Cropper input screen================================== -->
    <div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-primary text-white col-md-12">
            <strong>Raid Troops Calculator</strong>
        </div>
        <div class="card-text mx-auto text-center mt-2">
            <form action="{{route('calcRaid')}}" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless  mx-auto mt-2">
                	<tr>
						<td colspan="2">
							<span class="px-2"><img alt="wood" src="/images/x.gif" class="res wood"> :<input size="2" type="text" name="wood" required value="0"></span>
							<span class="px-2"><img alt="clay" src="/images/x.gif" class="res clay"> :<input size="2" type="text" name="clay" required value="0"></span>
							<span class="px-2"><img alt="iron" src="/images/x.gif" class="res iron"> :<input size="2" type="text" name="iron" required value="0"></span>
							<span class="px-2"><img alt="crop" src="/images/x.gif" class="res crop"> :<input size="2" type="text" name="wheat" required value="0"></span>						
						</td>                	
                	</tr>
                	<tr>
						<td>
							<strong>Cranny Capacity:</strong><input size="3" type="text" name="cranny" required value="0">
						</td>    
						<td>
							<strong>Hero Equipment:</strong>
							<select name="hero">
								<option value="1">None</option>
								<option value="1.1">Pouch of the Theif (+10%)</option>
								<option value="1.15">Bag of the Theif (+15%)</option>
								<option value="1.2">Sack of the Theif (+20%)</option>								
							</select>
						</td>            	
                	</tr>
                	<tr>
						<td colspan="2"><strong>Raider Tribe:</strong>
    						<input type="radio" name="tribe" value=1 data-toggle="tooltip" data-placement="top" title="Roman"> <img alt="Roman" src="/images/x.gif" class="tribe Roman"> 
    						<input type="radio" name="tribe" value=3 data-toggle="tooltip" data-placement="top" title="Gaul"> <img alt="Gaul" src="/images/x.gif" class="tribe Gaul"> 
    						<input type="radio" name="tribe" value=2 data-toggle="tooltip" data-placement="top" title="Teuton"> <img alt="Teuton" src="/images/x.gif" class="tribe Teuton">
    						<input type="radio" name="tribe" value=7 data-toggle="tooltip" data-placement="top" title="Hun"> <img alt="Hun" src="/images/x.gif" class="tribe Hun">
    						<input type="radio" name="tribe" value=6 data-toggle="tooltip" data-placement="top" title="Egyptian"> <img alt="Egyptian" src="/images/x.gif" class="tribe Egyptian">
    					</td>
                	</tr>
                    <tr>
                    	<td colspan="2">
                            <button class="btn btn-outline-primary px-5" type="submit"><strong>Calculate</strong></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>        
    </div>    
    
    @yield('result') 
		
@endsection