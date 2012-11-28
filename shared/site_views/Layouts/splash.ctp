<html>
<head>
<title><?php echo $title_for_layout; ?>
</title>
<meta content="<?php echo $meta_k; ?>" name='keywords'>
<meta name="description" content='<?php echo $meta_d; ?>'>
<?php 



echo $this->element("layout/v3/html-head-scripts");
echo $head_content;
?>
</head>
<body>
	<div id="fb-root"></div>
<!-- Zuckerberg Likes Us -->
	<?php echo $content_for_layout; ?>
	<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
</body>
<!-- <?php echo php_uname('n'); ?> -->
</html>