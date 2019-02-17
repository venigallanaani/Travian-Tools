@extends('Layouts.reports')


@section('content')
<div class="container">
	<div class="container">
		@yield('report')
		<div class="card col-md-12 p-1 my-2 shadow">
			<form class="mx-auto col-md-10" action="/reports/create" method="post">
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
    				<button class="btn btn-primary px-5" type="submit">Convert</button> 
    				<span class="align-right small"> *The report will be deleted if not used for 100 days.</span>
    			</div>
			</form>
		</div>	
	</div>
</div>
@endsection
