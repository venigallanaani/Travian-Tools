@extends('Calculators.template')

@section('body')

<!-- =================================== Cropper input screen================================== -->
    <div class="card float-md-left p-0 col-md-12 shadow">
        <div class="card-header h5 py-1 bg-primary text-white col-md-12">
            <strong>Construction NPC Calculator</strong>
        </div>
        <div class="card-text mx-auto text-center mt-2">
        	<table class="table col-md-10 mx-auto table-bordered">
        		<tr id="building">
        			<td class="align-middle px-1" style="width:15em">
        				<p><select name="name" id="name" style="width:10em">
        						<option value="ac1">Academy</option>
        						<option value="ac1">Academy</option>
        						<option value="ac1">Academy</option>
        						
        						<option value="ac1">Academy</option>
        						<option value="ac1">Academy</option>
        						<option value="ac1">Academy</option>
        						
        						<option value="ac1">Academy</option>
        						<option value="ac1">Academy</option>
        						<option value="ac1">Academy</option>
        						<option value="ac1">Academy</option>
        					</select>
        				</p>
        				<p class="small"><span class="px-2">From <input type="number" id="from" value=0 min=0 max=20 style="width:3em"></span>-<span class="px-2">To <input type="number" id="to" value=1 min=1 max=20 style="width:3em"></span></p>
        			</td>
        			<td style="width:40em" class="h6">
        				<p style="font-size:0.9em" class="h6"> 
        					<span class="px-1"><img alt="wood" src="/images/x.gif" class="res wood"><span class="px-1" id="wood">0</span></span>
							<span class="px-1"><img alt="clay" src="/images/x.gif" class="res clay"><span class="px-1" id="clay">0</span></span>
							<span class="px-1"><img alt="iron" src="/images/x.gif" class="res iron"><span class="px-1" id="iron">0</span></span>
							<span class="px-1"><img alt="crop" src="/images/x.gif" class="res crop"><span class="px-1" id="crop">0</span></span>							       				
        				</p>
        				<p class="h6">
        					<span class="px-2"><img alt="all" src="/images/x.gif" class="res all"><span class="px-1" id="all">0</span></span>
        				</p>
        				<p class="h6">        					
        					Population :<span class="px-1" id="pop">0</span> 
        					Culture Points :<span class="px-1" id="cp">0</span>
    					</p>        				
        			</td>
        		</tr>
        	</table>            
        </div>        
    </div>        		
@endsection

@push('scripts')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<script>
		$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
		$(document).on('change','#building',function(e){

			var row = $(this);			
			var id = row.find("#name").val();
			var from = row.find("#from").val();
			var to = row.find("#to").val();
							
			$.ajax({
	            type:'POST',
	            url:'{{route("calcNPC")}}',
	            data:{  id:id,	from:from,	to:to	},
	            success:function(data){					
					row.find("#wood").text(data.wood);
					row.find("#clay").text(data.clay);
					row.find("#iron").text(data.iron);
					row.find("#crop").text(data.crop);
					row.find("#all").text(data.all);

					row.find("#pop").text(data.pop);
					row.find("#cp").text(data.cp);		         	    
	            }
	         });		
		});
	</script>
@endpush