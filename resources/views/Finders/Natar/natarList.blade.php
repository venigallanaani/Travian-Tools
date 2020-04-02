@extends('Finders.Natar.natarFinder')

@section('result')

<!-- ========================================= Natar Finder -- Village found ======================================================== -->

    <div class="card float-md-left my-1 p-0 col-md-12 shadow mb-5">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Natar Results</strong>
        </div>
        <div class="card-text mx-auto text-center col-md-8 ">
            <table class="table table-hover">
                <tr class="h6">
                    <th onclick="">Distance</th>
                    <th onclick="">Village</th>
                    <th onclick="">Population</th>
                </tr>
                @foreach($natars as $natar)
                    <tr>
                        <td class="py-0">{{round($natar->distance,1)}}</td>
                        <td class="py-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$natar->x}}&y={{$natar->y}}" target="_blank">{{$natar->village}}</td>
                        <td class="py-0">{{$natar->population}}</td>
                    </tr>
                @endforeach
            </table>
			{{ $natars->links() }}
        </div>
    </div>

@endsection

