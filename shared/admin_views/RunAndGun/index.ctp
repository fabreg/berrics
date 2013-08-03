<script>
jQuery(document).ready(function($) {
	
	grabScores();

});
	
function grabScores () {
	
	$('tr[data-post-id]').each(function() {

		var $scoreTd = $(this).find('.average-score');
		var $totalTd = $(this).find('.total-votes');
		var $id = $(this).attr('data-post-id');

		$scoreTd.html('Loading...');
		$totalTd.html('Loading...');


		$.ajax({

			dataType:'json',
			url:"/run_and_gun/grab_score/"+$id+"?t=1",
			success:function(d) {

				console.log(d);
				$scoreTd.html(d.average);
				$totalTd.html(d.total_votes);

			}


		});

	});
	
}

</script>
<style>

.total-votes,.average-score {

	text-align: center;
	font-size:22px;
	font-weight: bold;

}	

</style>
<?php if (!$this->request->is('ajax')): ?>
<div class="page-header">
	<h1>Run And Gun</h1>
</div>  	 
<?php else: ?>
<h3>Run & Gun</h3>
<?php endif; ?>

<table cellpadding='0'>
	<tr>
		<?php if (!$this->request->is('ajax')): ?>
		<th>PostID</th>
		<th>Publish Date</th>	  	 
		<?php endif; ?>
		
		<th>Title</th>
		<th>Total Votes</th>
		<th>Average Score</th>
		<?php if (!$this->request->is('ajax')): ?>
		<th>Actions</th>  	 
		<?php endif; ?>
		
	</tr>
	<?php foreach ($posts as $k => $v): ?>
	<tr data-post-id='<?php echo $v['Dailyop']['id']; ?>'>
		<?php if (!$this->request->is('ajax')): ?>
		<td><?php echo $v['Dailyop']['id']; ?></td>
		<td><?php echo $this->Time->niceShort($v['Dailyop']['publish_date']) ?></td>
		<?php endif; ?>
		<td><?php echo $v['Dailyop']['name'] ?> - <?php echo $v['Dailyop']['sub_title']; ?></td>
		<td class='total-votes'></td>
		<td class='average-score'></td>
		<?php if (!$this->request->is('ajax')): ?>
		<td>
			<a href="/dailyops/edit/<?php echo $v['Dailyop']['id']; ?>" class="btn btn-primary">Edit</a>
		</td>
		<?php endif; ?>
	</tr>
	<?php endforeach ?>
</table>