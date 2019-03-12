@extends('Finders.template')

@section('body')
<!-- =================================== Inactive Finder input screen================================== -->
    <div class="card float-md-left my-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Inactive Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="/finder/inactive" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless my-2">
                    <tr>
                        <td class="col-md-5">
                            <div class="px-2 py-1">
                                <strong>Coordinates : </strong><input type="text" size="5" name="xCor" required value="{{old('xCor') ?? '0'}}"/> | <input type="text" size="5" name="yCor" required value="{{old('yCor') ?? '0'}}"/>
                            </div>
                            <div class="px-2 py-1"><strong>Distance : </strong><input type="number" min=0 name="dist" required value="{{old('dist') ?? '25'}}"/></div>
                            <div class="px-2 py-1"><strong>Min Pop : </strong><input type="number" min=0 name="pop" required value="{{old('pop') ?? '2'}}"/></div>
                            <div class="px-2 py-1">
                                <button class="btn btn-outline-warning px-5" type="submit"><strong>Search Inactives</strong></button>
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
	
	@yield('result')

@endsection