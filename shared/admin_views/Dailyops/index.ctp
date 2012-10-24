<script>
$(document).ready(function() { 


	$("a[rel=toggle-search]").click(function() { 

		$("#search").toggle();
		return false;

	});

	
	$("#dupe_uri_button").click(function() { 

		$("tr[dailyop_id]").each(function() { 

			var id=$(this).attr("dailyop_id");
			var sid=$(this).attr("section_id");
			var uri = $(this).attr("uri");
			dupe_uri_check(id,sid,uri);
		});

	});
	
});


function dupe_uri_check(dailyop_id,section_id,uri) {

	
	$.ajax({

		"url":"/dailyops/dupe_uri_check/"+dailyop_id+"/"+section_id+"/"+uri,
		"success":function(d) {
			var color = "green";
			var msg = "(OK)"
			if(d==0) {
	
				color="red";
				msg="(Duplicate Found)";
				
			} 
		 	$("tr[dailyop_id="+dailyop_id+"]").find(".uri").append("<span style='color:"+color+";'>"+msg+"</span>");
		
		}

	});
	
	
}

</script>
<style>
#dopt {

	font-size:95%;

}
.table td, .table th {

	font-size:12px;

}

</style>
<div class="dailyops index">
	<div class='page-header'>
		<h1>The Dailyops</h1>
	</div>
	<div>
		<ul class='nav nav-tabs'>
			<li class='dropdown'>
				<a href='#' data-toggle='dropdown' class="dropdown-toggle">Actions <b class='caret'></b></a>
				<ul class='dropdown-menu'>
					<li>
						<a><i class='icon-plus-sign'></i> Add New Post</a>
					</li>
				</ul>
			</li>
			<li><a href='#search' data-toggle='tab'>Search Posts</a></li>
		</ul>
		<div class='tab-content'>
			<div class='tab-pane well' id='search'>
			<?php 
						
					$this->Form->formSpan = "span9";
					
						echo $this->Form->create("Dailyop",array("url"=>array("action"=>"search")));
					?>
					<?php echo $this->Form->input("name"); ?>
					<?php echo $this->Form->input("sub_title"); ?>
					<?php echo $this->Form->input("DailyopSection",array("empty"=>"All *")); ?>
					<div class='form-actions'>
						<?php 
						echo $this->Form->submit("Run Filter");
						?>
					</div>
					<?php 
					
						
						
						echo $this->Form->end();
					?>
			</div>
		</div>
	</div>
	
	<?php echo $this->Admin->adminPaging(); ?>
	<table cellpadding="0" cellspacing="0" id='dopt'>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort("active"); ?>
			<th><?php echo $this->Paginator->sort("hidden"); ?></th>
			
			
			<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
			<th><?php echo $this->Paginator->sort('dailyop_section_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			

			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($dailyops as $dailyop):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr dailyop_id='<?php echo $dailyop['Dailyop']['id']; ?>' section_id='<?php echo $dailyop['DailyopSection']['id']; ?>' uri='<?php echo $dailyop['Dailyop']['uri']; ?>'>
		<td><?php echo $dailyop['Dailyop']['id']; ?>&nbsp;</td>
		<td><?php 
				
			switch($dailyop['Dailyop']['active']) {
				
				case 1:
					echo "<span class='label label-success'>Active</span>";
				break;
				default:
					echo "<span class='label label-important'>Disabled</span>";
				break;
				
			}
		
		?></td>
			<td><?php 
				
			switch($dailyop['Dailyop']['hidden']) {
				
				case 0:
					echo "<span class='label label-success'>Visible</span>";
				break;
				default:
					echo "<span class='label label-inverse'>Hidden</span>";
				break;
				
			}
		
		?></td>
		
		
		<td><?php echo $this->Time->niceShort($dailyop['Dailyop']['publish_date']); ?></td>
		<td>
			<?php echo $this->Admin->link($dailyop['DailyopSection']['name'], array('controller' => 'dailyop_sections', 'action' => 'view', $dailyop['DailyopSection']['id'])); ?>
		</td>
		<td>
			<?php echo $dailyop['Dailyop']['name']; ?>
			<div><small><?php echo $dailyop['Dailyop']['sub_title']; ?></small></div>
			<div><small>
			<?php 
			
				$uri = "/".$dailyop['DailyopSection']['uri']."/".$dailyop['Dailyop']['uri'];
				echo "<a href='http://dev.theberrics.com{$uri}' target='_blank'>{$uri}</a>"
				
			?>
			</small></div>
		</td>
		<td>
			<?php echo $this->Admin->link($dailyop['User']['last_name'].", ".$dailyop['User']['first_name']." ( ".$dailyop['User']['email']." )", array('controller' => 'users', 'action' => 'view', $dailyop['User']['id'])); ?>
		</td>
		<td><?php echo $this->Time->niceShort($dailyop['Dailyop']['modified']); ?>&nbsp;</td>
		
		<td class="actions">
			<?php //echo $this->Admin->link("View", "http://dev.theberrics.com/dailyops/view/".$dailyop['Dailyop']['id']."/".$dailyop['Dailyop']['uri'],array("target"=>"_blank")); ?>
			<div class='btn-toolbar'>
			<div class='btn-group dropdown'>
				<a class='btn btn-primary btn-small' href='<?php echo $this->Admin->url(array("controller"=>"dailyops","action"=>"edit",$dailyop['Dailyop']['id'])); ?>' >
					<i class='icon-edit icon-white'></i> Edit
				</a>
				<a class='btn btn-primary btn-small' data-toggle='dropdown'><b class='caret'></b></a>
				<ul class='dropdown-menu pull-right'>
					<li>
						<a class='none' href='<?php echo $this->Admin->url(array("controller"=>"dailyops","action"=>"edit",$dailyop['Dailyop']['id'])); ?>' target='_blank'>Edit in new window</a>
					</li>
				</ul>
							
				
			</div>
			<div class='btn-group'>
							<?php echo $this->Admin->link(__('Delete', true), array('action' => 'delete', $dailyop['Dailyop']['id']),array("confirm"=>"Are you sure you want to delete this post?")); ?>
				
			</div>
			</div>
			
			
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Admin->adminPaging(); ?>
</div>
