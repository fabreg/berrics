$(document).ready(function() { 

	yn3.init();

	
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
		
		yn3.getPins();
		
		$('#check-map').click(function() { 

			var s = 'Zoom:'+yn3.map.getZoom();

			$('.profile-div').html(s);

		});
		
		$(".country-list li").click(function() { 
			
			
			yn3.handleCountryClick(this);
			
			
		}).hover(
				function() { 
					
					$(this).addClass('over');
					
				},
				function() {
					
					$(this).removeClass('over');
					
				}
		);
		
		//setup country menu hovers
		
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
					
				};
				
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
			
					"key":str
			
				}
			
			},
			url:"/younited-nations-3/get_geo_cache",
			success:function(d) {
				
				if(d.lat == undefined || d.lng == undefined) {
					
					yn3.googleGeoCoder(str,callback);
					
				} else {
					
					callback.apply(this,[d,str]);
					
				}
				
			},
			type:"post",
			dataType:"json"
				
		};
		
		$.ajax(ops);
		
		
	},
	handleCountryClickGeoData:function(data,str) {
		
		
		
		$('body').append("Latitude: "+data.lat);
		$('body').append(" Longitude: "+data.lng+"<br />");
		
		$(window).scrollTo(215,"normal");
	
		//yn3.map.panToBounds(new google.maps.LatLngBounds(new google.maps.LatLng(data.viewport.southwest.lat,data.viewport.southwest.lng),new google.maps.LatLng(data.viewport.northeast.lat,data.viewport.northeast.lng)));
			
		yn3.map.setCenter(new google.maps.LatLng(data.lat,data.lng));
		
		var GLOBE_WIDTH = 256; // a constant in Google's map projection
		var west = data.bounds.southwest.lng;
		var east = data.bounds.northeast.lng;
		var angle = east - west;
		if (angle < 0) {
		  angle += 360;
		}
		var zoom = Math.round(Math.log(700 * 360 / angle / GLOBE_WIDTH) / Math.LN2);
		
		yn3.map.setZoom(zoom);
		
		
	},
	handleCountryClick:function(scope) {
		
		var str = $(scope).find('span:eq(0)').text();
		
		yn3.getGeoData(str, yn3.handleCountryClickGeoData);
		
	},
	googleGeoCoder:function(str,callback) {
		
		
		yn3.geocoder.geocode( { 'address': str}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				
					//results[0].geometry.location
				
					var data = {
							'lat':results[0].geometry.viewport.getCenter().lat(),
							'lng':results[0].geometry.viewport.getCenter().lng(),
							'viewport':{
								
								'southwest':{
									'lat':results[0].geometry.viewport.getSouthWest().lat(),
									'lng':results[0].geometry.viewport.getSouthWest().lng()
								},
								'northeast':{
									'lat':results[0].geometry.viewport.getNorthEast().lat(),
									'lng':results[0].geometry.viewport.getNorthEast().lng()
								}
								
							},
							'bounds':{
								
								'southwest':{
									'lat':results[0].geometry.bounds.getSouthWest().lat(),
									'lng':results[0].geometry.bounds.getSouthWest().lng()
								},
								'northeast':{
									'lat':results[0].geometry.bounds.getNorthEast().lat(),
									'lng':results[0].geometry.bounds.getNorthEast().lng()
								}
								
							}
					};

				
					//fire the callback method
				
					callback.apply(this,[data,str]);
				
					//send the results to the server to be cached
					
					var ops = {
							
							"url":"/younited-nations-3/set_geo_cache",
							type:"post",
							"data":{
							
								"data":{
						
									"key":str,
									"val":data
							
								}
							
							}
							
					};
					
					$.ajax(ops);
				
		      } else {
			      
		        	alert("Geocode was not successful for the following reason: " + status);
		        	//$("#YounitedNationsPosseCityStatePostal").parent().find('label').removeClass('green-label-check').addClass("red-label-x");
		        
		      }
		});
	}
	
	
	
	
};