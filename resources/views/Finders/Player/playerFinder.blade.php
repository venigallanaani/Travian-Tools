@extends('Finders.template')

@section('body')

<!-- =================================== Player Finder input screen================================== -->

    <div class="card float-md-left shadow mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Player Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="{{route('findPlayer')}}" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless mt-2">
                    <tr>
                        <td class="">
                            <div class="p-2">
                                <strong>Player Name: </strong><input type="text" size="15" name="plrNm" value="{{isset($plrNm)? $plrNm : ''}}" required/>
                            </div>
                            <div  class="p-2">
                                <button class="btn btn-outline-warning px-5" type="submit"><strong>Search Player</strong></button>
                            </div>
                        </td>
                        <td class="col-md-7 col-7 col-lg-7 mx-2 font-italic">
                            <p class="p-2"><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
	
	@yield('result')  



@endsection