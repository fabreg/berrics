<style>
	#browse-table tbody tr td {

		font-size:12px;

	}
</style>

<?php echo $this->Admin->adminPaging(); ?>
<h5>Filter</h5>
<?php echo  $this->Form->create('MediaFile',array(
	"id"=>'MediaFileForm',
	"url"=>"/attach_media/filter"
)); ?>
<div class="row-fluid">
	<div class="span12 well well-small">
		<?php echo $this->Form->input("name"); ?>
		<?php echo $this->Form->input("website_id"); ?>
		<?php echo $this->Form->input("media_type",array("options"=>$mediaTypes,"empty"=>true)) ?>
		<button class="btn btn-primary btn-mini">Filter</button>
	</div>
</div>
<?php echo $this->Form->end(); ?>
<table cellspacing='0' id='browse-table'>
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort("id") ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("UserGroup.name"); ?></th>
			
			<th><?php echo $this->Paginator->sort("first_name"); ?></th>
			<th><?php echo $this->Paginator->sort("last_name"); ?></th>
			<th><?php echo $this->Paginator->sort("email"); ?></th>
			<th>Website</th>
			<th>-</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $k => $user): ?>
		<tr>
			
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php echo $this->Admin->adminPaging(); ?>