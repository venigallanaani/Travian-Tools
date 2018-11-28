@extends('Finders.template')

@section('body')

<!-- =================================== Alliance Finder input screen================================== -->
    <div class="card float-md-left shadow mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Alliance Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form method="GET" action="/finder/alliance">
                <table class="table table-borderless mt-2">
                    <tr>
                        <td class="col-md-5">
                            <div class="p-2">
                                <strong>Alliance Name: </strong><input type="text" size="15" name="allyNm" required/>
                            </div>
                            <div  class="p-2">
                                <button class="btn btn-outline-warning px-5" type="submit">Search Alliance</button>
                            </div>
                        </td>
                        <td class="col-md-7 mx-2 font-italic">
                            <p class="p-2"><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<!-- ===================================== Alliance Finder output -- Alliance not available ======================================= -->
    <div class="alert alert-danger text-center mb-1 float-md-left col-md-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Alliance not found.</a>
    </div>

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
    
<!-- =========================== alliance Finder Output -- Single alliance ====================================== -->

    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Alliance Details</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-12">
            <div>
                <table class="table table-borderless mx-auto mt-3 text-left">
                    <tr>
                        <td>
                            <table class="mx-auto px-0">
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Alliance</span></strong></td>
                                    <td class="py-1">: <a href="">1812</a></td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Rank</span></strong></td>
                                    <td class="py-1">: 100</td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Players</span></strong></td>
                                    <td class="py-1">: 50</td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Population</span></strong></td>
                                    <td class="py-1">: 12340</td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Villages</span></strong></td>
                                    <td class="py-1">: 1000</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="align-center">
                                <tr><td class="py-1 text-success h5"><strong>Ingame Links</strong></td></tr>
                                <tr><td class="py-1"><a href=""><strong>Travian Profile</strong></a></td></tr>
                                <tr><td class="py-1"><a href=""><strong>Attack Points</strong></a></td></tr>
                                <tr><td class="py-1"><a href=""><strong>Defense Points</strong></a></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>                
            </div>
                
            <div class="mt-1 col-md-8 mx-auto">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="thead">
                        <tr>
                            <th colspan="5" class="h5 text-white bg-success"><strong>Players</strong></th>
                        </tr>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-3">Player</th>
                            <th class="col-md-1">Rank</th>
                            <th class="col-md-2">Population</th>
                            <th class="col-md-1">Villages</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>1</td>
                        <td><a href=""><strong>Neo</strong></a></td>
                        <td>10</td>
                        <td>12345</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><a href=""><strong>Neo</strong></a></td>
                        <td>10</td>
                        <td>12345</td>
                        <td>20</td>
                    </tr>                    
                    <tr>
                        <td>3</td>
                        <td><a href=""><strong>Neo</strong></a></td>
                        <td>10</td>
                        <td>12345</td>
                        <td>20</td>
                    </tr>                    
                    <tr>
                        <td>4</td>
                        <td><a href=""><strong>Neo</strong></a></td>
                        <td>10</td>
                        <td>12345</td>
                        <td>20</td>
                    </tr>
                </table>
            </div>         
        </div>
    </div>

@endsection