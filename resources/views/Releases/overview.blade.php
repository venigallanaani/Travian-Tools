@extends('Layouts.general')

@section('content')
	
    <header id="main-header" class="py-1 bg-info text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Releases</p>
        </div>
    </header>

    <!-- ============================================ home page body starts here ============================================ -->
    <div class="container my-1">			
		<table class="col-md-10 mx-auto table table-bordered shadow">
			<tr class=" bg-info text-center text-white h5">
				<th class="">Version</th>
				<th class="">Date</th>
				<th>Description</th>
			</tr>
			<tr>
				<td class="text-center">1.0</td>
				<td>February 15, 2019</td>
				<td>Initial Release - Reports Page</td>
			</tr>
			<tr>
				<td class="text-center">1.5</td>
				<td>March 28, 2019</td>
				<td>Finders & servers pages</td>
			</tr>
			<tr>
				<td class="text-center">2.0</td>
				<td>April 30, 2019</td>
				<td>Profile, Account, Auth features and Plus</td>
			</tr>
		</table>			
    </div>

@endsection