<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$( "#TrendingPostDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

});

</script>
<div class="page-header">
	<h1>Trending Posts</h1>
</div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="#2" data-toggle="tab">Filter</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="2">
			<div class="well well-small">
				<?php 
					echo $this->Form->create('TrendingPost',array(
						"id"=>'TrendingPostForm',
						"url"=>array("action"=>"search")
					));
				 ?>
				 <?php 

				 	echo $this->Form->input("section",array("options"=>TrendingPost::sections(),"empty"=>true));
				 	echo $this->Form->input("date",array("text"));
				  ?>
				 
				 	<button class="btn btn-primary">Filter</button>
				 
				 <?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<div class="trendingPosts index">
	<?php echo $this->Admin->adminPaging(); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('dailyop_id'); ?></th>
			<th><?php echo $this->Paginator->sort('display_weight'); ?></th>
			<th><?php echo $this->Paginator->sort('section'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date'); ?></th>
			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($trendingPosts as $trendingPost): ?>
	<tr>
		<td><?php echo $trendingPost['TrendingPost']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($trendingPost['TrendingPost']['modified']); ?>&nbsp;</td>
		<td><?php echo $trendingPost['Dailyop']['name']; ?> <?php echo $trendingPost['Dailyop']['sub_title']; ?>&nbsp;</td>
		<td><?php echo $trendingPost['TrendingPost']['display_weight']; ?>&nbsp;</td>
		<td><?php echo $trendingPost['TrendingPost']['section']; ?>&nbsp;</td>
		<td><?php echo $this->time->niceShort($trendingPost['TrendingPost']['start_date']); ?>&nbsp;</td>
		<td><?php echo $this->time->niceShort($trendingPost['TrendingPost']['end_date']); ?>&nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $trendingPost['TrendingPost']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $trendingPost['TrendingPost']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $trendingPost['TrendingPost']['id']), null, __('Are you sure you want to delete # %s?', $trendingPost['TrendingPost']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Admin->adminPaging(); ?>
</div>
