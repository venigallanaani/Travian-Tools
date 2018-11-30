@extends('Finders.Player.playerFinder')

@section('result')

<!-- ==================================== Player Finder Output -- Multiple players found ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Search Results</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <table class="table table-border-success">
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Alliance</th>                    
                    <th>Population</th>
                    <th>Villages</th>
                </tr>
                <tr>
                    <td>10</td>
                    <td><a href="/finder/player/Neo/1"><strong>Neo</strong></a></td>
                    <td><a href="/finder/alliance/1823/1"><strong>1823</strong></a></td>
                    <td>1200</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>100</td>
                    <td><a href="/finder/player/Neon/1"><strong>Neon</strong></a></td>
                    <td><a href="/finder/alliance/123456/1"><strong>123456</strong></a></td>
                    <td>120</td>
                    <td>1</td>
                </tr>
            </table>
        </div>
    </div>
    
@endsection