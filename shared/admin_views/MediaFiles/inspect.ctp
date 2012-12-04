<?php 
$tag_array = Set::extract("/Tag/name",$this->request->data);

$tag_str = implode(",",$tag_array);
?>
<div class='page-header'>
	<h1>Edit Media File</h1>
</div>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#1" data-toggle="tab">General</a></li>
		<?php if ($this->request->data['MediaFile']['media_type'] == "bcove"): ?>
		<li><a href="#2" data-toggle="tab">Video Tasks <span class="badge"><?php echo count($videoTasks); ?></span>	</a></li>
		<?php endif ?>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="1">
			<?php echo $this->Form->create("MediaFile",array("url"=>$this->request->here))?>
				
			<div class='row-fluid'>
				<div class='span6'>
					<fieldset>
						<legend>Details</legend>
						<dl>
							<dt>ID</dt>
							<dd><?php echo $this->request->data['MediaFile']['id']; ?></dd>
						</dl>
						<?php 
							
							echo $this->Form->input("MediaFile.id");
							echo $this->Form->input("MediaFile.name");
							echo $this->Form->input("MediaFile.caption");
							echo $this->Form->input("tags",array("value"=>$tag_str));
							echo $this->Form->submit("Update");
							
						?>
					</fieldset>
					<fieldset>
						<legend>Advertising Tags</legend>
						<div class='alert alert-danger'>These properties only apply to video</div>
						<?php 
							
							echo $this->Form->input("MediaFile.preroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
							echo $this->Form->input("MediaFile.preroll_tags");
							echo $this->Form->input("MediaFile.preroll_label_override");
							echo $this->Form->input("MediaFile.postroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
							echo $this->Form->input("MediaFile.postroll_tags");
							echo $this->Form->input("MediaFile.postroll_label_override");
							echo $this->Form->submit("Update");
							
						?>
					</fieldset>
				</div>
				<div class='span6'>
						<?php 
					
							switch($this->request->data['MediaFile']['media_type']) {
						
								case "bcove":
									echo $this->element("media_files/inspect_video_still");
									echo $this->element("media_files/inspect_limelight");
									break;
								case "img":
									echo $this->element("media_files/inspect_image");
									echo $this->element("media_files/inspect_image_link");
									break;
								
							}
						?>
				</div>
			</div>
			<?php 
			
				echo $this->Form->end("Update");
			
			?>

		</div>
		<div class="tab-pane" id="2">
			<?php if (isset($videoTasks)): ?>
				<table cellspacing="0">
					<thead>
						<tr>
							<th>Id</th>
							<th>Created/Modified</th>
							<th>TaskStatus</th>
							<th>Server</th>
							<th>Task</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($videoTasks as $k => $v): ?>
						<tr>
							<td><?php echo $v['VideoTask']['id']; ?></td>
							<td><?php echo $this->Time->niceShort($v['VideoTask']['created']); ?> - <?php echo $this->Time->niceShort($v['VideoTask']['modified']); ?></td>
							<td><span class="label label-info"> <?php echo strtoupper($v['VideoTask']['task_status']); ?></span></td>
							<td><?php echo $v['VideoTask']['server'] ?></td>
							<td><?php echo strtoupper($v['VideoTask']['task']) ?></td>
							<td></td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
	</div>
</div>
	