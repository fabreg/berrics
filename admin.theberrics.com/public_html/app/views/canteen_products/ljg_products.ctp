<script>
$(document).ready(function() { 


	$('.submit-button').click(function() { 

		$("#inv-form").submit();
		
	});

	$('input[type=checkbox]').change(function() {

		if($(this).attr("checked")) {

			$(this).parent().parent().css({
				"background-color":"#bbf4da"
			});
			
		} else {

			$(this).parent().parent().css({
				"background-color":"transparent"
			});
			
		}

	});
	
});
</script>
<Style>
.highlight {
	
	background-color:#bbf4da;

}
</Style>
<div class='index'>
	<?php echo $this->Form->create("LjgInventory",array("id"=>"inv-form","url"=>"/canteen_products/create_ljg_inventory")); ?>
	<?php 
		echo $this->Form->input("canteen_product_id",array("type"=>"hidden","value"=>$canteen_product['CanteenProduct']['id']));
	?>
	<h2>La Jolla Products File</h2>
	<h3><?php echo $canteen_product['Brand']['name']; ?> - <?php echo $canteen_product['CanteenProduct']['name']; ?> - <?php echo $canteen_product['CanteenProduct']['sub_title']; ?></h3>
	<table cellspacing='0'>
		<tr>
			<th>-</th>
			<?php foreach($schema as $v): ?>
			<th><?php echo $v; ?></th>
			<?php endforeach; ?>
			<th>-</th>
		</tr>
		<?php foreach($ljg_products as $k=>$v): 
			if($filter) {
				$seed = strtolower($canteen_product['CanteenProduct']['name']);
				if(!strstr(strtolower($v['Description']),$seed)) {
					
					continue;
					
				}
				
			}
		?>
		<tr>
			<td><input type='checkbox' value='<?php echo $k; ?>' name='data[index][]' /></td>
			<?php foreach($schema as $s):?>
			<td><?php echo $v[$s]; ?></td>
			<?php endforeach; ?>
			<td class='actions'>
				<a href='#' class='submit-button'>Submit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>