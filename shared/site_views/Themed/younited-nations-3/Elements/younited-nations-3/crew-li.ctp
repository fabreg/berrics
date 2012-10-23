<ul class='crew-list'>
	<?php foreach($entries['entries'] as $e): 

		if(strlen($e['YounitedNationsPosse']['name'])<=0) continue;
	
	?>
	<li country='<?php echo $e['YounitedNationsPosse']['country']; ?>' posse_id='<?php echo $e['YounitedNationsPosse']['id']; ?>'>
		<div class='info'>
			<?php echo $this->Text->truncate(strtoupper($e['YounitedNationsPosse']['name']),29); ?>
			<div class='entry-date'>Entry Date: <?php echo $this->Time->niceShort($e['YounitedNationsPosse']['created']); ?></div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>
<div style='clear:both;'></div>