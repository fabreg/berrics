<script type="text/javascript">
jQuery(document).ready(function($) {
	
	getYoutube();

});

function getYoutube() {
	
	$("#youtube").load(
		"/dailyops/ajax_list_youtube?t=1"
	).html("<div class='alert'>Loading Youtube Videos</div>");

}

</script>
<div class="page-header">
	<h1>Dailyops Sharing</h1>
</div>
<?php 

	echo $this->Form->create('VideoTask',array(
		"id"=>'VideoTaskForm',
		"url"=>$this->request->here
	));

?>

<button class="btn btn-primary">Process Posts</button>

<div class="row-fluid">
	<div class="span12">
		<table>
			<thead>
				<tr>
					<th>Post</th>
					<th>Youtube Data</th>
					<th>Vimeo Data</th>
				</tr>
			</thead>
			<tbody>
				<?php 

					foreach ($posts as $k => $v): 

					$yt = Set::extract("/DailyopsShareParameters[service=youtube]");

				?>
				<tr>
					<td>
						<div>
							<?php echo $v['Dailyop']['name'] ?>
							<?php if(!empty($v['Dailyop']['sub_title'])) echo "-".$v['Dailyop']['sub_title']; ?>
							<?php echo $this->Form->input("foreign_key.{$k}",array("type"=>"hidden","value"=>$v['Dailyop']['id'])); ?>
						</div>
						<div>
							<small><?php echo $v['DailyopSection']['name']; ?></small>
						</div>
					</td>
					<td class='youtube' data-youtubeid=''>
						
					</td>
					<td></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?php 

echo $this->Form->end();

 ?>