<?php 

//pr($locale_phrases);

?>
<div class="phrases index">
	<h2><?php __('Phrases');?></h2>
	
	<div style='padding:5px;'>
		<?php echo $this->Form->create("",array("url"=>array("controller"=>"phrases","action"=>"index"))); ?>
		Select Locale: <?php 
		
		echo $this->Form->select("selectLocale",$locales);
		
		?>
		<?php echo $this->Form->end(array("div"=>false,"value"=>"Go")); ?>
	</div>
	<?php 
	echo $this->Admin->adminPaging();
	?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('section');?></th>
			<th><?php echo $this->Paginator->sort('token');?></th>
			<th><?php echo $this->Paginator->sort('value');?></th>
			<th>Translated</th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($phrases as $phrase):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $phrase['Phrase']['id']; ?>&nbsp;</td>
		<td><?php echo $phrase['Phrase']['section']; ?>&nbsp;</td>
		<td><?php echo $phrase['Phrase']['token']; ?>&nbsp;</td>
		<td><?php echo $phrase['Phrase']['value']; ?>&nbsp;</td>
		<td><?php 

		$p = Set::extract("/Phrase[id=".$phrase['Phrase']['id']."]/value",$locale_phrases);
		
		if(count($p)>0) {
			
			echo $p[0];
			
		} else {
			
			echo "<span style='color:red; font-weight:bold;'>None</span>";
			
		}
		
		?></td>
		<td><?php echo $phrase['Phrase']['created']; ?>&nbsp;</td>
		<td><?php echo $phrase['Phrase']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<!-- <?php echo $this->Html->link(__('View', true), array('action' => 'view', $phrase['Phrase']['id'])); ?> -->
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $phrase['Phrase']['id'],"translate_locale"=>$this->Session->read("ControlPanel.translate_locale"))); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $phrase['Phrase']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $phrase['Phrase']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Phrase', true), array('action' => 'add')); ?></li>
	</ul>
</div>