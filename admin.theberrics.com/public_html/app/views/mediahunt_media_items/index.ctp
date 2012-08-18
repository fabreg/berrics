<div class="mediahuntMediaItems index">
	<h2><?php __('Mediahunt Media Items');?></h2>
	
	<div class='form'>
		<fieldset>
			<legend>Filter</legend>
			<?php 
				echo $this->Form->create("MediahuntMediaItem",array("url"=>array("action"=>"search")));
				echo $this->Form->input("approved",array("options"=>array(0=>"Un-Approved",1=>"Approved"),"empty"=>true));
				echo $this->Form->input("mediahunt_task_id",array("options"=>$mediahuntTaskSelect,"empty"=>true));
				echo $this->Form->end("Filter Results");
			?>
		</fieldset>
	</div>
	
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
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('approved');?></th>
			<th>User</th>
			

			<th>File</th>
			
			<th><?php echo $this->Paginator->sort('rank');?></th>
			<th><?php echo $this->Paginator->sort('mediahunt_task_id');?></th>
			<th>LINK</th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($mediahuntMediaItems as $mediahuntMediaItem):
		$mi = $mediahuntMediaItem['MediahuntMediaItem'];
		$u = $mediahuntMediaItem['User'];
		$t = $mediahuntMediaItem['MediahuntTask'];
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $mi['id']; ?></td>
		<td><?php echo $this->Time->niceShort($mi['created']); ?></td>
		<td><?php echo $mi['approved']; ?></td>
		<td>
			<?php echo $u['first_name']; ?> <?php Echo $u['last_name']; ?>
		</td>
		<td>
			<a href='http://img.theberrics.com/mediahunt-media/<?php echo $mi['file_name'];  ?>' target='_blank'>
				<img border='0' src='http://img.theberrics.com/i.php?src=/mediahunt-media/<?php Echo $mi['file_name']; ?>&w=100'  />
			</a>
		</td>
		<td>
			<?php 
			
				echo $this->Form->create("MediahuntMediaItem",array("url"=>array("action"=>"update_rank")));
				echo $this->Form->input("rank",array("value"=>$mi['rank'])); 
				echo $this->Form->input("callback",array("type"=>"hidden","value"=>base64_encode($this->here)));
				echo $this->Form->input("id",array("type"=>"hidden","value"=>$mi['id']));
				echo $this->Form->end("Update Rank");
					
			?>
		</td>
		<td><?php echo $t['name']; ?></td>
		<td>
			LEVIS PAGE LINK: <a href='http://theberrics.com/levis-nike-picture-perfect/image/<?php echo $mi['id']; ?>'>CLICK</a><br />
		</td>
		<td class="actions">
			<?php echo $this->Html->link("Approve",array("action"=>"approve",$mi['id'],"callback"=>base64_encode($this->here))); ?>
			<?php echo $this->Html->link("Shit Can",array("action"=>"delete",$mi['id'],"callback"=>base64_encode($this->here))); ?>
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
