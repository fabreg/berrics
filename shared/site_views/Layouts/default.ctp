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
		//echo $scripts_for_layout;
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<body>
		<?php if (!isset($_GET['t'])): ?>
		<header>
			<div class="container">
				<div class="row-fluid top-row">
					<div class="logo-div" >
						<a href='/dailyops'>
							<?php echo $this->Html->image('v3/layout/berrics-header-logo-blk.png',array("border"=>0,"alt"=>"The Berrics - Inside Eric Koston's and Steve Berra's Skatepark","id"=>"berrics-heading-logo")); ?>
						</a>
					</div>
					<div class="social-media">
						<div class="top">
							<div class="cart-widget">
								&nbsp;<i class="icon icon-white icon-shopping-cart"></i> <a href='/canteen/cart' > Cart</a> <span class="badge"><?php echo count(CakeSession::read('CanteenOrder.CanteenOrderItem')) ?></span>
							</div>
							
							<?php if (CakeSession::check("Auth.User.id")): ?>
								<div class="dropdown account-top">
									<a href='#' data-toggle='dropdown' class='dropdown-toggle'><i class="icon icon-caret-down icon-white"></i> <?php //echo CakeSession::read("Auth.User.first_name"); ?> <?php //echo CakeSession::read("Auth.User.last_name"); ?>Logged In</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="/identity/login/logout/<?php echo base64_encode($this->request->here); ?>"><i class="icon icon-off"></i> Logout</a> 
										</li>
									</ul>
								</div>
							<?php else: ?>
								<div class="login-top">
									<a class='login-link' href='/identity/login/form/<?php echo base64_encode($this->here); ?>'>
										<i class="icon icon-caret-down icon-white"></i>&nbsp;Account Login
									</a>
								</div>
							<?php endif ?>
							

						</div>
						<div class="bottom clearfix">
							<div class="instagram">
								<a href="http://instagram.com/berrics" target='_blank'>
									<img src="/img/v3/layout/instagram-top-icon.png" alt="" border='0' />
								</a>
							</div>
							
							<div class="twitter">
								<a href="http://twitter.com/berrics" target='_blank'>
									<img src="/img/v3/layout/twitter-top-icon.png"  alt="The Berrics Twitter" />
								</a>
							</div>
							<div class="fb-icon">
								<a href="http://www.facebook.com/pages/The-Berrics/123390707714463" target='_blank'>
									<img src="/img/v3/layout/fb-header-icon.jpg" alt="" border='0' />
								</a>
							</div>
							<div class="facebook hidden-phone">
								<div class="fb-like" data-href="http://www.facebook.com/pages/The-Berrics/123390707714463" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>
							</div>

						</div>
					</div>
				</div>
				<?php echo $this->element("layout/v3/top-nav-list"); ?>	
			</div>
		</header>
		<?php endif ?>
		<div id="main-wrapper">
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
		</div>
		<footer>
			<div class="container">
				<div class="inner">
					The Berrics - &copy; 2007-2013 | 
					<a href="/dailyops">The Daily Ops</a> |
					<a href="http://berricsunified.com" target='_blank'>The Berrics Unified</a> | 
					<a href="/features.html">Features</a> | 
					<a href="/headquarters">Headquarters</a> | 
					<a href="/battle-at-the-berrics-6">Battle At The Berrics 6</a>
				</div>
			</div>
		</footer>
		<div style='text-align:right; font-size:10px; clear:both;'><?php echo php_uname('n'); ?></div>
		<?php echo $this->element('sql_dump'); ?>
		<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
		<!-- The Berrics - June 16 2011 - NOW() - John.hardy@me.com -->
	</body>
</html>