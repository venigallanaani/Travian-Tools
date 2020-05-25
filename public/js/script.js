$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

$(document).on('click','.savewave',function(e){
	e.preventDefault();
	
	var plan = $('meta[name="planId"]').attr('content');
	var entry = $(this).closest("div.entry");	
	var target= $(this).closest(".target");
	var table = $(this).closest("table");
		
	var display = entry.siblings();
	var attid = display.attr("id");	
	//alert(attacker.attr("id")); 
	
	var tarid = target.attr("id");
	var id = $(this).val();	
	var unit = table.find("#unit").val();
	var wave = table.find("#waves").val();
	var type = table.find("#type").val();
	var notes = table.find("#notes").val();
	var landTime = table.find("#landTime").val();
	
    $.ajax({
        type:'POST',
        url:'/offense/plan/editwave',
        data:{  plan:plan,		id:id,					
        		unit:unit,		wave:wave,		type:type,			
        		notes:notes,	landTime:landTime        		
            },
        success:function(data){
        	alert(data.message);
        	table.hide();
        	
        	display.show();
        	display.css("background-color", "white");
        	
        	display.find("#waves").text(wave);
        	display.find("#landTime").text(data.landTime);        	
        	display.find("#type").text(data.type);        	
        	        	
        	var image=display.find(".units");
        	image.removeClass();
        	image.addClass("units "+data.unit);
        	image.parent("td").prop("title",data.name);
        	
        	var attacker = $('div.attacker[rel="' + data.attacker + '"]');
        	
        	if(data.type=="Real"){
        		display.find("#type").css('color','red');
        	}else if(data.type=="Fake"){
        		display.find("#type").css('color','blue'); 
        	}else{
        		display.find("#type").css('color','black');
        	}
        	
        	attacker.find("#real").text(data.areal);
        	attacker.find("#fake").text(data.afake);
        	attacker.find("#other").text(data.aother);
        	
        	target.find("#real").text(data.treal);
        	target.find("#fake").text(data.tfake);
        	target.find("#other").text(data.tother);
        },
        error:function(){
        	alert('Something went wrong, please try again. Contact administrator, if the problem persists.');
        }
     });	
	
});

$(document).on('click','.delwave',function(e){
	e.preventDefault();
	
	var plan = $('meta[name="planId"]').attr('content');
    var wave = $(this).val();
    var div = $(this).closest("div.display");
    var target = $(this).closest(".target");

    div.hide();

    $.ajax({
        type:'POST',
        url:'/offense/plan/deletewave',
        data:{  plan:plan,		
        		wave:wave					
            },
        success:function(data){
        	alert(data.message);
        	
        	var attacker = $('div.attacker[rel="' + data.attacker + '"]');        	        	
        	attacker.find("#real").text(data.areal);
        	attacker.find("#fake").text(data.afake);
        	attacker.find("#other").text(data.aother);        	
        	
        	target.find("#real").text(data.treal);
        	target.find("#fake").text(data.tfake);
        	target.find("#other").text(data.tother);
        },
        error:function(){
        	alert('Something went wrong, please try again. Contact administrator, if the problem persists.');
        }
     });	
});

$(document).on('click','.delitem',function(){
	$("#loading").toggle();
	
	var type = $(this).attr("id");	var id = $(this).val();
	var plan = $('meta[name="planId"]').attr('content');
			
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        	{	console.log(xmlhttp.responseText);		}
    };
    xmlhttp.open("GET", "/offense/plan/delitem/"+plan+"/"+type+"/"+id, true);
    xmlhttp.send();
		    
    setTimeout(function(){ location.reload(); }, 1000);
    
});

$(document).ready(function(){
	$(".attacker").css('cursor','grabbing');
	$(".attacker").draggable({
        helper: 'clone'
    });

    $(".target").droppable({
	    drop:function(event,ui){
	    	$("#loading").toggle();	    	

	    	var plan = $('meta[name="planId"]').attr('content');
	    	const target = $(this).attr('id');
            const attack = ui.draggable.attr("id");
            var id=attack+'-'+target;
            
    		var xmlhttp = new XMLHttpRequest();
    	    xmlhttp.onreadystatechange = function() {
    	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
    	        	{	console.log(xmlhttp.responseText);		}
    	    };
    	    
    	    xmlhttp.open("GET", "/offense/plan/addwave/"+plan+"/"+id, true);
    	    xmlhttp.send();
            
    		//alert(attack+'->'+target);
    		setTimeout(function(){ location.reload(); }, 1000);
    	}
    });
});

$(document).on('click','.editwave',function(){
	var div = $(this).closest("div.display");
	var entry = div.siblings();
	entry.show();
	div.hide();
});