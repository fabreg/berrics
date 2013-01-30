<div class='index'>

	<h2>La Jolla Products File</h2>
	<table cellspacing='0'>
		<tr>
			<th>-</th>
			<?php foreach($schema as $v): ?>
			<th><?php echo $v; ?></th>
			<?php endforeach; ?>
		</tr>
		<?php foreach($ljg_products as $k=>$v): 
			
		?>
		<tr>
			<td><input type='checkbox' value='<?php echo $k; ?>' name='data[index][]' /></td>
			<?php foreach($schema as $s):?>
			<td><?php echo $v[$s]; ?></td>
			<?php endforeach; ?>
		</tr>
		<?php endforeach; ?>
	</table>
	
</div>