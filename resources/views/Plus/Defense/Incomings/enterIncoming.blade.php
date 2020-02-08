@extends('Plus.template')

@section('body')
<div class="card float-md-left col-md-9 mt-1 mb-5 p-0 shadow">
	<div class="card-header h4 py-2 bg-info text-white"><strong>Enter Incomings</strong></div>
@foreach(['danger','success','warning','info'] as $msg)
	@if(Session::has($msg))
    	<div class="alert alert-{{ $msg }} text-center my-1 mx-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>{{ Session::get($msg) }}
        </div>
    @endif
@endforeach
	<div class="card-text my-3">
		<div class="col-md-10 mx-auto rounded pt-2 mb-2" style="background-color:#dbeef4;">
			<form method="post" action="/plus/incoming">
				{{csrf_field()}}
    			<table>
    				<tr>
    					<td colspan="2"><p class="h4 text-primary text-center"><strong>Input Incoming Details</strong></p></td>
    				</tr>
    				<tr>
    					<td class="align-middle px-2">
    						<form>								
    							<textarea rows="3" cols="40" name="incStr" required></textarea>
    							<p class="text-center"><button class="btn btn-primary" type="submit">Enter Incomings</button></p>
    						</form>
    					</td>
    					<td class="align-top px-2 font-italic">
    						<p>Enter the incoming attacks details from rally point here <strong><a href="https://{{Session::get('server.url')}}/build.php?gid=16&tt=1&filter=1&subfilters=1" target="_blank">Link</a></strong></p>
    					</td>
    				</tr>			
    			</table>
			</form>
		</div>   			    			
	</div>
			
	<div class="col-md-12 mt-2 mx-auto text-center">
	@if((count($owaves) + count($swaves))==0)			
		<p class="text-center h5 py-5"> No incoming attacks saved for this profile</p>			
	@else	
		@if(count($owaves)>0)		
    		<table class="table mx-auto col-md-11 table-hover table-sm table-bordered">
    			<thead class="thead-inverse">
    				<tr>
    					<td class="h4 text-dark py-2 my-0 bg-warning" colspan="7"><strong>Your Incomings</strong></td>
    				</tr>
    				<tr>
    					<th class="">Attacker</th>
    					<th class="">Target</th>					
    					<th class="">Land Time</th>
    					<th class="">Waves</th>
    					<th class="">Timer</th>
    					<th class="">Action</th>
    					<th></th>
    				</tr>
    			</thead>
    			@foreach($owaves as $wave)
    				@php
    					if($wave->ldr_sts=='Attack'){ $color = 'table-danger';	}
    					elseif($wave->ldr_sts=='Fake'){$color='table-primary';}
    					elseif($wave->ldr_sts=='Thinking'){$color='table-warning';}					
    					else{$color='table-white';}					
    				@endphp				
    						
        			<tr class="{{$color}} small">
        				<td><strong><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> ({{$wave->att_village}})</strong></td>
        				<td><strong>{{$wave->def_village}}</strong></td>    				
        				<td>{{$wave->landTime}}</td>
        				<td>{{$wave->waves}}</td>
        				<td><strong><span id="{{$wave->incid}}"></span></strong></td>
        				<td>{{$wave->ldr_sts}}</td>
        				<td><button class="btn btn-info btn-sm" id="details" name="button" value="" type="submit"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></td>
        			</tr>
        			<tr style="display: none;background-color:#dbeef4" class="text-center">
        				<form action="/plus/incoming/update" method="post">
							{{csrf_field()}}
            				<td colspan="3">
            					<p><a href="http://travian.kirilloid.ru/items.php" target="_blank"><strong>Hero Equipment <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p>
            						<select	name="right" class="small">
            							<option value="">--Select Right hand--</option>
        							@if($wave->att_tribe=='ROMAN')
            							<option value="RR1" @if($wave->hero_right =='RR1') selected @endif>Legionnaire Sword</option>
            							<option value="RR2" @if($wave->hero_right =='RR2') selected @endif>Praetorian Sword</option>
            							<option value="RR3" @if($wave->hero_right =='RR3') selected @endif>Imperian Sword</option>
            							<option value="RR4" @if($wave->hero_right =='RR4') selected @endif>Imperatoris Sword</option>
            							<option value="RR5" @if($wave->hero_right =='RR5') selected @endif>Caesaris Lance</option>
        							@endif
        							@if($wave->att_tribe=='GAUL')
            							<option value="RG1" @if($wave->hero_right =='RG1') selected @endif>Phalanx Spear</option>
            							<option value="RG2" @if($wave->hero_right =='RG2') selected @endif>Swordsman Sword</option>
            							<option value="RG3" @if($wave->hero_right =='RG3') selected @endif>Theutates Bow</option>
            							<option value="RG4" @if($wave->hero_right =='RG4') selected @endif>Druidrider Staff</option>
            							<option value="RG5" @if($wave->hero_right =='RG5') selected @endif>Haeduan Lance</option>
        							@endif
        							@if($wave->att_tribe=='TEUTON')
            							<option value="RT1" @if($wave->hero_right =='RT1') selected @endif>Clubswinger Club</option>
            							<option value="RT2" @if($wave->hero_right =='RT2') selected @endif>Spearman Spear</option>
            							<option value="RT3" @if($wave->hero_right =='RT3') selected @endif>Axeman Axe</option>
            							<option value="RT4" @if($wave->hero_right =='RT4') selected @endif>Paladin Hammer</option>
            							<option value="RT5" @if($wave->hero_right =='RT5') selected @endif>Teutonic Knight Sword</option>
        							@endif
        							@if($wave->att_tribe=='EGYPTIAN')
            							<option value="RE1" @if($wave->hero_right =='RE1') selected @endif>Slave Militia Club</option>
            							<option value="RE2" @if($wave->hero_right =='RE2') selected @endif>Ash Warden Axe</option>
            							<option value="RE3" @if($wave->hero_right =='RE3') selected @endif>Warrior Khopesh</option>
            							<option value="RE4" @if($wave->hero_right =='RE4') selected @endif>Anhor Guard Spear</option>
            							<option value="RE5" @if($wave->hero_right =='RE5') selected @endif>resheph Chariot Bow</option>
        							@endif
        							@if($wave->att_tribe=='HUN')
            							<option value="RH1" @if($wave->hero_right =='RH1') selected @endif>Mercenary Axe</option>
            							<option value="RH2" @if($wave->hero_right =='RH2') selected @endif>Bowman Bow</option>
            							<option value="RH3" @if($wave->hero_right =='RH3') selected @endif>Steppe Rider Sword</option>
            							<option value="RH4" @if($wave->hero_right =='RH4') selected @endif>Marksman Bow</option>
            							<option value="RH5" @if($wave->hero_right =='RH5') selected @endif>Marauder Sword</option>
        							@endif
            						</select>
            						<select name="left" class="small">
            							<option value="">--Select Left hand--</option>
            							<option value="l11" @if($wave->hero_left =='l11') selected @endif>Map</option>
            							<option value="l12" @if($wave->hero_left =='l12') selected @endif>Standard</option>
            							<option value="l13" @if($wave->hero_left =='l13') selected @endif>Sheild</option>
            							<option value="l14" @if($wave->hero_left =='l14') selected @endif>Pennant</option>
            							<option value="l15" @if($wave->hero_left =='l15') selected @endif>Bag</option>
            							<option value="l16" @if($wave->hero_left =='l16') selected @endif>Natarian Horn</option>
            						</select>
        						<p>
        						<p>
            						<select name="helm" class="small">
            							<option class="p-0 m-0" value="">--Select Helm--</option>
            							<option class="p-0 m-0" value="h11" @if($wave->hero_helm =='h11') selected @endif>Helmet of Awareness</option>
            							<option class="p-0 m-0" value="h12" @if($wave->hero_helm =='h12') selected @endif>Helmet of Enlightenment</option>
            							<option class="p-0 m-0" value="h13" @if($wave->hero_helm =='h13') selected @endif>Helmet of Wisdom</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h21" @if($wave->hero_helm =='h21') selected @endif>Helmet of Regeneration</option>
            							<option class="p-0 m-0" value="h22" @if($wave->hero_helm =='h22') selected @endif>Helmet of Healthiness</option>
            							<option class="p-0 m-0" value="h23" @if($wave->hero_helm =='h23') selected @endif>Helmet of Healing</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h31" @if($wave->hero_helm =='h31') selected @endif>Helmet of Gladiator</option>
            							<option class="p-0 m-0" value="h32" @if($wave->hero_helm =='h32') selected @endif>Helmet of Tribune</option>
            							<option class="p-0 m-0" value="h33" @if($wave->hero_helm =='h33') selected @endif>Helmet of Consul</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h41" @if($wave->hero_helm =='h41') selected @endif>Helmet of Mercenary</option>
            							<option class="p-0 m-0" value="h42" @if($wave->hero_helm =='h42') selected @endif>Helmet of Warrior</option>
            							<option class="p-0 m-0" value="h43" @if($wave->hero_helm =='h43') selected @endif>Helmet of Archon</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h51" @if($wave->hero_helm =='h51') selected @endif>Helmet of Horseman</option>
            							<option class="p-0 m-0" value="h52" @if($wave->hero_helm =='h52') selected @endif>Helmet of Cavalry</option>
            							<option class="p-0 m-0" value="h53" @if($wave->hero_helm =='h53') selected @endif>Helmet of Heavy cavalry</option>
            						</select>
            						<select name="chest" class="small">
            							<option value="">--Select Chest--</option>
            							<option class="p-0 m-0" value="c11" @if($wave->hero_chest =='c11') selected @endif>Light armour of Regeneration</option>
            							<option class="p-0 m-0" value="c12" @if($wave->hero_chest =='c12') selected @endif>Armour of Regeneration</option>
            							<option class="p-0 m-0" value="c13" @if($wave->hero_chest =='c13') selected @endif>Heavy armour of Regeneration</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="c21" @if($wave->hero_chest =='c21') selected @endif>Light Breastplate</option>
            							<option class="p-0 m-0" value="c22" @if($wave->hero_chest =='c23') selected @endif>Breastplate</option>
            							<option class="p-0 m-0" value="c23" @if($wave->hero_chest =='c23') selected @endif>Heavy Breastplate</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="c31" @if($wave->hero_chest =='c31') selected @endif>Light scale armour</option>
            							<option class="p-0 m-0" value="c32" @if($wave->hero_chest =='c32') selected @endif>Scale armour</option>
            							<option class="p-0 m-0" value="c33" @if($wave->hero_chest =='c33') selected @endif>Heavy scale armour</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="c41" @if($wave->hero_chest =='c41') selected @endif>Light segmented armour</option>
            							<option class="p-0 m-0" value="c42" @if($wave->hero_chest =='c42') selected @endif>Segmented armour</option>
            							<option class="p-0 m-0" value="c43" @if($wave->hero_chest =='c43') selected @endif>Heavy segmented armour</option>
            						</select>
        						</p>
        						<p>
            						<select	name="boot" class="small">
            							<option value="">--Select Boots--</option>
            							<option class="p-0 m-0" value="f11" @if($wave->hero_boots =='f11') selected @endif>Boots of Regeneration</option>
            							<option class="p-0 m-0" value="f12" @if($wave->hero_boots =='f12') selected @endif>Boots of Healthiness</option>
            							<option class="p-0 m-0" value="f13" @if($wave->hero_boots =='f13') selected @endif>Boots of Healing</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="f21" @if($wave->hero_boots =='f21') selected @endif>Small spurs</option>
            							<option class="p-0 m-0" value="f22" @if($wave->hero_boots =='f22') selected @endif>Small spurs</option>
            							<option class="p-0 m-0" value="f23" @if($wave->hero_boots =='f23') selected @endif>Nasty spurs</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="f31" @if($wave->hero_boots =='f31') selected @endif>Boots of the Mercenary</option>
            							<option class="p-0 m-0" value="f32" @if($wave->hero_boots =='f32') selected @endif>Boots of the Warrior</option>
            							<option class="p-0 m-0" value="f33" @if($wave->hero_boots =='f33') selected @endif>Boots of the Archon</option>
            						</select>
        						</p>
        						<p class="small py-0 my-0">
        							<strong>Notes : </strong><input type="text" name="comments" size="25" value="{{$wave->comments}}">
        						</p>
            				</td>
            				<td colspan="4">
            					<p><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$wave->att_uid}}" target="_blank"><strong>Attacker Account Information <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p><textarea rows="3" cols="25" name="account"></textarea></p>
            					<p><button class="btn btn-sm btn-primary" name="wave" value="{{$wave->incid}}" type="submit">UPDATE</button></p>
            				</td>
        				</form>
        			</tr>
    			@endforeach			
    		</table>		
		@endif
		
		@if(count($swaves)>0)
		<div class="my-3">						
    		<table class="table mx-auto col-md-11 table-hover table-sm table-bordered">
    			<thead class="thead-inverse">
    				<tr>
    					<td class="h4 text-dark py-2 my-0 bg-info" colspan="7"><strong>Your Sitter Incomings</strong></td>
    				</tr>
    				<tr>
    					<th class="">Attacker</th>
    					<th class="">Target</th>					
    					<th class="">Land Time</th>
    					<th class="">Waves</th>
    					<th class="">Timer</th>
    					<th class="">Action</th>
    					<th></th>
    				</tr>
    			</thead>
    			@foreach($swaves as $wave)
    				@php
    					if($wave->ldr_sts=='Attack'){ $color = 'table-danger';	}
    					elseif($wave->ldr_sts=='Fake'){$color='table-primary';}
    					elseif($wave->ldr_sts=='Thinking'){$color='table-warning';}					
    					else{$color='table-white';}					
    				@endphp				
    						
        			<tr class="{{$color}} small">
        				<td><strong><a href="{{route('findPlayer')}}/{{$wave->att_player}}/1" target="_blank">{{$wave->att_player}}</a> ({{$wave->att_village}})</strong></td>
        				<td><strong>{{$wave->def_village}}</strong></td>    				
        				<td>{{$wave->landTime}}</td>
        				<td>{{$wave->waves}}</td>
        				<td><strong><span id="{{$wave->incid}}"></span></strong></td>
        				<td>{{$wave->ldr_sts}}</td>
        				<td><button class="btn btn-info btn-sm" id="details" name="button" value="" type="submit"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></td>
        			</tr>
        			<tr style="display: none;background-color:#dbeef4" class="text-center">
        				<form action="/plus/incoming/update" method="post">
							{{csrf_field()}}
            				<td colspan="3">
            					<p><a href="http://travian.kirilloid.ru/items.php" target="_blank"><strong>Hero Equipment <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p>
            						<select	name="right" class="small">
            							<option value="">--Select Right hand--</option>
        							@if($wave->att_tribe=='ROMAN')
            							<option value="RR1" @if($wave->hero_right =='RR1') selected @endif>Legionnaire Sword</option>
            							<option value="RR2" @if($wave->hero_right =='RR2') selected @endif>Praetorian Sword</option>
            							<option value="RR3" @if($wave->hero_right =='RR3') selected @endif>Imperian Sword</option>
            							<option value="RR4" @if($wave->hero_right =='RR4') selected @endif>Imperatoris Sword</option>
            							<option value="RR5" @if($wave->hero_right =='RR5') selected @endif>Caesaris Lance</option>
        							@endif
        							@if($wave->att_tribe=='GUAL')
            							<option value="RG1" @if($wave->hero_right =='RG1') selected @endif>Phalanx Spear</option>
            							<option value="RG2" @if($wave->hero_right =='RG2') selected @endif>Swordsman Sword</option>
            							<option value="RG3" @if($wave->hero_right =='RG3') selected @endif>Theutates Bow</option>
            							<option value="RG4" @if($wave->hero_right =='RG4') selected @endif>Druidrider Staff</option>
            							<option value="RG5" @if($wave->hero_right =='RG5') selected @endif>Haeduan Lance</option>
        							@endif
        							@if($wave->att_tribe=='TEUTON')
            							<option value="RT1" @if($wave->hero_right =='RT1') selected @endif>Clubswinger Club</option>
            							<option value="RT2" @if($wave->hero_right =='RT2') selected @endif>Spearman Spear</option>
            							<option value="RT3" @if($wave->hero_right =='RT3') selected @endif>Axeman Axe</option>
            							<option value="RT4" @if($wave->hero_right =='RT4') selected @endif>Paladin Hammer</option>
            							<option value="RT5" @if($wave->hero_right =='RT5') selected @endif>Teutonic Knight Sword</option>
        							@endif
        							@if($wave->att_tribe=='EGYPTIAN')
            							<option value="RE1" @if($wave->hero_right =='RE1') selected @endif>Slave Militia Club</option>
            							<option value="RE2" @if($wave->hero_right =='RE2') selected @endif>Ash Warden Axe</option>
            							<option value="RE3" @if($wave->hero_right =='RE3') selected @endif>Warrior Khopesh</option>
            							<option value="RE4" @if($wave->hero_right =='RE4') selected @endif>Anhor Guard Spear</option>
            							<option value="RE5" @if($wave->hero_right =='RE5') selected @endif>resheph Chariot Bow</option>
        							@endif
        							@if($wave->att_tribe=='HUN')
            							<option value="RH1" @if($wave->hero_right =='RH1') selected @endif>Mercenary Axe</option>
            							<option value="RH2" @if($wave->hero_right =='RH2') selected @endif>Bowman Bow</option>
            							<option value="RH3" @if($wave->hero_right =='RH3') selected @endif>Steppe Rider Sword</option>
            							<option value="RH4" @if($wave->hero_right =='RH4') selected @endif>Marksman Bow</option>
            							<option value="RH5" @if($wave->hero_right =='RH5') selected @endif>Marauder Sword</option>
        							@endif
            						</select>
            						<select name="left" class="small">
            							<option value="">--Select Left hand--</option>
            							<option value="l11" @if($wave->hero_left =='l11') selected @endif>Map</option>
            							<option value="l12" @if($wave->hero_left =='l12') selected @endif>Standard</option>
            							<option value="l13" @if($wave->hero_left =='l13') selected @endif>Sheild</option>
            							<option value="l14" @if($wave->hero_left =='l14') selected @endif>Pennant</option>
            							<option value="l15" @if($wave->hero_left =='l15') selected @endif>Bag</option>
            							<option value="l16" @if($wave->hero_left =='l16') selected @endif>Natarian Horn</option>
            						</select>
        						<p>
        						<p>
            						<select name="helm" class="small">
            							<option class="p-0 m-0" value="">--Select Helm--</option>
            							<option class="p-0 m-0" value="h11" @if($wave->hero_helm =='h11') selected @endif>Helmet of Awareness</option>
            							<option class="p-0 m-0" value="h12" @if($wave->hero_helm =='h12') selected @endif>Helmet of Enlightenment</option>
            							<option class="p-0 m-0" value="h13" @if($wave->hero_helm =='h13') selected @endif>Helmet of Wisdom</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h21" @if($wave->hero_helm =='h21') selected @endif>Helmet of Regeneration</option>
            							<option class="p-0 m-0" value="h22" @if($wave->hero_helm =='h22') selected @endif>Helmet of Healthiness</option>
            							<option class="p-0 m-0" value="h23" @if($wave->hero_helm =='h23') selected @endif>Helmet of Healing</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h31" @if($wave->hero_helm =='h31') selected @endif>Helmet of Gladiator</option>
            							<option class="p-0 m-0" value="h32" @if($wave->hero_helm =='h32') selected @endif>Helmet of Tribune</option>
            							<option class="p-0 m-0" value="h33" @if($wave->hero_helm =='h33') selected @endif>Helmet of Consul</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h41" @if($wave->hero_helm =='h41') selected @endif>Helmet of Mercenary</option>
            							<option class="p-0 m-0" value="h42" @if($wave->hero_helm =='h42') selected @endif>Helmet of Warrior</option>
            							<option class="p-0 m-0" value="h43" @if($wave->hero_helm =='h43') selected @endif>Helmet of Archon</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="h51" @if($wave->hero_helm =='h51') selected @endif>Helmet of Horseman</option>
            							<option class="p-0 m-0" value="h52" @if($wave->hero_helm =='h52') selected @endif>Helmet of Cavalry</option>
            							<option class="p-0 m-0" value="h53" @if($wave->hero_helm =='h53') selected @endif>Helmet of Heavy cavalry</option>
            						</select>
            						<select name="chest" class="small">
            							<option value="">--Select Chest--</option>
            							<option class="p-0 m-0" value="c11" @if($wave->hero_chest =='c11') selected @endif>Light armour of Regeneration</option>
            							<option class="p-0 m-0" value="c12" @if($wave->hero_chest =='c12') selected @endif>Armour of Regeneration</option>
            							<option class="p-0 m-0" value="c13" @if($wave->hero_chest =='c13') selected @endif>Heavy armour of Regeneration</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="c21" @if($wave->hero_chest =='c21') selected @endif>Light Breastplate</option>
            							<option class="p-0 m-0" value="c22" @if($wave->hero_chest =='c23') selected @endif>Breastplate</option>
            							<option class="p-0 m-0" value="c23" @if($wave->hero_chest =='c23') selected @endif>Heavy Breastplate</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="c31" @if($wave->hero_chest =='c31') selected @endif>Light scale armour</option>
            							<option class="p-0 m-0" value="c32" @if($wave->hero_chest =='c32') selected @endif>Scale armour</option>
            							<option class="p-0 m-0" value="c33" @if($wave->hero_chest =='c33') selected @endif>Heavy scale armour</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="c41" @if($wave->hero_chest =='c41') selected @endif>Light segmented armour</option>
            							<option class="p-0 m-0" value="c42" @if($wave->hero_chest =='c42') selected @endif>Segmented armour</option>
            							<option class="p-0 m-0" value="c43" @if($wave->hero_chest =='c43') selected @endif>Heavy segmented armour</option>
            						</select>
        						</p>
        						<p>
            						<select	name="boot" class="small">
            							<option value="">--Select Boots--</option>
            							<option class="p-0 m-0" value="f11" @if($wave->hero_boots =='f11') selected @endif>Boots of Regeneration</option>
            							<option class="p-0 m-0" value="f12" @if($wave->hero_boots =='f12') selected @endif>Boots of Healthiness</option>
            							<option class="p-0 m-0" value="f13" @if($wave->hero_boots =='f13') selected @endif>Boots of Healing</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="f21" @if($wave->hero_boots =='f21') selected @endif>Small spurs</option>
            							<option class="p-0 m-0" value="f22" @if($wave->hero_boots =='f22') selected @endif>Small spurs</option>
            							<option class="p-0 m-0" value="f23" @if($wave->hero_boots =='f23') selected @endif>Nasty spurs</option>
            							<option class="p-0 m-0" disabled>----------</option>
            							<option class="p-0 m-0" value="f31" @if($wave->hero_boots =='f31') selected @endif>Boots of the Mercenary</option>
            							<option class="p-0 m-0" value="f32" @if($wave->hero_boots =='f32') selected @endif>Boots of the Warrior</option>
            							<option class="p-0 m-0" value="f33" @if($wave->hero_boots =='f33') selected @endif>Boots of the Archon</option>
            						</select>
        						</p>
            				</td>
            				<td colspan="4">
            					<p><a href="https://{{Session::get('server.url')}}/spieler.php?uid={{$wave->att_uid}}" target="_blank"><strong>Attacker Account Information <i class="fas fa-external-link-alt"></i></strong></a></p>
            					<p><textarea rows="3" cols="25" name="account"></textarea></p>
            					<p><button class="btn btn-sm btn-primary" name="wave" value="{{$wave->incid}}" type="submit">UPDATE</button></p>
            				</td>
        				</form>
        			</tr>
    			@endforeach			
    		</table>	
		</div>
		@endif
	@endif			
	</div>
</div>
@endsection

@push('scripts')
	@if(count($swaves)>0)	
	<script>
		@foreach($swaves as $wave)
			countDown("{{$wave->incid}}","{{$wave->landTime}}","{{Session::get('timezone')}}");
		@endforeach
	</script>
	@endif
	@if(count($owaves)>0)	
	<script>
		@foreach($owaves as $wave)
			countDown("{{$wave->incid}}","{{$wave->landTime}}","{{Session::get('timezone')}}");
		@endforeach
	</script>
	@endif
	
	<script>
    $(document).on('click','#details',function(e){
        e.preventDefault();  
    
        var col= $(this).closest("td");
        var id= col.find('#details').val();

		var row = $(this).closest('tr').next('tr');
		row.toggle('500');
    
    });

</script>
@endpush