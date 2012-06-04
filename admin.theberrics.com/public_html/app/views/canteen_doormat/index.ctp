<div class='index'>
	<h2>Canteen Doormat Manager</h2>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("display_weight"); ?></th>
			<th>Media Preview</th>
			<th>-</th>
		</tr>
		<?php 
			foreach($doormats as $doormat): 
			$d = $doormat['CanteenDoormat'];
		?>
		<tr>
			<td><?php echo $d['id']; ?></td>
			<td align='center'><?php echo $d['active']; ?></td>
			<td align='center'><?php echo $d['created']; ?></td>
			<td align='center'><?php echo $d['display_weight']; ?></td>
			<td align='center'>
				<?php if(empty($d['Media']['id'])): ?>
				<?php echo $this->Media->mediaThumb(array(
					"MediaFile"=>$doormat['MediaFile'],
					"w"=>120
				)); ?>
				<?php endif; ?>
				&nbsp;
			</td>
			<td class='actions'>
				<a href='/canteen_doormat/edit/<?php Echo $d['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>