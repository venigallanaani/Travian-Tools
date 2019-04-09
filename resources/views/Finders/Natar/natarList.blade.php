@extends('Finders.Natar.natarFinder')

@section('result')

<!-- ========================================= Natar Finder -- Village found ======================================================== -->

    <div class="card float-md-left my-1 p-0 col-md-12 shadow mb-5">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Natar Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-8 ">
            <table class="table table-hover table-sm small" id="sortableTable">
                <tr class="h6">
                    <th onclick="sortTable(1)">Distance</th>
                    <th onclick="sortTable(2)">Village</th>
                    <th onclick="sortTable(3)">Population</th>
                </tr>
                @foreach($natars as $natar)
                    <tr>
                        <td class="py-0">{{round(sqrt(pow(($xCor-$natar->x),2)+pow(($yCor-$natar->y),2)),1)}}</td>
                        <td class="py-0"><a href="https://{{Session::get('server.url')}}/karte.php?x={{$natar->x}}&y={{$natar->y}}" target="_blank">{{$natar->village}}</td>
                        <td class="py-0">{{$natar->population}}</td>
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
