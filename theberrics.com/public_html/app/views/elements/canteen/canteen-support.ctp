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
			<?php 
				echo $this->Form->create("CanteenOrderStatus",array("url"=>$this->here));
			?>
			<div>
				<?php echo $this->Form->input("email"); ?>
			</div>
			<div>
				<?php echo $this->Form->input("postal_code")?>
			</div>
			<div style='clear:both;'></div>
			<?php 
				echo $this->Form->end();
			?>
		</div>
	</div>
</div>