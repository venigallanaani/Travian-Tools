@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="card float-md-left col-md-10 mt-1 p-0 mb-5 shadow">
			<div class="card-header h5 py-2 bg-warning text-white">
				<strong>Account Overview</strong>
			</div>
			<div class="card-text">
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach  
        		<div>
        			<table class="table table-borderless col-md-5 mx-auto my-3 h6">
						<tr>
							<td class="py-1"><strong><span class="text-warning">Profile Name</span></strong></td>
							<td class="py-1">: <strong>{{$player->player}}</strong></td>
						</tr>
						<tr>
							<td class="py-1"><strong><span class="text-warning">Rank</span></strong></td>
							<td class="py-1">: {{$player->rank}}</td>
						</tr>
						<tr>
							<td class="py-1"><strong><span class="text-warning">Alliance Name</span></strong></td>
							<td class="py-1">: <a href="{{route('findAlliance')}}/{{$player->alliance}}/1" target="_blank"><strong>{{$player->alliance}}</strong></a></td>
						</tr>
						<tr>
							<td class="py-1"><strong><span class="text-warning">Population</span></strong></td>
							<td class="py-1">: {{$player->population}}
                            	<small>
                            	@if($player->diffpop>0)
                            		<span class="text-success">({{$player->diffpop}})</span>
                        		@else
                        			<span class="text-danger">({{$player->diffpop}})</span>
                        		@endif
                            	</small>
							</td>
						</tr>
						<tr>
							<td class="py-1"><strong><span class="text-warning">Villages</span></strong></td>
							<td class="py-1">: {{$player->villages}}</td>
						</tr>
						<tr>
							<td class="py-1"><strong><span class="text-warning">Tribe</span></strong></td>
							<td class="py-1">: {{$account->tribe}}</td>
						</tr>
						<tr>
							<td colspan="2" class="text-center py-1 h5"><strong><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$account->uid}}" target="_blank">Travian Profile  <i class="fas fa-external-link-alt"></i></a></strong></td>
						</tr>     
        			</table>
        		</div>
        		
        		<div class="col-md-8 text-center mt-3 mx-auto">
        			<table class="table table-bordered table-hover table-sm">
        				<thead class="thead">
        					<tr>
        						<th colspan="4" class="h5 text-white bg-warning"><strong>Villages</strong></th>
        					</tr>
        					<tr class="h6">
        						<th>#</th>
        						<th>Village</th>
        						<th>Population</th>
        						<th>Coordinates</th>
        					</tr>
        				</thead>
        				@foreach($villages as $index=>$village)
            				<tr class="" style="font-size: 0.9em">
            					<td class="py-1">{{$index+1}}</td>
            					<td class="py-1">{{$village->village}}</td>
            					<td class="py-1">{{$village->population}} 
									<small>
									@if($village->diffPop>0)
										<span class="text-success">({{$village->diffPop}})</span>
									@else
										<span class="text-danger">({{$village->diffPop}})</span>
									@endif
									</small>
								</td>
            					<td class="py-1"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$village->x}}&y={{$village->y}}" target="_blank">
            						{{$village->x}}|{{$village->y}}</a></td>
        					</tr>
    					@endforeach
        			</table>
        		</div>
			</div>			
		</div>
	

@endsection