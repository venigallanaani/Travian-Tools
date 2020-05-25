@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-10 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Leader Reports</strong></div>
			<div class="card-text">	
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
    		<br>
    		@if(count($reports)>0)
        			<table class="table text-center table-sm table-hover p-0 table-bordered mx-auto col-md-10">
        				<thead class="">
            				<tr>
            					<td colspan="4" class="py-2 h5 text-white bg-info">Reports</td>
            				</tr>
    						<tr class="text-info font-weight-bold">      							 							
    							<td class="px-1">Title</td>
    							<td class="px-1">Report</td> 
    							<td class="px-1">Date</td>
    							<td></td>
    						</tr>
        				</thead>
    				@foreach($reports as $report)
    					<tr>   						
							<td class="px-1">{{$report['title']}}</td>
							<td class="px-1"><a href="{{$report['report']}}" target="_blank">Link <i class="fas fa-external-link-alt"></a></td>
							<td class="px-1">{{$report['date']}}</td>
							<td class="px-0"><button class="badge badge-danger" id="delRep" value="{{$report['id']}}"><i class="fa fa-trash" aria-hidden="true"></i></button></td>							
						</tr>
    				@endforeach
        			</table>

    		@else
    			
    			<p class="text-center h5 text-danger py-3">No Reports are saved for this group</p>
    			
    		@endif
			</div>
		</div>

@endsection

@push('scripts')
	<script>
        $(function(){
        	$(document).on('click','#delRep',function(e){
    			var id= $(this).val();
    			//alert(id);    			
    			var xmlhttp = new XMLHttpRequest();
    		    xmlhttp.onreadystatechange = function() {
    		        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
    		        {	console.log(xmlhttp.responseText);	}
    		    };
    		    xmlhttp.open("GET", "/plus/ldrrpts/delete/"+id, true);
    		    xmlhttp.send();		

                e.preventDefault();
              	$(this).parents('tr').remove();		
            });
       });
	</script>    
@endpush