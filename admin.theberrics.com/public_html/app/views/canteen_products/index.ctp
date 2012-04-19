<div class='index form'>
	<h2>Canteen Products</h2>
	
	<fieldset>
		<legend>Filter</legend>
		<?php 
		
			echo $this->Form->create("CanteenProduct",array("url"=>array("action"=>"filter")));
			echo $this->Form->input("canteen_category_id",array("options"=>$canteenCategories,"empty"=>true));
			echo $this->Form->end("Run Filter");
		?>
	</fieldset>
	
	<p>
				<?php
					echo $this->Paginator->counter(array(
						'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
					));
				?>	
			</p>
		
			<div class="paging">
				<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
			 | 	<?php echo $this->Paginator->numbers();?>
		 |
				<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
			</div>
					
	<table cellspacing='0' style='font-size:12px;'>
		<tr>
			<th>Thumb Image</th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("featured"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("display_weight"); ?></th>
			<th><?php echo $this->Paginator->sort("style_code"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("CanteenCategory.name"); ?></th>
			<th><?php echo $this->Paginator->sort("Brand.name"); ?></th>
			<th>-</th>
		</tr>
		<?php 
		
			foreach($products as $prod):
				$p = $prod['CanteenProduct'];
				$c = $prod['CanteenCategory'];
				$b = $prod['Brand'];
		?>
		<tr>
			<td width='1%' nowrap>
				<?php if(isset($prod['CanteenProductImage'][0])): ?>
				<?php echo $this->Media->productThumb($prod['CanteenProductImage'][0],array("w"=>50)); ?>
				<?php else: ?>
				No Image
				<?php endif; ?>
			</td>
			<td align='center' nowrap width='1%'>
				<?php 
				
					switch($p['active']) {
					
						case 1:
							echo "<span style='color:green;'>YES</span>";
						break;
						default:
							echo "<span style='color:red;'>NO</span>";
						break;
					}
				?>
			</td>
			<td align='center' nowrap width='1%'>
				<?php 
				
					switch($p['featured']) {
					
						case 1:
							echo "<span style='color:green;'>YES</span>";
						break;
						default:
							echo "<span style='color:red;'>NO</span>";
						break;
					}
				?>
			</td>
			<td align='center' nowrap width='1%'>
				<?php 
				
					echo $p['display_weight'];
					
				?>
			</td>
			<td align='center' width='1%' nowrap><?php echo $this->Time->niceShort($p['modified']); ?></td>
			
			<td align='center' nowrap width='1%'><?php echo $p['style_code']; ?></td>
			<td align='center' nowrap width='1%'><?php echo $p['name']; ?> - <?php echo $p['sub_title']; ?></td>
			<td align='center'><?php echo $c['name']; ?></td>
			<td align='center'><?php echo $b['name']; ?></td>
			<td class='actions'>
				<a href='/canteen_products/edit/<?php echo $p['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
</div>