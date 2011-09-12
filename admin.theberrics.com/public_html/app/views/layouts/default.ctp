<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('main','top-nav','ui-lightness/jquery-ui-1.8.10.custom.css','ui-lightness/jquery-ui-timepicker.css'));
		echo $this->Html->script(array(
			"https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"https://connect.facebook.net/en_US/all.js",
			"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
			"jquery.form",
			"jquery.ui.timepicker-0.0.8.js",
			"top-nav",
			"/jw/jwplayer.js"
		));
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
		
			<?php echo $this->Html->link(__('The Berrics Backend Stuff', true), '/'); ?>
			<div class='top-nav'>
				<?php echo $this->element("top-nav/top-nav"); ?>
			</div>
		</div>
		<div id="content">
			
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
		
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>