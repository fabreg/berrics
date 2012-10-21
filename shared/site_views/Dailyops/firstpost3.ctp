<div id='section-view-header'>
	<?php 
	
		echo $this->element("dailyops/section-header");
	
	?>
</div>
<div>
<?php 

	echo $this->element('dailyops/post-bit',array("dop"=>$first_post));

?>
</div>
<div id='stacked3-view'>
<?php 

echo $this->element("dailyops/section-year-menu");


	foreach($posts as $val) {
		
		foreach($val as $v) {
			
			echo $this->element("dailyops/post-thumb-med",array("dop"=>$v,"showBubble"=>false));
			
		}
		
	}
	
?>

<div style='clear:both;'></div>

<?php
echo $this->element("dailyops/section-year-menu");


?>
</div>