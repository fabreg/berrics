<?php 

$title_for_layout = "The Berrics - STREET LEAGUE SKATEBOARDING: ARIZONA";

$this->set(compact("title_for_layout"));

$today = date("d");

$qual = 27;
$finals = 15;

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
	background-image:url(/img/splash/sls-12-az/bg.jpg);
}
#main-thing {

	width:500px;
	margin:auto;

}

.top-content {

6
	position:relative;
	

}

.days {

	position:absolute;
	z-index:5000;
	top:-10px;
	left:152px;
	color:black;
	font-family:'Arial';
	color:black;
	font-size:95px;
	height:95px;
	font-weight:bold;

}

#counter {

	height:96px;
	background-image:url(/img/splash/sls-12-az/counter.jpg);
	position:relative;
	
}



</style>
<div id='main-thing'>
	<div class='top-content'>
		
		<img border='0' src='/img/splash/sls-12-az/top.jpg' />
	</div>
	<!-- 
	<div id='counter'>
	
		<div class='days'><?php echo $days_to_finals; ?></div>
	</div>
	 -->
	<div>
		<a href='http://streetleague.com' target='_blank'>
			<img border='0' src='/img/splash/sls-12-az/bottom.jpg' />
		</a>
	</div>
		<div>
		<a href='/dailyops' >
			<img border='0' src='/img/splash/sls-12-az/enter.jpg' />
		</a>
	</div>
</div>
