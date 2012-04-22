<?php 

$header_img = '/img/layout/newsv2/header.jpg';
$bottom_img = '/img/layout/newsv2/header-bottom.png';

if($this->params['date_in'] == "2011-12-25") {

	
	$header_img = '/img/layout/newsv2/xmas-header.jpg';
	//$bottom_img = '/img/layout/newsv2/tg-bottom.png';
	//echo "<style>#top-banner-container {background-image:url(/img/layout/newsv2/xmas-header.jpg);} </style>";
	
} else if($this->params['date_in'] == "2012-01-08") {
	
	$header_img = '/img/layout/newsv2/best-of-header.jpg';
	
}

$at_link = "/news";

if(isset($this->params['date_in'])) {
	
	//$at_link = "/news/".$this->params['date_in'];
	
}

if(isset($post['Dailyop']['id'])) {
	
	$at_link = "/news/".date("Y",strtotime($post['Dailyop']['publish_date']))."/".date("m",strtotime($post['Dailyop']['publish_date']))."/".date("d",strtotime($post['Dailyop']['publish_date']));
	
}

$issue_date = strtoupper(date("l F jS, Y",strtotime($this->params['date_in'])));

if($this->params['action'] == "archive") {
	
	$issue_date = "THE ARCHIVE";
	
}

?>
<div id='top-banner-container'>
	<div style='text-align:center; height:131px;'>
		<a href='<?php echo $at_link; ?>'>
			<img alt='Aberrican Times' border='0' src='<?php echo $header_img; ?>' />
		</a>
	</div>
	<div class='bottom'>
		<div class='inner'>
			<div class='issue-date'><?php echo $issue_date; ?></div>
			<img src='<?php echo $bottom_img; ?>' />
		</div>
	</div>
</div>