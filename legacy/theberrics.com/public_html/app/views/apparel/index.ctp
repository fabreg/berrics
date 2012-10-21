<style>
	
body {

	background-image:url(/img/layout/apparel/main-bg.jpg);
	background-repeat:repeat-y;
	background-position:top center;
	background-color:black;

}

#index {

	width:750px;
	margin:auto;

}

#shirt {

	text-align:center;

}

#shops {

}

.shop {

	width:33%;
	float:left;
	text-align:center;
	color:#959487;
	padding-bottom:20px;
	font-size:14px;
	min-height:105px;
}

</style>
<?php 

$shirt = mt_rand(1,33);
$this->set("title_for_layout","The Berrics - T-Shirts");
?>
<div id='index' >
	<div id='shirt'>
		<img src='/img/layout/apparel/shirts/<?php echo $shirt; ?>.png' />
	</div>
	<div id='shops'>
	<?php 
		foreach($shops as $s):
	?>
		<div class='shop'>
			<strong><?php echo $s['UnifiedShop']['name']; ?></strong> <br />
			<?php echo $s['UnifiedShop']['street_address']; ?><br />
			<?php echo $s['UnifiedShop']['state']; ?>, <?php echo $s['UnifiedShop']['postal_code']; ?> <?php echo $s['UnifiedShop']['country']; ?><br />
			<?php echo $s['UnifiedShop']['phone_number']; ?>
		</div>
	<?php 
		endforeach;
	?>
	</div>
	<div style='clear:both;'></div>
	<?php if($splash): ?>
	<div style='text-align:center; padding:5px;'>
		<a href='/dailyops'>
		<img src='/img/layout/apparel/enter-berrics.png' border='0' />
		</a>
	</div>
	<?php endif;?>
</div>	