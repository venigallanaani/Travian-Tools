@extends('Finders.template')

@section('body')

<!-- =================================== Alliance Finder input screen================================== -->
    <div class="card float-md-left shadow mb-1">
        <div class="card-header h4 py-2 bg-success text-white">
            <strong>Alliance Finder</strong>
        </div>
        <div class="card-text mx-auto text-center">
            <form action="/finders/alliance" method="POST">
            	{{ csrf_field() }}
                <table class="table table-borderless mt-2">
                    <tr>
                        <td class="">
                            <div class="p-2">
                                <strong>Alliance Name: </strong><input type="text" size="15" name="allyNm" value="{{isset($allyNm)? $allyNm : ''}}" required/>
                            </div>
                            <div  class="p-2">
                                <button class="btn btn-outline-warning px-5" type="submit"><strong>Search Alliance</strong></button>
                            </div>
                        </td>
                        <td class="mx-2 font-italic align-center">
                            <p class="p-2"><small>The Travian maps file is not updated in real time, so expect difference in the statistics of what is displayed on the website vs what is displayed in real time in the game.</small></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
	
	@yield('result')
	
@endsection