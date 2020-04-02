@extends('Reports.template')

@section('report')

@if(count($reports)>0)	
		<div class="my-2 mx-auto container h6 rounded py-2" style="background-color: #dbeef4">			
    			<strong><span class="blockquote">Report Link: </span></strong><input type="text" id ="link" name="link" value="{{$link}}" class="w-75"/>
    			<button class="btn btn-primary btn-sm px-2" onclick="copyLink()"> Copy Link </button>
		</div>		
	
	@foreach($reports as $report)
	
		<div class="card col-md-12 my-2 shadow p-0">
			<div class="card-header text-center text-white py-0 bg-info">
				<p class="py-1 h4">{{$report['TITLE']}}</p>
			</div>
			<table class="my-2 mx-auto col-md-8">
    			<tr class="p-1 my-0">
    				<td><span class="h6 text-info blockquote"><strong>Report Date:</strong></span></td>
    				<td class="blockquote">{{$report['TIME']}}</td>
    			</tr>
			</table>

			<div>
				<table class="table table-sm col-md-10 mx-auto table-bordered text-center shadow">
					<tr class="font-weight-bold">
						<td class="h5 text-danger"><strong>Attacker</strong></td>						
						<td class="text-left h5" colspan="11"><strong><span class="text-danger">{{explode('from village',$report['ATTACK']['SUBJECT'])[0]}}</span></strong> from village 
							<strong><span class="text-danger">{{explode('from village',$report['ATTACK']['SUBJECT'])[1]}}</span></strong>
						</td>
					</tr>
					<tr>
						<td></td>
					@foreach($tribes[$report['ATTACK']['TRIBE']] as $unit)
						<td class="py-0" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}">
					@endforeach
						<td class="py-0" data-toggle="tooltip" data-placement="top" title="hero"><img alt="" src="/images/x.gif" class="hero"></td>
					</tr>
					<tr>
						<td class="py-0"><strong>Troops</strong></td>
					@foreach($report['ATTACK']['UNITS'] as $unit)
						<td class="@if($unit==0) text-muted @endif h6">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>
					<tr>
						<td class="py-0"><strong>Casualties</strong></td>
					@foreach($report['ATTACK']['LOSES'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>
					<tr>
						<td class="py-0"><strong>Survivours</strong></td>
					@foreach($report['ATTACK']['SURVIVORS'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>
				@if(!empty($report['ATTACK']['BOUNTY']))
					<tr>
						<td class="align-middle"><strong>Bounty</strong></td>
						<td class="text-left small" colspan="11">
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Wood"><img alt="" src="/images/x.gif" class="res wood"> {{$report['ATTACK']['BOUNTY']['WOOD']}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Clay"><img alt="" src="/images/x.gif" class="res clay"> {{$report['ATTACK']['BOUNTY']['CLAY']}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Iron"><img alt="" src="/images/x.gif" class="res iron"> {{$report['ATTACK']['BOUNTY']['IRON']}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Crop"><img alt="" src="/images/x.gif" class="res crop"> {{$report['ATTACK']['BOUNTY']['CROP']}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Carry"><img alt="" src="/images/x.gif" class="stats carry">{{$report['ATTACK']['BOUNTY']['CARRY']}}</span>
						</td>
					</tr>
				@endif
				@if(!empty($report['ATTACK']['INFO']))
					<tr>
						<td class="align-middle"><strong>Information</strong></td>
						<td class="text-left small" colspan="11">
						@if(strtoupper(explode(",",$report['ATTACK']['INFO'][0])[0])=='RESOURCES')
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Wood"><img alt="" src="/images/x.gif" class="res wood"> {{explode(",",$report['ATTACK']['INFO'][0])[1]}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Clay"><img alt="" src="/images/x.gif" class="res clay"> {{explode(",",$report['ATTACK']['INFO'][0])[2]}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Iron"><img alt="" src="/images/x.gif" class="res iron"> {{explode(",",$report['ATTACK']['INFO'][0])[3]}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Crop"><img alt="" src="/images/x.gif" class="res crop"> {{explode(",",$report['ATTACK']['INFO'][0])[4]}}</span>
							<span class="mx-2" data-toggle="tooltip" data-placement="top" title="Cranny"><img alt="" src="/images/x.gif" class="building cranny">{{explode(" ",explode(",",$report['ATTACK']['INFO'][0])[5])[1]}}</span>
						@else
						@foreach($report['ATTACK']['INFO'] as $info)
							<p class="my-0">{{$info}}</p>
						@endforeach
						@endif
						</td>
					</tr>
				@endif
				</table>
			</div>
			
			<div>
				<table class="table table-sm col-md-7 mx-auto table-bordered text-center shadow h6">
					<tr>
						<td class=""></td>
						<td class="text-white bg-danger font-weight-bold h5" colspan="2">Attacker ({{$report['STATS']['OFFENSE']['PERCENT']}} %)</td>
						<td class="text-white bg-success font-weight-bold h5" colspan="2">Defender ({{$report['STATS']['DEFENSE']['PERCENT']}} %)</td>
					</tr>
					<tr>
						<td class="h5">Troops</td>						
						<td class="h6" colspan="2">
							<span data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></span> 
								@if(is_numeric($report['STATS']['OFFENSE']['UPKEEP'])){{number_format($report['STATS']['OFFENSE']['UPKEEP'])}} 
								@else {{$report['STATS']['OFFENSE']['UPKEEP']}} @endif - 
							<span data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></span> 
								@if(is_numeric($report['STATS']['OFFENSE']['LOSS'])){{number_format($report['STATS']['OFFENSE']['LOSS'])}} 
								@else {{$report['STATS']['OFFENSE']['LOSS']}} @endif =
							<span data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></span> 
							@if(is_numeric($report['STATS']['OFFENSE']['REST'])){{number_format($report['STATS']['OFFENSE']['REST'])}} 
							@else {{$report['STATS']['OFFENSE']['REST']}} @endif
						</td>
						
						<td class="h6" colspan="2">
							<span data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></span> 
								@if(is_numeric($report['STATS']['DEFENSE']['UPKEEP'])){{number_format($report['STATS']['DEFENSE']['UPKEEP'])}} 
								@else {{$report['STATS']['DEFENSE']['UPKEEP']}} @endif - 
							<span data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></span> 
								@if(is_numeric($report['STATS']['DEFENSE']['LOSS'])){{number_format($report['STATS']['DEFENSE']['LOSS'])}} 
								@else {{$report['STATS']['DEFENSE']['LOSS']}} @endif =
							<span data-toggle="tooltip" data-placement="top" title="Upkeep"><img alt="" src="/images/x.gif" class="res upkeep"></span> 
							@if(is_numeric($report['STATS']['DEFENSE']['REST'])){{number_format($report['STATS']['DEFENSE']['REST'])}} 
							@else {{$report['STATS']['DEFENSE']['REST']}} @endif
						</td>						
					</tr>
					<tr>
						<td class="h5">Offense</td>
						
						<td class="h6" colspan="2">
							<span data-toggle="tooltip" data-placement="top" title="Total Offense"><img alt="" src="/images/x.gif" class="stats off"></span> 
								@if(is_numeric($report['STATS']['OFFENSE']['OFFENSE'])){{number_format($report['STATS']['OFFENSE']['OFFENSE'])}} 
								@else {{$report['STATS']['OFFENSE']['OFFENSE']}} @endif
						</td>
						
						<td class="h6" colspan="2">
							<span data-toggle="tooltip" data-placement="top" title="Total Offense"><img alt="" src="/images/x.gif" class="stats off"></span> 
								@if(is_numeric($report['STATS']['DEFENSE']['OFFENSE'])){{number_format($report['STATS']['DEFENSE']['OFFENSE'])}} 
								@else {{$report['STATS']['DEFENSE']['OFFENSE']}} @endif
						</td>
					</tr>
					<tr>
						<td class="align-middle h5" rowspan="2">Defense</td>						
						<td class="h6" colspan="2">
							<span data-toggle="tooltip" data-placement="top" title="Total Defense"><img alt="" src="/images/x.gif" class="stats def"></span> 
							@if(is_numeric($report['STATS']['OFFENSE']['DEFENSE'])){{number_format($report['STATS']['OFFENSE']['DEFENSE'])}} 
							@else {{$report['STATS']['OFFENSE']['DEFENSE']}} @endif
						</td>
						
						<td class="h6" colspan="2">
							<span data-toggle="tooltip" data-placement="top" title="Total Defense"><img alt="" src="/images/x.gif" class="stats def"></span> 
							@if(is_numeric($report['STATS']['DEFENSE']['DEFENSE'])){{number_format($report['STATS']['DEFENSE']['DEFENSE'])}} 
							@else {{$report['STATS']['DEFENSE']['DEFENSE']}} @endif
						</td>
					</tr>
					<tr>
						<td class="h6">
							<span data-toggle="tooltip" data-placement="top" title="Infantry Defense"><img alt="" src="/images/x.gif" class="stats dinf"></span> 
							@if(is_numeric($report['STATS']['OFFENSE']['INF'])){{number_format($report['STATS']['OFFENSE']['INF'])}} 
							@else {{$report['STATS']['OFFENSE']['INF']}} @endif
						</td>
						<td class="h6">
							<span data-toggle="tooltip" data-placement="top" title="Cavalry Defense"><img alt="" src="/images/x.gif" class="stats dcav"></span> 
							@if(is_numeric($report['STATS']['OFFENSE']['CAV'])){{number_format($report['STATS']['OFFENSE']['CAV'])}} 
							@else {{$report['STATS']['OFFENSE']['CAV']}} @endif
						</td>
						<td class="h6">
							<span data-toggle="tooltip" data-placement="top" title="Infantry Defense"><img alt="" src="/images/x.gif" class="stats dinf"></span> 
							@if(is_numeric($report['STATS']['DEFENSE']['INF'])){{number_format($report['STATS']['DEFENSE']['INF'])}} 
							@else {{$report['STATS']['DEFENSE']['INF']}} @endif
						</td>
						<td class="h6">
							<span data-toggle="tooltip" data-placement="top" title="Cavalry Defense"><img alt="" src="/images/x.gif" class="stats dcav"></span> 
							@if(is_numeric($report['STATS']['DEFENSE']['CAV'])){{number_format($report['STATS']['DEFENSE']['CAV'])}} 
							@else {{$report['STATS']['DEFENSE']['CAV']}} @endif
						</td>
					</tr>
					<tr>
						<td class="h5">Experience</td>
						<td class="h6" colspan="2"> 
						@if($report['STATS']['OFFENSE']['HERO'] == 0)
							0
						@else
							<img alt="" src="/images/x.gif" class="hero"> {{number_format($report['STATS']['DEFENSE']['LOSS'])}}
						@endif						 
						</td>
						<td class="h6" colspan="2">
						@if($report['STATS']['DEFENSE']['HERO'] == 0)
							0 
						@else
							<img alt="" src="/images/x.gif" class="hero"> {{$report['STATS']['DEFENSE']['HERO']}} / {{number_format($report['STATS']['OFFENSE']['LOSS'])}} 
						@endif 
						</td>
					</tr>	
					<tr>
						<td class="align-middle h5" rowspan="5">Resources</td>
						<td class="py-0 small">
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Wood"><img alt="" src="/images/x.gif" class="res wood"></span> 
								@if(is_numeric($report['STATS']['OFFENSE']['WOOD'])){{number_format($report['STATS']['OFFENSE']['WOOD'])}} 
								@else {{$report['STATS']['OFFENSE']['WOOD']}} @endif</p>
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Clay"><img alt="" src="/images/x.gif" class="res clay"></span> 
								@if(is_numeric($report['STATS']['OFFENSE']['CLAY'])){{number_format($report['STATS']['OFFENSE']['CLAY'])}} 
								@else {{$report['STATS']['OFFENSE']['CLAY']}} @endif</p>
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Iron"><img alt="" src="/images/x.gif" class="res iron"></span> 
								@if(is_numeric($report['STATS']['OFFENSE']['IRON'])){{number_format($report['STATS']['OFFENSE']['IRON'])}} 
								@else {{$report['STATS']['OFFENSE']['IRON']}} @endif</p>
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Crop"><img alt="" src="/images/x.gif" class="res crop"></span> 
								@if(is_numeric($report['STATS']['OFFENSE']['CROP'])){{number_format($report['STATS']['OFFENSE']['CROP'])}} 
								@else {{$report['STATS']['OFFENSE']['CROP']}} @endif</p>							
						</td>
						<td class="align-middle py-0 my-0 h6">
							<span data-toggle="tooltip" data-placement="top" title="All"><img alt="" src="/images/x.gif" class="res all"></span>
							@if(is_numeric($report['STATS']['OFFENSE']['TOTAL'])){{number_format($report['STATS']['OFFENSE']['TOTAL'])}} 
							@else {{$report['STATS']['OFFENSE']['TOTAL']}} @endif
						</td>
						
						<td class="py-0 small">
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Wood"><img alt="" src="/images/x.gif" class="res wood"></span> 
								@if(is_numeric($report['STATS']['DEFENSE']['WOOD'])){{number_format($report['STATS']['DEFENSE']['WOOD'])}} 
								@else {{$report['STATS']['DEFENSE']['WOOD']}} @endif</p>
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Clay"><img alt="" src="/images/x.gif" class="res clay"></span> 
								@if(is_numeric($report['STATS']['DEFENSE']['CLAY'])){{number_format($report['STATS']['DEFENSE']['CLAY'])}} 
								@else {{$report['STATS']['DEFENSE']['CLAY']}} @endif</p>
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Iron"><img alt="" src="/images/x.gif" class="res iron"></span> 
								@if(is_numeric($report['STATS']['DEFENSE']['IRON'])){{number_format($report['STATS']['DEFENSE']['IRON'])}} 
								@else {{$report['STATS']['DEFENSE']['IRON']}} @endif</p>
							<p class="my-0 py-0">
								<span data-toggle="tooltip" data-placement="top" title="Crop"><img alt="" src="/images/x.gif" class="res crop"></span> 
								@if(is_numeric($report['STATS']['DEFENSE']['CROP'])){{number_format($report['STATS']['DEFENSE']['CROP'])}} 
								@else {{$report['STATS']['DEFENSE']['CROP']}} @endif</p>							
						</td>
						<td class="align-middle py-0 my-0 h6">
							<span data-toggle="tooltip" data-placement="top" title="All"><img alt="" src="/images/x.gif" class="res all"></span>
							@if(is_numeric($report['STATS']['DEFENSE']['TOTAL'])){{number_format($report['STATS']['DEFENSE']['TOTAL'])}} 
							@else {{$report['STATS']['DEFENSE']['TOTAL']}} @endif
						</td>
					</tr>					
				</table>			
			</div>		
			
			<div>
				<table class="table table-sm col-md-10 mx-auto table-bordered text-center shadow">
					<tr class="">
						<td class="h5 text-success"><strong>Defender</strong></td>
						<td class="text-left h5" colspan="11"><strong><span class="text-success">{{explode('from village',$report['DEFEND']['SUBJECT'])[0]}}</span></strong> from village <strong><span class="text-success">{{explode('from village',$report['DEFEND']['SUBJECT'])[1]}}</span></strong></td>
					</tr>
					<tr>
						<td></td>
					@foreach($tribes[$report['DEFEND']['TRIBE']] as $unit)						
						<td class="py-0" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}">
					@endforeach
						<td class="py-0"  data-toggle="tooltip" data-placement="top" title="hero"><img alt="" src="/images/x.gif" class="hero"></td>
					</tr>
					<tr>
						<td class="h6"><strong>Troops</strong></td>
					@foreach($report['DEFEND']['UNITS'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>
					<tr>
						<td class="h6"><strong>Casualties</strong></td>
					@foreach($report['DEFEND']['LOSES'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>
					<tr>
						<td class="h6"><strong>Survivours</strong></td>
					@foreach($report['DEFEND']['SURVIVORS'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>					
				</table>
			</div>
			
	@if(!empty($report['REINFORCEMENT']))
		@foreach($report['REINFORCEMENT'] as $reinforcement)
			<div>
				<table class="table table-sm col-md-10 mx-auto table-bordered text-center shadow">
					<tr class="text-white">
						<td class="h5 text-success"><strong>Reinforcements</strong></td>
						<td class="text-left h5 text-success" colspan="11"><strong>{{ucfirst(strtolower($reinforcement['TRIBE']))}}</strong></td>
					</tr>
					<tr>
						<td></td>
					@foreach($tribes[$reinforcement['TRIBE']] as $unit)
						<td class="py-0" data-toggle="tooltip" data-placement="top" title="{{$unit->name}}"><img alt="" src="/images/x.gif" class="units {{$unit->image}}">
					@endforeach
					@if(count($reinforcement['UNITS'])>10)
						<td class="py-0"  data-toggle="tooltip" data-placement="top" title="hero"><img alt="" src="/images/x.gif" class="hero"></td>
					@endif
					</tr>
					<tr>
						<td class="h6"><strong>Troops</strong></td>
					@foreach($reinforcement['UNITS'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>
					<tr>
						<td class="h6"><strong>Casualties</strong></td>
					@foreach($reinforcement['LOSES'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>
					<tr>
						<td class="h6"><strong>Survivours</strong></td>
					@foreach($reinforcement['SURVIVORS'] as $unit)
						<td class="h6 @if($unit==0) text-muted @endif">@if(is_numeric($unit)){{number_format($unit)}} @else {{$unit}} @endif</td>					
					@endforeach
					</tr>					
				</table>
			</div>		
		@endforeach			
	@endif
		</div>	
	@endforeach
@else
    	<div class="alert alert-danger text-center my-1" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button><strong>Report not found!!</strong>
        </div>	
@endif
	
@endsection

@push('scripts')
<script>
    function copyLink() {
      var copyText = document.getElementById("link");
      copyText.select();
      document.execCommand("copy");
    }
</script>

@endpush
	