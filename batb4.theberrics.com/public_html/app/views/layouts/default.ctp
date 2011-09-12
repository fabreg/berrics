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
			<div id='header'>
				<div class='inner'>
					<div class='dc-link'>
						<a href='http://skate.dcshoes.com/' target='_blank'>
							<img src='/img/px.gif' width='100' height='111' border='0' />
						</a>
					</div>
					<div class='home-link'>
						<a href='/' title='Battle at the Berrics IV: U.S. VS. THEM' >
							<img src='/img/px.gif' width='755' height='111' border='0' />
						</a>
					</div>
				</div>
			</div>
			<div id='pagecontainer'>
				

				<div id='bodycontainer'>
					<div id='bodycontent'>
						<?php echo $this->Session->flash(); ?>

						<?php echo $content_for_layout; ?>
					</div>
				</div>
				<div id='footer'>
				
				</div>
			</div>
		</div>
	
	</div>
	<div style='text-align:right; font-size:9px;'><?php echo php_uname('n');?></div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>