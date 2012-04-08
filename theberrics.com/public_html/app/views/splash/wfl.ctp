<style>
* {

	margin:0px;
	padding:0px;

}
body {

	background-color:#000;

}

.dway {

	text-align:center;

}

.connect {

	font-size:24px;
	font-weight:bold;
	font-family:'Arial';
	
}

.connect a {

	color:white;

}
.enter {

	padding-top:25px;

}
</style>
<!-- 
 && $_SERVER['GEOIP_REGION_NAME']=='california'
 -->
<div class='dway'>
	<div>
		<img border='0' src='/img/splash/wfl/dway.jpg'/>
	</div>
	<?php if(
		$_SERVER['GEOIP_COUNTRY_CODE']=="US" && strtolower($_SERVER['GEOIP_REGION_NAME'])=='california'
	): ?>
	<div class='connect'>
		<a href='/identity/login/send_to_facebook/<?php echo base64_encode("/wfl"); ?>'>Click Here To Connect With Facebook To Win Tickets!</a>
	</div>
	<?php endif; ?>
	<div class='enter'>
		<a href='/dailyops'>
			<img src='/img/splash/wfl/enter.jpg' border='0'/>
		</a>
	</div>
</div>