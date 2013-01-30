<div class="canteenPromoCodes index">
	<h2><?php echo __('Canteen Promo Codes');?></h2>
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
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th>Icon</th>
			<th><?php echo $this->Paginator->sort('expire_date');?></th>
			<th><?php echo $this->Paginator->sort('start_date');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('rate');?></th>
			<th><?php echo $this->Paginator->sort('promo_type');?></th>
			<th><?php echo $this->Paginator->sort('promo_code');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
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
		<td align='center'>
			<?php echo $this->Media->promoCodeIcon($canteenPromoCode['CanteenPromoCode'],array("h"=>45)); ?>
		</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['expire_date']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['start_date']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['name']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['rate']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['promo_type']; ?>&nbsp;</td>
		<td><?php echo $canteenPromoCode['CanteenPromoCode']['promo_code']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $canteenPromoCode['CanteenPromoCode']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $canteenPromoCode['CanteenPromoCode']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $canteenPromoCode['CanteenPromoCode']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenPromoCode['CanteenPromoCode']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
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
</div>
