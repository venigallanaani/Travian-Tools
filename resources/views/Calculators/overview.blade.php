@extends('Calculators.template')

@section('body')

<!-- =============================================Finders Main Menu============================================ -->
    <div class="card float-md-left col-md-12 col-12 mt-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-primary text-white">
            <strong>Calculators Overview</strong>
        </div>
        <div class="card-text">
            <p class="col-md-9 col-9 mx-auto align-middle pt-2">Calculators are created to help with the mundane calculcations of the Travian.</p>
            <table class="table table-borderless col-md-10 col-10 mx-auto">
                <tr>
                    <td class="align-middle"><a href="{{route('cropper')}}" class="text-primary"><strong>Cropper Development</strong></a></td>
                    <td class="font-italic">Displays the sequence of steps for the optimal development route for Crop tiles.</td>
                </tr>
                <tr>
                    <td class="align-middle"><a href="{{route('wheatScout')}}" class="text-primary"><strong>Wheat Scout</strong></a></td>
                    <td class="font-italic">Helps in determining the troops outside of the village based on the crop consumption reports.</td>
                </tr>                  
            </table>
        </div>
    </div>
@endsection