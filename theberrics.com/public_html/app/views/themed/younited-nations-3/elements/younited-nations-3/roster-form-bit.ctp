<div class='roster-form-bit'>
	<div class='roster-inner'>
		<div class='form-body'>
			<div class='left'>
				<div class='chk'><?php echo $this->Form->checkbox("YounitedNationsEventEntry.{$i}.active"); ?></div>
				<div class='number'>#<?php echo ($i<10) ? "0":""; echo $i; ?>.</div>
			</div>
			<div class='right'>
				
			</div>
			<div class='center'>
				<?php 
				
					echo $this->Form->text("YounitedNationEventEntry.{$i}.name");
				
				?>
			</div>
		</div>
	</div>
</div>