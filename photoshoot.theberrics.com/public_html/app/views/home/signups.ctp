
<style>

div.index table {

	width:98%;
	border:1px solid #cccccc;
	border-bottom:none;
	border-left:none;
	margin:auto;
}

div.index table th {

	font-size:80%;
	font-weight:bold;
	background-color:#999999;
	padding:4px;
	border:1px solid #cccccc;
	border-top:none;
	border-right:none;
}

div.index td {
	
	font-size:80%;
	padding:4px;
	border:1px solid #cccccc;
	border-top:none;
	border-right:none;
}

div.index tr {
	
}

div.index tr:nth-child(odd) {
	
	background-color:#e9e9e9;	
	
}

div.index table a {

	color:#333333;
		
}

div.index table .actions {

	text-align:center;	
	padding:4px;
}
#content {

	width:100%;

}

div.paging {

	background-color:transparent;


}

</style>


<div class="users index">
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
			<th><?php echo $this->Paginator->sort("last_name"); ?></th>
			<th><?php echo $this->Paginator->sort("first_name"); ?></th>
			<th><?php echo $this->Paginator->sort("email"); ?></th>
			<th><?php echo $this->Paginator->sort("country"); ?></th>
			<th><?php echo $this->Paginator->sort("province"); ?></th>
			
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td style='font-size:10px;'><?php echo $user['User']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($user['User']['created']); ?>&nbsp;</td>
		<td><?php echo $user['User']['last_name']; ?></td>
		<td><?php echo $user['User']['first_name']; ?></td>
		<td><?php echo $user['User']['email']; ?></td>
		<td><?php echo $user['User']['country']; ?></td>
		<td><?php echo $user['User']['province']; ?></td>
		
	</tr>
<?php endforeach; ?>
	</table>
</div>