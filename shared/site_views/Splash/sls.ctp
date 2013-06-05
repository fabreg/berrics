<?php 

$title_for_layout = "STREET LEAGUE CHAMPIONSHIP: NEW JERSEY AUGUST 28TH ON ESPN2";

$this->set(compact("title_for_layout"));

$today = date("d");

$qual = 27;
$finals = 28;

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
body {
	background-color:#000;
	text-align: center;
}


#main-thing {

	width:850px;
	margin:auto;

}
#sls-banner {
	position:relative;

	
}

#sls-banner .left { 
	
	position:absolute;
	height:65px;
	width:340px;
	left:0px;
	top:165px;
	background-repeat:no-repeat;
	<?php echo $qual_bg; ?>

}
#sls-banner .right { 

	
	position:absolute;
	height:65px;
	width:340px;
	right:0px;
	top:165px;
	background-repeat:no-repeat;
	background-position:-30px top;
	<?php echo $finals_bg; ?>
}

.enter {
	
	font-size:36px;
	padding:10px;
	text-align:center;
	
}


.enter a {

	color:white;

}

.enter a:hover {

	color:#860000;

}

.fb {
	
	width:308px;
	height:207px;
	position:absolute;
	top:228px;
	left:36px;
	
}

.espn {
	
	width:308px;
	height:207px;
	position:absolute;
	top:228px;
	right:36px;
	
}

#countdown-div {

	height:404px;
	position:relative;
	background-image:url(/img/splash/sls/ch-2.jpg);
}

.fb-link {

	position:absolute;
	width:120px;
	height:30px;
	right:238px;
	bottom:240px;

}

.sls-link {


	position:absolute;
	width:120px;
	height:30px;
	right:115px;
	bottom:240px;
}

.ticket-link {

	
	position:absolute;
	width:100%;
	height:70px;
	
	bottom:160px;


}

.berrics-link {

	
	position:absolute;
	width:100%;
	height:70px;
	color:red;
	bottom:65px;
	font-size:26px;
	text-align:center;
}

.berrics-link a {

	color:inherit;

}

.countdown {

	position:absolute;
	left:115px;
	width:307px;
	height:117px;
	top:12px;
	<?php echo $finals_bg; ?>
	background-repeat:no-repeat;
	background-position:right center;
}




</style>
<div id="wrapper">
	
<div id='main-thing'>
	<div id='sls-banner'>
		<img src='/img/splash/sls/ch-1.jpg' alt='' title='Street League Finals : New Jersey' />
	</div>
	<div id='countdown-div'>
		<div class='countdown'>
			
		</div>
		<div class='fb-link'>
			<a href='http://www.facebook.com/streetleague'>
				<img src='/img/layout/clear.png' border='0' alt='' height='100%' width='100%'/>
			</a>
		</div>
		<div class='sls-link'>
			<a href='http://www.streetleague.com'>
				<img src='/img/layout/clear.png' border='0' alt='' height='100%' width='100%'/>
			</a>
		</div>
		<div class='ticket-link'>
			<a href='http://www.streetleague.com'>
				<img src='/img/layout/clear.png' border='0' alt='' height='100%' width='100%'/>
			</a>
		</div>
		<div class='berrics-link'>
			<a href='/dailyops'>ENTER THE BERRICS</a>
		</div>
	</div>
</div>
</div>
