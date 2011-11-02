<?php 

	if(!isset($meta_d)) {
		
		$meta_d = "";
		
	}

	if(!isset($meta_k)) {
		
		$meta_k = "";
		
	}
	
	if(!isset($fb_meta_img)) {
		
		$fb_meta_img = '';
		
	}
	
	if(!isset($rss_feed)) {
		
		$rss_feed = '';
		
	}
	

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<META name="description" content="<?php echo $meta_d; ?>"> 
	<META name="keywords" content="<?php echo $meta_k; ?>"> 
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
	<?php 

		echo $scripts_for_layout;
	?>
</head>
<body>
	<?php echo $content_for_layout; ?>
	
	<!-- Start Quantcast tag -->
	<script type="text/javascript">
	_qoptions={
	qacct:"p-99F0_WrFhGi4w"
	};
	</script>
	<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>
	<noscript>
	<a href="https://www.quantcast.com/p-99F0_WrFhGi4w" target="_blank"><img src="http://pixel.quantserve.com/pixel/p-99F0_WrFhGi4w.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/></a>
	</noscript>
	<!-- End Quantcast tag -->
	
	<!-- Start Google Analytics -->
	<script type="text/javascript">
	_uacct = "UA-2788005-1";
	urchinTracker();
	</script>
	<!-- End Google Analytics -->
		

	<?php echo $this->element('sql_dump'); ?>
	<!-- 8=D JH :-) 2011-06-20 -->
</body>
</html>