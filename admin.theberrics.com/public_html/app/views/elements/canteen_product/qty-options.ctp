<?php 

if(count($this->data['CanteenProductOption'])>0):
?>
<div class='index'>
<table cellspacing='0'>
<tr>
	<th align='left'>Label</th>
	<th align='left'>Value</th>
	<th align='left'>Qty</th>
	<th align='center'>-</th>
</tr>
<?php 
	foreach($this->data['CanteenProductOption'] as $k=>$o):
	echo $this->Form->input("CanteenProductOption.{$k}.id");
?>
	<tr>
		<td>
			<input type='text' name='data[CanteenProductOption][<?php echo $k; ?>][opt_label]' value='<?php echo $o['opt_label']; ?>' />
		</td>
		<td>
			<input type='text' name='data[CanteenProductOption][<?php echo $k; ?>][opt_value]' value='<?php echo $o['opt_value']; ?>' />
		</td>
		<td>
			<input type='text' name='data[CanteenProductOption][<?php echo $k; ?>][quantity]' value='<?php echo $o['quantity']; ?>' />
		</td>
		<td class='actions'>
			<?php 
			
				echo $this->Form->submit("RemoveOption",array("name"=>"data[RemoveOption][{$o['id']}]"));
			
			?>
		</td>
	</tr>
<?php 
	endforeach;
?>
</table>
	<?php echo $this->Form->submit("Update Options"); 
		echo $this->Form->submit("Add New Option",array("name"=>"data[AddNewOption]"));		
	?>
</div>
<?php 
else:

?>
<?php 

	echo $this->Form->input("quantity");
	echo $this->Form->submit("Update Quantity");
	echo $this->Form->submit("Add Multiple Options",array("name"=>"data[AddNewOption]"));
?>
<?php 

endif;

?>