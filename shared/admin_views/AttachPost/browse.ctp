<?php

echo $this->Form->create('Dailyop',array(
	"id"=>'DailyopForm',
	"url"=>"/attach_post/filter",
	"class"=>"form form-horizontal"
));

?>
<div class="well well-small">
	<h3>Filter Posts</h3>
<?php 

echo $this->Form->input("name");
echo $this->Form->input("sub_title");
echo $this->Form->input("dailyop_section_id",array("options"=>$dailyopSections,"empty"=>true));

?>
<div class="form-actions">
	<button class="btn btn-primary">
		Filter
	</button>
</div>
<?php 

echo $this->Form->end();

?>
</div>
<?php echo $this->Admin->adminPaging(); ?>
<div>
	<table cellspacing='0'>
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort("id") ?></th>
				<th><?php echo $this->Paginator->sort("publish_date") ?></th>
				<th><?php echo $this->Paginator->sort("name") ?></th>
				<th><?php echo $this->Paginator->sort("DailyopSection.name","Section") ?></th>
				<th>-</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $k => $post): ?>
			<tr data-id='<?php echo $post['Dailyop']['id']; ?>' data-section='<?php echo $post['DailyopSection']['name']; ?>' data-name='<?php echo $post['Dailyop']['name'] ?>' data-sub-title='<?php echo $post['Dailyop']['sub_title']; ?>'>
				<td>
					<?php echo $post['Dailyop']['id']; ?>
				</td>
				<td>
					<span class="label"><?php echo $this->Time->niceShort($post['Dailyop']['publish_date']) ?></span>  
				</td>
				<td>
					<?php echo $post['Dailyop']['name']; ?> 
					<div><small><em><?php echo $post['Dailyop']['sub_title']; ?></em></small></div>
				</td>
				<td>
					<?php echo $post['DailyopSection']['name']; ?>
				</td>
				<td class='actions'>
					<button class="btn btn-primary attach-btn"  data-id='<?php echo $post['Dailyop']['id']; ?>'>
						Attach
					</button>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>
<?php echo $this->Admin->adminPaging(); ?>