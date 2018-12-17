@extends('Plus.template')

@section('body')

	<!-- =============================================Plus Overview=========================================== -->
    <div class="card float-md-left col-md-9 mt-1 p-0 shadow">
        <div class="card-header h4 py-2 bg-info text-white">
            <strong>Member Details</strong>
        </div>
        <div class="card-text">
            <div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table table-hover table-sm table-bordered align-middle small">
						<thead class="bg-dark text-white">
    						<tr>
    							<th class="col-md-2">Player</th>
    							<th class="col-md-2">TT Account</th>
    							<th class="col-md-2">Alliance</th>
    							<th class="col-md-2">Sitter 1</th>
    							<th class="col-md-2">Sitter 2</th>
    							<th class="col-md-2">Last Login Date</th>
    						</tr>
						</thead>
						@foreach($members as $member)
    						<tr class="">
    							<td><a href="/finder/player/{{$member->account}}/1" target="_blank">{{$member->account}}</a></td>
    							<td><a href="/plus/member/{{$member->id}}">{{$member->user}}</a></td>
    							<td>Alliance1</td>
    							<td>sitter 1</td>
    							<td>sitter 2</td>
    							<td>20-11-2018</td>							
    						</tr>
						@endforeach
					</table>
				</div>
        </div>
    </div>
@endsection