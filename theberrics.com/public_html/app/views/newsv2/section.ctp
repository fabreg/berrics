<?php 

//if we are on "/" let's add in a special css '=)

if($_SERVER['REQUEST_URI'] == "/") $this->Html->css("splash_override","stylesheet",array("inline"=>false));


//split the posts up into 3 arrays

$rows = array();

$counter = 1;
$row_key = 0;
$top_post = array_shift($posts); 
$last_post = array_pop($posts);

$divisor = floor(count($posts)/3);
//die($divisor);


foreach($posts as $k=>$p) {

	$rows[$row_key] .= $this->element("news/news-bit",array("post"=>$p));		
	
	if($counter >= $divisor) {
		
		$row_key++;
		$counter = 1;
	} else {
		
		$counter++;
		
	}
	
}

//glue in last post to fix offestting

$rows[2] .= $this->element("news/news-bit",array("post"=>$last_post));

//page title
$this->set("title_for_layout","Aberrican Times | ".strtoupper(date("F jS, Y",strtotime($this->params['date_in'])))." ".date());


?>
<div id='news-section'>
	<div class='wrapper'>
		<div class='left-columns'>
			<div class='featured'>
				<?php echo $this->element("news/news-bit",array("post"=>$top_post)); ?>
			</div>	
			<div class='news-col col1'>
				<?php echo $rows[0]; ?>
			</div>
			<div class='news-col col2'>
				<?php echo $rows[1]; ?>
			</div>
			<div style='clear:both;'></div>
		</div>
		<div class='right-columns'>
			<div class='news-col col3'>
				<?php echo $rows[2]; ?>
			</div>
		</div>
		<div style='clear:both;'></div>
		<?php if($_SERVER['SCRIPT_URL'] == "/"): ?>
		<div class='enter-the-berrics'>
			<a href='/dailyops'>- ENTER THE BERRICS -</a>
		</div>
		<?php endif; ?>
		<div class='featured-news'>
			<div class='unified'>
				<?php print_r($unified); ?>
			</div>
			<div class='events'>
				<?php echo print_r($events); ?>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
</div>