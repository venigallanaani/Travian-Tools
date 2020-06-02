@extends('Plus.template')

@section('body')

	<div class="card float-md-left col-md-10 p-0 shadow">
		<div class="card-header h5 py-2 bg-info text-white"><strong>Search Offense</strong></div>
		<div class="card-text">
	@foreach(['danger','success','warning','info'] as $msg)
		@if(Session::has($msg))
        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>{{ Session::get($msg) }}
            </div>
        @endif
    @endforeach		
    		<div class="text-center my-2">	
    			<form action="/offense/search" method="POST" autocomplete="off">
    				{{ csrf_field() }}
    				<table class="text-center mx-auto">
    					<tr>
    						<td colspan="2">
		    					<p class="h6">X: <input name="xCor" type="number" style="width:4em" required value="0"> | 
									Y: <input name="yCor" type="number" style="width:4em" required value="0"></p>
    						</td>
    					</tr>
						<tr>
							<td colspan="2">
								<p class="h6">Offense (<img alt="" src="/images/x.gif" class="res upkeep">): 
    								<input name="offNeed" type="number" style="width:7em" required min="0"></p>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<p class="h6">Target Time: <input name="targetTime" type="text" size="20" class="dateTimePicker"></p>
							</td>
						</tr>
						<tr>
							<td>
								<p class="h6"><input type="checkbox" name="siege" value="yes"> No Siege/Palace Units</p>
							</td>
							<td>
								<p class="h6"><input type="checkbox" name="cavalry" value="yes"> Cavalry Only</p>
							</td>
						</tr> 				
    				</table>
    				<button class="btn btn-info px-3 py-1" type="submit">Search Offense</button>
    			</form>	
			</div>	
		</div>
	</div>
	
	@yield('results')

@endsection

@push('scripts')

	<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
	<script type="text/javascript">
        $(".dateTimePicker").datetimepicker({
            format: "yyyy-mm-dd hh:ii:ss",
            showSecond:true
        });
	</script>            

@endpush

@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endpush