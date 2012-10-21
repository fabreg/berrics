<html>
	<head>
	
		<title><?php echo $title_for_layout; ?></title>
		<?php 
		
			echo $this->element("layout/admin-head-includes");
		
			echo $scripts_for_layout; 
				
				
		?>
		<style>
			body {
			
				padding-top:0px;
			
			}
		</style>
		<script>
		$(document).ready(function() { 

			window.print();

		});
		</script>
	</head>
	<body>
		<div class='container-fluid'>
			<?php echo $content_for_layout; ?>
		</div>
	</body>
</html>