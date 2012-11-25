<html>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php 

		echo $this->Html->css(array(
			"v3/bootstrap",
			"v3/layout",
			"v3/bootstrap-responsive"
		),"stylesheet");

		echo $this->Html->script(array(
			"https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js",
			"https://www.google.com/uds?file=ima&v=1&nodependencyload=true",
			"v3/bootstrap",
			"v3/modernizr",
			"v3/jquery.fullscreen-min",
			"v3/video.div",
			"v3/respond.min.js",
			"v3/html5shiv",
			"v3/main"
		));
	?>
	<body>
		<div class='container' id='nav-nested-container'>

		</div>
		<div class="container" id='main-container'>
			<header id='top-header'>
				<div class="row-fluid">
					<div class="span8">
						<div class="hidden-phone">
							<img src='/img/v3/layout/berrics-header-logo.png' alt='THE BERRICS' border='0' />
						</div>
					</div>
				</div>
				<div class='row-fluid' id='top-nav-container'>
					<div class="span12">
						<ul id='top-nav-list' class='nav-collapse'>
							
							<li class='nav-btn'>
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
					<?php echo $content_for_layout; ?>
				</div>
			</div>
		</div>
		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>