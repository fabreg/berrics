<div class="modal-header">
	<h4>
		<?php echo $post['Dailyop']['name']; ?>
		<?php 
			if (!empty($post['Dailyop']['sub_title'])) {
				echo " - ".$post['Dailyop']['sub_title'];
			}
		 ?>
	</h4>
</div>
<div class="modal-content">
	<div class="row-fluid">
		<div class="span12" style='padding:5px;'>
			<?php foreach ($params as $k => $v): ?>
				<div class='well well-small'>
					<h5>
						<?php echo strtoupper($v['DailyopsShareParameter']['service']); ?>
					</h5>
					<div>
						<?php 
							$lnk = "http://youtube.com/watch?v={$v['DailyopsShareParameter']['foreign_key']}";
						?>
						<a href="<?php echo $lnk; ?>" target='_blank'><?php echo $lnk; ?></a>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-danger" data-dismiss="modal">
		Close
	</button>
</div>