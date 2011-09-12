<!DOCTYPE HTML>
<html>
<head>
<title><?php echo $title_for_layout; ?></title>

<?php 
	
	echo $this->Html->css("main.css","stylesheet");

	echo $scripts_for_layout;

?>

</head>
<body>
<div id='main-container'>
	<div id='page-container'>
		<div id='header'>
			<?php echo $this->Html->image("header.png"); ?>
		</div>
		<div id='content'>
			<?php 
	
				echo $content_for_layout;
			
			?>
		</div>
		<div id='footer'>
		
			<?php echo $this->Html->image("footer.png"); ?>
		
		</div>
	</div>
</div>
</body>

</html>