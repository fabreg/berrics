<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $page_title; ?></title>

<?php //if (Configure::read() == 0) { ?>
<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
<?php //} ?>
<?php 

echo $this->Html->css("main","stylesheet");

?>
<style>

.flash-message {

	
	width:350px;
	text-align:center;
	padding:35px;
	margin:auto;
	margin-top:35px;
	border:1px solid #999999;
	-moz-border-radius: 10px;
border-radius: 10px;
-webkit-box-shadow: 1px 5px px #949494;
-moz-box-shadow: 1px 5px px #949494;
box-shadow: 1px 5px px #949494;
background-color:white;

}

.flash-message a {

	color:black;

}

</style>
</head>
<body>

<div class='flash-message'>
<a href="<?php echo $url; ?>"><?php echo $message; ?></a>
</div>
</body>
</html>