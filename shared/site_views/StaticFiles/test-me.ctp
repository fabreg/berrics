<?php

//title for the page
$title_for_layout = "Your Title Goes Here";

//layout file
///un-comment the line below to use a blank layout template;
$this->layout = "blank";

//meta keywords
$meta_k = '';

//meta description
$meta_d = '';

$this->set(compact("title_for_layout","meta_k","meta_d"));

?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			body { background-color:black; }
		</style>
	</head>
	<body>
		Testing
	</body>
</html>