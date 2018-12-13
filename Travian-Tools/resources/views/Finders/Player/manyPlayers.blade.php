@extends('Finders.Player.playerFinder')

@section('result')

<!-- ==================================== Player Finder Output -- Multiple players found ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Search Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-10">
            <table class="table table-border-success small table-sm">
                <tr>
                    <th class="col-md-1">Rank</th>
                    <th class="col-md-1">Tribe</th>
                    <th class="col-md-2">Name</th>
                    <th class="col-md-2">Alliance</th>                    
                    <th class="col-md-1">Population</th>
                    <th class="col-md-1">Villages</th>
                </tr>
                @foreach($players as $player)
                    <tr>
                        <td>{{ $player['rank'] }}</td>
                        <td data-toggle="tooltip" data-placement="top" title="{{ $player['tribe'] }}"><img alt="wo" src="/images/x.gif" class="tribe {{ $player['tribe'] }}"></td>
                        <td><a href="/finder/player/{{ $player['player'] }}/1"><strong>{{ $player['player'] }}</strong></a></td>
                        <td><a href="/finder/alliance/{{ $player['alliance'] }}/1"><strong>{{ $player['alliance'] }}</strong></a></td>
                        <td>{{ $player['population'] }} <span class="small text-@if($player['diffpop'] >0 ){{'success'}}@else{{'danger'}}@endif">
                        	({{ $player['diffpop'] }})</span></td>
                        <td>{{ $player['villages'] }}</td>
                    </tr>                
                @endforeach
            </table>
            <small>{{ $players->links() }}</small>
        </div>
    </div>
    
@endsection