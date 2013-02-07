<html>
<head>
<title><?php echo $title_for_layout; ?>
</title>
<meta content="<?php echo $meta_k; ?>" name='keywords'>
<meta name="description" content="<?php echo $meta_d; ?>">
<?php 



echo $this->element("layout/v3/html-head-scripts");
echo $head_content;
?>

</head>
<body>
	<div id="fb-root"></div>
<!-- Zuckerberg Likes Us -->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<?php echo $content_for_layout; ?>
			</div>
		</div>
		
	</div>
	<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
</body>
<!-- <?php echo php_uname('n'); ?> -->
</html>