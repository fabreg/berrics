<?php

$cat_id = '';

if(isset($this->request->params['named']['CoverPage.aberrica_category_id'])) {
	
	$cat_id = $this->request->params['named']['CoverPage.aberrica_category_id'];
	
}

?>
<div class='index'>
<h2>Cover Pages</h2>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
		<div class='actions'>
		<ul>
			<?php echo $this->Admin->link("Add New Cover Page",array("action"=>"add",$cat_id)); ?>
		</ul>
	</div>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
			<th><?php echo $this->Paginator->sort("title"); ?></th>
			<th><?php echo $this->Paginator->sort("Category Name","AberricaCategory.name"); ?></th>
			<th><?php echo $this->Paginator->sort("click_count"); ?></th>
			<th>Media File</th>
			<th>Actions</th>
		</tr>
		<?php 
		
			foreach($coverPages as $v):
		
		?>
		<tr>
			<td><?php echo $v['CoverPage']['id']; ?></td>
			<td align='center'>
			<?php 
			
				switch($v['CoverPage']['active']) {
					
					case 1:
						echo "<span style='color:green;'>Yes</span>";
					break;
					default:
						echo "<span style='color:red;'>No</span>";
					break;
				}
			
			?>
			</td>
			<td><?php echo $this->Time->niceShort($v['CoverPage']['publish_date']); ?></td>
			<td><?php echo $v['CoverPage']['title']; ?></td>
			<td>
				<?php 
				
					if($v['CoverPage']['aberrica_category_id']>0) {
						
						echo $v['AberricaCategory']['name'];		
						
					} else {
						
						echo "Home";
						
					}
				
				?>
			</td>
			<td><?php echo $v['CoverPage']['click_count']; ?></td>
			<td></td>
			<td class='actions'>
				<?php 
				
					echo $this->Admin->link("Edit",array("action"=>"edit",$v['CoverPage']['id']));
				
				?>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		
		?>
	</table>
	<div class='actions'>
		<ul>
			<?php echo $this->Admin->link("Add New Cover Page",array("action"=>"add",$cat_id)); ?>
		</ul>
	</div>
</div>