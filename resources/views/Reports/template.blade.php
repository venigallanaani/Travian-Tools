@extends('Layouts.general')


@section('content')
<header id="main-header" class="py-1 bg-info text-white">
    <div class="container">
        <p class="h3 font-weight-bold d-inline-block">Reports</p>
    </div>
</header>
	@foreach(['danger','success','warning','info'] as $msg)
		@if(Session::has($msg))
		<div class="container">
        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>{{ Session::get($msg) }}
            </div>
        </div> 
        @endif
    @endforeach	

	<div class="container">
		@yield('report')
		<div class="card col-md-12 p-1 my-2 shadow">
			<form class="mx-auto col-md-10" action="{{route('makeReport')}}" method="post">
				@if(!empty($link))
					<input name="link" value="{{$link}}" hidden>
				@endif
				{{ csrf_field() }}
				<span class="h5">Enter report data here:</span><textarea class="form-control" rows="3" name="report" required></textarea>
				<table class="col-md-12 mx-auto my-2">
					<tr>
						<td><input type="checkbox" name="attacker" value="yes"> Hide Attacker</td>
						<td><input type="checkbox" name="defender" value="yes"> Hide Defender</td>
					@if(!empty($link))
						<td><input type="checkbox" name="previous" value="yes"> Link with Previous Report</td>
					@endif
					</tr>
				</table>
    			<div class="py-2 align-middle">
    				<button class="btn btn-info px-5" type="submit">Convert</button> 
<!--     				<span class="align-right small px-5"><i>*The report will be deleted if not viewed for 100 days.</i></span> -->
    			</div>
			</form>
		</div>	
	</div>

@endsection
