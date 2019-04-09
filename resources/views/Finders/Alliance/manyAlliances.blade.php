@extends('Finders.Alliance.allianceFinder')

@section('result')

<!-- ==================================== Alliance Finder Output -- Multiple Alliances found ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-5">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Search Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-8">
            <table class="table table-border-success table-sm">
                <tr>
                    <th>Rank</th>
                    <th>Alliance</th>
                    <th>Players</th>                    
                    <th>Population</th>
                    <th>Villages</th>
                </tr>                
                @foreach($alliances as $alliance)
                    <tr>
                        <td>{{$alliance['rank']}}</td>                    
                        <td><a href="/finders/alliance/{{$alliance['alliance']}}/1"><strong>{{$alliance['alliance']}}</strong></a></td>
                        <td>{{$alliance['players']}}</td>
                        <td>{{$alliance['population']}}</td>
                        <td>{{$alliance['villages']}}</td>
                    </tr>                
                @endforeach
            </table>
            <small>{{ $alliances->links() }}</small>
        </div>
    </div>
@endsection