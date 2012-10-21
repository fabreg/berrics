<?php 

$this->Html->script(array("BerricsReportPanel"),array("inline"=>false));

?>
<script>

$(document).ready(function() { 




	
});




function handleIndexLink(href) {

	
	
}

var Report = {

	openReport:function(href) { 

		$('body').append(
					$("<div class='report-overlay' />").append(
						$("<div class='overlay-wrapper' />").append(
							$("<div class='overlay-content'/>")
						)
					)
				);		

		
		
	},
	handleResize:function() { },
	hanleClose:function() { }
		
};


</script>
<div class='index'>
	<div style='float:left; width:35%;'>
		<fieldset>
			<legend>Generate A Report</legend>
			<div>
				<ul>
					<li>
						<a href=''>Traffic Overview</a>
					</li>
				</ul>
			</div>
		</fieldset>
		<div id='ajax-index'>
		
		</div>
	</div>
	<div style='float:right; width:64%;'></div>
	<div style='clear:both;'></div>
</div>