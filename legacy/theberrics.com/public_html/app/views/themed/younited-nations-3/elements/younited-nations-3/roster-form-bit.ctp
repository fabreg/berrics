<?php 

$num = array();

for($a=4;$a<=55;$a++) $num[$a]=$a;

$ii = ($i+1);

?>
<div class='roster-form-bit' id='roster-form-<?php echo ($ii); ?>'>
	<div class='roster-inner'>
		<div class='form-body'>
			<div class='left'>
				<div class='chk' roster_num='<?php echo $ii; ?>'><?php echo $this->Form->checkbox("YounitedNationsPosseMember.{$i}.active",array("class"=>"active-check")); ?></div>
				<div class='number'>#<?php echo ($ii<10) ? "0":""; echo $ii; ?>.</div>
			</div>
			<div class='right'>
				<?php echo $this->Form->input("YounitedNationsPosseMember.{$i}.age",array("options"=>$num,"label"=>false)); ?>
				<div class='label'>AGE</div>
			</div>
			<div class='center'>
				<?php 
				
					echo $this->Form->text("YounitedNationsPosseMember.{$i}.name");
				
				?>
				<div class='label'>NAME</div>
				<div style='clear:both;'></div>
			</div>
			<div style='clear:both;'></div>
			<div class='options'>
				<?php 
					echo $this->Form->input("YounitedNationsPosseMember.{$i}.skater");
					echo $this->Form->input("YounitedNationsPosseMember.{$i}.filmer");
					echo $this->Form->input("YounitedNationsPosseMember.{$i}.editor");
					if(isset($this->data['YounitedNationsPosseMember'][$i]['younited_nations_posse_id'])) {
						echo $this->Form->input("YounitedNationsPosseMember.{$i}.younited_nations_posse_id",array("type"=>"hidden"));
						echo $this->Form->input("YounitedNationsPosseMember.{$i}.id",array("type"=>"hidden"));
					}
				?>
			</div>
		</div>
	</div>
</div>