@extends('Finders.Natar.natarFinder')

@section('result')

<!-- ========================================= Natar Finder -- Village found ======================================================== -->

    <div class="card float-md-left my-1 p-0 col-md-12 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Natar Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-8 ">
            <table class="table table-hover table-sm small">
                <tr class="h6">
                    <th>Distance</th>
                    <th>Village</th>
                    <th>Population</th>
                    <th>+/- 7 Days</th>
                </tr>
                <tr>
                    <td class="py-0">1.0</td>
                    <td class="py-0"><a href="">Natars 01</td>
                    <td class="py-0">200</td>
                    <td class="py-0">+5</td>
                </tr>
                <tr>
                    <td class="py-0">5.0</td>
                    <td class="py-0"><a href="">Natars 02</td>
                    <td class="py-0">200</td>
                    <td class="py-0">+5</td>
                </tr>
            </table>
        </div>
    </div>

@endsection