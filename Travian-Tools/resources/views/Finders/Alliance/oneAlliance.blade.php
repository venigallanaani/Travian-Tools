@extends('Finders.Alliance.allianceFinder')

@section('result')    
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
                        <td class="py-0">1</td>
                        <td class="py-0"><a href=""><strong>Neo</strong></a></td>
                        <td class="py-0">10</td>
                        <td class="py-0">12345</td>
                        <td class="py-0">20</td>
                    </tr>
                    <tr>
                        <td class="py-0">2</td>
                        <td class="py-0"><a href=""><strong>Neo</strong></a></td>
                        <td class="py-0">10</td>
                        <td class="py-0">12345</td>
                        <td class="py-0">20</td>
                    </tr>                    
                    <tr>
                        <td class="py-0">3</td>
                        <td class="py-0"><a href=""><strong>Neo</strong></a></td>
                        <td class="py-0">10</td>
                        <td class="py-0">12345</td>
                        <td class="py-0">20</td>
                    </tr>                    
                    <tr>
                        <td class="py-0">4</td>
                        <td class="py-0"><a href=""><strong>Neo</strong></a></td>
                        <td class="py-0">10</td>
                        <td class="py-0">12345</td>
                        <td class="py-0">20</td>
                    </tr>
                </table>
            </div>         
        </div>
    </div>
@endsection