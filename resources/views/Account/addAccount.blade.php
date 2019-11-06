@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow mb-5">
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
      				
					<form action="{{route('account')}}/find" method="POST" class="col-md-10 mx-auto text-center">
						{{ csrf_field() }}        						
						<p class="my-2">
							<strong>Travian Account Name: <input type="text" name="player" size="15" required></strong>
						</p>        						
						<p class="my-2">
							<button class="btn btn-warning px-5" name="addPlayer"><strong>Add Account</strong></button>
						</p> 						
					</form>
        		
        		
        		@if($players!= null)
        			<form action="{{route('account')}}/add" method="POST" class="col-md-8 mx-auto text-center mt-3">
        				{{csrf_field()}}
            			<table class="table table-sm table-bordered">
            				<tr class="bg-warning">
            					<th>Name</th>
            					<th>Tribe</th>
            					<th>Population</th>
            					<th></th>
            				</tr>
            			@foreach($players as $player)
            				<tr>
            					<td><a href="{{route('findPlayer')}}/{{ $player['ACCOUNT'] }}/1"><strong>{{ $player['ACCOUNT'] }}</strong></a></td>
            					<td data-toggle="tooltip" data-placement="top" title="{{ $player['TRIBE'] }}"><img alt="wo" src="/images/x.gif" class="tribe {{ $player['TRIBE'] }}"></td>
            					<td>{{$player['POP']}}</td>
            					<td><button class="btn btn-warning btn-sm" name="player" value="{{$player['UID']}}">Add Account</button></td>
            				</tr>
            			
            			@endforeach  
            			</table>
        			</form>      		
        		@endif
        		</div>	
			</div>  
		</div>
	

@endsection