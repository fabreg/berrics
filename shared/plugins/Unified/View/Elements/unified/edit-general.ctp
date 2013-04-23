<?php 

$storeStatus = UnifiedStore::storeStatus();

$years = array();

for($i=1970;$i<=date("Y");$i++) $years[$i] = $i;

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
			echo $this->Form->input("established_year",array("options"=>$years));
		?>
		
	</div>
	<div class="span6">
		
	</div>
</div>