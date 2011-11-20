//Author: john.hardy@me.com ;-)
//set google object variables
var map,geocoder,marker,marker_img = false;
//overlay html stubs
var overlay_html = {
		
		"login":"<div><a href='/identity/login/send_to_facebook/"+Base64.encode(document.location.href)+"'>Login With Facebook</a></div>",
		"processing":"<div><img src='/theme/younited-nations-3/img/ajax-loader.gif' alt='' valign='absmiddle' />Updating Your Entry</div>"
		
};
//submit buttons for the entry form
var update_button = "<input class='update-button' type='submit' value='UPDATE' />";
var submit_button = "<input class='submit-button' type='submit' value='SUBMIT' />";

//shit's about to go down
$(document).ready(function() { 
	
	//i wanna live in los angeles
	var lat = new google.maps.LatLng(34.0522342,-118.2436849);
	
	//mapop hiphop
	var mapop = {

		zoom:14,
		center:lat,
		mapTypeId: google.maps.MapTypeId.HYBRID
			
	};
	
	//geo code LA
	geocoder = new google.maps.Geocoder();
	
	// create map instance
	map = new google.maps.Map(document.getElementById("map"),mapop);

	//test shit nikka
	$("#tester").click(function() {
		
		screenOverlay("testomg");
		
	});

	
	//bind the postal code field to fire the geo code
	$("#YounitedNationsPosseCityStatePostal").bind('blur',function() { 
	
		younitedNationsGeocode();

	});

	
	//mark all shit as bad
	$("#entry-form .crew-info-form label").addClass('red-label-x');
	
	//check to see if we're logged in
	//if not; show the facebook login on any form input focus
	if($(".facebook-login-large").length>0) {
	
		$('#entry-form input,#entry-form select').bind('focus click',function() { 
			
			$(this).blur();
			//screenOverlay(overlay_html.login);
			CartWidget.openLoginScreen();
		});
		
		$('#entry-form input').bind('keydown',function() { 
			
			$(this).blur();
			
		});
		
	} else {
		
		//validate on any change
		$(".crew-info-form input,.crew-info-form select").bind('keyup change',function(e) { 
			
			validateCrewInfo();
			
		});
		
	}
	
	//bind the form nikka!
	$("form[action='/younited-nations-3']").submit(function() { 
		
		if($(".facebook-login-large").length>0) {
			
			CartWidget.openLoginScreen();
			return false;
			
		}
		
		//check for red -x's
		if($('.red-label-x').length>0) {
			
			alert("Fix all fields with red x's");
			return false;
			
		}
		
		//open up the loading message
		screenOverlay(overlay_html.processing);
		
		//ajax submit
		var op = {
				
				url:"/younited-nations-3/ajax_update_entry",
				dataType:"json",
				success:function(d) {
					/*
					for(var a in d) {
					
						$('body').append(a+":"+d[a]+"<br />");
						for(var aa in d[a]) {
							$('body').append(aa+":"+d[a][aa]+"<br />");
						}
					}
					*/
					
					//populate hidden fields if needed
					if($("input[name='data[YounitedNationsEventEntry][id]']").length<=0) {
						
						var tmp = $("#hidden_input_clone").clone().attr({
							
							id:"YounitedNationsEventEntryId",
							value:d['YounitedNationsEventEntry']['id'],
							name:"data[YounitedNationsEventEntry][id]"
							
						});
						
						$("#YounitedNationsEventEntryForm").append(tmp);
						
					}
					if($("input[name='data[YounitedNationsPosse][id]']").length<=0) {
						var tmp = $("#hidden_input_clone").clone().attr({
							
							id:"YounitedNationsPosseId",
							value:d['YounitedNationsPosse']['id'],
							name:"data[YounitedNationsPosse][id]"
							
						});
						
						$("#YounitedNationsEventEntryForm").append(tmp);
					}
					
					$("#crew-roster-bits").html(d['roster_html']);
					
					popOverlay("Your Entry Has Been Updated Successfully");
					
					setTimeout(function() { handleOverlayClose('fadeout'); },2000);
					
					addSubmits();
					
				
				}
				
			};
		var debug = {
				
				url:"/younited-nations-3/ajax_update_entry",
				dataType:"html",
				success:function(d) {
					
					$('body').append(d);
					addSubmits();
				}
				
			};
		$(this).ajaxSubmit(op);
		
		
		return false;
	});
	
	
	//do an initial validate
	validateCrewInfo();
	addSubmits();
	//do an initial geo code if there is text present
	if($("#YounitedNationsPosseCityStatePostal").val().length>4) {
		
		younitedNationsGeocode();
		
	}
});

function addSubmits() {
	
	if($("input[name='data[YounitedNationsEventEntry][id]']").length>0) {
	
		$('.submit-holder').html(update_button);
		
	} else {
		
		$('.submit-holder').html(submit_button);
	}
	
}

