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
	
	$pt = "The Berrics";
	
	$pt .=  (preg_match("/(canteen)/",$_SERVER['REQUEST_URI'])) ? " Canteen":"";
	
	$pt .= " - ".$title_for_layout;
	echo $this->element("system/config-currency");
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $pt; ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<META name="description" content="<?php echo $meta_d?>"> 
	<META name="keywords" content="<?php echo $meta_k?>"> 
	<meta property="fb:app_id" content="128870297181216">
	<meta property="og:url" content="http://theberrics.com<?php echo $_SERVER['REQUEST_URI']; ?>">
	<meta property="og:title" content="<?php echo $pt; ?>">
	<meta property="og:type" content="website">
	<?php echo $this->element("layout/html-head-scripts"); ?>
	<?php 
		echo $scripts_for_layout;
	?>
	<?php if(isset($_GET['t']) && $_GET['t'] == 1): ?>
	<style>#top-banner-container { display:none; }</style>
	<?php endif; ?>
</head>
<body>
<!-- We Like Zuckerberg -->
<div id="fb-root"></div>

<!-- Zuckerberg Likes Us -->
	<div id='main-container'>
		<?php echo $this->element("layout/top-banner-container"); ?>
		<div id='page-wrapper-left'>
			<div id='page-wrapper-right'>
				<div id='page-container'>
					<div id='header-container'>
						<?php echo $this->element("layout/header"); ?>
					</div>
					<div id='body-container'>
						<?php echo $this->element("layout/body-content",compact("content_for_layout")); ?>
						<div style='clear:both;'></div>
					</div>
					<div id='footer'>
						<div class='links'>
							Copyright <?php echo date("Y"); ?> THE BERRICS Inc. - 
									<a href="/dailyops" title='The Daily Ops'>Daily Ops</a> | 
									<a href='/tags/a' title='Tag Directory'>Tag Directory</a> | 
									<a href="/unit-directive.html" title='Unit Directory'>Unit Directive</a> | 
									<a href="/headquarters.html" title='Headquarters'>Headquarters</a> | 
									<a href="/features.html" title='The Berrics Features'>Features</a> | 
									<a href="/news" title='Aberrican Times'>News</a> | 
									<a href="http://berricsunified.com/" target="_blank">Unified</a> | 
									<a href="http://theberricscanteen.com/" target="_blank"/>Canteen</a> | 
									<a href="/terms.html" target="_blank"/>Terms of service</a>
						</div>
						<?php 
									if(isset($_SERVER['DEVSERVER'])) {
										if($this->Session->check("Auth.User.id")) {
											
											echo $this->element("login/profile");
											
										} else {
											
											echo $this->element("login/login");
											
										}
									}
							?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script> initTopNav(); </script>
	<!-- Start Quantcast tag -->
	<script type="text/javascript">
	_qoptions={
	qacct:"p-99F0_WrFhGi4w"
	};
	</script>
	<script type="text/javascript" src="https://edge.quantserve.com/quant.js"></script>
	<noscript>
	<a href="https://www.quantcast.com/p-99F0_WrFhGi4w" target="_blank"><img src="https://pixel.quantserve.com/pixel/p-99F0_WrFhGi4w.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/></a>
	</noscript>
	<!-- End Quantcast tag -->
	
	<!-- Start Google Analytics -->
	<script type="text/javascript">
	_uacct = "UA-2788005-1";
	urchinTracker();
	</script>
	<!-- End Google Analytics -->
		
	<div style='font-size:9px; text-align:right;'>
		<?php echo php_uname("n"); ?>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<!-- TheBerrics.com By:John.Hardy@me.com  8=D :-) 2011-06-20 -->
</body>
</html>