@extends('Finders.Player.playerFinder')

@section('result')

<!-- ==================================== Player Finder Output -- Multiple players found ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-5">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Search Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-10">
            <table class="table table-border-success small table-sm">
                <tr>
                    <th class="">Rank</th>
                    <th class="">Tribe</th>
                    <th class="">Name</th>
                    <th class="">Alliance</th>                    
                    <th class="">Population</th>
                    <th class="">Villages</th>
                </tr>
                @foreach($players as $player)
                    <tr>
                        <td>{{ $player['rank'] }}</td>
                        <td data-toggle="tooltip" data-placement="top" title="{{ $player['tribe'] }}"><img alt="wo" src="/images/x.gif" class="tribe {{ $player['tribe'] }}"></td>
                        <td><a href="/finders/player/{{ $player['player'] }}/1"><strong>{{ $player['player'] }}</strong></a></td>
                        <td><a href="/finders/alliance/{{ $player['alliance'] }}/1"><strong>{{ $player['alliance'] }}</strong></a></td>
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