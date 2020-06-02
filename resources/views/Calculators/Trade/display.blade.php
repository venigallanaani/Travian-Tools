@extends('Calculators.template')

@section('body')

<!-- =================================== Cropper input screen================================== -->
    <div class="card float-md-left p-0 col-md-12 shadow">
        <div class="card-header h5 py-1 bg-primary text-white col-md-12">
            <strong>Trade Routes Calculator</strong>
        </div>
        <div class="card-text mx-auto text-center mt-2">
            <form action="{{route('calcTrade')}}" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless h6 mx-auto mt-2">
                	<tr>
                		<td class="">Village Production</td>
						<td class="text-left">
							<span class="px-1"><img alt="wood" src="/images/x.gif" class="res wood"> <input type="number" name="wood" required value={{$input['wood']}} min=0 style="width:4em"></span>
							<span class="px-1"><img alt="clay" src="/images/x.gif" class="res clay"> <input type="number" name="clay" required value={{$input['clay']}} min=0 style="width:4em"></span>
							<span class="px-1"><img alt="iron" src="/images/x.gif" class="res iron"> <input type="number" name="iron" required value={{$input['iron']}} min=0 style="width:4em"></span>
							<span class="px-1"><img alt="crop" src="/images/x.gif" class="res crop"> <input type="number" name="crop" required value={{$input['crop']}} min=0 style="width:4em"></span>						
						</td>                	
                	</tr>
                	<tr>
						<td class="">Deliveries: 
							<select class="small" name="deliveries">
                                <option value='1' @if($input['delivery']==1) selected @endif>X 1</option>
                                <option value='2' @if($input['delivery']==2) selected @endif>X 2</option>
                                <option value='3' @if($input['delivery']==3) selected @endif>X 3</option>
                            </select>						
						</td>    
						<td class="">Frequency: 
							<select class="small" name="frequency">
                                <option value='24' @if($input['frequency']==24) selected @endif>1 hour</option>
                                <option value='12' @if($input['frequency']==12) selected @endif>2 hours</option>
                                <option value='8' @if($input['frequency']==8) selected @endif>3 hours</option>
                                <option value='6' @if($input['frequency']==6) selected @endif>4 hours</option>
                                <option value='4' @if($input['frequency']==4) selected @endif>6 hours</option>
                                <option value='3' @if($input['frequency']==3) selected @endif>8 hours</option>
                                <option value='2' @if($input['frequency']==2) selected @endif>12 hours</option>
                                <option value='1' @if($input['frequency']==1) selected @endif>24 hours</option>
                            </select> 
						</td>            	
                	</tr>
                	<tr>
						<td class="">Town Hall: <input type="number" name="townhall" required value= "{{$input['townhall']}}" min=0 max=20 style="width:2.5em"></td>    
						<td class="">Celebrations: 
							<input type="radio" name="party" value='none'  @if($input['party']=='none') checked @endif> None 
							<input type="radio" name="party" value='small'  @if($input['party']=='small') checked @endif> Small 
    						<input type="radio" name="party" value='great'  @if($input['party']=='great') checked @endif> Great 
    						
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