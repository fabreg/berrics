<div>
	<div style='float:left; width:35%;'>
		<?php echo $this->Form->input("Meta.key",array("name"=>"data[NewMetaKey]")); ?>
	</div>
	<div style='float:left; width:35%;'>
		<?php echo $this->Form->input("Meta.value",array("name"=>"data[NewMetaVal]")); ?>
	</div>
	<div style='clear:both;'></div>
	<?php echo $this->Form->submit("AddMeta",array("name"=>"data[AddMeta]")); ?>
</div>
<?php 
if(count($this->data['Meta'])>0):
?>

	<table cellspacing='0'>
		<tr>
			<th>Key</th>
			<th>Value</th>
			<th>-</th>
		</tr>
		<?php 
			foreach($this->data['Meta'] as $k=>$m):
		?>
			<tr>
				<td><?php echo $this->Form->input("Meta.{$k}",array("value"=>$m['id'],"type"=>"hidden")); ?><?php echo $m['key']; ?></td>
				<td><?php echo $m['val']; ?></td>
				<td class='actions'>
					<?php echo $this->Form->submit("RemoveMeta",array("name"=>"data[RemoveMeta][{$m['id']}]")); ?>
				</td>				
			</tr>	
		<?php 
			endforeach;
		?>
	</table>

<?php 	
endif;
?>