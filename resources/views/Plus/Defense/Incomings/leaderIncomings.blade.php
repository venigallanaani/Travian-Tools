@extends('Plus.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
	<div class="card-header h4 py-2 bg-info text-white"><strong>Incomings</strong></div>
@foreach(['danger','success','warning','info'] as $msg)
	@if(Session::has($msg))
    	<div class="alert alert-{{ $msg }} text-center my-1 mx-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>{{ Session::get($msg) }}
        </div>
    @endif
@endforeach			
	<div class="col-md-12 mt-2 mx-auto text-center">		
	@if($waves==0)			
		<p class="h5 py-5"> No incoming attacks are logged.</p>			
	@else	
		<div class="h5 py-5">
			<p><span class="text-info"><strong>{{$waves}}</strong></span> incoming waves are logged from <span class="text-danger"><strong>{{$att}}</strong> attackers</span> on <span class="text-success"><strong>{{$def}}</strong> ally villages</span>.</p>
			<p><a href="/defense/incomings/list" target="_blank"><button class="btn btn-lg btn-outline-info"><strong>Go To Incomings List</strong></button></a></p>
		</div>
	@endif			
	</div>
</div>			

@endsection