function validateCrewInfo() {
	
	//disable the email field if filled
	if($("#YounitedNationsEventEntryContactEmail").val().length>=4) {
		
		$("#YounitedNationsEventEntryContactEmail").attr("disabled",true);
		
	} else {
		
		$("#YounitedNationsEventEntryContactEmail").attr("disabled",false);
		
	}
	
	$(".crew-info-form input,.crew-info-form select").each(function() { 
		
		
		var id = $(this).attr("id");
		
		var pass = null;
		var min_char = 2;
		switch(id) {
		
			case "YounitedNationsEventEntryContactEmail":
				var val = $(this).attr("value");
				if(val.length>3) {
					pass = true;
				} else {
					pass = false;
				}
				break;
			case "YounitedNationsPosseCountry":	
				min_char = 1;
			case "YounitedNationsPosseName":
			case "YounitedNationsPossePhoneNumber":
				
				var val = $(this).val();
				
				if(val.length>=min_char) {
					pass = true;
				} else {
					pass = false;
				}
				
				break;
		
		}
		
		if(pass == true) {
		
			$(this).parent().find("label").removeClass('red-label-x').addClass('green-label-check');
			
		} else if(pass == false) {
		
			$(this).parent().find("label").addClass('red-label-x').removeClass('green-label-check');
			
		}
		
	});
	
	
	
	
}

function screenOverlay() {
	
	$('body').append("<div id='yn3-overlay'><div class='wrapper'><div class='box'><div class='content'></div></div></div></div>");
	
	if(arguments[0] != undefined) popOverlay(arguments[0]);
	
	handleOverlayResize();
	
	$("#yn3-overlay").fadeIn('slow');
	
	
	
	$(window).bind('resize',function() { handleOverlayResize(); });
	
	$("#yn3-overlay").click(function() { 
		
		handleOverlayClose();
		
	});
	
}

function popOverlay(c) {
	
	$("#yn3-overlay .content").html(c);
	
}

function handleOverlayResize() {
	/*
	$('html,body').css({
		
		"overflow":"hidden"
		
	});
	*/
	$("#yn3-overlay").css({
		
		"width":"100%",
		"height":$(window).height()+"px",
		"top":"0px",
		"left":"0px",
		
	});
	
	$("#yn3-overlay .box").css({
		
		"margin-top":(($(window).height()/2)-($('#yn3-overlay .box').height()/2))+"px"
		
	});
	
}

function handleOverlayClose() {
	
	$(window).unbind('resize');
	
	if(arguments[0] == 'fadeout') {
		
		$("#yn3-overlay").fadeOut('normal',function() {
			
			$("#yn3-overlay").remove();
			
			
		});
		
		
		
	} else {
		
		$("#yn3-overlay").remove();
		
	}
	
	
}

function validateTextField(id,required) {

	required = required || 3;

	var chk = $(id).val();

	if(chk.length < required) {

		return false;

	} else {

		return true;

	}
	
}

function initRosterForms() {
	
	
	
}

function toggleRosterForm() {
	
	var ele = $(arguments[0]);
	var directive = arguments[1] || null;
	
	if(directive == null) {
		
	}
	
}



function showUpdateMsg() {
	
	
}

function closeUpdateMsg() {
	
	
	
}


function younitedNationsGeocode() {

	var country = $("#YounitedNationsPosseCountry").val();
	var other = $("#YounitedNationsPosseCityStatePostal").val();

	geocoder.geocode( { 'address': other+" "+country}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {

				if(!marker) {

					marker = new google.maps.Marker();

				} 

				if(!marker_img) {

					marker_img = new google.maps.MarkerImage("/theme/younited-nations-3/img/vans_pin.png");

					marker.setIcon(marker_img);
					
				}

	          marker.setMap(map); 
	          marker.setPosition(results[0].geometry.location);
			  marker.setDraggable(true);
			  
	       	  map.setCenter(results[0].geometry.location);

				if(other.length>0) {

					 map.setZoom(14);
					
				} else {


					 map.setZoom(4);
					
				}
		       	  
		         
		        $("body").append(results[0].geometry.location.lng()+" : "+results[0].geometry.location.lat());

				$("#YounitedNationsPosseGeoLongitude").val(results[0].geometry.location.lng());
				$("#YounitedNationsPosseGeoLatitude").val(results[0].geometry.location.lat());
				$("#YounitedNationsPosseCityStatePostal").parent().find('label').addClass('green-label-check').removeClass("red-label-x");
		        
	      } else {
		      
	        	//alert("Geocode was not successful for the following reason: " + status);
	        	$("#YounitedNationsPosseCityStatePostal").parent().find('label').removeClass('green-label-check').addClass("red-label-x");
	        
	      }
	});

	
}
