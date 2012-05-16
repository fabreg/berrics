<?php 

$title_for_layout = "The Berrics - STREET LEAGUE SKATEBOARDING: KANSAS CITY";

$this->set(compact("title_for_layout"));

$today = date("d");

$qual = 27;
$finals = 19;

$days_to_qual = $qual - $today;
$days_to_finals = $finals - $today;

if($days_to_qual >= 1) {
	
	$qual_bg = "background-image:url(/img/splash/sls/{$days_to_qual}-days.jpg);";
	
}

if($days_to_finals >=1) {

	$finals_bg ="background-image:url(/img/splash/sls/days/{$days_to_finals}-days.jpg);";
	
}


?>
<style>
* {

	padding:0px;
	margin:0px;

}

body {
	background-color:#000;
	background-image:url(/img/splash/sls-kc/bg.jpg);
}
#main-thing {

	width:500px;
	margin:auto;

}


.top-content {


	position:relative;
	

}

.days {

	position:absolute;
	z-index:5000;
	top:205px;
	left:152px;
	color:black;
	font-family:'Arial';
	color:black;
	font-size:95px;
	font-weight:bold;

}



</style>
<div id='main-thing'>
	<div class='top-content'>
		<div class='days'><?php echo $days_to_finals; ?></div>
		<img border='0' src='/img/splash/sls-kc/top.jpg' />
	</div>
	<div>
		<a href='http://streetleague.com' target='_blank'>
			<img border='0' src='/img/splash/sls-kc/sls-link.jpg' />
		</a>
	</div>
		<div>
		<a href='/dailyops' >
			<img border='0' src='/img/splash/sls-kc/enter-link.jpg' />
		</a>
	</div>
</div>