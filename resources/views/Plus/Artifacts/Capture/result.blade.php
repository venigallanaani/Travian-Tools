@extends('Plus.Artifacts.Capture.template')

@section('display')

		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach   
        
        <!-- ========================= Result display ============================== -->
			
		@php
		
		print_r($result);
		
		@endphp

@endsection