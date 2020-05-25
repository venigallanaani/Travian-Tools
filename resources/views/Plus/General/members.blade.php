@extends('Plus.template')

@section('body')

	<!-- =============================================Plus Overview=========================================== -->
    <div class="card float-md-left col-md-10 p-0 shadow">
        <div class="card-header h5 py-2 bg-info text-white">
            <strong>Member Details</strong>
        </div>
        <div class="card-text">
            <div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table table-hover table-sm table-bordered align-middle h6">
						<thead class="bg-dark text-white">
    						<tr>
    							<th class="">Player</th>
    							<th class="">TT Account</th>
    							<th class="">Alliance</th>
    							<th class="">Sitter 1</th>
    							<th class="">Sitter 2</th>    							
    						</tr>
						</thead>
						@foreach($members as $member)
    						<tr class="" style="font-size: 0.9em">
    							<td><a href="{{route('findPlayer')}}/{{$member['player']}}/1" target="_blank">{{$member['player']}}</a></td>
    							<td><a href="/plus/member/{{$member['id']}}">{{$member['account']}}</a></td>
    							<td><a href="{{route('findAlliance')}}/{{$member['alliance']}}/1" target="_blank">{{$member['alliance']}}</a></td>
    							<td><a href="{{route('findPlayer')}}/{{$member['sitter1']}}/1" target="_blank">{{$member['sitter1']}}</a></td>
    							<td><a href="{{route('findPlayer')}}/{{$member['sitter2']}}/1" target="_blank">{{$member['sitter2']}}</a></td>    														
    						</tr>
						@endforeach
					</table>
				</div>
        </div>
    </div>
@endsection