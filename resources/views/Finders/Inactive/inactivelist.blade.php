@extends('Finders.Inactive.inactiveFinder')

@section('result')

<!-- ==================================== Inactive Finder Output -- List Inactives ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Inactive Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-12">
            <table id="sortableTable" class="table table-border-success table-hover table-sm small">
                <tr class="h6">
                    <th onclick="sortTable(0)" class="col-md-1">Distance</th>
                    <th onclick="sortTable(1)" class="col-md-2">Village</th>                    
                    <th onclick="sortTable(2)" class="col-md-2">Player</th>
                    <th class="col-md-1">Tribe</th>
                    <th onclick="sortTable(3)" class="col-md-2">Alliance</th>   
                    <th onclick="sortTable(4)" class="col-md-2">Pop<small>(+/- 7 days)</small></th>
                    <th onclick="sortTable(5)" class="col-md-2">Status</th>
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
            			
            			if($village->status=='Inactive'){	$status='text-dark';	}
            			else{	$status='text-danger';	}
        			@endphp
                    <tr>
                        <td class="py-0">{{round(sqrt(pow(($x-$village->x),2)+pow(($y-$village->y),2)),1)}}</td>
                        <td class="py-0"><a href="https://{{Session::get('server.url')}}/karte.php?x={{$village->x}}&y={{$village->y}}" target="_blank">{{$village->village}}</a></td>                    
                        <td class="py-0"><a href="/finder/player/{{$village->player}}/1">{{$village->player}}</a></td>
                    	<td class="py-0" data-toggle="tooltip" data-placement="top" title="{{$tribe}}"><img alt="" src="/images/x.gif" class="tribe {{$tribe}}"></td>
                        <td class="py-0"><a href="/finder/alliance/{{$village->alliance}}/1">{{$village->alliance}}</a></td>                        
                        <td class="py-0">{{$village->population}}({{$village->diffPop}})</td>
                        <td class="{{$status}} py-0">{{$village->status}}</td>
                    </tr>                
                @endforeach                
            </table>
        </div>
    </div>

@endsection