<?php 

//if we are on "/" let's add in a special css '=)

if($_SERVER['REQUEST_URI'] == "/") $this->Html->css("splash_override","stylesheet",array("inline"=>false));

//split the posts up into 3 arrays

$rows = array();

$counter = 1;

$row_key = 0;

$top_post = array_shift($posts); 

$divisor = ceil(count($posts)/3);

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

//$rows[2] .= $this->element("news/news-bit",array("post"=>$last_post));

//page title
$this->set("title_for_layout","Aberrican Times | ".strtoupper(date("F jS, Y",strtotime($this->params['date_in'])))." ".date());

?>
<div id='news-section'>
	<div class='wrapper'>
		<div class='featured'>
			<div style='float:left;'>
				<?php echo $this->element("news/news-bit",array("post"=>$top_post)); ?>
			</div>
			<div style='float:right; margin-top:29px; border-left:1px solid #000; padding-left:20px; '>
				<div style='height:250px; overflow:hidden; border:5px solid #000;'>
								<!-- News -->
				<script type="text/javascript">
				  var ord = window.ord || Math.floor(Math.random() * 1e16);
				  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/News;sz=300x250;ord=' + ord + '?"><\/script>');
				</script>
				</div>
				<div>
					<?php echo $this->element("layout/right-col-social-buttons"); ?>
				</div>
			</div>
			
			<div style='clear:both;'></div>
		</div>	
		<div class='cols-wrapper'>
		<div class='news-col col1'>
			<?php echo $rows[0]; ?>
		</div>
		<div class='news-col col2'>
			<?php echo $rows[1]; ?>
		</div>
		<div class='news-col col3'>
			<?php echo $rows[2]; ?>
		</div>	
		<div style='clear:both;'></div>
		</div>
		<div style='border-bottom:1px solid #000; margin-top:4px; margin-bottom:4px;'></div>
		<div class='featured-news'>
			<div class='unified'>
				<div style='text-align:center; background-color:#000;'><img src='/img/layout/news/unified-header.jpg' /></div>
				<div class='inner'>
					<?php foreach($unified as $p): ?>
						<?php echo $this->element("newsv2/unified-bit-home",array("p"=>$p)); ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class='events'>
				<div style='text-align:center; background-color:#000;'><img src='/img/layout/news/upcoming-header.jpg' /></div>
				<div class='inner'>
					<?php foreach($event_news as $p): ?>
						<?php echo $this->element("newsv2/event-bit-home",array("p"=>$p)); ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
		<?php if($_SERVER['SCRIPT_URL'] == "/"): ?>
			<div class='enter-the-berrics'>
				<a href='/dailyops'>
				<img style='padding-top:8px;' border='0' alt='' src='/img/layout/newsv2/enter-button-bottom.jpg' />
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>