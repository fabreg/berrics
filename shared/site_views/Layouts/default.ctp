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
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name='keywords' content="<?php echo $meta_k; ?>" >
	<meta name='decsription' content="<?php echo $meta_d; ?>" >
	<meta property="fb:app_id" content="128870297181216">
	<meta property="og:url" content="http://theberrics.com<?php echo $_SERVER['REQUEST_URI']; ?>">
	<meta property="og:type" content="website">
	<?php 
		echo $fb_meta_img;
		echo $this->element("layout/v3/html-head-scripts"); 
		echo $scripts_for_layout;
	?>
	<body>
		<?php if (!isset($_GET['t'])): ?>
		<header>
			<div class="container">
				<div class="row-fluid top-row">
					<div class="logo-div" >
						<a href='/dailyops'><img id='berrics-heading-logo' src="/img/v3/layout/berrics-heading-logo.png" border='0' alt="The Berrics -  Inside Eric Koston's and Steve Berra's Skatepark" /></a>
					</div>
					<div class="social-media">
						<!--
						<div class="cart">
								
								<span class="cart-icon-img">
									<img src="/img/v3/layout/cart-header-icon.png" alt="" />
								</span>
									
							  Cart
							<span class="label">
								<?php echo count($this->Session->read("CanteenOrder.CanteenOrderItem")); ?>
							</span>
						</div>
						-->
						<div class="user-info">
							<img src="/img/v3/layout/top-user-icon.png" alt="" />
						</div>
						
						<div class="fb-icon">
							<a href="http://www.facebook.com/pages/The-Berrics/123390707714463" target='_blank'>
								<img src="/img/v3/layout/fb-header-icon.jpg" alt="" border='0' />
							</a>
						</div>
						<!--
						<div class="tumblr visible-desktop">
							<a href="http://twitter.com/berrics" target='_blank'>
								<img src="/img/v3/layout/px.png" height='25' width='33' alt="" />
							</a>
						</div>
						-->
						<div class="twitter">
							<a href="http://twitter.com/berrics" target='_blank'>
								<img src="/img/v3/layout/px.png" height='25' width='33' alt="" />
							</a>
						</div>
						<div class="facebook visible-desktop">
							<div class="fb-like" data-href="http://www.facebook.com/pages/The-Berrics/123390707714463" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
						</div>
						
					</div>
				</div>
				<?php echo $this->element("layout/v3/top-nav-list"); ?>	
			</div>
		</header>
		<?php endif ?>
		
		<div class="container" id='main-container'>
			<div class="row-fluid" id='body-row'>
				<div class="span12" id='body-div'>
					<?php echo $this->element($top_element); ?>
					<?php 
						if(!isset($body_element) || empty($body_element)) $body_element = "layout/v3/two-column";
						echo $this->element($body_element); 

					?>
				</div>
			</div>
		</div>
		<footer>
			<div class="container">
				<div class="inner">
					The Berrics - &copy; 2007-2013 | 
					<a href="/dailyops">The Daily Ops</a> |
					<a href="http://berricsunified.com" target='_blank'>The Berrics Unified</a> | 
					<a href="/features.html">Features</a> | 
				</div>
			</div>
		</footer>
		<div style='text-align:right; font-size:10px; clear:both;'><?php echo php_uname('n'); ?></div>
		<?php echo $this->element('sql_dump'); ?>
		<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
	</body>
</html>