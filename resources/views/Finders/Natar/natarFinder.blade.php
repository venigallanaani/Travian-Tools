@extends('Finders.template')

@section('body')
<!-- =================================== Natar Finder input screen================================== -->
    <div class="card float-md-left my-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Natar Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="/finders/natar" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless my-2">
                    <tr>
                        <td class="">
                            <div class="p-2">
                                <strong>Coordinates: </strong><input type="text" size="5" name="xCor" required value="{{isset($xCor) ? $xCor : 0}}"/> | <input type="text" size="5" name="yCor" required value="{{isset($yCor) ? $yCor : 0}}"/>
                            </div>
                            <div><strong>Distance: </strong><input type="number" size="5" name="dist" required value="{{isset($dist) ? $dist : 50}}"/></div>
                            <div  class="p-2">
                                <button class="btn btn-outline-warning px-5" type="submit"><strong>Search Natars</strong></button>
                            </div>
                        </td>
                        <td class="col-md-7 col-7 col-lg-7 mx-2">
                            <p><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

	@yield('result')

@endsection