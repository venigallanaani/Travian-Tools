@extends('Calculators.template')

@section('body')

<!-- =================================== Cropper input screen================================== -->
    <div class="card float-md-left p-0 col-md-12 shadow">
        <div class="card-header h5 py-2 bg-primary text-white col-md-12">
            <strong>Cropper Development</strong>
        </div>
        <div class="card-text mx-auto text-center my-3 col-md-12">
			<table class="mx-auto">
				<tr>
					<td colspan="3" class="text-left">
						<div class="px-2 py-1">
							<form name="o0">
    							<strong>Cropper:</strong> 
    								<select name="no0" onChange="seto0(document.o0.no0.options[document.o0.no0.options.selectedIndex].value)">
    									<option value=15>15 Crop</option>
    									<option value=9>9 Crop</option>
    									<option value=7>7 Crop</option>
    									<option value=6>6 Crop</option>
    								</select>
							</form>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="px-3 py-1">
							<form name="o4">
    							<strong>Capital : </strong>
    								<select name="no4" onChange="seto4(document.o4.no4.options[document.o4.no4.options.selectedIndex].value)">
    									<option value="0">Yes</option>
    									<option value="1">No</option>
    								</select>	
							</form>						
						</div>
					</td>
					<td>
						<div class="px-3 py-1">
							<form name="o5">
    							<strong>Plus : </strong>
    								<select name="no5" onChange="seto5(document.o5.no5.options[document.o5.no5.options.selectedIndex].value)">
    									<option value=1.25>Yes</option>
    									<option value=1>No</option>
    								</select>
							</form>
						</div>
					</td>
					<td>
						<div class="px-3 py-1">
							<form name="o6">
    							<strong>Waterworks : </strong>
    								<select name="no6" onChange="seto6(document.o6.no6.options[document.o6.no6.options.selectedIndex].value)">
    									<option value="0">No</option>
    									<option value="1">Yes</option>
    								</select>
							</form>
						</div>
					</td>					
				</tr>
				<tr>
					<td>
						<div class="px-3 py-1">
							<form name="o1">
    							<strong>Oasis 1:</strong> 
    								<select name="no1" onChange="seto1(document.o1.no1.options[document.o1.no1.options.selectedIndex].value)">
    									<option value=0>0%</option>
    									<option value=0.25>25%</option>
    									<option value=0.50>50%</option>									
    								</select>
							</form>
						</div>
					</td>
					<td>
						<div class="px-2 py-1">
							<form name="o2">
    							<strong>Oasis 2:</strong> 
    								<select name="no2" onChange="seto2(document.o2.no2.options[document.o2.no2.options.selectedIndex].value)">
    									<option value=0>0%</option>
    									<option value=0.25>25%</option>
    									<option value=0.50>50%</option>									
    								</select>
							</form>
						</div>
					</td>
					<td>
						<div class="px-3 py-1">
							<form name="o3">
    							<strong>Oasis 3:</strong> 
    								<select name="no3" onChange="seto3(document.o3.no3.options[document.o3.no3.options.selectedIndex].value)">
    									<option value=0>0%</option>
    									<option value=0.25>25%</option>
    									<option value=0.50>50%</option>									
    								</select>
							</form>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="text-danger font-italic px-2 py-1">Please select the highest Oasis first</td>
				</tr>
				<tr>
					<td colspan="3">
						<button class="btn btn-outline-primary px-5" type="button" onclick="getOrder()"><strong>Calculate</strong></button>
					</td>
				</tr>
			</table>
        </div>        
        	<p class="text-right px-5"><small>Page credited to Bryan H & MaTzE</small></p>        
    </div>    
    	<span id="steps"></span>

    
		
@endsection


@push('scripts')

        <script>
var o0=15, mill=0, bake=0, hm=0, o1=0, o2=0, o3=0, o1p=0, o2p=0, o3p=0, cap=0, gold=1.25, waterwork=0, egypt=0;
costs=new Object();
costs.m = new Array(0,2560,4605,8295,14925,26875);
costs.b = new Array(0,5150,9270,16690,30035,54060);
costs.hm= new Array(0,114240,383295,1595070);
costs.ww= new Array(0,3105,4065,5325,6980,9145,11975,15695,20555,26925,35280,46215,60545,79310,103895,136105,178300,233560,305965,400815,525070);

