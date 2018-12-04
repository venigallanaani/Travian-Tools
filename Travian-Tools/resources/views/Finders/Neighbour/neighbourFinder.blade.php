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
                            <div class="p-2"><strong>Population: </strong>
								<input type="range" class="custom-range col-md-6" min="2" max="2000" step="2" id="range1" name="dist">
							</div>
                            <div  class="p-2">
                                <button class="btn btn-outline-warning px-5" type="submit"><strong>Search Inactives</strong></button>
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

	@yield('result')

@endsection