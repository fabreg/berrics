
var yn3 = {


	map:null,
	geocoder:null,
	marker_img:null,
	markers:[],
	init:function() { 
		
		yn3.geocoder = new google.maps.Geocoder();
	    var latlng = new google.maps.LatLng(-34.397, 150.644);
	    var lat = new google.maps.LatLng(34.0522342,-118.2436849);
		var myOptions = {
			      zoom:2,
			      center: latlng,
			      mapTypeId: google.maps.MapTypeId.HYBRID,
			      center:lat
		};
		yn3.map = new google.maps.Map(document.getElementById("map"),myOptions);
		yn3.marker_img = new google.maps.MarkerImage("/theme/younited-nations-3/img/vans_pin.png");

	},
	dropPins:function() {
		
		
		$.ajax({
			
			dataType:'json',
			url:'/younited-nations-3/ajax_get_crews',
			success:function(d) {
			
				//var t = prettyPrint(d,{maxArray: 5,maxDepth:5});
				
				//$('body').append(t);
				
				for(var a in d.YounitedNationsEventEntry) {
				
					var p = d.YounitedNationsEventEntry[a].YounitedNationsPosse;
					
					yn3.markers[a] = new google.maps.Marker({
						
						map:yn3.map,
						icon:yn3.marker_img,
						position:new google.maps.LatLng(p.geo_latitude,p.geo_longitude),
						
						
					});
					
					yn3.configPin(yn3.markers[a]);
				}
			
				
				
			}
			
		});
		
	},
	configPin:function(pin) {
	
		google.maps.event.addListener(pin,'click',function(e) { 
			
			var z = yn3.map.getZoom();
			
			yn3.map.panTo(e.latLng);
			//yn3.map.setCenter(e.latLng);
			yn3.map.setZoom(z+1);
			
			
		});
		
	}

	
}