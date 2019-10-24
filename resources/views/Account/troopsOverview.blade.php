@extends('Account.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-warning text-white">
				<strong>Troops Details</strong>
			</div>
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
    			<div class="col-md-8 mx-auto my-4 rounded" style="background-color:#dbeef4;">
    				<p class="h4 text-center text-primary"><strong>Summary</strong></p>
        			<table class="table table-borderless">					
        				<tr>
        					<td class="py-1"><strong>Total Troops : </strong>{{$stats['upkeep']}}</td>
        					<td class="py-1"><strong>Troop/Pop Ratio : </strong>{{round($stats['upkeep']/$stats['pop'],1)}} : 1</td>
        				</tr>
        				<tr>
        					<td class="py-1"><strong>Offense Troops : </strong>{{$stats['offense']}} ({{$stats['offratio']}}%)</td>
        					<td class="py-1"><strong>Defense Troops : </strong>{{$stats['defense']}} ({{$stats['defratio']}}%)</td>
        				</tr>
        			</table>
    			</div>

        		<div class="text-center mx-2 ">
					<table class="table table-bordered col-md-10 p-0 table-sm small mx-auto">
						<tr class="text-warning font-weight-bold h6">
							<td class="px-0 py-1">Village</td>
							@foreach($units as $unit)
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}"></td>
							@endforeach
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></td> 
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Tournament Square"><img alt="" src="/images/x.gif" class="build tsq"></td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Village Type">Type</td>
							<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="Icons"></td>
						</tr>
					@foreach($troops as $index=>$troop)
						<tr id="{{$troop['vid']}}">
							<td class="p-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$troop['x']}}&y={{$troop['y']}}" target="_blank">
								{{$troop['village']}}</a></td>
							<td class="p-0 unit01" contenteditable="true">{{number_format($troop['unit01'])}}</td>
							<td class="p-0 unit02" contenteditable="true">{{number_format($troop['unit02'])}}</td>
							<td class="p-0 unit03" contenteditable="true">{{number_format($troop['unit03'])}}</td>
							<td class="p-0 unit04" contenteditable="true">{{number_format($troop['unit04'])}}</td>
							<td class="p-0 unit05" contenteditable="true">{{number_format($troop['unit05'])}}</td>
							<td class="p-0 unit06" contenteditable="true">{{number_format($troop['unit06'])}}</td>
							<td class="p-0 unit07" contenteditable="true">{{number_format($troop['unit07'])}}</td>
							<td class="p-0 unit08" contenteditable="true">{{number_format($troop['unit08'])}}</td>
							<td class="p-0 unit09" contenteditable="true">{{number_format($troop['unit09'])}}</td>
							<td class="p-0 unit10" contenteditable="true">{{number_format($troop['unit10'])}}</td>
							<td class="p-0">{{number_format($troop['upkeep'])}}</td>
							<td class="p-0 tsq" contenteditable="true">{{$troop['Tsq']}}</td>
							<td class="py-0">{{$troop['type']}}</td>
							<td class="p-0" data-toggle="tooltip" data-placement="top" title="save">
            					<button class="badge badge-primary" type="button" id="update"><i class="far fa-save"></i></button>																						
							</td>
						</tr>
					@endforeach
						<tr class="font-weight-bold">
							<td class="px-0">Total</td>
							<td class="px-0">{{number_format($stats['unit01'])}}</td>
							<td class="px-0">{{number_format($stats['unit02'])}}</td>
							<td class="px-0">{{number_format($stats['unit03'])}}</td>
							<td class="px-0">{{number_format($stats['unit04'])}}</td>
							<td class="px-0">{{number_format($stats['unit05'])}}</td>
							<td class="px-0">{{number_format($stats['unit06'])}}</td>
							<td class="px-0">{{number_format($stats['unit07'])}}</td>
							<td class="px-0">{{number_format($stats['unit08'])}}</td>
							<td class="px-0">{{number_format($stats['unit09'])}}</td>
							<td class="px-0">{{number_format($stats['unit10'])}}</td>
							<td class="px-0" colspan="2">{{number_format($stats['upkeep'])}}</td>
							<!-- <td></td>
							<td></td>  -->
						</tr>
        			</table>
        		</div>        		
			</div>	

			<div class="col-md-8 mx-auto rounded mb-5 pt-2" style="background-color:#dbeef4;">
				<form method="post" action="{{route('accountTroops')}}/parse">	
					{{ csrf_field() }}
    				<table>
    					<tr>
    						<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Troops Details</strong></p></td>
    					</tr>
    					<tr>
    						<td class="align-middle px-2">							
								<p><textarea rows="3" cols="25" required name="troopStr"></textarea>														
    						</td>
    						<td class="small font-italic align-middle px-2">
    							<p>Enter the Troops page data here</p>
    							
    						</td>
    					</tr>
    					<tr>
    						<td colspan="2" class="text-center"><p><button class="btn btn-primary"><strong>Update Troops</strong></button></p></td>	
						</tr>			
				</table>
				</form>
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
   
        $(document).on('click','#update',function(e){
            e.preventDefault();  

			var village = $(this).closest("tr");
            var vid = village.attr("id");
            var unit01 = village.find('td:eq(1)').text();            var unit02 = village.find('td:eq(2)').text();
            var unit03 = village.find('td:eq(3)').text();            var unit04 = village.find('td:eq(4)').text();
            var unit05 = village.find('td:eq(5)').text();            var unit06 = village.find('td:eq(6)').text();
            var unit07 = village.find('td:eq(7)').text();            var unit08 = village.find('td:eq(8)').text();
            var unit09 = village.find('td:eq(9)').text();            var unit10 = village.find('td:eq(10)').text();
            var tsq = village.find('td:eq(12)').text();
                
            $.ajax({
               type:'POST',
               url:'{{route("accountTroops")}}/update',
               data:{	vid:vid, 		tsq:tsq,	
            	   		unit01:unit01,	unit02:unit02,
            	   		unit03:unit03,	unit04:unit04,
            	   		unit05:unit05,	unit06:unit06,
            	   		unit07:unit07,	unit08:unit08,
            	   		unit09:unit09,	unit10:unit10
                   },
               success:function(data){
					village.find("td:eq(11)").text(data.upkeep);
            	   	alert(data.success)
               }
            });  
    
    	});
	</script>
@endpush

@push('extensions')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush