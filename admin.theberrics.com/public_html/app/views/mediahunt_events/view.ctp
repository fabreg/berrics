<div class='index'>
	<h2>
		Event: <?php echo $mediahuntEvent['MediahuntEvent']['name']; ?>
	</h2>
	<div>
		<fieldset>
			<legend>Actions</legend>
			<ul class='actions'>
			<li>
				<a href='/mediahunt_tasks/add/mediahunt_event_id:<?php echo $mediahuntEvent['MediahuntEvent']['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'>Add New Task</a>
			</li>
		</ul>
		<div style='clear:both;'></div>
		</fieldset>
	</div>
	<div>
		<div style='float:left; width:49%;'>
			<h3>Tasks</h3>
			<div>
				<table cellspacing='0'>
					<tr>
						<th width='1%'>SortOrder</th>
						<th>Name</th>
						<th>Publish Date</th>
						<th width='1%'>Active</th>
						<th>UploadCount</th>
						<th>-</th>
					</tr>
					<?php foreach($tasks as $task): ?>
					<tr>
						<td align='center'><?php echo $task['MediahuntTask']['sort_order']; ?></td>
						<td><?php echo $task['MediahuntTask']['name']; ?> <span style='font-size:10px; font-style:italic;'>(ID: <?php echo $task['MediahuntTask']['id']; ?>)</span>
						<div style='font-style:italic;'>
							<strong>Details:</strong> <?php echo $task['MediahuntTask']['details']; ?>
						</div>
						</td>
						<td align='center'>
							<?php echo $this->Time->niceShort($task['MediahuntTask']['publish_date']); ?>
						</td>
						<td align='center'>
							<?php 
								switch($task['MediahuntTask']['active']) {
									
									case 1:
										echo "<span style='color:green;'>Yes</span>";
									break;
									default:
										echo "<span style='color:red;'>No</span>";
									break;
									
								}
							?>
						</td>
						<td>A:<?php echo $task['MediahuntEvent']['UploadApproved']; ?>/T:<?php echo $task['MediahuntEvent']['UploadCount']; ?></td>
						<td class='actions'>
							<?php 
								
								echo $this->Html->link("Edit",array("controller"=>"mediahunt_tasks","action"=>"edit",$task['MediahuntTask']['id'],"callback"=>base64_encode($this->here))); 
								
								echo $this->Html->link("View Entries",array(
																		"controller"=>"mediahunt_media_items",
																		"action"=>"index",
																		"search"=>1,
																		"MediahuntMediaItem.mediahunt_task_id"=>$task['MediahuntTask']['id']
																		),array("target"=>"_blank"));
								
							?>
							<a target='_blank' href='http://theberrics.com/levis-nike-picture-perfect/gallery/<?php echo $task['MediahuntTask']['id']; ?>'>Gallery View ( There needs to be approved images for it to work )</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
		<div style='float:left; width:49%;'>	
			<h3>Recently Submitted</h3>
			<table cellspacing='0'>
				<tr>
					<th>Image</th>
					<th>Date</th>
					<th>Task</th>
					<th>User</th>
					<th>-</th>
				</tr>
				<?php foreach($uploads as $u): 
					$m = $u['MediahuntMediaItem'];
					$t = $u['MediahuntTask'];
					$u = $u['User'];
				?>
				<tr>
					<td>
						<a href='http://img.theberrics.com/mediahunt-media/<?php echo $m['file_name']; ?>' target='_blank'>
							<img src='http://img.theberrics.com/i.php?src=/mediahunt-media/<?php echo $m['file_name']; ?>&h=75&w=75' border='0'/>
						</a>
					</td>
					<td>
						<?php echo $this->Time->niceShort($m['created']); ?>
					</td>
					<td>
						<?php echo $t['name'];  ?>
					</td>
					<td>
						<?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?> 
						<span style='font-style:italic;'><a href='/users/edit/<?php echo $u['id']; ?>' target='_blank'>Edit</a></span>
					</td>
					<td class='actions'>
						<?php echo $this->Html->link("Approve",array("controller"=>"mediahunt_media_items","action"=>"approve",$m['id'],"callback"=>base64_encode($this->here))); ?>
						<?php echo $this->Html->link("Shit Can",array("controller"=>"mediahunt_media_items","action"=>"delete",$m['id'],"callback"=>base64_encode($this->here))); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	
		<div style='clear:both'></div>
	</div>
</div>