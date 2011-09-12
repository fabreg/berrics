<div style='text-align:center; padding:9px;'>
	<img src='/theme/yoonivision/img/yoonivision-header.png' />
	<div>
		<?php echo $gallery['Dailyop']['sub_title']; ?>
	</div>
<?php 

	echo $this->element("dailyops/post-footer",array("dop"=>$gallery));

?>
</div>