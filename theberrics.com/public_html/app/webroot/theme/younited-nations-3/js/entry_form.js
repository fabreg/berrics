
//set variables
var map,geocoder,marker,marker_img = false;
var overlay_html = {
		
		"login":"<div><a href='/identity/login/send_to_facebook/"+Base64.encode(document.location.href)+"'>Login With Facebook</a></div>",
		"processing":"<div>Processing</div>"
		
};
$(document).ready(function() { 

	var lat = new google.maps.LatLng(34.0522342,-118.2436849);
	
	var mapop = {

		zoom:14,
		center:lat,
		mapTypeId: google.maps.MapTypeId.HYBRID
			
	};
	
	geocoder = new google.maps.Geocoder();
	map = new google.maps.Map(document.getElementById("map"),mapop);

	$("#tester").click(function() {
		
		younitedNationsGeocode();
		
	});

	$("#YounitedNationsEntryCityStatePostal").bind('blur',function() { 
	
		younitedNationsGeocode();

	});

	$("#entry-form label").addClass('red-label-x');
	
	if($(".facebook-login-large").length>0) {
	
		$('#entry-form input').bind('focus',function() { 
			
			$(this).blur();
			screenOverlay(overlay_html.login);
			
		});
		
		$('#entry-form input').bind('keydown',function() { 
			
			$(this).blur();
			
		});
		
	} else {
		
		var s = "#YounitedNationsEntryName,";
		s += "#YounitedNationsEntryCityStatePostal,";
		s += "#YounitedNationsEntryPhoneNumber,";
		s += "#YounitedNationsEntryEmail,";
		s += "#YounitedNationsEntryCountry";
		
		$(s).bind('keyup change',function(e) { 
			
			validateCrewInfo();
			
		});
		
	}
	
	//do an initial validate
	validateCrewInfo();
	
});

function validateCrewInfo() {
	
	var s = "#YounitedNationsEntryName,";
	s += "#YounitedNationsEntryCityStatePostal,";
	s += "#YounitedNationsEntryPhoneNumber,";
	s += "#YounitedNationsEntryEmail,";
	s += "#YounitedNationsEntryCountry";
	
	$(s).each(function() { 
		
		var val = $(this).val();
		
		if(val.length>=2) {
		
			$(this).parent().find("label").removeClass('red-label-x').addClass('green-label-check');
			
		} else {
		
			$(this).parent().find("label").addClass('red-label-x').removeClass('green-label-check');
			
		}
		
	});
	
	
	
	
}

function screenOverlay() {
	
	$('body').append("<div id='yn3-overlay'><div class='wrapper'><div class='content'></div></div></div>");
	
	if(arguments[0] != undefined) $("#yn3-overlay .content").html(arguments[0]);
	
	handleOverlayResize();
	
	$(window).bind('resize',function() { handleOverlayResize(); });
	
	$("#yn3-overlay").click(function() { 
		
		handleOverlayClose();
		
	})
	
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
		"background-color":"black",
		"position":"fixed",
		"z-index":"1900",
		"top":"0px",
		"left":"0px",
		"opacity":.5
		
	});
	
}

function handleOverlayClose() {
	
	$(window).unbind('resize');
	
	$("#yn3-overlay").remove();
	
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




function younitedNationsGeocode() {

	var country = $("#YounitedNationsEntryCountry").val();
	var other = $("#YounitedNationsEntryCityStatePostal").val();

	geocoder.geocode( { 'address': other+" "+country}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {

				if(!marker) {

					marker = new google.maps.Marker();

				} 

				if(!marker_img) {

					marker_img = new google.maps.MarkerImage("/theme/younited-nations-3/img/yn3-pin.png");

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

				$("#YounitedNationsEntryLongitude").val(results[0].geometry.location.lng());
				$("#YounitedNationsEntryLatitude").val(results[0].geometry.location.lat());

		        
		        
	      } else {
		      
	        	alert("Geocode was not successful for the following reason: " + status);
	        
	      }
	});

	
}
