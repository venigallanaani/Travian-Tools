@extends('Calculators.template')

@section('body')

<!-- =================================== Player Finder input screen================================== -->
    <div class="card float-md-left shadow mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Distance Calculator</strong>
        </div>
        <div class="card-text mx-auto text-center">
			<table class="table table-sm table-borderless mx-auto">
				<tr>
					<td>From</td>
					<td></td>
					<td>To</td>
				</tr>
				<tr>
					<td><input name="x1" type="text" id="x1" size="5" placeholder="0"> | <input name="y1" type="text" id="y1" size="5" placeholder="0"></td>
					<td></td>
					<td><input name="x2" type="text" id="x2" size="5" placeholder="0"> | <input name="y2" type="text" id="y2" size="5" placeholder="0"></td>
				</tr>			
			
			</table>
        </div>
    </div>
	
	@yield('result')  

    </div>

@endsection