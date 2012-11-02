<html>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php 

		echo $this->Html->css(array(
			"v3/bootstrap",
			"v3/layout",
			"v3/bootstrap-responsive"
		),"stylesheet");

		echo $this->Html->script(array(
			"https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js",
			"v3/bootstrap",
			"v3/modernizr",
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
							<img src='/img/v3/layout/berrics-heading.gif' alt='THE BERRICS' border='0' />
						</div>
					</div>
				</div>
				<div class='row-fluid' id='top-nav-container'>
					<div class="span12">
						<ul id='top-nav-list' class='nav-collapse'>
							<li class='top-nav-logo'>
								<img src='/img/v3/layout/berrics-heading.jpg' alt='THE BERRICS' border='0' />
							</li>
							<li>
								<a href="#">FEATURES</a>
							</li>
							<li>
								<a href="">NEWS</a>
							</li>
							<li>
								<a href="">UNIFIED</a>	
							</li>
							<li>CANTEEN</li>
							<li class='hidden-phone'>HEADQUARTERS</li>
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
	</body>
</html>