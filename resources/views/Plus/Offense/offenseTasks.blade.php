@extends('Plus.template')

@section('body')
	<!-- ==================================== Main Content of the Offense tasks list ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Offense Tasks</strong></div>
			<div class="card-text">
    <!-- ==================================== List of Ops in progress ======================================= -->
    		@if($ops==null)
    			<p class="text-center h5 my-3">No offense plans are available</p>
    		@else
    			@foreach($ops as $plan)
    			<table class="text-center col-md-8 mx-auto my-3">
    				<tr>
    					<td colspan="2" class="h5">Plan: <span class="text-danger"><strong>{{$plan['name']}}</strong></span></td>
					</tr>
    				<tr>
    					<td><span class="text-info font-weight-bold">Created By: </span>{{$plan['create']}}</td>
    					<td><span class="text-info font-weight-bold">Updated By: </span>{{$plan['update']}}</td>
    				</tr>
    			</table>
    			<div class="text-center col-md-12 mx-auto my-3 px-2">
					<table class="table align-middle small table-sm table-hover">
						<thead class="thead-inverse">
    						<tr>
    							<th class="">Attacker</th>
    							<th class="">Target</th>
    							<th class="">Type</th>
    							<th class="">Land time</th>
    							<th class="">Waves</th>
    							<th class="">Troops</th>    							
    							<th class="">Start time</th>
    							<th class="">Timer</th>
    							<th class="">Comments</th>
    							<th class=""></th>
    						</tr>
						</thead>
					@foreach($plan['waves'] as $wave)
						<tr id="{{$wave->id}}">
							<td><a href="" target="_blank">
								<strong>{{$wave->a_village}}</strong></a>
							</td>
							<td><a href="" target="_blank">
								<strong>{{$wave->d_player}} ({{$wave->d_village}})</strong></a>
							</td>
							<td class="text-danger"><strong>{{$wave->type}}</strong></td>
							<td>{{$wave->landtime}}</td>
							<td><strong>{{$wave->waves}}</strong></td>
							<td><span data-toggle="tooltip" data-placement="top" title="Catapult"><img alt="all" src="/images/x.gif" class="units {{$wave->unit}}"></td>
							<td>2019-01-30 00:00:00 </td>
							<td>00:00:00</td>
							<td>{{$wave->comments}}</td>
							<td>@if($wave->status==null)
								<button class="badge badge-success" id="sts">sent</button>
    							<button class="badge badge-danger" id="sts">skipped</button>
    							@else
    							{{$wave->status}}
    							@endif
							</td>							
						</tr>
					@if($wave->status=='Sent')
						<tr>
							<form method="post" action="/plus/offense/update">
								{{csrf_field()}}
    							<td colspan="5"><strong>Report: </strong><input type="text" name="report" size="40" value="{{$wave->report}}"/></td>
    							<td colspan="4"><strong>Notes: </strong><input type="text" name="notes" size="20" value="{{$wave->notes}}"/></td>
    							<td><button class="btn btn-info btn-sm px-3" type="submit" name="save" value="{{$wave->id}}">Save</button></td>
							</form>
						</tr>
					@endif
					@endforeach
					</table>  			
    			@endforeach
    			</div>
    		@endif
			</div>
		</div>
@endsection


@push('scripts')
		<script>    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });   
   
        $(document).on('click','#sts',function(e){
            e.preventDefault();  

			var wave = $(this).closest("tr").attr("id"); 
			var status = $(this).closest("tr").find('td:eq(9)').text(); 
                
            $.ajax({
               type:'POST',
               url:'/plus/offense/update',
               data:{	wave:wave, status=status	},
               
               success:function(data){					
            	   	alert(data.success)
               }
            });  
    
    	});
	</script>
@endpush

@push('extensions')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

