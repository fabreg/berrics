<div style='text-align:center; padding:9px;'>
	
	<div style='font-size:20px;'>
		<?php echo $gallery['Dailyop']['sub_title']; ?>
	</div>
<?php 

	echo $this->element("dailyops/post-footer",array("dop"=>$gallery));

?>
</div>