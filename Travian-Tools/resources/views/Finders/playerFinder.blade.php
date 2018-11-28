@extends('Finders.template')

@section('body')

<!-- =================================== Player Finder input screen================================== -->
    <div class="card float-md-left shadow mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Player Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="/finder/player" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless mt-2">
                    <tr>
                        <td class="col-md-5">
                            <div class="p-2">
                                <strong>Player Name: </strong><input type="text" size="15" name="plrNm" required/>
                            </div>
                            <div  class="p-2">
                                <button class="btn btn-outline-warning px-5" type="submit">Search Player</button>
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
<!-- ===================================== Player Finder output -- Player not available ======================================= -->
    <div class="alert alert-danger text-center mb-1 float-md-left col-md-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Player not found.</a>
    </div>

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
    
<!-- =========================== Player Finder Output -- Single player ====================================== -->

    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Player Details</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <div class="col-md-12">
                <table class="table table-borderless mx-auto mt-3">
                    <tr>
                        <td>
                            <table class="table table-borderless text-left">
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Profile Name</span></strong></td>
                                    <td class="py-1">: Barca</td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Tribe</span></strong></td>
                                    <td class="py-1">: Teuton</td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Alliance</span></strong></td>
                                    <td class="py-1">: <a href="">1812</a></td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Rank</span></strong></td>
                                    <td class="py-1">: 100</td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Population</span></strong></td>
                                    <td class="py-1">: 1234</td>
                                </tr>
                                <tr>
                                    <td class="py-1"><strong><span class="text-success">Villages</span></strong></td>
                                    <td class="py-1">: 10</td>
                                </tr>
                            </table>
                        </td>
                        <td>                                
                            <div class="bg-secondary float-md-left rounded h-100">
                                <p>Tribe Image -- tribe.png</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
                
            <div class="col-md-12 text-center mt-1 float-md-left">
                <table class="table table-bordered text-center table-sm">
                    <tr>                            
                        <td colspan="2" class="h5 text-white bg-success"><strong>Ingame Links</strong></td>
                    </tr>
                    <tr>                            
                        <td class=""><a href="">Travian Profile</a></td>
                        <td class=""><a href="">Hero XP</a></td>
                    </tr>
                    <tr>                            
                        <td class=""><a href="">Attack Points</a></td>
                        <td class=""><a href="">Defense Points</a></td>
                    </tr>
                </table>                

                <table class="table table-bordered table-hover table-sm">
                    <thead class="thead">
                        <tr>
                            <th colspan="4" class="h5 text-white bg-success"><strong>Villages</strong></th>
                        </tr>
                        <tr>
                            <th class="col-md-1">#</th>
                            <th class="col-md-4">Village Name</th>
                            <th class="col-md-1">Population</th>
                            <th class="col-md-1">Coordinates</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>1</td>
                        <td class="text-left">01 thunderbolt</td>
                        <td>168</td>
                        <td><a href="">1|-46</a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="text-left">02 Barcelona</td>
                        <td>168</td>
                        <td><a href="">1|-46</a></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="text-left">03 Alps</td>
                        <td>168</td>
                        <td><a href="">1|-46</a></td>
                    </tr>
                </table>
            </div>
                

            </div>          
        </div>
    </div>

@endsection