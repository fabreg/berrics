<table cellspacing='0'>
	<tr>
		<th>Key</th>
		<th>Value</th>
		<th>Options</th>
	</tr>
	<?php 
		if(count($dailyops['Meta'])>0):
			$metas = $dailyops['Meta'];
		 	foreach($metas as $meta):
	
	?>
	<tr>
		<td>
			<?php 
			
				echo $meta['key'];
			
			?>
		</td>
		<td>
		
			<?php 
			
				echo $meta['val'];
			
			
			?>
		</td>
		<td class='actions'>
		<!--  HIDDEN FIELDS -->
			
			<input type='hidden' value='<?php echo $meta['DailyopsMeta']['meta_id']; ?>' name='data[Meta][]' />
			
			<a href='' rel='<?php echo $meta['DailyopsMeta']['id']; ?>'>
				Delete
			</a>
		</td>
	</tr>
	<?php 
	
			endforeach;
		endif;
	?>
</table>
