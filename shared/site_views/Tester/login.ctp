<?php 

$this->Html->script(array("jquery.berrics.login"),array("inline"=>false));


$this->Html->css(array("BerricsLogin"),"stylesheet",array("inline"=>false));

?>
<div>
<script>

$(document).ready(function() { 


	$("#fuck").click(function() { 

		$.BerricsLogin("openWindow",{
			"screen":"loginScreen"
		});

	});

	
});

</script>
<input type='button' value='fuck' id='fuck' />

</div>