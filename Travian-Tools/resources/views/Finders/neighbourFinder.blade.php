@extends('Finders.template')

@section('body')

<!-- =================================== Neighbour Finder input screen================================== -->
    <div class="card float-md-left col-md-12 mt-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Neighbour Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="/finder/neighbour" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless mt-2">
                    <tr>
                        <td class="col-md-5">
                            <div class="p-2">
                                <strong>Coordinates: </strong><input type="text" size="5" name="xCor" required value="0"/> | <input type="text" size="5" name="yCor" required value="0"/>
                            </div>
                            <div class="p-2"><strong>Distance: </strong><input type="number" name="dist" required value="100"/></div>
                            <div class="p-2"><strong>Population: </strong><input type="number" name="dist" required value="100"/></div>
                            <div  class="p-2">
                                <button class="btn btn-outline-warning px-5" type="submit">Search Inactives</button>
                            </div>
                        </td>
                        <td class="col-md-7 mx-2 font-italic align-middle">
                            <p class="p-5"><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <!-- ===================================== Neighbour Finder output -- village not available ======================================= -->
    <div class="alert alert-danger text-center my-1 float-md-left col-md-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        No Neighbours found in given range</a>
    </div>
<!-- ========================================= Natar Finder -- Village found ======================================================== -->

    <div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Neighbourhood Scan</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-10 ">
            <table class="table table-hover table-sm">
                <tr>
                    <th>Distance</th>
                    <th>Village</th>
                    <th>Player</th>
                    <th>Alliance</th>
                    <th>Pop<small>(+/- 7 Days)</small></th>
                </tr>
                <tr>
                    <td>1.0</td>
                    <td><a href="">Village 01</td>
                    <td><a href="">Player 01</td>
                    <td><a href="">Alliance 01</td>
                    <td>200<span class="text-success">(+5)</span></td>
                </tr>
                <tr>
                    <td>2.0</td>
                    <td><a href="">Village 02</td>
                    <td><a href="">Player 02</td>
                    <td><a href="">Alliance 02</td>
                    <td>300<span class="text-danger">(-5)</span></td>
                </tr>
            </table>
        </div>
    </div>


@endsection