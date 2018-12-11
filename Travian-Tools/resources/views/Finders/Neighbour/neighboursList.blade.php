@extends('Finders.Neighbour.neighbourFinder')

@section('result')


<!-- ========================================= Natar Finder -- Village found ======================================================== -->

    <div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Neighbourhood Scan</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-10 ">
            <table class="table table-hover table-sm small" id="sortableTable">
                <tr class="h6">
                    <th onclick="sortTable(1)">Distance</th>
                    <th onclick="sortTable(2)">Village</th>
                    <th>Coordinates</th>
                    <th onclick="sortTable(3)">Player</th>
                    <th>Tribe</th>
                    <th onclick="sortTable(4)">Alliance</th>
                    <th onclick="sortTable(5)">Population</th>
                </tr>
                @foreach($villages as $village)
                    @php 
                    	if($village->id === 1){	$tribe='Roman'; }
                		elseif($village->id===2){	$tribe='Teuton';	}
            			elseif($village->id===3){	$tribe='Gaul';	}
            			elseif($village->id===4){	$tribe='Nature';	}
            			elseif($village->id===5){	$tribe='Natar';	}
            			elseif($village->id===6){	$tribe='Egyptian';	}
            			elseif($village->id===7){	$tribe='Hun';	}
            			else {	$tribe='Natar';	}
        			@endphp
                    <tr>
                        <td class="py-0">{{round(sqrt(pow(($x-$village->x),2)+pow(($y-$village->y),2)),2)}}</td>
                        <td class="py-0">{{$village->village}}</td>
                        <td class="py-0"><a href="">{{$village->x}}|{{$village->x}}</a></td>
                        <td class="py-0"><a href="/finder/player/{{$village->player}}/1">{{$village->player}}</td>
                        <td class="py-0" data-toggle="tooltip" data-placement="top" title="{{$tribe}}"><img alt="" src="/images/x.gif" class="tribe {{$tribe}}"></td>
                        <td class="py-0"><a href="/finder/alliance/{{$village->alliance}}/1">{{$village->alliance}}</td>
                        <td class="py-0">{{$village->population}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>


@endsection

@push('scripts')
<script>
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("sortableTable");
    switching = true;
    dir = "asc"; 
    while (switching) {
      	switching = false;
      	rows = table.rows;
      	for (i = 1; i < (rows.length - 1); i++) {
        	shouldSwitch = false;
        	x = rows[i].getElementsByTagName("TD")[n];
        	y = rows[i + 1].getElementsByTagName("TD")[n];
        	if (dir == "asc") {
          		if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            		shouldSwitch= true;
            		break;
         		}
        	} else if (dir == "desc") {
          		if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            		shouldSwitch = true;
            		break;
          		}
    		}
      	}
      	if (shouldSwitch) {
        	rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        	switching = true;
        	switchcount ++;      
      	} else {
        	if (switchcount == 0 && dir == "asc") {
          		dir = "desc";
          		switching = true;
        	}
      	}
	}
}
</script>
@endpush
