<div class='crew-details'>
	<dl>
		<dt>Crew Name:</dt>
		<dd><?php echo strtoupper($posse['YounitedNationsPosse']['name']); ?></dd>
		<dt>Entry Date:</dt>
		<dd><?php echo strtoupper($this->Time->niceShort($posse['YounitedNationsPosse']['created'])); ?></dd>
		<dt>Location:</dt>
		<dd><?php echo strtoupper($posse['YounitedNationsPosse']['geo_formatted']); ?></dd>
	</dl>
	<div class='crew-members-heading'>
		CREW:
	</div>
	<div class='crew-members'>
		<?php 
			$i=1;
			foreach($posse['YounitedNationsPosseMember'] as $p):	
				if(empty($p['name'])) continue;
		?>
		<div class='crew-bit'>
			<span class='number'><?php echo ($i); ?>.</span>
			<span class='label name-label'>NAME:</span>
			<span class='name'>
				<?php echo strtoupper($p['name']); ?>
			</span>
			<span class='label age-label'>AGE:</span>
			<span class='age'>
				<?php echo $p['age']; ?>
			</span>
			<span class='label skater-label'>
				SKATER:
			</span>
			<span class='skater'>
			</span>
			<span class='label filmer-label'>
				FILMER:
			</span>
			<span class='filmer'>
			</span>
			<span class='label editor-label'>
				EDITOR:
			</span>
			<span class='editor'></span>
			<div style='clear:both;'></div>
		</div>
		<?php 
			$i++;
			endforeach;
		
		?>
	</div>
</div>
<pre>
<?php 

//print_r($posse['YounitedNationsPosseMember']);

?>
</pre>