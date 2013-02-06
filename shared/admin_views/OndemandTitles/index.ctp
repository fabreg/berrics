<div class="page-header">
	<h1>OnDemand Titles</h1>
</div>
<ul class="nav nav-tabs">
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Actions <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li><a href="<?php echo $this->Html->url(array("controller"=>"ondemand_titles","action"=>"add")); ?>">Add New Title</a></li>

		</ul>
	</li>
</ul>
<?php echo $this->Admin->adminPaging(); ?>
<div class="row-fluid">
	<div class="span12">
		<table cellspacing='0'>
			<tr>
				<th><?php echo $this->Paginator->sort("id"); ?></th>
				<th><?php echo $this->Paginator->sort("active")?></th>
				<th><?php echo $this->Paginator->sort("modified"); ?></th>
				<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
				<th><?php echo $this->Paginator->sort("release_date"); ?></th>
				<th><?php echo $this->Paginator->sort("title"); ?></th>
				<th>-</th>
			</tr>
			<?php 
				foreach($ondemandTitles as $title):
						$t = $title['OndemandTitle']; 
			?>
			<tr>
				<td align='center' width='2%' nowrap><?php echo $t["id"]; ?></td>
				
				<td  align='center' width='2%' nowrap>
				<?php 
				
					switch($t["active"]) {
					
						case "1":
							echo "<span style='color:green;'>Yes</span>";
						break;
						default:
							echo "<span style='color:red;'>No</span>";
						break;
						
					} 

				?>
				</td>
				<td align='center' width='5%' nowrap><?php echo $this->Time->niceShort($t["modified"]); ?></td>
				<td align='center' width='5%' nowrap><?php echo $this->Time->niceShort($t["publish_date"]); ?></td>
				<td align='center' width='5%' nowrap><?php echo $this->Time->niceShort($t["release_date"]); ?></td>
				
				<td><?php echo$t["title"]; ?></td>
				<td class='actions'>
					<a class='btn btn-primary' href='/ondemand_titles/edit/<?php echo $t['id']; ?>/<?php echo base64_encode($this->request->here); ?>'><i class="icon icon-white icon-edit"></i> Edit</a>
				</td>
			</tr>	
			<?php endforeach; ?>
		</table>
	</div>
</div>
<?php echo $this->Admin->adminPaging(); ?>