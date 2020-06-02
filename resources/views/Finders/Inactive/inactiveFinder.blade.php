@extends('Finders.template')

@section('body')
<!-- =================================== Inactive Finder input screen================================== -->
    <div class="card float-md-left mb-1 p-0 shadow">
        <div class="card-header h5 py-2 bg-success text-white">
            <strong>Inactive Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="{{route('findInactive')}}" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless my-2">
                    <tr>
                        <td class="">
                            <div class="px-2 py-1">
                                <strong>Coordinates : </strong><input type="text" size="3" name="xCor" required value="{{isset($xCor) ? $xCor : 0}}"/> | <input type="text" size="3" name="yCor" required value="{{isset($yCor) ? $yCor : 0}}"/>
                            </div>                            
                            <div class="px-2 py-1"><strong>Min Population : </strong><input type="text" size="5" min=0 name="pop" required value="{{isset($pop) ? $pop : 2}}"/></div>
                            <div class="px-2 py-1">
                                <button class="btn btn-outline-warning px-5" type="submit"><div class="mx-3"><strong>Search Inactives</strong></div></button>
                            </div>
                        </td>
                        <td class="col-md-7 col-7 col-lg-7 mx-2 font-italic align-middle">
                            <p class="p-2"><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
	
	@yield('result')

@endsection