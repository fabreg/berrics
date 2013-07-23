<?php
	$this->Unified->mapJsIncludes();
	$this->Html->script(array("//google-maps-utility-library-v3.googlecode.com/svn/trunk/infobubble/src/infobubble-compiled.js"),array("inline"=>false));
	$this->Html->css(array("site_index"),"stylesheet",array("inline"=>false));	
	$this->set("title_for_layout","THE BERRICS UNIFIED");

?>
<script>
//var markersJson = <?php echo json_encode($stores); ?>;
var map,geocoder = false;
var startLng = '<?php echo (!empty($this->request->data['GeoLocation']['lng'])) ? $this->request->data['GeoLocation']['lng']:'-118.2436849';?>';
var startLat = '<?php echo (!empty($this->request->data['GeoLocation']['lat'])) ? $this->request->data['GeoLocation']['lat']:'34.0522342';?>';
var markers = [];
var circle = false;
var centerMarker = false;
var markersJson = <?php echo json_encode($store_pins); ?>;
var infoWindow = false;
var infoBubble = false;

var BerricsGoogleMap = {

	geocode:false,
	map:false,
	startLng:false,
	startLat:false,
	markers:[],
	circle:false,
	centerMarker:false,
	infoWindow:false,
	infoBubble:false,
	initUnifiedLocator:function() {



	}

};

jQuery(document).ready(function($) {
	
	//$('select').selectBoxIt();

	


	geocoder = new google.maps.Geocoder();

	
		
	$("#location-btn").show().bind('click',function() {
		
		if(navigator.geolocation) {

			navigator.geolocation.getCurrentPosition(function(p) {

				bootstrapMap(p.coords.latitude,p.coords.longitude);
				shopLatLong(p.coords.latitude,p.coords.longitude,25);

			},function() { 
		


			});

		} else {

			bootstrapMap(startLat,startLng);
			$("#location-btn").hide();
		}

	});

		
	bootstrapMap(startLat,startLng);
	

	$(window).bind('resize.map',function() {

		//handleScreenResize();

	}).trigger('resize');
	
});

function handleScreenResize() {
	
	var bw = $(window).width(); //browser width
	var bh = $(window).height(); //browser height
	
	var mw = $('#map-row').width(); //map width
	var mh = $("#map-row").height(); //map height
	
	if(bw<=798) {
	
		$("#shop-results").css({"height":"auto"});

	} else {

		$("#shop-results").height(mh);

	}

	

}

