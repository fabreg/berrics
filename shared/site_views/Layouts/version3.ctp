<html>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<?php echo $this->element("layout/v3/html-head-scripts"); ?>
	<body>
		<div class='container' id='nav-nested-container'>

		</div>
		<div class="container" id='main-container'>
			<header id='top-header'>
				<div class="row-fluid">
					<div class="span8">
						<div class="hidden-phone">
							<a href='/dailyops'><img src='/img/v3/layout/berrics-header-logo.png' alt='THE BERRICS' border='0' /></a>
						</div>
					</div>
				</div>
				<div class='row-fluid' id='top-nav-container'>
					<div class="span12">
						<ul id='top-nav-list' class='nav-collapse'>
							
							<li class='nav-btn' id='top-dropdown'>
								<a href="#">FEATURES</a>
								
							</li>
							<li class="spacer"></li>
							<li class='nav-btn'>
								<a href="">NEWS</a>
							</li>
							<li class="spacer"></li>
							<li class='nav-btn'>
								<a href="">UNIFIED</a>	
							</li>
							<li class="spacer"></li>
							<li class='nav-btn'>CANTEEN</li>
							<li class="spacer"></li>
							<li class='hidden-phone nav-btn'>HEADQUARTERS</li>
							<li class="spacer"></li>
							<li class='nav-btn'>MORE</li>
							<li class="spacer"></li>
							<li class='nav-btn search'>SEARCH <input type='text' /></li>
						</ul>
					</div>
				</div>
			</header>
			<div class="row-fluid" id='body-row'>
				<div class="span12" id='body-div'>
					<?php echo $this->element($top_element); ?>
					<?php echo $this->element($body_element); ?>
				</div>
			</div>
		</div>
		<div style='text-align:right; font-size:10px;'><?php echo php_uname('n'); ?></div>
		<?php echo $this->element('sql_dump'); ?>
		<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
	</body>
</html>