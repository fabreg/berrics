<?php 

//if we are on "/" let's add in a special css '=)

if($_SERVER['REQUEST_URI'] == "/") $this->Html->css("splash_override","stylesheet",array("inline"=>false));


//split the posts up into 3 arrays

$rows = array();

$counter = 1;
$row_key = 0;
$divisor = ceil(count($posts)/3);

foreach($posts as $k=>$p) {

	$rows[$row_key][] = $p;		
	
	if($counter >= $divisor) {
		
		$row_key++;
		$counter = 1;
	} else {
		
		$counter++;
		
	}
	
}

?>
<div id='news-section'>
	<div class='wrapper'>
		<div class='news-columns'>
			<div class='news-col'>
				<?php print_r($rows[0]); ?>
			</div>
			<div class='news-col'>
				<?php print_r($rows[1]); ?>
			</div>
			<div class='news-col'>
				<?php print_r($rows[2]); ?>
			</div>
			<div style='clear:both;'></div>
		</div>
		<div class='featured-news'>
		
		</div>
	</div>
</div>