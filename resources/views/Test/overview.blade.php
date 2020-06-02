@extends('Layouts.general')

@section('content')        
        
    <!-- ============================================ home page body starts here ============================================ -->
	
	<div class="container">
		<form action="/plus/offense/update" method="POST">
		{{csrf_field()}}
			<p> Delete wave </p>
			<input type="text" value="status" name="name" hidden>
			<input type="test" value="Launch" name="value" required hidden>
			<input type="number" value=26 name="id" required>
			<button class="badge badge-success savewave" type="submit" id="savewave"><i class="fas fa-save"></i></button>
		</form>
	</div> 
	  
@endsection
