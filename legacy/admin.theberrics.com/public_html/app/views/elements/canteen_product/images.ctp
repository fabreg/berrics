<?php 

$dw = array();

for($i=1;$i<=100;$i++) $dw[$i]=$i;

?>
<div>
	<?php 
	
		echo $this->Form->input("AddImage",array("type"=>"file"));
		echo $this->Form->submit("Add New Image",array("name"=>"data[AddNewImage]"));
	?>
</div>
<?php 
if(count($this->data['CanteenProductImage'])>0):
	
	
?>
	<table cellspacing='0'>
		<tr>
			<th>Image</th>
			<th>Display Weight</th>
			<th>Main Image?</th>
			<th>Thumb Image?</th>
			<th>-</th>
		</tr>
		<?php 
			foreach($this->data['CanteenProductImage'] as $k=>$img):
		?>
		<tr>
			<td>
				<?php echo $this->Media->productThumb($img,array("w"=>100)); ?>
				<?php echo $this->Form->input("CanteenProductImage.{$k}.id"); ?>
			</td>
			<td><?php echo $this->Form->input("CanteenProductImage.{$k}.display_weight",array("options"=>$dw)); ?></td>
			<td>
				<?php 
				
					if($img['front_image'] == 1) {
						
						echo "Yes";
						
					} else {
						
						echo $this->Form->submit("Promote",array("name"=>"data[PromoteFrontImage][{$img['id']}]"));
						
					}
				
				?>
			
			</td>
			<td>
			<?php 
				
					if($img['thumb_image'] == 1) {
						
						echo "Yes";
						
					} else {
						
						echo $this->Form->submit("Promote",array("name"=>"data[PromoteThumbImage][{$img['id']}]"));
						
					}
				
				?>
			</td>
			<td class='actions'>
				<?php echo $this->Form->submit("RemoveImage",array("name"=>"data[RemoveImage][{$img['id']}]")); ?>
			</td>
		</tr>
		<?php 
			endforeach;
		?>
	</table>
	<?php 
	
		echo $this->Form->submit("Update Images");
	
	?>
<?php 
endif;
?>