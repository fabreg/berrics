<?php 

$header_img = '/img/layout/newsv2/header.jpg';
$bottom_img = '/img/layout/newsv2/header-bottom.png';

if($this->params['date_in'] == "2011-11-27") {

	
	$header_img = '/img/layout/newsv2/tg-header.png';
	$bottom_img = '/img/layout/newsv2/tg-bottom.png';
	echo "<style>#top-banner-container {background-image:url(/img/layout/newsv2/tg-bg.png);} #top-banner-container .bottom {background-image:url(/img/layout/newsv2/tg-bottom-bg.png); background-repeat:repeat-x;}</style>";
	
}
?>
<div id='top-banner-container'>
	<div style='text-align:center; height:131px;'>
		<a href='/news/<?php echo str_replace("-","/",$this->params['date_in']); ?>'>
			<img alt='Aberrican Times' border='0' src='<?php echo $header_img; ?>' />
		</a>
	</div>
	<div class='bottom'>
		<div class='inner'>
			<div class='issue-date'><?php echo strtoupper(date("l F jS, Y",strtotime($this->params['date_in']))); ?></div>
			<img src='<?php echo $bottom_img; ?>' />
		</div>
	</div>
</div>