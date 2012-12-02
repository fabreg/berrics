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
<html>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name='keywords' content='<?php echo $meta_k; ?>' >
	<meta name='decsription' content='<?php echo $meta_d; ?>' >
	<meta property="fb:app_id" content="128870297181216">
	<meta property="og:url" content="http://theberrics.com<?php echo $_SERVER['REQUEST_URI']; ?>">
	<meta property="og:type" content="website">
	<?php 
		echo $fb_meta_img;
		echo $this->element("layout/v3/html-head-scripts"); 
		echo $scripts_for_layout;
	?>
	<body>
		<header>
			<div class="container">
				<div class="row-fluid top-row">
					<div class="span8" >
						<a href='/dailyops'><img id='berrics-heading-logo' src="/img/v3/layout/berrics-heading-logo.png" border='0' alt="The Berrics -  Inside Eric Koston's and Steve Berra's Skatepark" /></a>
					</div>
					<div class="span3 social-media visible-desktop">
						
					</div>
					<div class="span1 cart  visible-desktop">
						
					</div>
				</div>
				<?php echo $this->element("layout/v3/top-nav-list"); ?>	
			</div>
					</header>
		<div class="container" id='main-container'>
			
			<div class="row-fluid" id='body-row'>
				<div class="span12" id='body-div'>
					<?php echo $this->element($top_element); ?>
					<?php echo $this->element($body_element); ?>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
						<div style='text-align:right; font-size:10px;'><?php echo php_uname('n'); ?></div>
				</div>
			</div>
		</div>
		<?php echo $this->element('sql_dump'); ?>
		<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
	</body>
</html>