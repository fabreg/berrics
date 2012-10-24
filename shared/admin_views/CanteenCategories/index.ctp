<?php

//pr($cats);

?>
<div class='index'>
	<h2>Canteen Categories</h2>

	<table cellspacing='0'>
		<tr>
			<th>Category</th>
			<th>Active</th>
			<th>Browsable</th>
			<th>URI</th>
			<th>Actions</th>
		</tr>
		<?php 
		
			foreach($cats as $k=>$v):
			
		?>
		<tr>
			<td>
			<?php 
			
				if($v['CanteenCategory']['parent_id']>0) {
					
					echo "-".$v['CanteenCategory']['name'];
					
				} else {
					
					echo "<strong>".$v['CanteenCategory']['name']."</strong>";
					
				}
			
			?>
			</td>
			<td align='center'>
			<?php 
			
				switch($v['CanteenCategory']['active']) {
					
					case 1:
						echo "<span style='color:green;'>Yes</span>";
					break;
					default:
						echo "<span style='color:red;'>No</span>";
					break;
				}
			
			?>
			
			</td>
			<td align='center'>
			<?php 
			
				switch($v['CanteenCategory']['browsable']) {
					
					case 1:
						echo "<span style='color:green;'>Yes</span>";
					break;
					default:
						echo "<span style='color:red;'>No</span>";
					break;
				}
			
			?>
			</td>
			<td>
			<?php 
			
				echo $v['CanteenCategory']['uri'];
			
			?>
			</td>
			<td class='actions'>
							<?php echo $this->Admin->link("Edit",array("action"=>"edit",$v['CanteenCategory']['id'])); ?> 
							<?php 
								if($v['CanteenCategory']['parent_id']<=0) {
									//echo $this->Admin->link("Add Aberrica Cover Page",array("controller"=>"cover_pages","action"=>"add",$v['CanteenCategory']['id']));
								//	echo $this->Admin->link("View Cover Pages",array("controller"=>"cover_pages","action"=>"index","CoverPage.aberrica_category_id"=>$v['CanteenCategory']['id']));
									echo $this->Admin->link("Add Child",array("action"=>"add",$v['CanteenCategory']['id']));
								} else {
									
									echo $this->Admin->link("Sort Products",array("action"=>"sort_products",$v['CanteenCategory']['id']));
									
								}
							?> 
							<?php echo $this->Admin->link("Move Up",array("action"=>"move_up",$v['CanteenCategory']['id'],1)); ?>
							<?php echo $this->Admin->link("Move Down",array("action"=>"move_down",$v['CanteenCategory']['id'],1)); ?> 
							<?php echo $this->Admin->link("Remove",array("action"=>"remove",$v['CanteenCategory']['id']),array("onclick"=>"return confirm('Are you sure you wanna do this?')")); ?> 
							
			</td>
		</tr>

		<?php 
		
			endforeach;	
		
		?>
	</table>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link("New Top Level Category", array('action' => 'add')); ?></li>
	</ul>
</div>