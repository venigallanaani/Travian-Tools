@extends('Finders.Neighbour.neighbourFinder')

@section('result')


<!-- ========================================= Natar Finder -- Village found ======================================================== -->

    <div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Neighbourhood Scan</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-10 ">
            <table class="table table-hover table-sm small">
                <tr class="h6">
                    <th>Distance</th>
                    <th>Village</th>
                    <th>Player</th>
                    <th>Alliance</th>
                    <th>Pop<small>(+/- 7 Days)</small></th>
                </tr>
                <tr>
                    <td class="py-0">1.0</td>
                    <td class="py-0"><a href="">Village 01</td>
                    <td class="py-0"><a href="">Player 01</td>
                    <td class="py-0"><a href="">Alliance 01</td>
                    <td class="py-0">200<span class="text-success">(+5)</span></td>
                </tr>
                <tr>
                    <td class="py-0">2.0</td>
                    <td class="py-0"><a href="">Village 02</td>
                    <td class="py-0"><a href="">Player 02</td>
                    <td class="py-0"><a href="">Alliance 02</td>
                    <td class="py-0">300<span class="text-danger">(-5)</span></td>
                </tr>
            </table>
        </div>
    </div>


@endsection