@extends('Finders.Alliance.allianceFinder')

@section('result')
<!-- ===================================== Alliance Finder output -- Alliance not available ======================================= -->
    <div class="alert alert-danger text-center mb-1 float-md-left col-md-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Alliance <strong>{{ $allyNm }}</strong> not found.</a>
    </div>
@endsection