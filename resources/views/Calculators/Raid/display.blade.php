@extends('Calculators.template')

@section('body')

<!-- =================================== Cropper input screen================================== -->
    <div class="card float-md-left p-0 col-md-12 shadow">
        <div class="card-header h5 py-1 bg-primary text-white col-md-12">
            <strong>Raid Troops Calculator</strong>
        </div>
        <div class="card-text mx-auto h6 text-center mt-2">
            <form action="{{route('calcRaid')}}" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless  mx-auto mt-2">
                	<tr>
						<td colspan="2">
							<span class="px-2"><img alt="wood" src="/images/x.gif" class="res wood"> <input type="number" name="wood" required value=0 min=0 style="width:4em"></span>
							<span class="px-2"><img alt="clay" src="/images/x.gif" class="res clay"> <input ype="number" name="clay" required value=0 min=0 style="width:4em"></span>
							<span class="px-2"><img alt="iron" src="/images/x.gif" class="res iron"> <input type="number" name="iron" required value=0 min=0 style="width:4em"></span>
							<span class="px-2"><img alt="crop" src="/images/x.gif" class="res crop"> <input type="number" name="wheat" required value=0 min=0 style="width:4em"></span>						
						</td>                	
                	</tr>
                	<tr>
						<td>
							Cranny Capacity:<input type="number" name="cranny" required value=0 min=0 style="width:4em" >
						</td>    
						<td>Hero Equipment:
							<select name="hero"  style="width:10em; font-size:0.9em;">
								<option value="1">None</option>
								<option value="1.1">Pouch of the Theif (+10%)</option>
								<option value="1.15">Bag of the Theif (+15%)</option>
								<option value="1.2">Sack of the Theif (+20%)</option>								
							</select>
						</td>            	
                	</tr>
                	<tr>
						<td colspan="2" class="py-1">Raider Tribe:
    						<input type="radio" name="tribe" value=1> <img alt="Roman" src="/images/x.gif" class="tribe Roman" data-toggle="tooltip" data-placement="top" title="Roman"> 
    						<input type="radio" name="tribe" value=2> <img alt="Teuton" src="/images/x.gif" class="tribe Teuton" data-toggle="tooltip" data-placement="top" title="Teuton"> 
    						<input type="radio" name="tribe" value=3> <img alt="Gaul" src="/images/x.gif" class="tribe Gaul" data-toggle="tooltip" data-placement="top" title="Gaul"> 
    						<input type="radio" name="tribe" value=6> <img alt="Egyptian" src="/images/x.gif" class="tribe Egyptian" data-toggle="tooltip" data-placement="top" title="Egyptian"> 
    						<input type="radio" name="tribe" value=7> <img alt="Hun" src="/images/x.gif" class="tribe Hun" data-toggle="tooltip" data-placement="top" title="Hun">    						
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