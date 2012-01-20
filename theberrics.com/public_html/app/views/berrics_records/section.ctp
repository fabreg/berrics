<div>
	<?php foreach($records as $record): ?>
	<div class='record-plaq'>
		<?php echo strtoupper($record['BerricsRecord']['record_name']); ?>
		<?php foreach($record['BerricsRecordsItem'] as $item):?>
			<div class='badge'>
				<div class='name'><?php echo strtoupper($item['User']['first_name']); ?> <?php echo strtoupper($item['User']['last_name']); ?></div>
				<div class='result-label'><?php echo strtoupper($item['result_label']); ?></div>
				<div class='date'><?php echo strtoupper($this->Time->niceShort($item['Post']['Dailyop']['publish_date'])); ?></div>
			</div>
		<?php endforeach;?>
	</div>
	<?php endforeach; ?>
</div>