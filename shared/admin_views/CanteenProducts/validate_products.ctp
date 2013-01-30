<div class='index'>
	<div class='form'>
		<fieldset>
			<legend>Filter</legend>
			<div>
				<?php 
					echo $this->Form->create("CanteenProduct",array("url"=>$this->request->here));
					echo $this->Form->input("active",array("checked"=>"checked"));
					echo $this->Form->input("canteen_category_id",array("empty"=>true));
					echo $this->Form->end("Go");
				?>
			</div>
		</fieldset>
	</div>
	<h2>Products</h2>
	<?php if(isset($products) && count($products)>0): ?>
	<table cellspacing='0'>
		<tr>
			<th>Product</th>
			<th>Message</th>
		</tr>
		<?php foreach($products as $p): ?>
		<tr>
			<td>
				<a href='/canteen_products/edit/<?php Echo $p['CanteenProduct']['id']; ?>' target='_blank'><?php echo $p['CanteenProduct']['name']; ?> - <?php echo $p['CanteenProduct']['sub_title']; ?></a>
			</td>
			<td>
				<?php foreach($p['ValidateMessage'] as $m) echo "<div>{$m}</div>"; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php else: ?>
	<div>
		No invalid products found
	</div>
	<?php endif; ?>
</div>
<?php 
$ids = Set::extract("/CanteenProduct/id",$products);
echo implode($ids,",");
?>