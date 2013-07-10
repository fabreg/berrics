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

	<div class='container'>
		<div class='row-fluid'>
			<div class='span8'>
				
			</div>
			<div class='span4'>
				
			</div>
		</div>
		<div class='row'>
			<div class='span8'>
				<ul class='thumbnails'>
					<li class='span12'>
						
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div style='height:50px;'></div>
		<div class='container-fluid' style='max-width:1170px; min-width:320px; margin:auto;'>
		<div class='row-fluid'>
			<div class='span8'>
				<div style='text-align:center; background-color:#000; padding:10px; margin:auto;'>
					<img src="http://img01theberrics.com/i.php?src=/video/stills/502d5547-a998-4d70-922f-551a323849cf.jpg&amp;zc=0&amp;h=400&amp;w=700" border="0" alt="">
				</div>
				<div style='text-align:center;'>
					<script>
						  var ord = window.ord || Math.floor(Math.random() * 1e16);
						  document.write('<script type="text/javascript" src="https://ad.doubleclick.net/N5885/adj/dailyops_p1;sz=728x90;tile=1;ord=' + ord + '?"><\/script>');
						</script>
				</div>
				<div style='text-align:center;'>
					<img src="http://img01theberrics.com/i.php?src=/video/stills/502d5547-a998-4d70-922f-551a323849cf.jpg&amp;zc=0&amp;h=400&amp;w=700" border="0" alt="">
				</div>
			</div>
			<div class='span4'>
						
				<script type="text/javascript">
				  var ord = window.ord || Math.floor(Math.random() * 1e16);
				  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/dailyops_p1_lo;sz=300x250;tile=3;ord=' + ord + '?"><\/script>');
				</script>
				<script type="text/javascript">
				  var ord = window.ord || Math.floor(Math.random() * 1e16);
				  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/dailyops_p1_lo;sz=300x250;tile=3;ord=' + ord + '?"><\/script>');
				</script>
			</div>
		</div>
	</div>
</body>
</html>