function bootstrapMap($lat,$lng) {
		
		var latLng = new google.maps.LatLng($lat, $lng);
 		var mapOptions = {
          center: latLng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        if(!map) map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        setZoom(latLng,25);
	
		loadAllPins();

		//zip search form

		$("#StoreSearchForm").submit(function() { 

			zipSearch($("#StoreSearchQuery").val(),$("#StoreSearchMiles").val());

			return false;

		});


}

function loadPins() {

	var o = {

		url:'/unified/map/load_pins',
		success:function(d) {

		}

	};

	$.ajax(o);

}

function clearMarkers () {
	
	if(markers.length>0) {

		for(var a in markers) {

			markers[a].setMap(null);

		}
	
		//clear the shit!
		markers = [];

	}

}



function createShopInfoBubble($store_id) {

	var s = markersJson[$store_id];

	var $d = $(".dummy");

	var html = $('.bubble-holder').clone();

	html.find('.shop-name').html(s.UnifiedStore.shop_name);
	html.find('.shop-address').html(s.UnifiedStore.address1+" "+s.UnifiedStore.address2);
	html.find('.shop-city').html(s.UnifiedStore.city+", "+s.UnifiedStore.state+" "+s.UnifiedStore.zip+" "+s.UnifiedStore.country_code);
	html.find('.shop-phone').html("<strong>P:</strong>"+s.UnifiedStore.phone);
	if(s.UnifiedStore.shop_email) {

		html.find('.shop-phone').append(" <strong>E:</strong>"+s.UnifiedStore.shop_email)

	}
	

	//directions link
	var link = $("<a />").attr({
		"href":"http://maps.google.com?saddr=current+location&daddr="+encodeURIComponent(s.UnifiedStore.address1+" "+s.UnifiedStore.address2+" "+s.UnifiedStore.city+", "+s.UnifiedStore.state+" "+s.UnifiedStore.zip+" "+s.UnifiedStore.country_code),
		"target":"_blank"
	}).html("<i class='icon icon-road '></i> Get Directions");

	html.find('.directions').html(link);

	//add in the html to dummy
	$d.html(html.html());

	var h = $d.outerHeight()+30;
	var w = $d.outerWidth()+40;

	if(w<320) {

		w = 320;

	}
	
	console.log(w);
	console.log(h);

	return new InfoBubble({

		content:html.html(),
		minHeight:h,

		minWidth:w

	});

	return b;

}

function addMarker ($latLng,$unified_store_id) {
	
	var mark = new google.maps.Marker({
		
			position:$latLng,
			animation:google.maps.Animation.DROP,
			map:map,
			//icon:"/img/v3/unified/marker.png",
			icon:"/theme/unified/img/marker-new.png",
			unified_store_id:$unified_store_id
			
	});

	google.maps.event.addListener(mark,'click',function() { 
		
		if(infoBubble) {

			infoBubble.close();

		}
		
		var bubble = createShopInfoBubble(mark.unified_store_id)

		infoBubble = bubble;
		infoBubble.open(map,mark);
	});
	
	/*
	google.maps.event.addListener(mark,'click',function() { 
		
		var store = markersJson[mark.unified_store_id];

		if(infoWindow) {

			infoWindow.close();

		}

		var html = "<div>"+store.UnifiedStore.shop_name+"</div>";
		html += "<div>"+store.UnifiedStore.address1+" "+store.UnifiedStore.address2+"</div>";
		html += "<div>"+store.UnifiedStore.city+", "+store.UnifiedStore.state+" "+store.UnifiedStore.zip+"</div>";
		html += "<div>"+store.UnifiedStore.phone+"</div>";
		
		html = "<div class=''>"+html+"</div>";

		infoWindow = new google.maps.InfoWindow({

			"content":html

		});

		infoWindow.open(map,mark);

	});

	*/

	google.maps.event.addListener(mark,'dblclick',function() { 
	
		var store = markersJson[mark.unified_store_id];
	
		map.setZoom(12);

		map.panTo(mark.position);

	});

	markers[mark.unified_store_id]=mark;

}

function setZoom($latLng) {

	var miles = arguments[1] || 10;
	
	var radius = 1609.34 * miles;

	var cOptions = {
			center: $latLng,
		    fillOpacity: 0,
		    strokeOpacity:.5,
		    map: map,
		    radius: radius ,
		    strokeColor:"red"
	};
	
	if(circle) circle.setMap(null);

	circle = new google.maps.Circle(cOptions);

	map.fitBounds(circle.getBounds());

	if(centerMarker) {

		centerMarker.setMap(null);

	} 

	centerMarker = new google.maps.Marker({

			position:$latLng,
			animation:google.maps.Animation.DROP,
			map:map,
			icon:"//maps.google.com/intl/en_us/mapfiles/ms/micons/purple-dot.png"



		});
}

function zipSearch($zip,$radius) {

	var r = {};

	r.address = $zip;

	geocoder.geocode(r,function($geo,$res) { 
	
		map.setCenter($geo[0].geometry.location);
		setZoom($geo[0].geometry.location,$radius);
		//map.setZoom(19);
		//clearMarkers();
		//addMarker($geo[0].geometry.location);

		//set the lat and long fields
		//$("#GeoLocationLat").val($geo[0].geometry.location.lat());
		//$("#GeoLocationLng").val($geo[0].geometry.location.lng());
		//$("#GeoLocationStreetAddressFormatted").val($geo[0].formatted_address);

		//console.log($geo);
		shopLatLong($geo[0].geometry.location.lat(),$geo[0].geometry.location.lng(),$radius);

	});

}

function shopLatLong($lat,$lng,$distance) {

	var o = {
		"type":"post",
		"url":"/unified/map/search_shops_geo",
		"data":{
			data:{
				"GeoLocation":{
					"lat":$lat,
					"lng":$lng,
					"distance":$distance
				}
			}
		},
		success:function(d) { 
		
			$("#shop-results").html(d);

			$('.shop-result').bind('click',function() { 

				var id = $(this).attr("data-unified-store-id");

				var store = markersJson[id];
				
				//map.setZoom(17);

				map.panTo(markers[id].position);

				google.maps.event.trigger(markers[id],'click');

			});


		},
		error: function (xhr, ajaxOptions, thrownError) {
          // alert(xhr.status);
          // alert(xhr.responseText);
          // alert(thrownError);
          console.log(xhr.responseText);
       }
	
	};

	$.ajax(o);

}

function loadAllPins() {

	for(var a in markersJson) {
	
		var latLng = new google.maps.LatLng(markersJson[a].GeoLocation.lat,markersJson[a].GeoLocation.lng);
		addMarker(latLng,markersJson[a].UnifiedStore.id);
		

	}

}

function setSearchMarker($lat,$lng) {

	if(centerMarker) centerMarker.setMap(null);

	//marker options
	var o = {
	
		

	};

	centerMarker = new google.maps.Marker(o);

}

function handleMarkerClick($marker) {

	

}


</script>
<style>
	
</style>
<?php 

	$miles = array("5"=>"Within 5 Miles","10"=>"Within 10 Miles");

	for($i=25;$i<=100;$i+=25) {

		$miles[$i] = "Within ".$i." Miles";

	}

 ?>

<div id="unified-site-index">
	<?php echo $this->element("misc/ribbon-heading",array("heading"=>"UNIFIED STORE LOCATOR")); ?>
</div>

<div id="unified-map" class='column-shadow'>
	
	
	
	<div class="clearfix" id='map-row'>
		<div class="" id='map-container'>
			<div id="search-bar" class="map-search-div row-fluid">
				<?php echo $this->Form->create('StoreSearch',array(
					"id"=>'StoreSearchForm',
					"url"=>$this->request->here
				)); ?>
				<div class="row-fluid">
					<div class="span12">
					 
					 <div class="row-fluid">
					 	<div class="span12">
					 		<input type="text" name='data[StoreSearch][query]' id='StoreSearchQuery' class='span12' placeholder='Enter Your City / Postal Code or Address' />
					 	</div>
					 	
					 </div>
					 <div class="row-fluid">
					 	<div class="span6">
							<?php echo $this->Form->select("miles",$miles,array("label"=>false,"div"=>false,"class"=>"span12")); ?>
					 	</div>
					 	<div class="span6">
					 		<div class="btn-group pull-right">
					 			<button class="btn" type='submit'><i class="icon  icon-search"></i> Search</button>
					 			<button class="btn" type='button' id='location-btn'><i class='icon  icon-map-marker'></i></button>
					 		</div>
					 	</div>
					 </div>
				</div>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
			<div id="map_canvas" ></div>
		</div>
		<div class="" id='results-col'>
			
			<div id="shop-results">
			 	
			</div>
		</div>
	</div>
</div>
<div class="dummy"></div>
<div class="bubble-holder">
	<div class="shop-bubble">
		<div class="shop-name"></div>
		<div class="shop-inner">
			<div class="shop-address"></div>
			<div class="shop-city"></div>
			<div class="shop-phone"></div>
			<div class="shop-email"></div>
			
			<div class="directions"></div>
			<div class="shop-hours">
				<div class="hrs-label">Store Hours</div>
			</div>
		</div>
	</div>
</div>
<?php echo pr($stores); ?>