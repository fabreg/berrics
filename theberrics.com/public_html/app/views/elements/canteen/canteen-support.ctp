<script>

$(document).ready(function() { 


	 $('#order-status-form').ajaxForm({

		"success":function(d) {

		 	$("#order-status-results").html(d);
		 
	 	},
	 	"beforeSubmit":function() { 

			$("#order-status-results").html("Locating Orders....");
			
		 }
			
	});
	
});


</script>
<div id='canteen-support'>
	<div class='heading'>
		QUESTIONS
	</div>
	<div class='questions-content'>
	
	</div>
	<div class='heading'>
		ORDER STATUS
	</div>
	<div class='order-status-content'>
		<div>
			<p>
				To check the status or your order, please use the form below.<br />
				<span style='font-size:12px; font-style:italic;'>* If you ordered through your Berrics Account, you can view your order history by clicking <a href='/account/canteen'>here</a></span>
			</p>
		</div>
		<div>
			<?php 
				echo $this->Form->create("CanteenOrderStatus",array("url"=>$this->here,"id"=>"order-status-form"));
			?>
			<div>
				<?php echo $this->Form->input("email",array("label"=>"Email Address")); ?>
			</div>
			<div>
				<?php echo $this->Form->input("postal_code")?>
			</div>
			<div style='clear:both;'></div>
			<div style='text-align:center;'>
				<?php echo $this->Form->submit("Lookup Your Order"); ?>
			</div>
			<?php 
				echo $this->Form->end();
			?>
		</div>
	</div>
	<div id='order-status-results'>
	
	</div>
</div>