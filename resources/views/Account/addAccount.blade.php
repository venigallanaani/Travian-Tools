@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="card float-md-left col-md-12 col-12 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-warning text-white">
				<strong>Account Overview</strong>
			</div>
			<div class="card-text">
    		    <div class="card card-body shadow">          			          			
			@foreach(['danger','success','warning','info'] as $msg)
    			@if(Session::has($msg))
    	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                @endif
            @endforeach        
      				
					<form action="/account/add" method="POST" class="col-md-10 mx-auto text-center">
						{{ csrf_field() }}        						
						<p class="my-2">
							<strong>Travian Account Name: <input type="text" name="player" size="15" required></strong>
						</p>        						
						<p class="my-2">
							<button class="btn btn-warning px-5" name="addPlayer"><strong>Add Account</strong></button>
						</p> 						
					</form>
        		</div>	
			</div>  
		</div>
	

@endsection