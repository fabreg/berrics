<?php echo $this->Form->create("CanteenOrderItem",array("url"=>$this->here)); ?>
<div class='index form'>
	<div>
		<h2> Editing Line Item </h2>
	</div>
	<fieldset>
		<legend>Other Actions</legend>
		<div class='actions'>
			<a href='/canteen_orders/edit/<?php echo $this->data['CanteenOrderItem']['canteen_order_id']; ?>'>Go Back to Order</a>
		</div>
	</fieldset>
	<fieldset>
		<legend>Line Item Totals</legend>
		<?php 
			echo $this->Form->input("sub_total");
			
		?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
	<fieldset>
		<legend>Child Line Items</legend>
		<table cellspacing='0'>
			<?php foreach($this->data['ChildCanteenOrderItem'] as $k=>$c): ?>
			<tr>
				<th></th>
				<th>Name Label</th>
				<th>Sub Label</th>
				<th>Brand Label</th>
				<th>Linked Product</th>
				<th>Linked Inventory Record</th>
				<th>Linked Shipment</th>
			</tr>
			<tr>
				<td>
				<?php echo $this->Form->input("ChildCanteenOrderItem.{$k}.id"); ?>
				</td>
				<td>
				<?php echo $this->Form->input("ChildCanteenOrderItem.{$k}.title"); ?>
				</td>
				<td>
				<?php echo $this->Form->input("ChildCanteenOrderItem.{$k}.sub_title"); ?>
				</td>
				<td>
				<?php echo $this->Form->input("ChildCanteenOrderItem.{$k}.brand_label"); ?>
				</td>
				<td>Linked Product</td>
				<td>Linked Inventory Record</td>
				<td>Linked Shipment</td>
			</tr>
			<?php endforeach; ?>
		</table>
		
	</fieldset>
</div>
<?php echo $this->Form->end(); ?>
<?php 
pr($this->data);
?>