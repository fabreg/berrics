<script>
$(document).ready(function() { 

	
});

function userSelected(user) {

	$("#BerricsRecordsItemUserId").val(user['User']['id']);
	$("#record-user").html(user['User']['first_name']+" "+user['User']['last_name']);
	UserSearch.closeModal();
}

</script>
<div class='form'>
	<h2>Edit Berrics Record</h2>
	
	<fieldset>
		<legend>General Info</legend>
		<?php echo $this->Form->create("BerricsRecord"); ?>
		<?php 
			echo $this->Form->input("id",array("type"=>"hidden"));
			echo $this->Form->input("active");
			echo $this->Form->input("record_name");
		?>
		<?php echo $this->Form->end("Update Record"); ?>
	</fieldset>
</div>
<div style='width:95%; margin:auto;'>
	<fieldset>
		<legend>Attached Posts</legend>
		<div class='index'>
			<?php if(count($this->data['BerricsRecordsItem'])<=0): ?>
				<div style='padding:10px; font-weight:bold; color:Red;'>No Posts have been attached</div>
			<?php else: ?>
				<table cellspacing='0'>
					<tr>
						<th>User</th>
						<th>Dailyops Post</th>
						<th>Result Label</th>
						<th>Active</th>
						<th>Current Record</th>
						<th>-</th>
					</tr>
					<?php foreach($this->data['BerricsRecordsItem'] as $item):?>
					<tr>
						<td align='center'><?php echo $item['User']['first_name']; ?> <?php echo $item['User']['last_name']; ?></td>
						<td><?php echo $item['Dailyop']['name']; ?> - <?php echo $item['Dailyop']['sub_title']; ?></td>
						<td  align='center'><?php echo $item['result_label']; ?></td>
						<td align='center'>
							<?php 
							
								echo $this->Form->create("BerricsRecordsItem",array("url"=>"update_item_active"));
								echo $this->Form->input("active",array(
									"options"=>array(
										"No",
										"Yes"
									),"value"=>$item['active'],"label"=>false,"div"=>false
								));
								echo $this->Form->input("id",array("value"=>$item['id'],"type"=>"hidden"));
								echo $this->Form->input("berrics_record_id",array("value"=>$this->data['BerricsRecord']['id'],"type"=>"hidden"));
								echo $this->Form->submit("Update",array("div"=>false));
								echo $this->Form->end();
							?>
						</td>
						<td align='center'>
						<?php 
							
								echo $this->Form->create("BerricsRecordsItem",array("url"=>"update_current_record_item"));
								echo $this->Form->input("current_record",array(
									"options"=>array(
										"No",
										"Yes"
									),"value"=>$item['current_record'],"label"=>false,"div"=>false
								));
								echo $this->Form->input("id",array("value"=>$item['id'],"type"=>"hidden"));
								echo $this->Form->input("berrics_record_id",array("value"=>$this->data['BerricsRecord']['id'],"type"=>"hidden"));
								echo $this->Form->submit("Update",array("div"=>false));
								echo $this->Form->end();
							?>
						</td>
						
						<td class='actions'>
							<a href='/berrics_records/delete_item/<?php echo $item['id']?>/<?php echo $item['berrics_record_id']; ?>' onclick='return confirm("Are you sure you want to delete this item?");'>Delete</a>
						</td>
					</tr>
					<?php endforeach;?>
				</table>
				
			<?php endif; ?>
		</div>
	</fieldset>
</div>
<div class='form'>
	<fieldset>
		<legend>Attach A Post</legend>
		<?php 
			echo $this->Form->create("BerricsRecordsItem",array("url"=>"/berrics_records/add_berrics_records_item"));
			echo $this->Form->input("BerricsRecordsItem.result_label");
			echo $this->Form->input("BerricsRecordsItem.berrics_record_id",array("value"=>$this->data['BerricsRecord']['id'],"type"=>"hidden"));
			echo $this->Form->input("BerricsRecordsItem.dailyop_id",array("options"=>$dailyopsList));
			echo $this->Form->input("BerricsRecordsItem.user_id",array("type"=>"hidden"));
		?>
			<div>
				<label>User:</label> 
				<span id='record-user'>
					<?php 
						if($e=1):
					?>
					
					<?php 
						else:
					?>
					<span style='color:red;'>No User Selected. </span>
					<?php 
						endif;
					?>
				</span>
			</div>
			<div><a href='javascript:UserSearch.openSearch("userSelected"); '>Click Here To Search Users</a></div>
			<?php echo $this->Form->end("Attach Post");?>
	</fieldset>
	
</div>