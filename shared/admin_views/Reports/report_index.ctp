<script>

$(document).ready(function() { 


	if(typeof formatIndexLinks == 'function') { 
		formatIndexLinks(); 
		}

	initBootstrap();
});

</script>
<div class='page-header'>
	<h1>Reports</h1>
</div>
<?php 
echo $this->Session->flash();
?>
<div>
<?php echo $this->Admin->adminPaging(); ?>
</div>
<div class='index'>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("report_status"); ?></th>
			<th><?php echo $this->Paginator->sort("report_type"); ?></th>
			<th><?php echo $this->Paginator->sort("title"); ?></th>
			<th><?php echo $this->Paginator->sort("user_id"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($reports as $v): 
		
			$r = $v['Report'];
			$u = $v['User'];
		
		?>
		<tr>
			<td><?php echo $r['id']; ?></td>
			<td><?php echo $this->Time->niceShort($r['created']); ?></td>
			<td><?php 
				
				switch(strtoupper($r['report_status'])) {
					
					case "PENDING":
						echo "<span class='label label-warning'>PENDING</span>";
					break;
					case "COMPLETED":
						echo "<span class='label label-success'>COMPLETED</span>";
					break;
					default:
						echo "<span class='label label-inverse'>{$r['report_status']}</span>";
				}
			
			?></td>
			<td><?php echo strtoupper($r['report_type']); ?></td>
			<td><?php echo $r['title']; ?></td>
			<td>
				<?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?>
			</td>
			<td class='actions'>
								<a href='<?php echo $this->Admin->url(array("action"=>"view",$r['id'])); ?>' class='btn btn-info btn-small' ><i class='icon icon-white icon-eye-open'></i> View </a>
								<a href='<?php echo $this->Admin->url(array("action"=>"view",$r['id'],"?"=>array("print"=>1))); ?>' rel='noAjax' class='btn btn-primary btn-small' target='_blank'><i class='icon icon-white icon-print'></i> Print</a>
			
			
				
			</td>
		</tr>
		<?php endforeach;?>
	</table>
</div>