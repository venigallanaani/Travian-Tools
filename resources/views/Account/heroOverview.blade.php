@extends('Account.template')
@section('body')

    <div class="card float-md-left col-md-9 mt-1 p-0 shadow">
    	<div class="card-header h5 py-2 bg-warning text-white">
    		<strong>Hero Details</strong>
    	</div>
    	<div class="card-text">
    		<div class="col-md-12 mx-auto my-3">
    	@foreach(['danger','success','warning','info'] as $msg)
    		@if(Session::has($msg))
            	<div class="alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
    		@if($hero == null)
            	<div class="alert alert-warning text-center my-1 col-md-10 mx-auto" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>Hero data not yet added
                </div>
            @else
    			<table class="mx-auto">
    				<tr>
    					<td class="px-2">
    						<table class="">
        						<tr>
        							<td class="text-warning"><strong>Name</strong></td><td>: {{$hero->name}}</td>
        						</tr>
        						<tr>
        							<td class="text-warning"><strong>Level</strong></td><td>: {{$hero->level}}</td>
        						</tr>
        						<tr>
        							<td class="text-warning"><strong>Experience</strong></td><td>: {{number_format($hero->exp)}}</td>
        						</tr>
        						<tr>
        							<td class="text-warning"><strong>Fighting Strength</strong></td><td>: {{$hero->fs}} ({{$hero->fp}})</td>
        						</tr>
        						<tr>
        							<td class="text-warning"><strong>Offense Bonus</strong></td><td>: {{$hero->off * 0.2}}% ({{$hero->off}})</td>
        						</tr>
        						<tr>
        							<td class="text-warning"><strong>Defense Bonus</strong></td><td>: {{$hero->def * 0.2}}% ({{$hero->def}})</td>
        						</tr>
        						<tr>
        							<td class="text-warning"><strong>Resources</strong></td><td>: {{$hero->res}}</td>
        						</tr>
        					</table>
    					</td>
    					<td>
    		        		 <div id="heroPieChart" style="width: 40%; height: 100%;"></div>
    					</td>
    				</tr>
    			</table>
			@endif					
    		</div>   
    		<div class="col-md-9 mx-auto rounded my-3 text-center" style="background-color:#dbeef4;">
    			<form action="{{route('accountHero')}}" method="post">
    			{{csrf_field()}}
					<p class="h5 text-primary py-2"><strong>Input Hero Details</strong></p>
					<p><textarea rows="3" cols="50" name="heroStr" required></textarea></td>
					<p class=" h6 font-italic">Enter the Hero page information here <small>(Expand the Attributes page)</small></p>

					<p colspan="2" class="text-center pb-3"><button class="btn btn-primary px-4" type="submit"><strong>Update Hero</strong></button></p>
    			</form>
    		</div>
    	</div>							
    </div>

	@if(!$pieData == null)
		{{createPieChart($pieData['name'],$pieData['title'],$pieData['data'])}}
	@endif

@endsection

@push('extensions')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush
