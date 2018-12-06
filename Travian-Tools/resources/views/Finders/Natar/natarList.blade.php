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
                </tr>
                @foreach($natars as $natar)
                    <tr>
                        <td class="py-0">1.0</td>
                        <td class="py-0"><a href="">{{$natar['village']}}</td>
                        <td class="py-0">{{$natar['population']}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection