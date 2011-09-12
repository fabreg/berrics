<?php

$data = $pics->data;

$total_pics = count($data) - 1;

//get a random array

$seed = mt_rand(0,$total_pics);


$pic = $data[$seed];

$title_for_layout = "The Berrics - DC Presents Battle At The Berrics 4: U.S. VS THEM";

$this->set(compact("title_for_layout"));

$this->Html->css(array("instagram"),"stylesheet",array("inline"=>false));
//pr($pic);

$startTime = strtotime("2011-07-01 19:00:00");

$diffTime = $startTime - time();

$diffMin = floor($diffTime/60);

if($diffMin > 0) {
	
	$msg = "BATTLES START IN {$diffMin} MINUTES";
	
} else {
	
	$msg = "FINALS IN PROGRESS";
	
}


?>
<div class='container'>

	<div class='top-banner'>
	
		<div class='alert'><?php echo $msg; ?></div>
	</div>
	<div class='instagram'>	
		<div class='title'>
			<span style='padding:10px;'>
			 <a href='<?php echo $this->here; ?>'>
			 <img src='/img/splash/insta-refresh.jpg'  border='0' style='border:none;' />
			 </a> 
			 </span>
			 <br />
			 BERRICS INSTAGRAM LIVE FROM THE FINALS
		</div>
		<img src='<?php echo $pic->images->standard_resolution->url; ?>' border='0' alt='' />
		<div class='caption'>
			<?php if(isset($pic->caption->text)) echo strtoupper($pic->caption->text); ?>
		</div>
	</div>
	<div class='comments' style='width:600px; margin:auto; padding:1px;margin-top:40px;'>
		<div class='facebook'>
			<div >
				<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
					<fb:comments css="http://theberrics.com/css/fbc.css" href='theberrics.com'></fb:comments>
				<script type="text/javascript">
					FB.init("4bf16033df99101e2722c24a2d165e82", "http://theberrics.com/xd-receiver.html");
				</script>
			</div>		
		</div>
		<div style='clear:both;'></div>
	</div>
</div>




