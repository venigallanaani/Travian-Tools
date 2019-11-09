@extends('Plus.template')

@section('body')
<!-- ==================================== Main Content of the Plus Menu ================================= -->
		<div class="card float-md-left col-md-9 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Leader Access</strong></div>
			<div class="card-text">

		<!-- ============================ Add success/failure notifications ============================== -->
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
				<div class="container">
    	        	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>{{ Session::get($msg) }}
                    </div>
                </div>
            @endif
        @endforeach
        @if(!$players==null)
		<!-- =========================== leadership Options control panel ================================ -->		
				<div class="text-center col-md-11 mx-auto my-2 p-0">
					<table class="table table-hover table-sm table-bordered align-middle small">
						<thead class="bg-info text-white">
    						<tr>
    							<th class="align-middle" rowspan="2">Player</th>
    							<th class="align-middle" rowspan="2">Account</th>
    							<th class="align-middle" rowspan="2">Alliance</th>
    							<th class="align-middle" rowspan="2">Plus</th>
    							<th colspan="6">Leadership Options</th>
    						</tr>
    						<tr class="">
    							<th class="">Leader</th>
    							<th class="">Defense</th>
    							<th class="">Offense</th>
    							<th class="">Resources</th>
    							<th class="">Artifacts</th>
    							<th class="">Wonder</th>
    						</tr>
						</thead>
					@foreach($players as $player)
						<tr>											
							<td><a href="{{route('findPlayer')}}/{{$player['account']}}/1">{{$player['account']}}</a></td>
							<td><a href="/plus/member/{{$player['user']}}">{{$player['user']}}</a></td>
							<td><a href="{{route('findAlliance')}}/{{$player['alliance']}}/1">{{$player['alliance']}}</a></td>					
            				<td><a href="javascript:void(0)" onClick="updPlus({{$player['id']}},'plus')">
            							<input type="checkbox" @if($player['plus']==1) checked @endif/></a></td>
            				<td><a href="javascript:void(0)" onClick="updPlus({{$player['id']}},'leader')">
            							<input type="checkbox" @if($player['leader']==1) checked @endif/></a></td>
            				<td><a href="javascript:void(0)" onClick="updPlus({{$player['id']}},'defense')">
            							<input type="checkbox" @if($player['defense']==1) checked @endif/></a></td>
            				<td><a href="javascript:void(0)" onClick="updPlus({{$player['id']}},'offense')">
            							<input type="checkbox" @if($player['offense']==1) checked @endif/></a></td>
            				<td><a href="javascript:void(0)" onClick="updPlus({{$player['id']}},'resources')">
            							<input type="checkbox" @if($player['resources']==1) checked @endif/></a></td>
            				<td><a href="javascript:void(0)" onClick="updPlus({{$player['id']}},'artifact')">
            							<input type="checkbox" @if($player['artifact']==1) checked @endif/></a></td>
            				<td><a href="javascript:void(0)" onClick="updPlus({{$player['id']}},'wonder')">
            							<input type="checkbox" @if($player['wonder']==1) checked @endif/></a></td>				       
            			</tr>
					@endforeach					
					</table>
				</div>	
		@endif		
			</div>
		</div>
@endsection


@push('scripts')

<script>
function updPlus(id,sts)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            console.log(xmlhttp.responseText);
        }
    };
    xmlhttp.open("GET", "/leader/access/update/"+id+"/"+sts, true);
    xmlhttp.send();
}
</script>

@endpush
