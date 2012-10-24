<div class='index'>
	<?php foreach($xml->Package->Service as $Service): ?>
		<table cellspacing='0'>
		<?php foreach($Service as $sk=>$sv): ?>
			<tr>
				<td width='20%' align='right'><?php echo $sk; ?></td>
				<td><?php echo $sv; ?></td>
			</tr>
		<?php endforeach; ?>
		</table><br />
	<?php endforeach;?>
	<pre style='overflow:auto;'>
	<?php //echo $xml->Package->Observations; ?>
	</pre>
	
</div>
<pre>
<?php
//print_r($xml);
?>
</pre>