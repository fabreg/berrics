<div class='index'>
	<h1>Manage Berrics Menu</h1>
	<?php 
	
		echo $this->Form->create("DailyopSection",array("url"=>$this->here));
	
	?>
	<table cellspacing='0'>
		<tr>
			<th>Name</th>
			<th>Label Override</th>
			<th>Sort Weight</th>
			<th>&nbsp;</th>
		</tr>
		<?php 
		
			foreach($items as $item):
		
		?>
		<tr>
			<td>
				<?php echo $item['DailyopSection']['name']; ?>
			</td>
			<td><?php echo $this->Form->textarea("nav_label[".$item['DailyopSection']['id']."]",array("value"=>$item['DailyopSection']['nav_label'],"name"=>"data[".$item['DailyopSection']['id']."][nav_label]"));?></td>
			<td><?php echo $this->Form->text("sort_weight[".$item['DailyopSection']['id']."]",array("value"=>$item['DailyopSection']['sort_weight'],"name"=>"data[".$item['DailyopSection']['id']."][sort_weight]")); ?></td>
			<td>
				<?php echo $this->Form->submit("Update"); ?>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
	<?php 
		
		echo $this->Form->end();
	
	?>
</div>