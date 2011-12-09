$(document).ready(function() { 

	yn3.init();
	yn3.getPins();
	
	yn3.tester();
	
	$('#check-map').click(function() { 

		var s = 'Zoom:'+yn3.map.getZoom();

		$('.profile-div').html(s);

	});
	
});
var yn3 = {


	map:null,
	geocoder:null,
	marker_img:null,
	crewMarkers:[],
	countryMarkers:[],
	crewMarkerCluster:null,
	jsonData:null,
	infoWindow:null,
	init:function() { 
		
		yn3.geocoder = new google.maps.Geocoder();
	    var latlng = new google.maps.LatLng(-34.397, 150.644);
	    var lat = new google.maps.LatLng(34.0522342,-118.2436849);
		var myOptions = {
			      zoom:3,
			      mapTypeId: google.maps.MapTypeId.HYBRID,
			      center:lat
		};
		yn3.map = new google.maps.Map(document.getElementById("map"),myOptions);
		yn3.marker_img = new google.maps.MarkerImage("/theme/younited-nations-3/img/vans_pin.png");
		yn3.infoWindow = new google.maps.InfoWindow();

	},
	setJson:function(d) {
		
	},
	getJson:function() {
	},
	getPins:function() {

		$.ajax({
			
			dataType:'json',
			url:'/younited-nations-3/ajax_get_crews',
			success:function(d) {
			
				//var t = prettyPrint(d,{maxArray: 5,maxDepth:5});
				
				//$('body').append(t);
				
				yn3.jsonData = d;
				yn3.configMap();
				yn3.configCrewPins();
				yn3.placeCrewPins();
				
			}
			
		});
		
	},
	configMap:function() {
		
		google.maps.event.addListener(yn3.map,'zoom_changed',function(e) {
			
			var z = yn3.map.getZoom();
			
			$('body').append("NewZoom: "+yn3.map.getZoom()+"<br />");
			
		});
		
	},
	configCrewPins:function() {
		
		var d = arguments[0] || yn3.jsonData;
		
		for(var a in d.YounitedNationsEventEntry) {

			var p = d.YounitedNationsEventEntry[a].YounitedNationsPosse;
			
			var m = new google.maps.Marker({
				
				map:null,
				icon:yn3.marker_img,
				position:new google.maps.LatLng(p.geo_latitude,p.geo_longitude),
				title:p.name
				
			});
	
			//alert(marker.getId());
			
			google.maps.event.addListener(m,'click',(function(m,p) { 

				return function() {
					
					yn3.infoWindow.setContent("<div style='color:#000;'>"+p.name+"</div>");
					yn3.infoWindow.open(yn3.map,m);
					
					if(yn3.map.getZoom()<7) {
						
						yn3.map.setZoom(7);
						yn3.map.setCenter(m.getPosition());
						
						
					}
					
				}
				
			})(m,p));
			
			yn3.crewMarkers.push(m);

		}
		
		
	},
	placeCrewPins:function() {

		yn3.crewMarkerCluster = new MarkerClusterer(yn3.map,yn3.crewMarkers,{
			
			gridSize:20,
			maxZoom:null,
			minimumClusterSize:8
			
		});
		//yn3.crewMarkerCluster.fitMapToMarkers();
		yn3.crewMarkerCluster.repaint();
	},
	removeCrewPins:function() {
		
		for(var i =0;i<yn3.crewMarkers.length;i++) {
		
			yn3.crewMarkers[i].setMap(null);
			
		}
		
	},
	getGeoData:function(str,callback) {
	
		var ops = {
				
			data:{
			
				"data":{
			
					
			
				}
			
			},
			url:"/younited-nations-3/get_geo_data",
			success:function(d) {
				
			}
				
		};
		
		
	},
	handleCountryClickGeoData:function(data) {
		
		var msg = ["testing"];
		
		yn3.getGeoData.call(this,msg);
		
	},
	handleCountryClick:function() {
		
	}
	
	
	
	
};