<script>

$(document).ready(function() { 



	var meta_count = $('.meta-item').length;

	$('#meta-badge').html(meta_count);
	
	$('.remove-meta').click(function() { 

		removeMeta($(this).val());

	});

	
});

function removeMeta($id) {
	
	var form = $("#meta-form");

	form.append($("<input />").attr({

		"name":"data[Meta][DeleteMeta]",
		"value":$id,
		"type":"hidden"
		
	}));

	form.attr("autosave","autosave").submit();

	form.removeAttr("autosave");

	
}

</script>
<style>

</style>
<?php 

$url = array(

		"action"=>"handle_tab_save"
		
);

echo $this->Form->create("Dailyop",array("url"=>$url,"id"=>"meta-form"));
echo $this->Form->input("element",array("type"=>"hidden","value"=>"edit-meta"));
echo $this->Form->input("id");

?>
<?php echo $this->Session->flash(); ?>
<h3>Meta Data</h3>
<div class='row-fluid'>
	<div class='span6'>
		<div class='row-fluid'>
			<div class='span6'>
				<?php echo $this->Form->input("Meta.key"); ?>
			</div>
			<div class='span6'>
				<?php echo $this->Form->input("Meta.val"); ?>
			</div>
		</div>
		<div class='form-actions'>
			<button class='btn btn-primary'>Add New Meta</button>
		</div>
	</div>
	<div class='span6'>
		<?php if(count($this->request->data['Meta'])>0): ?>
		<?php foreach($this->request->data['Meta'] as $k=>$v): ?>
		
		<?php if(!($k%2)) echo "<div class='row-fluid'>"; ?>
		
		<div class='span6'>
			<div class='well well-small meta-item'>
				<div>
					<strong>Key: </strong><?php echo $v['key']; ?>
				</div>
				<div>
					<strong>Value: </strong><?php echo $v['val']; ?>
				</div>
				<div>
					<button value='<?php echo $v['DailyopsMeta']['id']; ?>' class='btn btn-danger remove-meta' ><i class='icon icon-white icon-remove-circle'></i> Remove</button>
				</div>
			</div>
		</div>
		<?php if(($k%2) || (count($this->request->data['Meta'])==($k+1))) echo "</div>"; ?>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?php 
echo $this->Form->end();
?>
