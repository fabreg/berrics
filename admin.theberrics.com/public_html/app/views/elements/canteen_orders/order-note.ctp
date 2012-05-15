<?php 

$n = (isset($CanteenOrderNote['CanteenOrderNote'])) ? $CanteenOrderNote['CanteenOrderNote']:$CanteenOrderNote;

$c = $CanteenOrderNote['ChildCanteenOrderNote'];

if(!isset($show_header)) $show_header = false;

?>
<table cellspacing='0'>
	<?php if($show_header): ?>
	<tr>
		<th>ID</th>
		<th>Created</th>
		<th>Status</th>
		<th>Name</th>
		<th>Message</th>
	</tr>
	<?php endif; ?>
	
	<?php if(count($c)>0): ?>
		<?php foreach($c as $k=>$v): ?>
	<tr>
		<td width='1%'><?php echo $n['id']?></td>
		<td width='1%'><?php echo $this->Time->niceShort($n['created']); ?></td>
		<td width='1%'><?php echo strtoupper($n['note_status']); ?></td>
		<td>
			<?php if(isset($n['User']['id'])): ?>
				<?php echo $n['User']['first_name']; ?> <?php echo $n['User']['last_name']; ?>
			<?php else: ?>
				CUSTOMER
			<?php endif; ?>
		</td>
		<td><?php echo nl2br($n['message']); ?></td>
	</tr>
		<?php endforeach; ?>
	<?php endif; ?>
</table>