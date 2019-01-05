@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="card float-md-left col-md-9 mt-1 p-0">
			<div class="card-text">
		@foreach(['danger','success','warning','info'] as $msg)
    		@if(Session::has($msg))
    			<div class="col-md-10 mx-auto">
                	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                </div>
            @endif
        @endforeach
        		<div class="card shadow col-md-12 p-0 mx-auto">
    				<div class="card-header h4 py-2 bg-warning text-white text-center">
    					<strong>Sitter Details</strong>
    				</div>
    				<div class="card-text">
    					<table class="table table-hover col-md-6 text-center mx-auto">
    						<tr>
    							<td class="text-right col-md-6">Sitter 1 :</td>
    							<td contenteditable="true" class="text-left col-md-6" id="sitter1Edit">{{$account->sitter1}}</td>
    						</tr>
    						<tr>
    							<td class="text-right col-md-6">Sitter 2 :</td>
    							<td contenteditable="true" class="text-left col-md-6" id="sitter2Edit">{{$account->sitter2}}</td>
    						</tr>
    					</table>
    					<form id="form" action="/account/sitter/update" method="POST" onsubmit="return updateSitter()" class="text-center pb-3">
    						{{ csrf_field() }}
    						<input id="sitter1" name="sitter1" style="display:none">
    						<input id="sitter2" name="sitter2" style="display:none">    						
    						<button class="btn btn-warning btn-lg px-5" type="submit">Save</button>						
    					</form>					
    				</div>			
    			</div> 
    			
    			<div class="card shadow col-md-12 p-0 mt-3 mx-auto">
    				<div class="card-header h4 py-2 bg-warning text-white text-center">
    					<strong>Dual Details</strong>
    				</div>  
    				<div class="card-text">
    					<div class="col-md-8 mx-auto text-center py-2">
    						<p>Dual Passcode:	{{$account->token}}</p>
    					</div>
    					<table class="table table-hover table-sm table-bordered col-md-8 text-center mx-auto">
    						<tr>
    							<td class="text-right col-md-6">Dual Passcode:</td>
    							<td class="text-left col-md-6">{{$account->token}}</td>
    						</tr>
    					</table>
    				</div>  			
    			</div>
    			     		
			</div>			
		</div>
@endsection

@push('scripts')
        <script>
            function updateSitter() {
            	sitter1=document.getElementById("sitter1Edit").innerHTML;
    			if(sitter1=='<br>'){ sitter1='';}
                document.getElementById("sitter1").value = sitter1;
                
                sitter2=document.getElementById("sitter2Edit").innerHTML;
                if(sitter2=='<br>'){ sitter2='';}
                document.getElementById("sitter2").value = sitter2;             
            }
    	</script>
@endpush