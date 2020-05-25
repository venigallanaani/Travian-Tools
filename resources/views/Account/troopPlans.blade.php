@extends('Account.template')

@section('body')
		<div class="card float-md-left col-md-10 mt-1 mb-5 p-0 shadow">
			<div class="card-header h5 py-2 bg-warning text-white">
				<strong>Troops Development Plans</strong>
			</div>
			<div class="card-text">
        		<div class="m-3">
            		<div class="card card-header text-center h6 btn btn-block collapsed bg-warning shadow" data-toggle="collapse" href="#task" aria-expanded="false" aria-controls="task">
                		<p class="p-0 m-0">
                    		<i class="fa fa-plus"></i> <span class=""><strong>Create New Troops Plan</strong></span>
        			 	</p>
            		</div>
            		<div class="collapse" id="task" style="font-size:0.9em">
              			<div class="card card-body shadow h6">
    						<form action="{{route('accountPlan')}}/create" method="POST" class="col-md-8 mx-auto text-center">
        						{{ csrf_field() }}
        						<p class="my-2">
        							Village:
        								<select name="village">
        								@foreach($villages as $village)
        									<option value="{{$village['VID']}}">{{$village['VILLAGE']}}</option>
        								@endforeach
        								</select>
    								Plan Name: <input type="text" name="name">        							
        						</p>
        						<p>Notes: <textarea rows="2" cols="25" name="comments"></textarea>
        						</p>
        						<p><button class="btn btn-warning" type="submit"><strong>Create Plan</strong></button></p>					
    						</form>
              			</div>
            		</div>
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
            		<br>
        		@if($plans==null)
					<p class="text-center h6 py-3">No Troops Plans are created for this account</p>
				@else
        		@foreach($plans as $plan)
            		<div class="card col-md-10 mx-auto my-2 p-0 shadow">
            			<div class="card-header h6 py-2 bg-warning">
            				Village - <strong>{{$plan['VILLAGE']}}</strong><span class="float-right">Plan Name - <strong>{{$plan['NAME']}}</strong></span>
            			</div>
            			<div class="card-text p-2">
            				<table class="mx-auto col-md-8 my-2" style="font-size:0.9em">
                				<tr>
                					<td><strong>Created date - </strong>{{$plan['CREATE']}}</td>
                					<td rowspan="2"><strong>Notes - </strong>{{$plan['COMMENTS']}}</td>
            					</tr>  
                				<tr>
                					<td><strong>Updated date - </strong>{{$plan['UPDATE']}}</td>
                					<td></td>
            					</tr> 
            				</table>
            				<table class="table table-sm text-center table-bordered small">
            					<thead>
            						<tr>
            							<td></td>
            						@foreach($tribe as $unit)
            							<td class="" data-toggle="tooltip" data-placement="top" title="{{$unit['NAME']}}"><img alt="" src="/images/x.gif" class="units {{$unit['IMAGE']}}"></td>
            						@endforeach
            							<td class="" data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></td> 
            						</tr>
        						</thead>
        						<tr class="table-info font-weight-bold" id="planned">
            							<td>Planned *</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][0])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][1])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][2])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][3])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][4])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][5])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][6])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][7])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][8])}}</td>
        								<td contenteditable="true" class="px-0">{{number_format($plan['PLANNED'][9])}}</td>
        								<td class="px-0">{{number_format($plan['PLANNED_UPKEEP'])}}</td>
        						</tr>
        						<tr class="">
        							<td class="font-weight-bold">Trained</td>
    							@foreach($plan['COMPLETED'] as $unit)
    								<td class="px-0">{{number_format($unit)}}</td>
    							@endforeach
    								<td class="px-0">{{number_format($plan['COMPLETED_UPKEEP'])}}</td>
        						</tr>
        						<tr class="" id="queued">
        							<td class="font-weight-bold px-0">In Queue *</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][0])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][1])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][2])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][3])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][4])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][5])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][6])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][7])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][8])}}</td>
    								<td contenteditable="true" class="px-0">{{number_format($plan['PROGRESS'][9])}}</td>
    								<td class="px-0">{{number_format($plan['PROGRESS_UPKEEP'])}}</td>
        						</tr>
        						<tr class="table-success font-weight-bold">
        							<td class="font-weight-bold">Total</td>
    							@foreach($plan['TOTAL'] as $unit)
    								<td class="px-0">{{number_format($unit)}}</td>
    							@endforeach
    								<td class="px-0">{{number_format($plan['TOTAL_UPKEEP'])}}</td>
        						</tr>  
        						<tr class="table-warning">
        							<td class="font-weight-bold">Pending</td>
    							@foreach($plan['PENDING'] as $unit)
    								<td class="px-0">{{number_format($unit)}}</td>
    							@endforeach
    								<td class="px-0">{{number_format($plan['PENDING_UPKEEP'])}}</td>
        						</tr>      				
        						<tr>
        							<td colspan="4" class="py-2">Calculator - TBD
            						</td>
            						<td colspan="4" class="py-2">
                                		<button class="btn btn-warning px-3 mx-3" name="update" id="update" value="{{$plan['ID']}}" type="submit"><strong>Update</strong></button>
                            		</td>
                            		<td colspan="4" class="py-2">
            		        			<form action="{{route('accountPlan')}}/delete" method="POST" >
        									{{csrf_field()}}
                                			<button class="btn btn-danger px-3 mx-3" name="delete" value="{{$plan['ID']}}" type="submit"><strong>Delete</strong></button>
                            			</form>
            						</td>                						
        						</tr>
            				</table>
            			</div>
        			</div>
        			<br>
        		@endforeach  
        		@endif         		
        		</div>
			</div>		
		</div>
