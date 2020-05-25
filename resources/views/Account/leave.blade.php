@extends('Account.template')

@section('body')
	<!-- =============================================Plus Overview=========================================== -->
    <div class="card float-md-left col-md-9 mt-1 p-0 shadow">
        <div class="card-header h5 py-2 bg-warning text-white">
            <strong>Delete account</strong>
        </div>
        <div class="text-center p-5 mx-auto">
            <table>
            	<tr>
            		<td colspan="2" class="h6">Are you sure you want to delete the Travian Tools account?</td>
            	</tr>
            	<tr>
            		<td class="py-3">
    					<form id="form" action="{{route('accountDelete')}}" method="POST">
    						{{ csrf_field() }}						
    						<button class="btn btn-danger px-5" type="submit">YES</button>						
    					</form>            			
            		</td>
            		<td class="py-3">
            			<a href="{{route('account')}}"><button class="btn btn-warning px-5">NO</button></a>
            		</td>
            	</tr>    
            </table>
        </div>        
    </div>
    	
@endsection