<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Battle At The Berrics 4 - 
		<?php echo $title_for_layout; ?>
	</title>
	
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js' type='text/javascript'></script>
	<?php
		
		echo $this->Html->script("jquery.scrollTo-min.js");	
	
		echo $this->Html->css('main');
	
		echo $scripts_for_layout;
	?>
	
</head>
<body>
	<div id='maincontainer'>
		<div id='pagewrapper'>
			<div id='pagecontainer'>
				<div id='header'>
				
				</div>
				<div id='batb4-header'>

				</div>
				<div id='bodycontainer'>
					<div id='bodycontent'>
<div style='width:450px; background-color:white; margin:auto; '><a href="<?php echo $url; ?>"><?php echo $message; ?></a></div>
					</div>
				</div>
				<div id='footer'>
				
				</div>
			</div>
		</div>
	
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>