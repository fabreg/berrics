<?php 

$n = (isset($CanteenOrderNote['CanteenOrderNote'])) ? $CanteenOrderNote['CanteenOrderNote']:$CanteenOrderNote;

$c = $CanteenOrderNote['ChildCanteenOrderNote'];

?>
<table cellspacing='0'>
	<tr>
		<td><?php echo $n['id']?></td>
		<td><?php echo strtoupper($n['note_status']); ?></td>
		<td>
		
		</td>
	</tr>
</table>