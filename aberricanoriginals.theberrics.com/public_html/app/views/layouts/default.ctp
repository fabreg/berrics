<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title_for_layout; ?></title>
		<?php 
		
			echo $this->Html->css("main","stylesheet");
			echo $this->Html->script(array(
		
				"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
				"http://connect.facebook.net/en_US/all.js#xfbml=1",
				"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
				"jquery.scrollTo",
				"jquery.swfobject",
				"jquery.client",
				"swfupload/swfupload.js",
				"jquery.swfupload",
				"http://admin.brightcove.com/js/BrightcoveExperiences.js",
				"main"
		
			));
		?>
		<?php echo $scripts_for_layout; ?>
	</head>
	<body>
		<div id='main-container'>
			<div id='page-container'>
				<div id='header'>
					<div class='left'>
						<img src='/img/header-1.jpg'/>
					</div>
					<div class='right'>
						<img src='/img/header-2.jpg' />
						<div class='twitter'>
							<a href='http://twitter.com/#!/levisworkshops' target='_blank'><img src='/img/clear.png' height='30' width='104' /></a>
						</div>
						<div class='facebook'>
							<a href='http://www.facebook.com/Levis' target='_blank'><img src='/img/clear.png' height='30' width='120' /></a>
						</div>
					</div>
				</div>
				<div id='content'>
					<?php echo $content_for_layout; ?>
				</div>
			</div>
			<div style='font-size:9px; text-align:right;'>
				<?php //echo php_uname("n"); ?>
			</div>
		</div>
	</body>
	<?php echo $this->element("sql_dump"); ?>
</html>