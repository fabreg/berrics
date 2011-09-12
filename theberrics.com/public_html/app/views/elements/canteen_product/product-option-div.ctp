<?php

?>
<div id='<?php echo $opt['id']; ?>' class='canteen-product-option-div'>
	<?php echo $opt['opt_label']; ?>:<?php echo $opt['opt_value']; ?>
	<?php echo $this->Form->input('CanteenOrderItem.canteen_product_option_id',array("value"=>$opt['id'],"disabled"=>true,"type"=>"hidden")); ?>
</div>