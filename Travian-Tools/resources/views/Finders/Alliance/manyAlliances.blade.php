@extends('Finders.Alliance.allianceFinder')

@section('result')

<!-- ==================================== Alliance Finder Output -- Multiple Alliances found ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Search Results</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <table class="table table-border-success">
                <tr>
                    <th>Rank</th>
                    <th>Alliance</th>
                    <th>Players</th>                    
                    <th>Population</th>
                    <th>Villages</th>
                </tr>
                <tr>
                    <td>10</td>                    
                    <td><a href="/finder/alliance/1823/1"><strong>1823</strong></a></td>
                    <td>10</td>
                    <td>12000</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>100</td>                    
                    <td><a href="/finder/alliance/123456/1"><strong>123456</strong></a></td>
                    <td>8</td>
                    <td>1200</td>
                    <td>10</td>
                </tr>
            </table>
        </div>
    </div>
@endsection