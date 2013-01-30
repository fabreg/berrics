<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $page_title; ?></title>
<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<?php echo $this->element("layout/v3/html-head-script"); ?>
</head>
<body>

<div style="text-align:center;">
	<p><a href="<?php echo $url; ?>"><?php echo $message; ?></a></p>
<p><a href="<?php echo $url; ?>">Click Here If You Are Not Redirected</a></p>
</div>
</body>
</html>