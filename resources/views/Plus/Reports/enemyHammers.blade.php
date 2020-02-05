@extends('Plus.template')

@section('body')

		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Enemy Hammers Tracking</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
				<div class="m-3">
            		<div class="card card-header text-center h6 btn btn-block collapsed bg-warning shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
                		<p class="p-0 m-0">
                    		<i class="fa fa-plus"></i> <span class=""><strong>Add New Report</strong></span>
        			 	</p>
            		</div>
            		<div class="collapse" id="task" style="">
              			<div class="card card-body shadow">
    						<form action="/plus/reports/hammers/add" method="POST" class="col-md-10 mx-auto text-center" autocomplete="off">
        						{{ csrf_field() }}
        						<p class="my-2">
        							<strong>Report - </strong><input name="report" type="text" size="50" required placeholder="http://www.travian-tools.xyz/reports/abcdef1234">
        						</p>
        						<table class="mx-auto table table-borderless my-2">
        							<tr>
        								<td>
			        						<p class="my-2">
                    							<strong>X: <input type="text" name="xCor" size="5" required> | Y: <input type="text" name="yCor" size="5" required></strong>
                    						</p>
                    						<p class="my-2">
                    							<strong>Report Type: </strong>
                    								<input type="radio" name="type" value="SCOUT" checked> Scout 
                    								<input type="radio" name="type" value="ATTACK">  Attacker
                    								<input type="radio" name="type" value="DEFEND">  Defender
                    						</p>
                    						<p class="my-2">
                								<strong>Report Date: <input type="text" name="date" size="10" class="dateTimePicker">        									 
                    						</p>
        								</td>
        								<td>
			        						<p class="my-2">
        										<strong>Notes:</strong><textarea name="comments" class="form-control" rows="3"></textarea>
        									</p>
        								</td>
        							</tr>        							
        						</table>
        						<p class="my-2">
        							<button class="btn btn-info px-5" name="trackHammer"><strong>Add Report</strong></button>
        						</p> 						
    						</form>
    						<p class="text-right text-primary font-italic">Please use the links with one report</p>
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
    		
    		@if(count($hammers)>0)
        		<div class="card card-body m-3">
        			<table class="table text-center table-sm table-hover p-0 table-bordered">
        				<thead class="">
            				<tr>
            					<td colspan="8" class="py-2 h5 text-white bg-info">Enemy Hammers</td>
            				</tr>
    						<tr class="text-info font-weight-bold">
    							<td class="px-1">Player</td>
    							<td class="px-1">Village</td>
    							<td class="px-1">Alliance</td>
    							<td class="px-1">Upkeep (<img alt="" src="/images/x.gif" class="res upkeep">)</td>
    							<td class="px-1">Report</td>
    							<td class="px-1">Date</td>
    							<td class="px-1">Notes</td>
    							<td class="px-1"></td>
    						</tr>
        				</thead>
    				@foreach($hammers as $hammer)
    					<tr>
							<td class="px-1"><a href="{{route('findPlayer')}}/{{$hammer['player']}}/1" target="_blank">{{$hammer['player']}}</a></td>
							<td class="px-1"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$hammer['x']}}&y={{$hammer['y']}}" target="_blank">{{$hammer['village']}}</a></td>
							<td class="px-1"><a href="{{route('findAlliance')}}/{{$hammer['alliance']}}/1" target="_blank">{{$hammer['alliance']}}</a></td>
							<td class="px-1">{{number_format($hammer['upkeep'])}}</td>
							<td class="px-1"><a href="{{route('reports')}}/{{$hammer['report']}}" target="_blank">Link <i class="fas fa-external-link-alt"></a></td>
							<td class="px-1">{{$hammer['report_date']}}</td>
							<td class="small px-1">{{$hammer['notes']}}</td>
							<td class="px-0"><button class="btn btn-danger btn-sm" id="delRep" value="{{$hammer['id']}}">x</button></td>
						</tr>
    				@endforeach
        			</table>
        		</div>
    		@else
    			
    			<p class="text-center h5 text-danger py-3">No Enemy hammers are being tracked</p>
    			
    		@endif
			</div>
		</div>

@endsection

@push('scripts')

	<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
	<script type="text/javascript">
        $(".dateTimePicker").datetimepicker({
            format: "yyyy-mm-dd",
            showSecond:true
        });


        $(function(){
        	$(document).on('click','#delRep',function(e){
    			var id= $(this).val();
    			//alert(id);    			
    			var xmlhttp = new XMLHttpRequest();
    		    xmlhttp.onreadystatechange = function() {
    		        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
    		        {	console.log(xmlhttp.responseText);	}
    		    };
    		    xmlhttp.open("GET", "/plus/reports/hammers/delete/"+id, true);
    		    xmlhttp.send();		

                e.preventDefault();
              	$(this).parents('tr').remove();		
            });
       });
	</script>    
@endpush

@push('extensions')
	<link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
@endpush