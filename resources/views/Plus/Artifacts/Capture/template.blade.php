@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Artifact Capture Plan</strong></div>
			<div class="card-text">
			
				@yield('display')
				
			</div>
		</div>

@endsection
