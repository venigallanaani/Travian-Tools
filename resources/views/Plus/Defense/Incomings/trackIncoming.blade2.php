@extends('Layouts.incomings')

@section('body')

		<div class="card float-md-left col-md-12 mt-1 p-0 shadow">
			<div class="card-header h4 py-2 bg-info text-white"><strong>Incoming Hammer Tracking</strong></div>
			<div class="card-text">
		<!-- ========================== Create CFD Options ============================== -->
					
		@foreach(['danger','success','warning','info'] as $msg)
			@if(Session::has($msg))
	        	<div class="alert alert-{{ $msg }} text-center my-1 mx-auto col-md-11" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>{{ Session::get($msg) }}
                </div>
            @endif
        @endforeach
    		
    			
    			<div class="card card-body m-0 p-2">
    				<table class="table col-md-9 mx-auto table-borderless align-center">
    					<tr>
    						<td>
    							<p><strong>Attacker - </strong>{{$incomings[0]['att_player']}}</p>
    							<p><strong>Village - </strong>{{$incomings[0]['att_village']}}</p>
    							<p><strong>Total waves - </strong>{{array_sum(array_column($incomings,'waves'))}}</p>    							
    							<p><strong>Target Villages - </strong>{{count(array_unique(array_column($incomings,'def_vid')))}}</p>
    						</td>
    						<td>
    							<form action="/plus/incoming/update" method="post">
    								{{csrf_field()}}
        							<table class="text-center rounded" style="background-color:#dbeef4">
        								<tr>
        									<td colspan="2"><strong>Update Attacker Stats</strong></td>
        								</tr>
        								<tr>
        									<td>
                								<select	name="right" class="small">
                        							<option value="">--Select Right hand--</option>
                    							@if($incomings[0]['att_tribe']=='ROMAN')
                        							<option value="RR1" @if($attack['right'] =='RR1') selected @endif>Legionnaire Sword</option>
                        							<option value="RR2" @if($attack['right'] =='RR2') selected @endif>Praetorian Sword</option>
                        							<option value="RR3" @if($attack['right'] =='RR3') selected @endif>Imperian Sword</option>
                        							<option value="RR4" @if($attack['right'] =='RR4') selected @endif>Imperatoris Sword</option>
                        							<option value="RR5" @if($attack['right'] =='RR5') selected @endif>Caesaris Lance</option>
                    							@endif
                    							@if($incomings[0]['att_tribe']=='GAUL')
                        							<option value="RG1" @if($attack['right'] =='RG1') selected @endif>Phalanx Spear</option>
                        							<option value="RG2" @if($attack['right'] =='RG2') selected @endif>Swordsman Sword</option>
                        							<option value="RG3" @if($attack['right'] =='RG3') selected @endif>Theutates Bow</option>
                        							<option value="RG4" @if($attack['right'] =='RG4') selected @endif>Druidrider Staff</option>
                        							<option value="RG5" @if($attack['right'] =='RG5') selected @endif>Haeduan Lance</option>
                    							@endif
                    							@if($incomings[0]['att_tribe']=='TEUTON')
                        							<option value="RT1" @if($attack['right'] =='RT1') selected @endif>Clubswinger Club</option>
                        							<option value="RT2" @if($attack['right'] =='RT2') selected @endif>Spearman Spear</option>
                        							<option value="RT3" @if($attack['right'] =='RT3') selected @endif>Axeman Axe</option>
                        							<option value="RT4" @if($attack['right'] =='RT4') selected @endif>Paladin Hammer</option>
                        							<option value="RT5" @if($attack['right'] =='RT5') selected @endif>Teutonic Knight Sword</option>
                    							@endif
                    							@if($incomings[0]['att_tribe']=='EGYPTIAN')
                        							<option value="RE1" @if($attack['right'] =='RE1') selected @endif>Slave Militia Club</option>
                        							<option value="RE2" @if($attack['right'] =='RE2') selected @endif>Ash Warden Axe</option>
                        							<option value="RE3" @if($attack['right'] =='RE3') selected @endif>Warrior Khopesh</option>
                        							<option value="RE4" @if($attack['right'] =='RE4') selected @endif>Anhor Guard Spear</option>
                        							<option value="RE5" @if($attack['right'] =='RE5') selected @endif>resheph Chariot Bow</option>
                    							@endif
                    							@if($incomings[0]['att_tribe']=='HUN')
                        							<option value="RH1" @if($attack['right'] =='RH1') selected @endif>Mercenary Axe</option>
                        							<option value="RH2" @if($attack['right'] =='RH2') selected @endif>Bowman Bow</option>
                        							<option value="RH3" @if($attack['right'] =='RH3') selected @endif>Steppe Rider Sword</option>
                        							<option value="RH4" @if($attack['right'] =='RH4') selected @endif>Marksman Bow</option>
                        							<option value="RH5" @if($attack['right'] =='RH5') selected @endif>Marauder Sword</option>
                    							@endif
                        						</select>
                        						<select name="left" class="small">
                        							<option value="">--Select Left hand--</option>
                        							<option value="l11" @if($attack['left'] =='l11') selected @endif>Map</option>
                        							<option value="l12" @if($attack['left'] =='l12') selected @endif>Standard</option>
                        							<option value="l13" @if($attack['left'] =='l13') selected @endif>Sheild</option>
                        							<option value="l14" @if($attack['left'] =='l14') selected @endif>Pennant</option>
                        							<option value="l15" @if($attack['left'] =='l15') selected @endif>Bag</option>
                        							<option value="l16" @if($attack['left'] =='l16') selected @endif>Natarian Horn</option>
                        						</select>
        									</td>
        									<td rowspan="3">
        										<p><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$incomings[0]['att_uid']}}" target="_blank">Account Details <i class="fas fa-external-link-alt"></i></a></p>
        										<p><a href="javascript:void(window.open('view-source:'+https://{{Session::get('server.url')}}/spieler.php?uid={{$incomings[0]['att_uid']}}))" target="_blank">Account Details source <i class="fas fa-external-link-alt"></i></a></p>
        										<textarea rows="3" cols="25" name="account"></textarea>
        									</td>
        								</tr>
        								<tr>
        									<td>	
        										<select name="helm" class="small">
                        							<option class="p-0 m-0" value="">--Select Helm--</option>
                        							<option class="p-0 m-0" value="h11" @if($attack['helm'] =='h11') selected @endif>Helmet of Awareness</option>
                        							<option class="p-0 m-0" value="h12" @if($attack['helm'] =='h12') selected @endif>Helmet of Enlightenment</option>
                        							<option class="p-0 m-0" value="h13" @if($attack['helm'] =='h13') selected @endif>Helmet of Wisdom</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="h21" @if($attack['helm'] =='h21') selected @endif>Helmet of Regeneration</option>
                        							<option class="p-0 m-0" value="h22" @if($attack['helm'] =='h22') selected @endif>Helmet of Healthiness</option>
                        							<option class="p-0 m-0" value="h23" @if($attack['helm'] =='h23') selected @endif>Helmet of Healing</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="h31" @if($attack['helm'] =='h31') selected @endif>Helmet of Gladiator</option>
                        							<option class="p-0 m-0" value="h32" @if($attack['helm'] =='h32') selected @endif>Helmet of Tribune</option>
                        							<option class="p-0 m-0" value="h33" @if($attack['helm'] =='h33') selected @endif>Helmet of Consul</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="h41" @if($attack['helm'] =='h41') selected @endif>Helmet of Mercenary</option>
                        							<option class="p-0 m-0" value="h42" @if($attack['helm'] =='h42') selected @endif>Helmet of Warrior</option>
                        							<option class="p-0 m-0" value="h43" @if($attack['helm'] =='h43') selected @endif>Helmet of Archon</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="h51" @if($attack['helm'] =='h51') selected @endif>Helmet of Horseman</option>
                        							<option class="p-0 m-0" value="h52" @if($attack['helm'] =='h52') selected @endif>Helmet of Cavalry</option>
                        							<option class="p-0 m-0" value="h53" @if($attack['helm'] =='h53') selected @endif>Helmet of Heavy cavalry</option>
                    							</select>
                    							<select name="chest" class="small">
                    								<option value="">--Select Chest--</option>
                        							<option class="p-0 m-0" value="c11" @if($attack['chest'] =='c11') selected @endif>Light armour of Regeneration</option>
                        							<option class="p-0 m-0" value="c12" @if($attack['chest'] =='c12') selected @endif>Armour of Regeneration</option>
                        							<option class="p-0 m-0" value="c13" @if($attack['chest'] =='c13') selected @endif>Heavy armour of Regeneration</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="c21" @if($attack['chest'] =='c21') selected @endif>Light Breastplate</option>
                        							<option class="p-0 m-0" value="c22" @if($attack['chest'] =='c23') selected @endif>Breastplate</option>
                        							<option class="p-0 m-0" value="c23" @if($attack['chest'] =='c23') selected @endif>Heavy Breastplate</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="c31" @if($attack['chest'] =='c31') selected @endif>Light scale armour</option>
                        							<option class="p-0 m-0" value="c32" @if($attack['chest'] =='c32') selected @endif>Scale armour</option>
                        							<option class="p-0 m-0" value="c33" @if($attack['chest'] =='c33') selected @endif>Heavy scale armour</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="c41" @if($attack['chest'] =='c41') selected @endif>Light segmented armour</option>
                        							<option class="p-0 m-0" value="c42" @if($attack['chest'] =='c42') selected @endif>Segmented armour</option>
                        							<option class="p-0 m-0" value="c43" @if($attack['chest'] =='c43') selected @endif>Heavy segmented armour</option>
                    							</select>
        									</td>
        								</tr>
        								<tr>
        									<td>        										
        										<select	name="boot" class="small">
                        							<option value="">--Select Boots--</option>
                        							<option class="p-0 m-0" value="f11" @if($attack['boots'] =='f11') selected @endif>Boots of Regeneration</option>
                        							<option class="p-0 m-0" value="f12" @if($attack['boots'] =='f12') selected @endif>Boots of Healthiness</option>
                        							<option class="p-0 m-0" value="f13" @if($attack['boots'] =='f13') selected @endif>Boots of Healing</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="f21" @if($attack['boots'] =='f21') selected @endif>Small spurs</option>
                        							<option class="p-0 m-0" value="f22" @if($attack['boots'] =='f22') selected @endif>Small spurs</option>
                        							<option class="p-0 m-0" value="f23" @if($attack['boots'] =='f23') selected @endif>Nasty spurs</option>
                        							<option class="p-0 m-0" disabled>----------</option>
                        							<option class="p-0 m-0" value="f31" @if($attack['boots'] =='f31') selected @endif>Boots of the Mercenary</option>
                        							<option class="p-0 m-0" value="f32" @if($attack['boots'] =='f32') selected @endif>Boots of the Warrior</option>
                        							<option class="p-0 m-0" value="f33" @if($attack['boots'] =='f33') selected @endif>Boots of the Archon</option>
                        						</select>
        									</td>
        								</tr>
        								<tr>
        									<td colspan="2"><button type="submit" class="btn btn-small px-5 btn-primary"  name="att" value="{{$incomings[0]['att_id']}}">Update</button></td>
        								</tr>
        							</table>
    							</form>    							
    						</td>
    					</tr>
    				</table>
        		@if($report==null)
        			<p class="text-center text-danger h5">No reports of enemy hammer are saved</p>
        		@else
        			        			
        			<table class="table table-bordered text-center col-md-8 mx-auto">
        				<thead>
            				<tr>
            					<td colspan="13" class="py-2 h6 bg-primary text-white">Enemy Hammer Report</td>
        					</tr>
            				<tr>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[0]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[0]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[1]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[1]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[2]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[2]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[3]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[3]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[4]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[4]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[5]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[5]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[6]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[6]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[7]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[7]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[8]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[8]['image']}}"></td>
            					<td class="px-0 py-1" data-toggle="tooltip" data-placement="top" title="{{$units[9]['name']}}"><img alt="" src="/images/x.gif" class="units {{$units[9]['image']}}"></td>
            					<td class="px-0 py-1"><strong>Upkeep</strong></td>
            					<td class="px-0 py-1"><strong>Report Date</strong></td>
            					<td class="px-0 py-1"><strong>Report</strong></td>
            				</tr>
        				</thead>
        				<tr>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][0])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][1])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][2])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][3])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][4])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][5])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][6])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][7])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][8])}}</td>
        					<td class="px-0 py-1 small" >{{number_format($report['troops'][9])}}</td>
        					<td class="px-0 py-0" >{{number_format($report['upkeep'])}}</td>
        					<td class="px-0 py-0" >{{$report['report_date']}}</td>
        					<td class="px-0 py-0" ><a href="/reports/{{$report['report']}}" target="_blank">Link <i class="fas fa-external-link-alt"></i></a></td>
        				</tr>
        			</table>
        			
        		@endif
    			</div>
    			
        		<div class="card card-body">
        		@if(count($tracks)==0)
        			<p class="text-center text-primary h5">Attacker Stats information not stored</p>
        		@else
        			<table class="table text-center table-sm table-hover table-bordered">
        				<thead class="">
            				<tr>
            					<td colspan="8" class="py-2 h5 bg-warning">Attacker Tracking</td>
            				</tr>
    						<tr class="text-info font-weight-bold">
    							<td class="px-0">Helm</td>
    							<td class="px-0">Chest</td>
    							<td class="px-0">Boots</td>
    							<td class="px-0">Right Hand</td>
    							<td class="px-0">Left Hand</td>
    							<td class="px-0">Hero XP</td>
    							<td class="px-0">Saved Time</td>
    							<td class="px-0">Saved By</td>
    						</tr>
        				</thead>
						@foreach($tracks as $track)
							<tr class="small">
								<td class="px-0 @if($track['helm_change']=='YES') table-warning @endif">
									@if($track['helm'] =='h11')Helmet of Awareness
                                    @elseif($track['helm'] =='h12')Helmet of Enlightenment
                                    @elseif($track['helm'] =='h13')Helmet of Wisdom
                                    @elseif($track['helm'] =='h21')Helmet of Regeneration
                                    @elseif($track['helm'] =='h22')Helmet of Healthiness
                                    @elseif($track['helm'] =='h23')Helmet of Healing
                                    @elseif($track['helm'] =='h31')Helmet of Gladiator
                                    @elseif($track['helm'] =='h32')Helmet of Tribune
                                    @elseif($track['helm'] =='h33')Helmet of Consul
                                    @elseif($track['helm'] =='h41')Helmet of Mercenary
                                    @elseif($track['helm'] =='h42')Helmet of Warrior
                                    @elseif($track['helm'] =='h43')Helmet of Archon
                                    @elseif($track['helm'] =='h51')Helmet of Horseman
                                    @elseif($track['helm'] =='h52')Helmet of Cavalry
                                    @elseif($track['helm'] =='h53')Helmet of Heavy cavalry
                                    @else N/A
                                    @endif
								</td>
								<td class="px-0 @if($track['chest_change']=='YES') table-warning @endif">
									@if($track['chest'] =='c11') Light armour of Regeneration
                                    @elseif($track['chest'] =='c12') Armour of Regeneration
                                    @elseif($track['chest'] =='c13') Heavy armour of Regeneration              
                                    @elseif($track['chest'] =='c21') Light Breastplate
                                    @elseif($track['chest'] =='c23') Breastplate
                                    @elseif($track['chest'] =='c23') Heavy Breastplate               
                                    @elseif($track['chest'] =='c31') Light scale armour
                                    @elseif($track['chest'] =='c32') Scale armour
                                    @elseif($track['chest'] =='c33') Heavy scale armour              
                                    @elseif($track['chest'] =='c41') Light segmented armour
                                    @elseif($track['chest'] =='c42') Segmented armour
                                    @elseif($track['chest'] =='c43') Heavy segmented armour
                                    @else N/A
                                    @endif
								</td>
								<td class="px-0 @if($track['boots_change']=='YES') table-warning @endif">
									@if($track['boots'] =='f11') Boots of Regeneration
                                    @elseif($track['boots'] =='f12') Boots of Healthiness
                                    @elseif($track['boots'] =='f13') Boots of Healing
                                    @elseif($track['boots'] =='f21') Small spurs
                                    @elseif($track['boots'] =='f22') Small spurs
                                    @elseif($track['boots'] =='f23') Nasty spurs
                                    @elseif($track['boots'] =='f31') Boots of the Mercenary
                                    @elseif($track['boots'] =='f32') Boots of the Warrior
                                    @elseif($track['boots'] =='f33') Boots of the Archon
                                    @else N/A
                                    @endif
								</td>
								<td class="px-0 @if($track['right_change']=='YES') table-warning @endif">
									@if($track['right'] =='RR1') Legionnaire Sword
                                    @elseif($track['right'] =='RR2') Praetorian Sword
                                    @elseif($track['right'] =='RR3') Imperian Sword
                                    @elseif($track['right'] =='RR4') Imperatoris Sword
                                    @elseif($track['right'] =='RR5') Caesaris Lance
                                    @elseif($track['right'] =='RG1') Phalanx Spear
                                    @elseif($track['right'] =='RG2') Swordsman Sword
                                    @elseif($track['right'] =='RG3') Theutates Bow
                                    @elseif($track['right'] =='RG4') Druidrider Staff
                                    @elseif($track['right'] =='RG5') Haeduan Lance
                                    @elseif($track['right'] =='RT1') Clubswinger Club
                                    @elseif($track['right'] =='RT2') Spearman Spear
                                    @elseif($track['right'] =='RT3') Axeman Axe
                                    @elseif($track['right'] =='RT4') Paladin Hammer
                                    @elseif($track['right'] =='RT5') Teutonic Knight Sword
                                    @elseif($track['right'] =='RE1') Slave Militia Club
                                    @elseif($track['right'] =='RE2') Ash Warden Axe
                                    @elseif($track['right'] =='RE3') Warrior Khopesh
                                    @elseif($track['right'] =='RE4') Anhor Guard Spear
                                    @elseif($track['right'] =='RE5') resheph Chariot Bow
                                    @elseif($track['right'] =='RH1') Mercenary Axe
                                    @elseif($track['right'] =='RH2') Bowman Bow
                                    @elseif($track['right'] =='RH3') Steppe Rider Sword
                                    @elseif($track['right'] =='RH4') Marksman Bow
                                    @elseif($track['right'] =='RH5') Marauder Sword
                                    @else N/A
                                    @endif
								</td>
								<td class="px-0 @if($track['left_change']=='YES') table-warning @endif">
									@if($track['left'] =='l11') Map
                                    @elseif($track['left'] =='l12') Standard
                                    @elseif($track['left'] =='l13') Sheild
                                    @elseif($track['left'] =='l14') Pennant
                                    @elseif($track['left'] =='l15') Bag
                                    @elseif($track['left'] =='l16') Natarian Horn
                                    @else N/A
                                    @endif
								</td>
								<td class="px-0 @if($track['hero_change']=='YES') table-warning @endif">
									{{number_format($track['exp'])}}
								</td>
								<td class="px-0">{{$track['save_time']}}</td>
								<td class="px-0">{{$track['save_by']}}</td>
							</tr>
						@endforeach
        			</table>
    			@endif
        		</div>
        		
        		<div class="card card-body">
        			<table class="table text-center table-sm table-hover table-bordered">
        				<thead class="">
            				<tr>
            					<td colspan="8" class="py-2 h5 text-white bg-info">Incoming Waves</td>
            				</tr>
    						<tr class="text-info font-weight-bold">
    							<td class="px-0">Target</td>
    							<td class="px-0">Waves</td>
    							<td class="px-0">Land Time</td>
    							<td class="px-0">Start Time</td>
    							<td class="px-0">Noticed Time</td>
    							<td class="px-0">Status</td>
    							<td class="px-">Notes</td>
    						</tr>
        				</thead>
						@foreach($incomings as $incoming)
							<tr class="small">
								<td class="px-0"><a href="https://{{Session::get('server.url')}}/position_details.php?x={{$incoming['def_x']}}&y={{$incoming['def_y']}}" target="_blank">
									<strong>{{$incoming['def_player']}}</strong> ({{$incoming['def_village']}})</a></td>
								<td class="px-0">{{$incoming['waves']}}</td>
								<td class="px-0">{{$incoming['landTime']}}</td>
								<td class="px-0">TBD</td>
								<td class="px-0">{{$incoming['noticeTime']}}</td>
								<td class="px-0">{{$incoming['ldr_sts']}}</td>
								<td class="px-0">{{$incoming['comments']}}</td>
							</tr>
						@endforeach
        			</table>
        		</div>
			</div>
		</div>

@endsection

