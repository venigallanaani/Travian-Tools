@extends('Plus.Artifacts.Capture.template')

@section('display')

		<!-- ========================== display notifications Options ============================== -->
	
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach        
				<form class="col-md-10 mx-auto" action="{{route('ldrArt')}}/capture" method="POST">
					{{csrf_field()}}
<!-- ================================= Artifact Coordinates Input ========================= -->
    				<div class="card my-4 p-0 text-center">
    					<div class="card-header p-1 bg-info text-white">
    						<p class="h4">Expected Hammer sizes</p>
    					</div>
    					<div class="card-body">
    						<table class="table table-borderless">
    							<tr>
    								<td>Small Artifacts (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="smHammer" size="5" required></td>
    								<td>Large Artifacts (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="lgHammer" size="5" required></td>
    							</tr>
    							<tr>
    								<td colspan="2">Unique Artifacts (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="unHammer" size="5" required></td>				
    							</tr>
    						</table>
    					</div>
    				</div>
				
    				<div class="card p-0 m-0 text-center">
    					<div class="card-header p-1 bg-info text-white">
    						<p class="h4">Artifact Coordinates</p>
    					</div>
    					<div class="card-body">
    						<table class="table table-sm table-borderless rounded">
    							<tr>
    								<th>Artifact</th>
    								<th>Coordinates</th>
    								<th>Priority</th>
    								<th></th>
    							</tr>
    					@foreach($group as $artys)
    						@foreach($artys as $arty)
    							@php
    								if(strtoupper($arty['SIZE'])=='UNIQUE'){
    									$color = "table-danger";
    								}elseif(strtoupper($arty['SIZE'])=='LARGE'){
    									$color = "table-warning";
    								}else{ $color = "table-info";	}
    							@endphp
    							<tr id="{{$arty['ID']}}" class="small {{$color}}">
    								<td data-toggle="tooltip" data-placement="top" title="{{$arty['DESC']}}">{{$arty['NAME']}}</td>
    								<td>X:<input type="text" name="{{$arty['ID']}}_x" size="5">|Y:<input type="text" name="{{$arty['ID']}}_y" size="5"></td>
    								<td><select name="{{$arty['ID']}}_priority">
        									<option value="low">Low</option>
        									<option value="medium">Medium</option>
        									<option value="high">High</option>
        								</select> 
    								</td>
    							</tr>
    						@endforeach
    							<tr class="table-white"><td colspan="3"></td></tr>
    					@endforeach
    						</table>
    					</div>
    				</div>
    				
					<button class="btn btn-primary large py-2 px-5 my-2">Execute Artifact Capture Plan</button>
					
				</form>

@endsection
