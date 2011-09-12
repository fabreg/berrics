<div class="splashPages index">
	<h2><?php __('Splash Pages');?></h2>
	<p>
	<div class='form'>
			<?php
			
				echo $this->Form->create("Search",array("url"=>array("controller"=>"splash_pages","action"=>"splash_filter"))); ?>
				Hide Active
				<?php echo $this->Form->checkbox("active"); ?>
				Hide
				<?php echo $this->Form->input('promo',array('type'=>'checkbox' ,'selected'=>1, 'value'=>1));
				echo $this->Form->end("Filter that shit");
			
			?>
			</div>
			
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
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('promo');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('publish_date');?></th>
			<th><?php echo $this->Paginator->sort('page_title');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($splashPages as $splashPage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $splashPage['SplashPage']['id']; ?>&nbsp;</td>
		<td align='center'><?php 
					
		
				switch($splashPage['SplashPage']['active']) {
					
					
					case 1:
						echo "<span style='color:green'>Yes</span>";
					break;
					default:
						echo "<span style='color:red;'>No</span>";
					break;

				} 
					
			?>&nbsp;</td>
			<td align='center'><?php 
					
		
				switch($splashPage['SplashPage']['promo']) {
					
					
					case 1:
						echo "<span style='color:green'>Yes</span>";
					break;
					default:
						echo "<span style='color:red;'>No</span>";
					break;

				} 
					
			?>&nbsp;</td>
		<td align='center'><?php echo $this->Time->niceShort($splashPage['SplashPage']['modified']); ?>&nbsp;</td>
		<td align='center'><?php echo $this->Time->niceShort($splashPage['SplashPage']['publish_date']); ?>&nbsp;</td>
		
		<td><?php echo $splashPage['SplashPage']['page_title']; ?>&nbsp;</td>

		
		<td class="actions">
			<a href='http://dev.theberrics.com/preview/<?php echo $splashPage['SplashPage']['preview_hash']; ?>' target='_blank'>Preview</a>
			<a href='/splash_pages/edit/<?php echo $splashPage['SplashPage']['id']; ?>'>Edit</a>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $splashPage['SplashPage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $splashPage['SplashPage']['id'])); ?>
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