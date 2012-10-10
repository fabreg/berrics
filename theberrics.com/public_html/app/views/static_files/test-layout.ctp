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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php 
	
		echo $this->Html->css(array("bootstrap"));
		
		echo $this->Html->css(array("bootstrap-responsive"));
		
		echo $this->Html->script(array("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js","bootstrap"));
	
	?>
	<style>
	.show-grid [class*="span"] {
  background-color: #eee;
  text-align: center;
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
  min-height: 30px;
  line-height: 30px;
}
.show-grid:hover [class*="span"] {
  background: #ddd;
}
.show-grid {
  margin-top: 10px;
  margin-bottom: 20px;
}
	</style>
<script>

$(document).ready(function() { 


	$(window).bind("resize",function() {

		$(".container:eq(0) div[class^=span]").each(function() { 

			var w = $(this).width();

			$(this).html(w);

		});


	});

	$(window).resize();

	
});

	
</script>
</head>
<body>




	<div class='container'>
			<div class="row show-grid">
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		    <div class="span1">1</div>
		  </div>
		  <div class="row show-grid">
		    <div class="span4">4</div>
		    <div class="span4">4</div>
		    <div class="span4">4</div>
		  </div>
		  <div class="row show-grid">
		  	<div class="span8">8</div>
		    <div class="span4">4</div>
		    
		  </div>
		  <div class="row show-grid">
		    <div class="span6">6</div>
		    <div class="span6">6</div>
		  </div>
		  <div class="row show-grid">
		    <div class="span12">12</div>
		  </div>
	</div>

</body>
</html>