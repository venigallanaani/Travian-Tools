@extends('Account.template')

@section('body')
<!-- =================================== Account Overview screen================================== -->
		<div class="card float-md-left col-md-9 mt-1 p-0 mb-5 shadow">
			<div class="card-header h4 py-2 bg-warning text-white">
				<strong>Villages Overview</strong>
			</div>
			<div class="card-text">
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="container alert alert-{{ $msg }} text-center my-1" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach          		
        		<div class="text-center mx-auto">
        			<form class="px-2 my-3" action="{{route('accountVillages')}}" method="post">
        				{{csrf_field()}}
            			<table class="table table-bordered table-hover table-sm align-middle">
            				<thead class="bg-warning">
            					<tr>
            						<th class="align-middle py-0 px-1" rowspan="2">Village</th>        						
            						<th class="align-middle py-0 px-1" rowspan="2">Cap</th>            						
            						<th class="align-middle py-0 px-1" rowspan="2">Tiles</th>
            						<th class="align-middle py-0 px-1" rowspan="2">Fields</th>
            						<th class="py-0 px-1" colspan="4">Oasis</th>
            						<th class="py-0 px-1" colspan="2">*Prod <img alt="wood" src="/images/x.gif" class="res all"></th>
            						<th class="align-middle py-0 px-1" rowspan="2">Artifact</th> 						
            					</tr>
            					<tr>
            						<th class="py-0 px-1"><img alt="wood" src="/images/x.gif" class="res wood"></th>
            						<th class="py-0 px-1"><img alt="wood" src="/images/x.gif" class="res clay"></th>
            						<th class="py-0 px-1"><img alt="wood" src="/images/x.gif" class="res iron"></th>
            						<th class="py-0 px-1"><img alt="wood" src="/images/x.gif" class="res crop"></th>
            						<th class="py-0 px-1">Normal</th> 
            						<th class="py-0 px-1">Plus</th>       						
            					</tr>
            				</thead>
            				@foreach($villages as $village)
                				<tr>
                					<td class="px-1"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$village['X']}}&y={{$village['Y']}}" target="_blank">{{$village['NAME']}}</a></td>
                					<td class="px-1"><input type="checkbox" name="{{$village['VID']}}_cap"  @if($village['CAP']!=null) checked @endif></td>                					
                					<td class="px-1 small"><select name="{{$village['VID']}}_tiles" style="border:1px">
        									<option value="4-4-4-6" @if($village['TILES']=='4-4-4-6') selected @endif>4-4-4-6</option>
											<option value="5-4-3-6" @if($village['TILES']=='5-4-3-6') selected @endif>5-4-3-6</option>
											<option value="5-3-4-6" @if($village['TILES']=='5-3-4-6') selected @endif>5-3-4-6</option>
											<option value="4-5-3-6" @if($village['TILES']=='4-5-3-6') selected @endif>4-5-3-6</option>
											<option value="3-5-4-6" @if($village['TILES']=='3-5-4-6') selected @endif>3-5-4-6</option>
											<option value="3-4-5-6" @if($village['TILES']=='3-4-5-6') selected @endif>3-4-5-6</option>
											<option value="4-3-5-6" @if($village['TILES']=='4-3-5-6') selected @endif>4-3-5-6</option>
											<option value="3-4-4-7" @if($village['TILES']=='3-4-4-7') selected @endif>3-4-4-7</option>
											<option value="4-3-4-7" @if($village['TILES']=='4-3-4-7') selected @endif>4-3-4-7</option>
											<option value="4-4-3-7" @if($village['TILES']=='4-4-3-7') selected @endif>4-4-3-7</option>
											<option value="3-3-3-9" @if($village['TILES']=='3-3-3-9') selected @endif>3-3-3-9</option>
											<option value="1-1-1-15" @if($village['TILES']=='1-1-1-15') selected @endif>1-1-1-15</option>
        								</select> 
                					</td>
                					<td class="px-1 small"><input type="number" name="{{$village['VID']}}_field" min="0" max="21" style="width:3em; border:1px" value="{{$village['FIELD']}}"></td>
                					<td class="px-1 small"><select name="{{$village['VID']}}_wood" style="width: 4em; border:1px">
        									<option value="0"  @if($village['WOOD']==0) selected @endif>0%</option>
        									<option value="25" @if($village['WOOD']==25) selected @endif>25%</option>
        									<option value="50" @if($village['WOOD']==50) selected @endif>50%</option>
        									<option value="75" @if($village['WOOD']==75) selected @endif>75%</option>
        									<option value="100" @if($village['WOOD']==100) selected @endif>100%</option>
        									<option value="125" @if($village['WOOD']==125) selected @endif>125%</option>
        									<option value="150" @if($village['WOOD']==150) selected @endif>150%</option>
        								</select>
    								</td>
                					<td class="px-1 small"><select name="{{$village['VID']}}_clay" style="width: 4em; border:1px">
        									<option value="0" @if($village['CLAY']==0) selected @endif>0%</option>
        									<option value="25" @if($village['CLAY']==25) selected @endif>25%</option>
        									<option value="50" @if($village['CLAY']==50) selected @endif>50%</option>
        									<option value="75" @if($village['CLAY']==75) selected @endif>75%</option>
        									<option value="100" @if($village['CLAY']==100) selected @endif>100%</option>
        									<option value="125" @if($village['CLAY']==125) selected @endif>125%</option>
        									<option value="150" @if($village['CLAY']==150) selected @endif>150%</option>
        								</select>
    								</td>
                					<td class="px-1 small"><select name="{{$village['VID']}}_iron" style="width: 4em; border:1px">
        									<option value="0" @if($village['IRON']==0) selected @endif>0%</option>
        									<option value="25" @if($village['IRON']==25) selected @endif>25%</option>
        									<option value="50" @if($village['IRON']==50) selected @endif>50%</option>
        									<option value="75" @if($village['IRON']==75) selected @endif>75%</option>
        									<option value="100" @if($village['IRON']==100) selected @endif>100%</option>
        									<option value="125" @if($village['IRON']==125) selected @endif>125%</option>
        									<option value="150" @if($village['IRON']==150) selected @endif>150%</option>
        								</select>
    								</td>
                					<td class="px-1 small"><select name="{{$village['VID']}}_crop" style="width: 4em; border:1px">
        									<option value="0" @if($village['CROP']==0) selected @endif>0%</option>
        									<option value="25" @if($village['CROP']==25) selected @endif>25%</option>
        									<option value="50" @if($village['CROP']==50) selected @endif>50%</option>
        									<option value="75" @if($village['CROP']==75) selected @endif>75%</option>
        									<option value="100" @if($village['CROP']==100) selected @endif>100%</option>
        									<option value="125" @if($village['CROP']==125) selected @endif>125%</option>
        									<option value="150" @if($village['CROP']==150) selected @endif>150%</option>
        								</select>
    								</td>
                					<td class="px-1 small">{{number_format($village['PROD'])}}</td>
                					<td class="px-1 small">{{number_format($village['PROD']*1.25)}}</td>
                					<td class="px-0 small"><select name="{{$village['VID']}}_art" style="width: 5em; border:1px">
        									<option value="NONE" @if($village['ART']=='NONE') selected @endif>None</option>
        									<option value="SMALL" @if($village['ART']=='SMALL') selected @endif>Small</option>
        									<option value="LARGE" @if($village['ART']=='LARGE') selected @endif>Large</option>
        									<option value="UNIQUE" @if($village['ART']=='UNIQUE') selected @endif>Unique</option>
        								</select>               					
                					</td>
            					</tr>
        					@endforeach
            			</table>
            			<button class="btn btn-warning btn-lg px-5" type="submit"><strong>Update Villages</strong></button>
        			</form>
        		</div>
        		<p class="text-right px-5">* The displayed values are approximate values</p>
			</div>			
		</div>
	

@endsection