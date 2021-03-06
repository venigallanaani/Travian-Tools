@extends('Finders.Player.playerFinder')

@section('result')
<!-- =========================== Player Finder Output -- Single player ====================================== -->

    <div class="card float-md-left shadow col-md-12 px-0 mb-5">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Player Details</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-12">
            <div class="col-md-6 mx-auto">
                <table class="table table-borderless mx-auto mt-3 text-left">                    
                    <tr>
                        <td class="py-1"><strong><span class="text-success">Profile Name</span></strong></td>
                        <td class="py-1">: {{ $player['player'] }}</td>
                    </tr>
                    <tr>
                        <td class="py-1"><strong><span class="text-success">Tribe</span></strong></td>
                        <td class="py-1">: {{ $player['tribe'] }}</td>
                    </tr>
                    <tr>
                        <td class="py-1"><strong><span class="text-success">Alliance</span></strong></td>
                        <td class="py-1">: <a href="/finders/alliance/{{ $player['alliance'] }}/1">{{ $player['alliance'] }}</a></td>
                    </tr>
                    <tr>
                        <td class="py-1"><strong><span class="text-success">Rank</span></strong></td>
                        <td class="py-1">: {{ $player['rank'] }}</td>
                    </tr>
                    <tr>
                        <td class="py-1"><strong><span class="text-success">Population</span></strong></td>
                        <td class="py-1">: {{ $player['population'] }} <span class="small text-@if($player['diffpop'] >0 ){{'success'}}@else{{'danger'}}@endif"
                        			>({{ $player['diffpop'] }})</span></td>
                    </tr>
                    <tr>
                        <td class="py-1"><strong><span class="text-success">Villages</span></strong></td>
                        <td class="py-1">: {{ $player['villages'] }}</td>
                    </tr>                            
                </table>
            </div>
                
            <div class="col-md-8 text-center mx-auto mt-1">
                <table class="table table-bordered text-center table-sm">
                    <tr>                            
                        <td colspan="2" class="h5 text-white bg-success"><strong>Ingame Links</strong></td>
                    </tr>
                    <tr>                            
                        <td class=""><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$player['uid']}}" target="_blank">Travian Profile</a></td>
                        <td class=""><a href="https://{{Session::get('server.url')}}/statistiken.php?id=3&name={{$player['player']}}" target="_blank">Hero XP</a></td>
                    </tr>
                    <tr>                            
                        <td class=""><a href="https://{{Session::get('server.url')}}/statistiken.php?id=0&idSub=1&name={{$player['player']}}" target="_blank">Attack Points</a></td>
                        <td class=""><a href="https://{{Session::get('server.url')}}/statistiken.php?id=0&idSub=2&name={{$player['player']}}" target="_blank">Defense Points</a></td>
                    </tr>
                </table>                

                <table class="table table-bordered table-hover table-sm col-md-12">
                    <thead class="thead">
                        <tr>
                            <th colspan="4" class="h5 text-white bg-success"><strong>Villages</strong></th>
                        </tr>
                        <tr>
                            <th class="">#</th>
                            <th class="">Village Name</th>
                            <th class="">Population</th>
                            <th class="">Coordinates</th>
                        </tr>
                    </thead>
                    @foreach($villages as $index => $village)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td class="text-left">{{ $village['village']}}</td>
                            <td>{{$village['population']}} <span class="small text-@if($village['diffPop'] >0 ){{'success'}}@else{{'danger'}}@endif"
                                    			>({{ $village['diffPop'] }})</span></td>
                            <td><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$village['x']}}&y={{$village['y']}}" target="_blank">
                            	<strong>{{$village['x']}}|{{$village['y']}}</strong></a></td>
                        </tr>                
                    @endforeach
                </table>
            </div>
        </div>          
    </div>
@endsection