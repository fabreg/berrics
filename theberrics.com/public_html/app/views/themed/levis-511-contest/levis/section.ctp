<?php 

$this->Html->script(array("LevisContest"),array("inline"=>false));

?>
<script>
$(document).ready(function() { 

	$('#test-button').click(function() { 

		$.LevisContest('openWindow',{
			'url':"/levis-511/upload_image"
		});

	});
	
});
</script>
TEST
<input type='button' value='testing' id='test-button' />