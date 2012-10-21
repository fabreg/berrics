<html>
<head>
<title><?php echo $title_for_layout; ?>
</title>
<meta content="<?php echo $meta_k; ?>" name='keywords'>
<meta name="description" content='<?php echo $meta_d; ?>'>
<?php 



echo $this->element("layout/html-head-scripts");
echo $head_content;
?>
</head>
<body>
	<?php echo $content_for_layout; ?>
</body>
<!-- <?php echo php_uname('n'); ?> -->
</html>