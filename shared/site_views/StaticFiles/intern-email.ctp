<?php 

$this->set("title_for_layout","Berrics Intern Email");

?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		document.location.href = "mailto:joel@theberrics.com?subject=Berrics Intern Position";
		
		setTimeout(function() { 

			document.location.href = '/dailyops';

		},1000);

	});
</script>