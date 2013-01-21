
<?php 


 //$this->Html->css(array("search"),"stylesheet",array("inline"=>false));


?>
<style type="text/css">
	
.redirect {

	text-align: center;
	
	width:80%;
	margin:auto;


}

#search-redirect {

	min-height: 500px;

}

</style>
<div id="search-redirect">
	<div class='redirect alert alert-success'>

		Searching The Berrics For <span class='term'><b>"<?php echo base64_decode($token); ?>"</b></span>
		<div>This may take a few seconds</div>

	</div>
</div>
<script>
setTimeout(function() { 

	document.location.href = "/search/results/<?php echo $token; ?>";
	
},1000);
</script>