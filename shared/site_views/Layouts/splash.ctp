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
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=128870297181216";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Zuckerberg Likes Us -->
</body>
<!-- <?php echo php_uname('n'); ?> -->
</html>