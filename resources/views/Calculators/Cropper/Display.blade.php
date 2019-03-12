@extends('Calculators.template')

@section('body')

<!-- =================================== Alliance Finder input screen================================== -->
    <div class="card float-md-left shadow mb-1 col-md-12">
        <div class="card-header h4 py-2 bg-success text-white col-md-12">
            <strong>Cropper Development</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="/calculators/cropper" method="POST">
            	{{ csrf_field() }}
				<table>
					<tr>
						<td>
							<div class="py-0">
								<strong>Cropper:</strong> 
									<select name="cropper">
										<option value="15">15C</option>
										<option value="9">9C</option>
										<option value="7">7C</option>
										<option value="6">6C</option>
									</select>
							</div>
						</td>
						<td>
							<div class="px-2 py-1"><strong>Capital : </strong><input type="checkbox" name="capital"/></div>
						</td>
						<td>
							<div class="px-2 py-1"><strong>Plus : </strong><input type="checkbox" name="plus"/></div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="py-2">
								<strong>Oasis 1:</strong> 
									<select name="oasis1">
										<option value="50">50%</option>
										<option value="25">25%</option>
										<option value="0">0%</option>
									</select>
							</div>
						</td>
						<td>
							<div class="py-2">
								<strong>Oasis 2:</strong> 
									<select name="oasis2">
										<option value="50">50%</option>
										<option value="25">25%</option>
										<option value="0">0%</option>
									</select>
							</div>
						</td>
						<td>
							<div class="py-2">
								<strong>Oasis 3:</strong> 
									<select name="oasis3">
										<option value="50">50%</option>
										<option value="25">25%</option>
										<option value="0">0%</option>
									</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<button class="btn btn-outline-primary px-5" type="submit"><strong>Calculate</strong></button>
						</td>
					</tr>
				</table>
            </form>
        </div>
    </div>
	
	@yield('result')
	
@endsection