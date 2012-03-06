<style>
body {

	background-image:url(/img/splash/yn3splash/bg.jpg);
	background-position:top center;
	
}

#yn3 {

	width:368px;
	height:772px;
	margin:auto;
	position:relative;
	background-image:url(/img/splash/yn3splash/images/yn3-logo.jpg);
	background-repeat:no-repeat;
	cursor:pointer;
}

.date {

	position:absolute;
	top:676px;
	width:100%;
	text-align:center;
	font-weight:bold;
	font-size:20px;
	color:#59291d;
}

.date .day {
	
	color:black;

}

#enter-link {

	text-align:center;
	font-size:24px;
	padding-bottom:40px;
	
}
#enter-link a {
	
	color:inherit;

}

</style>
<script type='text/javascript'>
$(document).ready(function() { 

	$("#yn3").click(function() { 

		document.location.href = "/younited-nations-3";

	});

	
});
</script>
<div id='yn3'>
	<div class='date'>
		<?php 
		
			$today = date("d");
			
			$days_left = 15-$today;
			
			if($days_left > 1) {
				
				$blurb = "DAYS REMAINING TO ENTER";
				
			} else {
				
				$blurb = "DAY REMAINING TO ENTER";
				
			}
		
		?>
		<span class='day'><?php echo $days_left?></span> <?php echo $blurb; ?>
	</div>
</div>
<div id='enter-link'>
<a href='/dailyops'>- ENTER THE BERRICS -</a>
</div>