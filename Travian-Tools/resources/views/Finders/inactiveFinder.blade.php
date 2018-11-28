@extends('Finders.template')

@section('body')
<!-- =================================== Inactive Finder input screen================================== -->
    <div class="card float-md-left my-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Inactive Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form>
                <table class="table table-borderless my-2">
                    <tr>
                        <td class="col-md-5">
                            <div class="px-2 py-1">
                                <strong>Coordinates : </strong><input type="text" size="5" name="xCor" required value="0"/> | <input type="text" size="5" name="yCor" required value="0"/>
                            </div>
                            <div class="px-2 py-1"><strong>Distance : </strong><input type="number" name="dist" required value="100"/></div>
                            <div class="px-2 py-1"><strong>Population : </strong><input type="number" name="pop" required value="100"/></div>
                            <div class="px-2 py-1">
                                <button class="btn btn-outline-warning px-5" type="submit">Search Inactives</button>
                            </div>
                        </td>
                        <td class="col-md-7 mx-2 font-italic align-middle">
                            <p class="p-2"><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<!-- ===================================== Inactive Finder output -- inactives not available ======================================= -->
    <div class="alert alert-danger text-center my-1 float-md-left col-md-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Inactive villages not found in given range</a>
    </div>

<!-- ==================================== Inactive Finder Output -- List Inactives ==================================== -->
    <div class="card float-md-left shadow col-md-12 px-0 mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Inactive Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-12">
            <table id="sortableTable" class="table table-border-success table-hover table-sm">
                <tr>
                    <th onclick="sortTable(0)" class="col-md-2">Distance</th>
                    <th onclick="sortTable(1)" class="col-md-2">Village</th>                    
                    <th onclick="sortTable(2)" class="col-md-2">Player</th>
                    <th onclick="sortTable(3)" class="col-md-2">Alliance</th>                    
                    <th onclick="sortTable(4)" class="col-md-2">Pop<small>(+/- 7 days)</small></th>
                    <th onclick="sortTable(5)" class="col-md-2">Status</th>
                </tr>
                <tr>
                    <td>1.1</td>
                    <td><a href="" target="_blank">Village 01</a></td>                    
                    <td><a href="">Player 01</a></td>
                    <td><a href="">Alliance 01</a></td>
                    <td>100(0)</td>
                    <td class="text-dark">Inactive</td>
                </tr>
                <tr>
                    <td>2.2</td>
                    <td><a href="" target="_blank">Village 02</a></td>
                    <td><a href="">Player 02</a></td>
                    <td><a href="">Alliance 02</a></td>
                    <td>600(-10)</td>
                    <td class="text-danger">Attack</td>
                </tr>
                <tr>
                    <td>4.3</td>
                    <td><a href="" target="_blank">Village 03</a></td>
                    <td><a href="">Player 03</a></td>
                    <td><a href="">Alliance 03</a></td>
                    <td>300(0)</td>
                    <td class="text-dark">Inactive</td>
                </tr>
                <tr>
                    <td>8.4</td>
                    <td><a href="" target="_blank">Village 04</a></td>
                    <td><a href="">Player 04</a></td>
                    <td><a href="">Alliance 04</a></td>
                    <td>400(0)</td>
                    <td class="text-dark">Inactive</td>
                </tr>
            </table>
        </div>
    </div>

@endsection