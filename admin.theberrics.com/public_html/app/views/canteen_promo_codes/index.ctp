<div class="canteenPromoCodes index">
	<h2><?php __('Canteen Promo Codes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('expire_date');?></th>
			<th><?php echo $this->Paginator->sort('start_date');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('rate');?></th>
			<th><?php echo $this->Paginator->sort('promo_type');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($canteenPromoCodes as $canteenPromoCode):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['id']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['created']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['modified']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['expire_date']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['start_date']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($canteenPromoCode['User']['id'], array('controller' => 'users', 'action' => 'view', $canteenPromoCode['User']['id'])); ?>
		</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['name']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['rate']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['promo_type']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $canteenPromoCode['CanteenPromoCode']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $canteenPromoCode['CanteenPromoCode']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $canteenPromoCode['CanteenPromoCode']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $canteenPromoCode['CanteenPromoCode']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Canteen Promo Code', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>