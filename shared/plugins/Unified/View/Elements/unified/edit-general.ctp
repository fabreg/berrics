<?php 

$storeStatus = UnifiedStore::storeStatus();

?>
<script>
jQuery(document).ready(function($) {
	

});

function checkDupeUnifiedUri() {

	

}
</script>
<div class="row-fluid">
	<div class="span6">
		<?php 
			echo $this->Form->input("id");
			if(CakeSession::read("is_admin") == 1) {

				echo $this->Form->input("store_status",array("options"=>$storeStatus));

			}
			echo $this->Form->input("shop_name"); 
			echo $this->Form->input('shop_bio');
			echo $this->Form->input("uri");
			
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