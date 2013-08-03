<script>

var loading_htm = "<div class='alert alert-info'>Loading .... </div>";

$(document).ready(function() { 

	
	loadDailyops();
	loadTopTenPages();
	loadTopTenVideos();
	loadTraffic();
	loadCanteenOrderStats();
	loadUserUploads();
	loadBerricsRecords();
	loadRg();
});


function loadRg() {

	$("#rg-votes").html(loading_htm).load("/run_and_gun",function(d) { initBootstrap(); });
	
}

function loadDailyops() {

	var date = arguments[0] || '';

	$("#dailyops").html(loading_htm).load('<?php echo $this->Admin->url(array("controller"=>"dashboard","action"=>"dailyops",date("Y-m-d"))); ?>',
						{
							"data":{
									"Dailyops":{
										"start_date":date
									}
								}
							},
						function(d) {

							initBootstrap();

						}
						);

	
	
	
}

function loadTopTenPages() {

	$("#top-ten-pages").html(loading_htm).load("/dashboard/top_pages/15",function(d) { initBootstrap(); });
	
}

function loadTopTenVideos() {

	$("#top-ten-videos").html(loading_htm).load("/dashboard/top_videos/15",function(d) { initBootstrap(); });
	
}

function loadTraffic() {

	$("#traffic").html(loading_htm).load("/dashboard/traffic",function(d) { initBootstrap(); });
	
}


function loadCanteenOrderStats() {

	$("#canteen-order-stats").html(loading_htm).load("/dashboard/canteen_order_stats",function(d) { initBootstrap(); });
	
}

function loadUserUploads() {

	$("#user-uplaods").html(loading_htm).load("/media_file_uploads/dashboard",function(d) { initBootstrap(); });
	
}

function loadBerricsRecords () {
	
	$("#berrics-records").html(loading_htm).load("/berrics_records/pending_records/limit:10",function(d) { initBootstrap(); });

}



</script>
<style>

 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 1600px) { 

	.left-col .span6 {
	
		width:100%;
		margin-left:0;
	
	}

}
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {  

	.left-col .span6 {
	
		width:100%;
		
	
	}

}
 
/* Landscape phones and down */
@media (max-width: 480px) { 


}
</style>
<div class='page-header'>
	<h2>Dashboard</h2>
</div>
<div class='row-fluid'>
	<div class='span6'>
		<div id='dailyops'>
		
		</div>
	</div>
	<div class='span6 left-col'>
		<div class='row-fluid'>
			<div class='span6'>
				<div id='traffic'></div>
				<div id='top-ten-pages'>
		
				</div>
				<div id='top-ten-videos'>
		
				</div>
			</div>
			<div class='span6'>
				<div id='canteen-order-stats'></div>
				<div id="rg-votes"></div>
				<div id='user-uplaods'></div>
				<div id="berrics-records"></div>
			</div>
			
		</div>
		
	</div>
	
</div>