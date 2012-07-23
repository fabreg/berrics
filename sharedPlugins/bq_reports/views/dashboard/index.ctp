<?php 

$this->Html->script(array("BerricsReportPanel"),array("inline"=>false));

?>
<script>

$(document).ready(function() { 


	Report.init();

	
});




function handleIndexLink(href) {

	
	
}

var Report = {
	init:function() { 

		$('#report-menu a').click(function() { 

			Report.openReport($(this).attr("href"));
			
			return false;
			
		});
		
	},
	openReport:function(href) { 

		$('body').append(
					$("<div class='report-overlay' />").append(
						$("<div class='overlay-wrapper' />").append(
							
							$("<div class='close-overlay'>CLOSE [x]</div><div class='overlay-content'/>")
						)
					)
				);		


		$('.overlay-content').html("Loading ....... ");
		
		$('.close-overlay').click(function() { 

			Report.handleClose();

		});

		Report.handleResize();	


		//load the content
		$.get(href,function(d) { $('.overlay-content').html(d); });
		
		
	},
	handleResize:function() { 

		$('body,html').css({

			"overflow":"hidden"

		});
		
	},
	handleClose:function() { 

		$('.report-overlay').remove();

		$('body,html').css({

			"overflow":"auto"

		});

	}
		
};


</script>
<div class='index'>
	<div style='float:left; width:35%;'>
		<fieldset id='report-menu'>
			<legend>Generate A Report</legend>
			<div>
				<ul>
					<li>
						<?php echo $this->Html->link("Traffic Overview",array("action"=>"generate","traffic-overview")); ?>
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