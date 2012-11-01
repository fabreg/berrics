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

			"v3/bootstrap"

		));
	?>
	<body>
		<div class="container" id='main-container'>
			<div class="row-fluid">
				<div class="span12">
					<header id='top-header'>
						<h1>THE BERRICS</h1>
					</header>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span12">
					<?php echo $content_for_layout; ?>
				</div>
			</div>
		</div>
	</body>
</html>