field=new Object();
field.fields = new Array(0,0,0,0,0,0);
field.values = new Array(3,7,13,21,31,46,70,98,140,203,280,392,525,691,889,1120,1400,1820,2240,2800,3430,4270);
field.increase = new Array(0,4,6,8,10,15,24,28,42,63,77,112,133,168,196,231,280,420,420,560,630,840);
field.costs = new Array(0,250,415,695,1165,1945,3250,5425,9055,15125,25255,42180,70445,117650,196445,328070,547880,914960,1527985,2551735,4261410,7116555);
//field.increase = new Array(0,3,4,6,7,11,17,20,30,45,55,80,95,120,140,165,200,300,300,400,450,600);
//field.values = new Array(2,5,9,15,22,33,50,70,100,145,200,280,375,495,635,800,1000,1300,1600,2000,2450,3050);

field.lowest = function()
{
	return field.fields[o0-1];
}
field.highest = function()
{
	return field.fields[0];
}
field.uplowest = function()
{
	for(var i=0;i<o0;i++)
	{
		if (field.fields[i] <= field.lowest())
		{
			field.fields[i]=field.fields[i]+1;
			return field.fields[i];
		}
	}
	return ;
}
field.uphighest = function()
{
	field.fields[0]=field.fields[0]+1;
}
field.tprod = function()
{
	var valuei, tprod=0;
	for(var i=0;i<o0;i++)
	{
		valuei = field.fields[i];
		tprod=tprod+field.values[valuei];
	}
	return tprod;
}
function seto0(select)
{
o0 = select;
if (o0==3)
field.fields=[0,0,0];
else if (o0==4)
field.fields=[0,0,0,0];
else if (o0==5)
field.fields=[0,0,0,0,0];
else if (o0==6)
field.fields=[0,0,0,0,0,0];
else if (o0==7)
field.fields=[0,0,0,0,0,0,0];
else if (o0==9)
field.fields=[0,0,0,0,0,0,0,0,0];
else if (o0==15)
field.fields=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
else
field.fields=[];
}
function totalprod()
{
	return field.tprod()*(1+o1*o1p*(1+waterwork*.05)+o2*o2p*(1+waterwork*.05)+o3*o3p*(1+waterwork*.05)+bake*.05+mill*.05);
}
function totalprodn(f,m)
{			z.innerHTML=f +'-'+ m
	return (field.tprod()+f)*(1+o1*o1p*(1+waterwork*.05)+o2*o2p*(1+waterwork*.05)+o3*o3p*(1+waterwork*.05)+bake*.05+mill*.05+m);
}

function seto1(select)
{
o1 = parseFloat(select);
}
function seto2(select)
{
o2 = parseFloat(select);
}
function seto3(select)
{
o3 = parseFloat(select);
}
function seto4(select)
{
cap = parseFloat(select);
}
function seto5(select)
{
gold = parseFloat(select);
}
function seto6(select)
{
egypt = parseFloat(select);
}
function reset()
{
	if (cap == 1)
		field.costs[11]=1000000
	else
		field.costs[11]=42180
	seto0(o0);
	hm =0;
	mill =0;
	bake =0;
	o1p =0;
	o2p =0;
	o3p =0;
	waterwork=0;
}

