<div class='index'>
<h1>Aberrican Originals Contest</h1>
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
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id");?></th>
			<th><?php echo $this->Paginator->sort("created");?></th>
			<th>User</th>
			<th>-</th>
		</tr>
		<?php 
		
			foreach($files as $file):
			$f = $file['AberricanOriginal'];
			$u = $file['User'];
		?>
		<tr>
			<td><?php echo $f['id']; ?></td>
			<td><?php echo $this->Time->niceShort($f['created']); ?></td>
			<td><a href='/users/edit/<?php echo $u['id']; ?>'><?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?></a>
			<td class='actions'>
				<a href='http://aberricanoriginals.theberrics.com/files/<?php echo $f['file']; ?>' target='_blank'>View Video</a>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>

</div>