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
				<form class="mx-auto" action="{{route('ldrArt')}}/hammers" method="POST">
					{{csrf_field()}}
<!-- ================================= Artifact Coordinates Input ========================= -->
    				<div class="card my-2 p-0 text-center mx-auto col-md-10">
    					<div class="card-header p-1 bg-info text-white">
    						<p class="h4">Expected Hammer sizes</p>
    					</div>
    					<div class="card-body my-0">
    						<table class="table table-borderless my-0">
    							<tr>
    								<td>Small Artifacts (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="smHammer" size="5" required></td>
    								<td>Large Artifacts (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="lgHammer" size="5" required></td>
    							</tr>
    							<tr>
    								<td colspan="2">Unique Artifacts (<img alt="upkeep" src="/images/x.gif" class="res upkeep">): <input type="text" name="unHammer" size="5" required></td>				
    							</tr>
    							<tr>
    								<td colspan="2"><button class="btn btn-info btn-lg shadow" name="search" type="submit">Seach Artifact Hammers</button></td>
    							</tr>
    						</table>
    					</div>
    				</div>

					
				</form>

@endsection