@endsection

@push('scripts')
	<script>    
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});  
           
        $(document).on('click','#update',function(e){
            e.preventDefault();  

            var id= $(this).closest("table").find('#update').val();

			var planned = $(this).closest("table").find('#planned');
			var p_01 = planned.find('td:eq(1)').text();				var p_02 = planned.find('td:eq(2)').text();
			var p_03 = planned.find('td:eq(3)').text();				var p_04 = planned.find('td:eq(4)').text();
			var p_05 = planned.find('td:eq(5)').text();				var p_06 = planned.find('td:eq(6)').text();
			var p_07 = planned.find('td:eq(7)').text();				var p_08 = planned.find('td:eq(8)').text();
			var p_09 = planned.find('td:eq(9)').text();				var p_10 = planned.find('td:eq(10)').text();		

			var queued = $(this).closest("table").find('#queued');
			var q_01 = queued.find('td:eq(1)').text();				var q_02 = queued.find('td:eq(2)').text();
			var q_03 = queued.find('td:eq(3)').text();				var q_04 = queued.find('td:eq(4)').text();
			var q_05 = queued.find('td:eq(5)').text();				var q_06 = queued.find('td:eq(6)').text();
			var q_07 = queued.find('td:eq(7)').text();				var q_08 = queued.find('td:eq(8)').text();
			var q_09 = queued.find('td:eq(9)').text();				var q_10 = queued.find('td:eq(10)').text();		
            
            $.ajax({
               type:'POST',
               url:'{{route("accountPlan")}}/update',
               data:{  id:id,
                   	   p_01:p_01,		p_02:p_02,		p_03:p_03,		p_04:p_04,
                	   p_05:p_05,		p_06:p_06,		p_07:p_07,		p_08:p_08,
                	   p_09:p_09,		p_10:p_10,
                	   q_01:q_01,		q_02:q_02,		q_03:q_03,		q_04:q_04,
                	   q_05:q_05,		q_06:q_06,		q_07:q_07,		q_08:q_08,
                	   q_09:q_09,		q_10:q_10
                   },
               success:function(data){					
            	   	//alert(data.success)
            	    location.reload();
               }
            });
    	});
	</script>
@endpush

@push('extensions')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
