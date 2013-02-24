<div class="row-fluid">
	<div class="span6">
		<?php 
			echo $this->Form->input("id");
			echo $this->Form->input("active");
			echo $this->Form->input("shop_name"); 
			echo $this->Form->input('shop_bio');
			
		?>
		
	</div>
	<div class="span6">
		<?php 

			echo $this->Form->input('address1');
			echo $this->Form->input('address2');
			echo $this->Form->input('city');
			echo $this->Form->input('state');
			echo $this->Form->input('full_state');
			echo $this->Form->input('zip');
			echo $this->Form->input('country');
			echo $this->Form->input('phone');

		 ?>
	</div>
</div>