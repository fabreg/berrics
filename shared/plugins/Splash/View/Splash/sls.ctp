<style>
@font-face {
    font-family: 'constructa';
    src: url('/fonts/constructa/constructa.eot?') format('eot'),
         url('/fonts/constructa/constructa.woff') format('woff'),
         url('/fonts/constructa/constructa.ttf') format('truetype'),
         url('/fonts/constructa/constructa.svg') format('svg');
    font-weight: normal;
    font-style: normal;
}
body {

	font-family: 'constructa';
	background-color: #000;
	background-image:none;

}

#sls {

	width:1000px;
	margin:auto;

}
.bottom {

	position: relative;


}

.bottom .days-left {

	color:#fff;
	font-size:72px;
	position: absolute;
	top:58px;
	right:146px;
	
	width:205px;
	text-align: center;
}

#enter {

	font-size:48px;
	padding:25px;
	text-align: center;


}

#enter a {

	color:#fff;

}


</style>
<?php 

$day = date("d");

$day_of = 9;

$days_left = $day_of - $day;

$this->set("title_for_layout","THE BERRICS - STREET LEAGUE KANSAS SUNDAY JUNE 9th");

?>
<div id='sls'>
	<div class="top">
		<a href="http://streetleague.com" target="_blank">
			<img src="/img/v3/splash/sls-kansas/top.jpg" alt="" border='0'>
		</a>
	</div>
	<div class="bottom">
		<a href="http://streetleague.com" target="_blank">
			<img src="/img/v3/splash/sls-kansas/bottom.jpg" border='0' alt="">
		</a>
		<div class="days-left">
			<?php if ($days_left<=1): ?>
				0
			<?php else: ?>
				<?php echo $days_left ?>
			<?php endif ?>
		</div>
	</div>
	<div id="enter">
		<a href="/dailyops">ENTER THE BERRICS</a>
	</div>
</div>