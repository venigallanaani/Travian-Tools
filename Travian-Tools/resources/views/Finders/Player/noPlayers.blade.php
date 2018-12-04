@extends('Finders.Player.playerFinder')

@section('result')

<!-- ===================================== Player Finder output -- Player not available ======================================= -->
    <div class="alert alert-danger text-center mb-1 float-md-left col-md-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Player <strong>{{ $player }}</strong> not found.</a>
    </div>
    
@endsection