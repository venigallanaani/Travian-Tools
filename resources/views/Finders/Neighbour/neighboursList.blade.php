@extends('Finders.Neighbour.neighbourFinder')

@section('result')


<!-- ========================================= Natar Finder -- Village found ======================================================== -->

    <div class="card float-md-left my-1 p-0 col-md-12 shadow mb-5">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Neighbourhood Scan</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-10 ">
            <table class="table table-hover table-sm small" id="sortableTable">
                <tr class="h6">
                    <th>Distance</th>
                    <th>Village</th>
                    <th>Coordinates</th>
                    <th>Player</th>
                    <th>Tribe</th>
                    <th>Alliance</th>
                    <th>Population</th>
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
                        <td class="py-0">{{round(sqrt(pow(($xCor-$village->x),2)+pow(($yCor-$village->y),2)),1)}}</td>
                        <td class="py-0">{{$village->village}}</td>
                        <td class="py-0"><a href="https://{{Session::get('server.url')}}/karte.php?x={{$village->x}}&y={{$village->y}}" target="_blank">{{$village->x}}|{{$village->y}}</a></td>
                        <td class="py-0"><a href="/finders/player/{{$village->player}}/1">{{$village->player}}</a></td>
                        <td class="py-0" data-toggle="tooltip" data-placement="top" title="{{$tribe}}"><img alt="" src="/images/x.gif" class="tribe {{$tribe}}"></td>
                        <td class="py-0"><a href="/finders/alliance/{{$village->alliance}}/1">{{$village->alliance}}</a></td>
                        <td class="py-0">{{$village->population}}</td>
                    </tr>
                @endforeach
            </table>      
        </div>
    </div>


@endsection

@push('scripts')
<script>

</script>
@endpush
