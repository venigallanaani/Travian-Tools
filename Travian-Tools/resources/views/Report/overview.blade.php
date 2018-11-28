@extends('layouts.general')

@section('content')
	
    <header id="main-header" class="py-1 bg-info text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">Report</p>
            <div class="float-right">
            <div class="btn btn-light dropdown d-inline-block">
                <a class="dropdown-toggle" data-toggle="dropdown">Server Name </a>
                <div class="dropdown-menu">
                    <a href="servers.php" class="dropdown-item"><i class="fas fa-server"></i> Change Server</a>
                </div>              
            </div>
            <p class="h6 d-inline-block px-2"><span id="clock"></span></p>
            </div>
        </div>
    </header>

    <!-- ============================================ Report page body starts here ============================================ -->
	<div class="container mt-1">

		<div class="alert alert-success text-center my-1 mx-5" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button><strong>Your report is received, thanks for the support.</strong> 
		</div>

		<div class="card col-md-12 p-1 shadow" style="background-color:#dbeef4;">
			<p class="h4 py-2 text-info mx-auto"><strong>Please enter defects and suggestions here</strong></p>
			<form class="mx-auto col-md-6">
				<div class="input-group py-1">
					<label for="subject" class="input-group-prepend"><span class="input-group-text">Subject:</span></label>
						<input type="text" required class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
				</div>
				<div class="input-group py-1">
					<label for="email" class="input-group-prepend"><span class="input-group-text">Email Address:</span></label>
						<input type="text" required class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
				</div>
				<div class="input-group py-1">
					<label for="type" class="input-group-prepend"><span class="input-group-text">Type:</span></label>
						<select class="form-control col-md-3" aria-label="" aria-describedby="basic-addon1">
							<option value="">Defect</option>
							<option value="">Suggestion</option>
							<option value="">Other</option>
						</select>
				</div>
				<div class="input-group py-1">
					<label for="comments" class="input-group-prepend"><span class="input-group-text">Description:</span></label>
						<textarea class="form-control" rows="8"></textarea>
				</div>
    			<div class="py-2 align-middle">
    				<button class="btn btn-primary px-5">Submit</button>
    			</div>
			</form>
		</div>		
	</div>
@endsection