function getNextStep()
{
	var output = "";
	var lowest = 0;
	var efflowest = 1000000;
	var temp = 0;
	
	//test lowest field
	if(field.fields[o0-1]<=10 || cap != 1)
		efflowest = field.costs[field.fields[o0-1]+1]/(totalprodn(field.increase[field.fields[o0-1]+1],0) - totalprod());
	//test mill/bake rush if applicable
	if (field.fields[0]<10)
	{
		if (field.fields[0]<5)
		{
			var tfi=0; tfc=0;
			for(var i=field.fields[0]+1;i<6;i++)
			{
				tfi=tfi+field.increase[i];
				tfc=tfc+field.costs[i];
			}
			//try all mill level rushes
			tfc = tfc+costs.m[1];
			temp = tfc/(totalprodn(tfi,.05)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			tfc = tfc+costs.m[2];
			temp = tfc/(totalprodn(tfi,.1)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			
			tfc = tfc+costs.m[3];
			temp = tfc/(totalprodn(tfi,.15)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			tfc = tfc+costs.m[4];
			temp = tfc/(totalprodn(tfi,.2)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			tfc = tfc+costs.m[5];
			temp = tfc/(totalprodn(tfi,.25)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
		}
		else if(field.fields[o0-1]<=10|| cap == 0)
		{
			var tfi=0; tfc=0; tfm=0;
			for(var i=field.fields[0]+1;i<11;i++)
			{
				tfi=tfi+field.increase[i];
				tfc=tfc+field.costs[i];
			}
			if (mill<5)
			{
				for(var i=mill; i<5; i++)
				{
					tfc+=costs.m[i+1];
					tfm+=.05;
				}
			}
			//try all mill level rushes
			tfc = tfc+costs.b[1];
			temp = tfc/(totalprodn(tfi,.05+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			tfc = tfc+costs.b[2];
			temp = tfc/(totalprodn(tfi,.1+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			
			tfc = tfc+costs.b[3];
			temp = tfc/(totalprodn(tfi,.15+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			tfc = tfc+costs.b[4];
			temp = tfc/(totalprodn(tfi,.2+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
			tfc = tfc+costs.b[5];
			temp = tfc/(totalprodn(tfi,.25+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=1;
			}
		}
	}
	//test flowermill/bake special case
	if (mill<5 && field.fields[0]>=10)
		{
			var tfi=0; tfc=0; tfm=0;
			if (mill<5)
			{
				for(var i=mill; i<5; i++)
				{
					tfc+=costs.m[i+1];
					tfm+=.05;
				}
			}
			//try all mill level rushes
			tfc = tfc+costs.b[1];
			temp = tfc/(totalprodn(tfi,.05+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=2;
			}
			tfc = tfc+costs.b[2];
			temp = tfc/(totalprodn(tfi,.1+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=2;
			}
			
			tfc = tfc+costs.b[3];
			temp = tfc/(totalprodn(tfi,.15+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=2;
			}
			tfc = tfc+costs.b[4];
			temp = tfc/(totalprodn(tfi,.2+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=2;
			}
			tfc = tfc+costs.b[5];
			temp = tfc/(totalprodn(tfi,.25+tfm)-totalprod());
			if (temp <= efflowest)
			{
				efflowest=temp;
				lowest=2;
			}
		}
		
		//test waterwark	
	if (hm >= 10 && egypt==1)
	{
		temp = costs.ww[waterwork+1]/(totalprodn(0,o1*o1p*.05+o2*o2p*.05+o3*o3p*.05)-totalprod());
		if (temp <= efflowest)
		{
			efflowest = temp;
			waterwork++;
			lowest = 5;
		}
	}
	//test mill
	if (field.fields[0]>=5 && mill<5)
	{
		temp = costs.m[mill+1]/(totalprodn(0,.05)-totalprod());
		if (temp <= efflowest)
		{
			efflowest = temp;
			lowest = 2;
		}
	}
	//test bake
	if (field.highest()>=10 && bake<5 && mill == 5)
	{
		temp = costs.b[bake+1]/(totalprodn(0,.05)-totalprod());
		if (temp <= efflowest)
		{
			efflowest = temp;
			lowest = 3;
		}
	}
	//test oasis	
	if (o1p == 0)
	{
		temp = costs.hm[1]/(totalprodn(0,o1)-totalprod());
		if (temp <= efflowest)
		{
			efflowest = temp;
			o1p = 1;
			hm = 10;
			lowest = 4;
		}
	}
	else if (o2p == 0)
	{
		temp = costs.hm[2]/(totalprodn(0,o2)-totalprod());
		if (temp <= efflowest)
		{
			efflowest = temp;
			o2p = 1;
			hm = 15;
			lowest = 4;
		}
	}
	else if (o3p == 0)
	{
		temp = costs.hm[3]/(totalprodn(0,o3)-totalprod());
		if (temp <= efflowest)
		{
			efflowest = temp;
			o3p = 1;
			hm = 20;
			lowest = 4;
		}
	}
	else if (efflowest == 1000000)
		return;
	
	if (lowest == 0)
	{
		if (cap==1 && field.lowest()==10)
			return;
		output = output + field.uplowest();
		return "Upgrade a crop field to level " + output + ". </td><td>" + Math.round(efflowest/gold/.24)/100 + "</td>";
	}
	if (lowest == 1)
	{
		if (cap==1 && field.lowest()==10)
			return;
		field.uphighest();
		return '<b>Upgrade a crop field to level ' + field.fields[0] + "</span></b>. </td><td>" + Math.round(efflowest/gold/.24)/100 + "</td>";
	}
	if (lowest == 2)
	{
		mill++;
		return '<b><span class="text-warning">Upgrade the Flour Mill to level ' + mill + "</span></b>. </td><td>" + Math.round(efflowest/gold/.24)/100 + "</td>";
	}
	if (lowest == 3)
	{
		bake++;
		return '<b><span class="text-info">Upgrade the Bakery to level ' + bake + "</span></b>. </td><td>" + Math.round(efflowest/gold/.24)/100 + "</td>";
	}
	if (lowest == 4)
	{
		return "<b><span class='text-danger'>Upgrade the Hero Mansion to level " + hm + " and capture your oasis</span></b>. </td><td>" + Math.round(efflowest/gold/.24)/100 + "</td>";
	}
		if (lowest == 5)
	{
		return "<b><span class='text-primary'>Upgrade the waterworks to level " + waterwork + "</span></b>. </td><td>" + Math.round(efflowest/gold/.24)/100 + "</td>";
	}
}

function getOrder()
{
	reset();
	z=document.getElementById("steps");  // nothing
	z.innerHTML="Calculating...";   
	var j=1;
	var output='<div class="card float-md-left mb-5 p-0 col-md-12 shadow"><div class="card-header h5 py-2 bg-primary text-white"><strong>Cropper Development Sequence</strong></div>';
	output=output+'<div class="card-text mx-auto text-center"><table class="table table-hover table-sm small"><tr class="h6 text-primary">';
	output=output+'<th>#</th><th>[F,B,H,W]</th>';
	output=output+'<th>Fields</th><th>Production</th><th>Action</th><th>ROI <small>(days)</small></th><tr>';
	
	var i=0;
	if (cap == 0)
	{
		while(field.lowest()<21)
		{
			i = i+1;
			output=output+"<tr><td>"+j+"</td><td>["+mill+","+bake+","+hm+","+waterwork+"]</td>"+"<td>["+field.fields+"]</td>"+"<td><strong>"+Math.round(totalprod()*gold)+"</strong></td><td>"+getNextStep()+"</td></tr>";
			j=j+1;
		}
	}
	else if (cap == 1)
	{
		i = 0;
		while(field.lowest()<10||mill<5||bake<5||(hm<10&&o1!=0)||(hm<15&&o1!=0&&o2!=0)||(hm<20&&o1!=0&&o2!=0&&o3!=0))
		{
			i = i+1;
			output=output+"<tr><td>"+j+"</td><td>["+mill+","+bake+","+hm+","+waterwork+"]</td>"+"<td>["+field.fields+"]</td>"+"<td><strong>"+Math.round(totalprod()*gold)+"</strong></td><td>"+getNextStep()+"</td></tr>";
			j=j+1;
		}
	}
	
	output=output+"<tr><td>"+j+"</td><td>["+mill+","+bake+","+hm+","+waterwork+"]</td>"+"<td>["+field.fields+"]</td>"+"<td><strong>"+Math.round(totalprod()*gold)+'</strong></td><td class="text-success"><b>Done. Congrats!!</b></td></table>';
	x=document.getElementById("steps");  // Find the element
	x.innerHTML=output;   // Change the content

}
</script>

@endpush