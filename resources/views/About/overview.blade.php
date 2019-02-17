@extends('Layouts.general')

@section('content')
	
    <header id="main-header" class="py-1 bg-warning text-white">
        <div class="container">
            <p class="h3 font-weight-bold d-inline-block">About</p>
        </div>
    </header>

    <!-- ============================================ home page body starts here ============================================ -->
    <div class="container my-1">
        <div class="card col-md-4 float-md-left">
        	<!-- img class="card-img-top" src="img_avatar1.png" alt="Card image" style="width:100%" -->
            <div class="card-body">
                <h4 class="card-title">Administrator</h4>
                <div class="card-text">
                	<p class='font-italic h6'>Admin/Support</p>
                	<p class='my-0'><strong>Email : </strong>admin@travian-tools.com</p>
                	<!--  Plus only details -->
                	<br/>
              		<p>Please contact admin for any question and queries.</p>
        		</div>                
            </div>
        </div>
	</div>

@endsection