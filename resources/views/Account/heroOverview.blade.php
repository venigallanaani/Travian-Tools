@extends('Account.template')
@section('body')

    <div class="card float-md-left col-md-12 col-12 mt-1 p-0 shadow">
    	<div class="card-header h4 py-2 bg-warning text-white">
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
                    </button>Hero data not added yet
                </div>
            @else
    			<table class="p-0 m-0 mx-auto">
    				<tr>
    					<td class="">
    						<table class="mx-auto">
        						<tr>
        							<td class="px-0 text-warning"><strong>Name</strong></td>
        							<td>: {{$hero->name}}</td>
        						</tr>
        						<tr>
        							<td class="px-0 text-warning"><strong>Level</strong></td>
        							<td>: {{$hero->level}}</td>
        						</tr>
        						<tr>
        							<td class="px-0 text-warning"><strong>Experience</strong></td>
        							<td>: {{$hero->exp}}</td>
        						</tr>
        						<tr>
        							<td class="px-0 text-warning"><strong>Fighting Strength</strong></td>
        							<td>: {{$hero->fp}} <span class="text-primary"> ({{$hero->fs}})</span></td>
        						</tr>
        						<tr>
        							<td class="px-0 text-warning"><strong>Offense Bonus</strong></td>
        							<td>: {{$hero->off}} <span class="text-primary"> ({{$hero->off * 0.2}}%)</span></td>
        						</tr>
        						<tr>
        							<td class="px-0 text-warning"><strong>Defense Bonus</strong></td>
        							<td>: {{$hero->def}} <span class="text-primary"> ({{$hero->def * 0.2}}%)</span></td>
        						</tr>
        						<tr>
        							<td class="px-0 text-warning"><strong>Resources</strong></td>
        							<td>: {{$hero->res}}</td>
        						</tr>
        					</table>
    					</td>
    					<td class="">
    		        		<div id="heroPieChart" style="width: 100%; height: 100%;" class="">        			
                    		</div>
    					</td>
    				</tr>
    			</table>
			@endif					
    		</div>        		
    		<div class="col-md-9 mx-auto rounded my-5" style="background-color:#dbeef4;">
    			<form action="/account/hero/update" method="post">
    			{{csrf_field()}}
        			<table class="mx-auto">
        				<tr>
        					<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Hero Details</strong></p></td>
        				</tr>
        				<tr>
        					<td class="align-middle px-2"><p><textarea rows="3" cols="25" name="heroStr" required></textarea></td>
        					<td class="align-middle px-2 small font-italic"><p>Enter the Hero page data here <br/>(Expand the attributes section)</p></td>
        				</tr>
        				<tr>
        					<td colspan="2" class="text-center pb-3"><button class="btn btn-primary px-4" type="submit"><strong>Update Hero</strong></button></td>
        				</tr>
        			</table>
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
