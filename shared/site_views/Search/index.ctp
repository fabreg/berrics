
<?php 


 $this->Html->css(array("search"),"stylesheet",array("inline"=>false));


?>
<div class='redirect'>

	Searching The Berrics For <span class='term'>"<?php echo base64_decode($token); ?>"</span>
	<div>This may take a few seconds</div>

</div>
<script>
setTimeout(function() { 

	document.location.href = "/search/results/<?php echo $token; ?>";
	
},1000);
</script>