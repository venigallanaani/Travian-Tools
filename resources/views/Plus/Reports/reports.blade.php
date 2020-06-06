@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-10 mb-5 p-0 shadow">
			<div class="card-header h5 py-2 bg-info text-white"><strong>Plus Group Reports</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
				<div class="m-3">
            		<div class="card card-header text-center h6 btn btn-block collapsed bg-warning shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
                		<p class="p-0 m-0">
                    		<i class="fa fa-plus"></i> <span class=""><strong>Save Report</strong></span>
        			 	</p>
            		</div>
            		<div class="collapse" id="task" style="">
              			<div class="card card-body shadow text-center">
              				<p class="h5"><a href="{{route('reports')}}" class="text-info" target="_blank">Reports Converter <i class="fas fa-external-link-alt"></i></a></p>
    						<form action="/plus/reports/add" method="POST" class="col-md-10 mx-auto text-center" autocomplete="off">
        						{{ csrf_field() }}
        						<p class="my-2 h6">
        							Report URL- <input name="link" type="text" required size="30">
        						</p>
        						<p class="my-2">
        							<button class="btn btn-info px-5"><strong>Save Report</strong></button>
        						</p> 						
    						</form>
              			</div>
            		</div>	
        		</div>		
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
    		
    		@if(count($reports)>0)
        			<table class="table text-center table-sm table-hover table-bordered mx-auto col-md-8">
        				<thead class="">
            				<tr>
            					<td colspan="3" class="py-2 h6 text-white bg-info">Group Reports</td>
            				</tr>
    						<tr class="text-info h6">
    							<td class="">Date</td>
    							<td class="">Title</td>    							
    							<td class="">Report</td>    							
    						</tr>
        				</thead>
    				@foreach($reports as $report)
    					<tr style="font-size:0.9em">    
    						<td class="px-1">{{$report['date']}}</td>						
							<td class="px-1">{{$report['title']}}</td>							
							<td class="px-1"><a href="{{$report['report']}}" target="_blank">Link <i class="fas fa-external-link-alt"></a></td>							
						</tr>
    				@endforeach
        			</table>

    		@else
    			
    			<p class="text-center h5 text-danger py-3">No Reports are saved for this group</p>
    			
    		@endif
			</div>
		</div>

@endsection
