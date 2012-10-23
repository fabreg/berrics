<style>

#archive {

	width:965px;
	margin:auto;

}

.at-thumb {

	float:left;
	width:270px;
	background-image:url(/img/layout/newsv2/at-archive-bg.png);
	background-repeat:no-repeat;
	margin-left:30px;
	min-height:260px;
}

.at-thumb:nth-child(even) {

	float:right;
	clear:right;
	margin-left:0px;
	margin-right:30px;
	
}

.at-thumb .thumb {

	text-align:center;
	min-height:137px;
}

.at-thumb .issue {

	text-align:right;
	color:#333;
	font-size:18px;
	font-weight:bold;
	margin-top:23px;
}

.at-thumb .issue a {

	color:inherit;

}

.at-thumb .top-spacer {

	height:55px;

}

.right-banners {

	float:right;

}

.large-tile {

	margin-bottom:10px;

}

.large-tile .issue {

	font-size:26px;
	font-weight:bold;
	color:#333;
	padding-bottom:4px;
}

.large-tile .click-thru {

	color:#333;
	font-size:20px;
	font-weight:bold;
	text-align:right;
	padding-top:5px;

}
.large-tile .click-thru a {

	color:inherit;

}
</style>
<div id='archive'>
	<div style='width:640px; float:left;'>
		<?php 
		
			$i = 1;
				
			foreach($posts as $k=>$p):
		?>
			<?php if($i == 1): ?>
				<div class='large-tile'>
					<div class='issue'>Issue <?php echo (count($posts)-$k); ?></div>
					<a href='/news/<?php echo date("Y",strtotime($p['Dailyop']['publish_date']))."/".date("m",strtotime($p['Dailyop']['publish_date']))."/".date("d",strtotime($p['Dailyop']['publish_date'])); ?>'>
					<?php echo $this->Media->mediaThumb(
						array(
							"MediaFile"=>$p['DailyopTextItem'][0]['MediaFile'],
							"w"=>640
						)
					)?></a>
					<div class='click-thru'><a href='/news/<?php echo date("Y",strtotime($p['Dailyop']['publish_date']))."/".date("m",strtotime($p['Dailyop']['publish_date']))."/".date("d",strtotime($p['Dailyop']['publish_date'])); ?>'>Click Here To View The Latest Issue</a></div>
				</div>
				<div style='clear:both;'></div>
			<?php else: ?>
				<div class='at-thumb'>
					<div class='inner'>
						<div class='top-spacer'></div>
						<div class='thumb'>
							<a href='/news/<?php echo date("Y",strtotime($p['Dailyop']['publish_date']))."/".date("m",strtotime($p['Dailyop']['publish_date']))."/".date("d",strtotime($p['Dailyop']['publish_date'])); ?>'>
							<?php echo $this->Media->mediaThumb(
											array(
												"MediaFile"=>$p['DailyopTextItem'][0]['MediaFile'],
												"w"=>250,
												"h"=>129
											)
										)?>
							</a>
						</div>
						<div class='issue'>Issue <?php echo (count($ps)-$k); ?></div>
					</div>
					
				</div>
			<?php endif; ?>
		<?php 
			$i++;
			endforeach;
		
		?>
		<div style='clear:both;'></div>
	</div>
	<div class='right-banners'>
		<?php echo $this->element("layout/right-banners"); ?>
	</div>
	<div style='clear:both;'></div>
</div>