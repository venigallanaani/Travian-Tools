@extends('Layouts.reports')

@section('content')

	<div class="container">
		<div class="card col-md-12 p-1 my-2 shadow">
			<form class="mx-auto col-md-8" action="/reports/create" method="post">
				{{ csrf_field() }}
				<span class="h5">Enter report data here:</span><textarea class="form-control" rows="5" name="report" required></textarea>
				<table class="col-md-6 mx-auto my-2">
					<tr>
						<td><input type="checkbox" name="attacker" value="yes"> Hide Attacker</td>
						<td><input type="checkbox" name="defender" value="yes"> Hide Defender</td>
					</tr>
				</table>
    			<div class="py-2 align-middle">
    				<button class="btn btn-primary px-5" type="submit">Convert</button>
    			</div>
			</form>
		</div>	
	</div>

@endsection
