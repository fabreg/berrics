<?php 

$tag_str = '';

if(isset($this->data['Tag'])) {
	
	foreach($this->data['Tag'] as $t) $tag_str .= $t['name'].",";
	
}

$tag_str = rtrim($tag_str,",");

?>
<script>
$(document).ready(function() { 

	$("#CanteenProductPubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
	$("#CanteenProductPubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});
	
});
</script>
<style>

#settings-checks .checkbox {

	float:left;
	margin-right:15px;
}
#pub-times .text {

	float:left;
	width:250px;
	clear:none;
}
</style>
<div class='product-form' id='general-info'>
			
		<div id='settings-checks'>
			<?php 
				echo $this->Form->input("active");
				echo $this->Form->input("allow_free_shipping");
				echo $this->Form->input("allow_discount");
				echo $this->Form->input("featured");
				echo $this->Form->input("digital_item");
				echo $this->Form->input("ljg_inv");
			?>
			<div style='clear:both;'></div>
		</div>
		
		<div id='pub-times'>
			<?php 
				echo $this->Form->input("pub_date");
				echo $this->Form->input("pub_time");
			?>
			<div style='clear:both;'></div>
		</div>
		<?php 
				
				
				
				echo $this->Form->input("name");
				echo $this->Form->input("sub_title");
				echo $this->Form->input("description");
				echo $this->Form->input("brand_id");
				echo $this->Form->input("canteen_category_id");
				if($this->params['action'] != "add") echo $this->Form->input("display_weight");
				echo $this->Form->input("tags",array("value"=>$tag_str));
				echo $this->Form->input("uri");
				echo $this->Form->input("shipping_weight");
				echo $this->Form->input("merch_template",array("options"=>CanteenProduct::merchTemplates()));
				echo $this->Form->submit("Update General Info");
				
			?>
</div>