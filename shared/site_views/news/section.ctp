<style>
#news-home #super-top-stuff .news-bit .title h3  {
	
	font-size:120%;

}
</style>
<?php 
$row1 = '';
$row2 = '';

$top_post = array_shift($general); 

foreach($general as $key=>$p) {
	$ele =  $this->element("news/news-bit",array("post"=>$p));
	if(($key+1) > ceil((count($general)/2))) {
		
		$row2.= $ele;
		
	} else {
		
		$row1.= $ele;
		
	}
}
?>
<div id='news-home'>
	<div style='padding:8px;' id='super-top-stuff'>
	<?php echo $this->element("news/news-bit",array("post"=>$top_post)); ?>
	</div>
	<div class='left-col'  >
		<div class='inner'><?php echo $row1; ?></div>
	</div>
	<div class='right-col' >
		<div class='inner'><?php echo $row2; ?></div>
	</div>
	<div style='clear:both;'></div>
</div>
<div id='paging-menu'>
		<div class='left'>
		<?php 
		
			if($newer_date && !preg_match('/^(\/dailyops)/',$_SERVER['REQUEST_URI'])) {
				$newer_date = strtotime($newer_date);
				//echo $this->Html->link("<span> ".date("F jS, Y",$newer_date)."</span>",date("/Y/m/d/",$newer_date),array("escape"=>false,"title"=>date("F jS, Y",$newer_date)));
				
			}
			
		?>
		</div>
		<div class='right'>
		<?php 
			
			if($older_date) {
				
				$older_date = strtotime($older_date);
				echo $this->Html->link("<span>".date("F jS, Y",$older_date)."</span>",date("/Y/m/d/",$older_date),array("escape"=>false,"title"=>date("F jS, Y",$older_date)));
				
			}
			
		?>
		</div>
		<div style='clear:both'></div>
	</div>