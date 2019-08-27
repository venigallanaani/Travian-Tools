@extends('Finders.template')

@section('body')

<!-- =================================== Neighbour Finder input screen================================== -->
    <div class="card float-md-left col-md-12 mt-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Neighbour Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="/finders/neighbour" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless mt-2">
                    <tr>
                        <td class="">
                            <div class="p-2">
                                <strong>Coordinates: </strong><input type="text" name="xCor" size="3" required value="{{old('xCor') ?? '0'}}"/> | <input type="text" size="3" name="yCor" required value="{{old('yCor') ?? '0'}}"/>
                            </div>
                            <div class="px-2 py-1"><strong>Distance: </strong><input type="text" size="5" name="dist" required value="{{old('dist') ?? '50'}}"/></div>
                            <div class="px-2 py-1"><strong>Min Pop : </strong><input type="text" size="5" min=2 name="pop" required value="{{old('pop') ?? '2'}}"/></div>
                            <div class="px-2 py-1"><strong>Natars : </strong><input type="checkbox" min=2 name="natar"/></div>
                            <div  class="p-2 py-1">
                                <button class="btn btn-outline-warning px-5" type="submit"><div class="mx-1"><strong>Scan Neighbourhood</strong></div></button>
                            </div>
                        </td>
                        <td class="mx-2 font-italic align-middle">
                            <p class="p-5"><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

	@yield('result')

@endsection