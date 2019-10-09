@extends('Finders.template')

@section('body')

<!-- =============================================Finders Main Menu============================================ -->
    <div class="card float-md-left col-md-12 col-12 mt-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Finders Overview</strong>
        </div>
        <div class="card-text">
            <p class="col-md-9 col-9 mx-auto align-middle pt-2">Finders will help you with finding details on the server such as player, alliance, neighbours, or inactive players.</p>
            <table class="table table-borderless col-md-10 col-10 mx-auto">
                <tr>
                    <td class="align-middle"><a href="{{route('findPlayer')}}" class="text-success"><strong>Player Finder</strong></a></td>
                    <td class="font-italic">Helps you with finding the details on the in-game account and links to the statistics of the player.</td>
                </tr>
                <tr>
                    <td class="align-middle"><a href="{{route('findAlliance')}}" class="text-success"><strong>Alliance Finder</strong></a></td>
                    <td class="font-italic">Helps you with finding the details of the in-game alliance details and links to the alliance statistics.</td>
                </tr>
                <tr>
                    <td class="align-middle"><a href="{{route('findInactive')}}" class="text-success"><strong>Inactive Finder</strong></a></td>
                    <td class="font-italic">Displays the list of the players whose population didn't change or only dropped in last 5 days from the input coordinates. 
                    	Can be filtered by the population of the villages.</td>
                </tr>
                <tr>
                    <td class="align-middle"><a href="{{route('findNatar')}}" class="text-success"><strong>Natar Finder</strong></a></td>
                    <td class="font-italic">Displays the natar villages within the range of the input coordinates.</td>
                </tr>
                <tr>
                    <td class="align-middle"><a href="{{route('findNeighbour')}}" class="text-success"><strong>Neighbour Finder</strong></a></td>
                    <td class="font-italic">Helps you know the neighbours better by scanning the specified range from the given coordinates. 
                    	Can be filtered based on the population and alliance names. Natars can be included into the search as well.</td>
                </tr>                   
            </table>
        </div>
    </div>
@endsection