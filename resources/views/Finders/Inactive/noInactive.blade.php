@extends('Finders.Inactive.inactiveFinder')

@section('result')

<!-- ===================================== Inactive Finder output -- inactives not available ======================================= -->
    <div class="alert alert-danger text-center my-1 float-md-left col-md-12" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Inactive villages not found in given range</a>
    </div>

@endsection