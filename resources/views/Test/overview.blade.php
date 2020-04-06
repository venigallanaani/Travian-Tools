@extends('Layouts.general')

@section('content')        
        
    <!-- ============================================ home page body starts here ============================================ -->
    <div class="container mx-auto mt-1">
    	<table class="mx-auto table table-bordered">
			<tr  class="first">
				<th>Attacker</th>
				<th>Defender</th>
				<th>Type</th>
			</tr>
    		<tr class="first">
    			<td>
    				<p class="h6"><input class="id_attack" rel="attack" type="checkbox" value="A1"> ATT1</p>
    				<p class="h6"><input class="id_attack" rel="attack" type="checkbox" value="A2"> ATT2</p>    				
    			</td>
    			<td>
    				<p class="h6"><input class="id_defend" rel="defend" type="checkbox" value="D1"> DEF1</p>
    				<p class="h6"><input class="id_defend" rel="defend" type="checkbox" value="D2"> DEF2</p>
    				<p class="h6"><input class="id_defend" rel="defend" type="checkbox" value="D3"> DEF3</p>
				</td>
    			<td>
    				<p class="h6 table-white px-2 py-0"><input class="id_type" rel="type" type="checkbox" value="NEW"> New</p>
    				<p class="h6 table-success px-2 py-0"><input class="id_type" rel="type" type="checkbox" value="DEF"> Defend</p>
    				<p class="h6 table-secondary px-2 py-0"><input class="id_type" rel="type" type="checkbox" value="FAKE"> Fake</p>
    				<p class="h6 table-warning px-2 py-0"><input class="id_type" rel="type" type="checkbox" value="SCOUT"> Scouting</p>
    				<p class="h6 table-primary px-2 py-0"><input class="id_type" rel="type" type="checkbox" value="ART"> Artefact</p>
    				<p class="h6 table-info px-2 py-0"><input class="id_type" rel="type" type="checkbox" value="NONE"> None</p>
    				<p class="h6 table-danger px-2 py-0"><input class="id_type" rel="type" type="checkbox" value="SNIPE"> Snipe</p>
				</td>
    		</tr>
    	</table>

		<table class="mx-auto table table-bordered text-center">
			<tr class="first">
				<th>Attacker</th>
				<th>Defender</th>
				<th>Type</th>
			</tr>
			<tr>
				<td class="attack" rel="A1">ATT1</td>
				<td class="defend" rel="D1">DEF1</td>
				<td class="type" rel="NEW">New</td>
			</tr>
			<tr>
				<td class="attack" rel="A1">ATT1</td>
				<td class="defend" rel="D2">DEF2</td>
				<td class="type" rel="DEF">Defend</td>
			</tr>
			<tr>
				<td class="attack" rel="A2">ATT2</td>
				<td class="defend" rel="D1">DEF1</td>
				<td class="type" rel="FAKE">Fake</td>
			</tr>
			<tr>
				<td class="attack" rel="A2">ATT2</td>
				<td class="defend" rel="D2">DEF2</td>
				<td class="type" rel="SCOUT">Scouting</td>
			</tr>
			<tr>
				<td class="attack" rel="A1">ATT1</td>
				<td class="defend" rel="D3">DEF3</td>
				<td class="type" rel="ART">Artefact</td>
			</tr>
			<tr>
				<td class="attack" rel="A2">ATT2</td>
				<td class="defend" rel="D3">DEF3</td>
				<td class="type" rel="NONE">None</td>
			</tr>
			<tr>
				<td class="attack" rel="A1">ATT1</td>
				<td class="defend" rel="D1">DEF1</td>
				<td class="type" rel="NONE">None</td>
			</tr>			
			<tr>
				<td class="attack" rel="A1">ATT1</td>
				<td class="defend" rel="D1">DEF1</td>
				<td class="type" rel="SNIPE">SNIPE</td>
			</tr>		
		</table>
    </div>  
	  
@endsection

@push('scripts')
<script>
 	$("input:checkbox").click(function () {
 	    var showAll = true;
 	    $('tr').not('.first').hide();
 	    $('input[type=checkbox]').each(function () {
 	        if ($(this)[0].checked) {
 	            showAll = false;
 	            var status = $(this).attr('rel');
 	            var value = $(this).val();            
 	            $('td.' + status + '[rel="' + value + '"]').parent('tr').show();
 	        }
 	    });
 	    if(showAll){
 	        $('tr').show();
 	    }
 	});
</script>   
@endpush