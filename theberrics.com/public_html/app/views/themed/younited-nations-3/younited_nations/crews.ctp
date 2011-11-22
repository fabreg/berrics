<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true"),array("inline"=>false));
$c = Arr::countries();
?>
<script>
var map,geocoder,marker_img;
var markers = [];
$(document).ready(function() { 
	geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var lat = new google.maps.LatLng(34.0522342,-118.2436849);
	var myOptions = {
		      zoom:2,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.HYBRID,
		      center:lat
	};
	map = new google.maps.Map(document.getElementById("map"),myOptions);
	marker_img = new google.maps.MarkerImage("/theme/younited-nations-3/img/vans_pin.png");
	<?php foreach($entries['YounitedNationsEventEntry'] as $k=>$e): ?>

	markers[<?php echo $k; ?>] = new google.maps.Marker({

			
			position:new google.maps.LatLng(<?php echo $e['YounitedNationsPosse']['geo_latitude']; ?>,<?php echo $e['YounitedNationsPosse']['geo_longitude']; ?>)

		});
	markers[<?php echo $k; ?>].setMap(map);
	markers[<?php echo $k; ?>].setIcon(marker_img);
	<?php endforeach;?>
	
});

</script>
<style>

#yn3-left-col {

	width:100%;

}
#map {

	height:450px;
	width:100%;
}


#yn3-right-col {

	display:none;

}



</style>
<div class='yn3-crews'>
	<div style='height:150px;'>

	</div>
	<div id='map'>
	
	</div>
	<div>
	<div class='profile-div'>
	
	</div>
	<div class='crew-list'>
		<ul>
			<?php foreach($countries as $k=>$v): ?>
				<li>
					<div style="font-weight:bold; font-size:24px; font-family:'Arial'"><?php echo $c[$k]; ?></div>
						<ul>
					<?php foreach($v as $e): ?>
							<li>
								<?php echo strtoupper($e['YounitedNationsPosse']['name']); ?>
								<div style='font-size:12px; color:#999; font-style:italic;'><?php echo $e['YounitedNationsPosse']['geo_formatted']; ?></div>
							</li>
					<?php endforeach; ?>
						</ul>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div style='clear:both;'></div>
	</div>
</div>
<?php 

print_r($countries);

?>