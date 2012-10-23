<?php 

$posse_check = false;

foreach($posse['YounitedNationsPosseMember'] as $p) if(!empty($p['name'])) $posse_check = true;


?>
<div class='crew-details'>
	<dl>
		<dt>Crew Name:</dt>
		<dd><?php echo strtoupper($posse['YounitedNationsPosse']['name']); ?></dd>
		<dt>Entry Date:</dt>
		<dd><?php echo strtoupper($this->Time->niceShort($posse['YounitedNationsPosse']['created'])); ?></dd>
		<dt>Location:</dt>
		<dd><?php echo $this->Text->truncate(strtoupper($posse['YounitedNationsPosse']['geo_formatted']),40); ?></dd>
	</dl>
	<?php if(!$posse_check): ?>
	<div style='padding:10px; text-align:center;'>NO CREW MEMBERS ADDED!!!</div>
	<?php else: ?>
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
			<?php 
			
				if($p['skater']) {
					
					echo "X";
					
				} else {
					
					echo "&nbsp;";
					
				}
			
			?>
			</span>
			<span class='label filmer-label'>
				FILMER:
			</span>
			<span class='filmer'>
			<?php 
			
				if($p['filmer']) {
					
					echo "X";
					
				} else {
					
					echo "&nbsp;";
					
				}
			
			?>
			</span>
			<span class='label editor-label'>
				EDITOR:
			</span>
			<span class='editor'>
			<?php 
			
				if($p['editor']) {
					
					echo "X";
					
				} else {
					
					echo "&nbsp;";
					
				}
			
			?>
			</span>
			<div style='clear:both;'></div>
		</div>
		<?php 
			$i++;
			endforeach;
		
		?>
	</div>
	<?php endif; ?>
	
</div>
<pre>
<?php 

//print_r($posse['YounitedNationsPosseMember']);

?>
</pre>