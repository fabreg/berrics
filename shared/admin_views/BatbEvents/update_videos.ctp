<?php


?>

<div class='form'>
<?php echo $this->Form->create("BatbMatch",array("url"=>$this->request->here)); ?>
<?php echo $this->Form->input("BatbMatch.id"); ?>
<div>
	<h2>Update Videos For Event: <?php echo $this->request->data['BatbEvent']['name']; ?></h2>
	<div>
		Bracket: <?php echo $this->request->data['BatbMatch']['bracket_num']; ?> / Match: <?php echo $this->request->data['BatbMatch']['match_num']; ?> 
	</div>
	<div>
		<strong><?php echo $this->request->data['Player1User']['first_name']; ?> <?php echo $this->request->data['Player1User']['last_name']; ?></strong> VS. <strong><?php echo $this->request->data['Player2User']['first_name']; ?> <?php echo $this->request->data['Player2User']['last_name']; ?></strong>
	</div>
</div>

	<fieldset>
		<legend>Legacy Video Links</legend>
		<div>
		Note* Full link is requried IE: http://www.theberrics.com/.......
		</div>
		<?php 
		
			
			echo $this->Form->input("legacy_video_link");
			
		
		?>
	</fieldset>
		<fieldset>
		<legend>Attach Posts (*** Use this for BATB4 & BATB5 ****)</legend>
		<?php 
		
		
			echo $this->Form->input("pregame_dailyop_id",array("options"=>$postSelect,"label"=>"Pre-Game Post","empty"=>true));
		
			echo $this->Form->input("battle_dailyop_id",array("options"=>$postSelect,"label"=>"Battle Post","empty"=>true));
			
			echo $this->Form->input("postgame_dailyop_id",array("options"=>$postSelect,"label"=>"Post-Game Post","empty"=>true));
		
		
		?>
	</fieldset>
	<fieldset>
		<legend>Media Files</legend>
		<div>
			<h4>Pregame Video</h4>
			<?php echo $this->Admin->attachMediaLink("BatbMatch","pregame_media_file_id",$this->request->data['BatbMatch']['id'],$this->request->here); ?>
			<?php 
			
				if(!empty($this->request->data['PreGameVideo']['id'])) {
					echo "<br />";
					echo $this->Media->mediaThumb(array(
					
						"MediaFile"=>$this->request->data['PreGameVideo'],
						"w"=>100
					
					));
					
				}
			
			
			?>
		</div>
		<div>
			<h4>Battle Video</h4>
			<?php echo $this->Admin->attachMediaLink("BatbMatch","video_media_file_id",$this->request->data['BatbMatch']['id'],$this->request->here); ?>
			<?php 
			
				if(!empty($this->request->data['BattleVideo']['id'])) {
					echo "<br />";
					echo $this->Media->mediaThumb(array(
					
						"MediaFile"=>$this->request->data['BattleVideo'],
						"w"=>100
					
					));
					
				}
			
			
			?>
		</div>
		<div>
			<h4>Post Game Video</h4>
			<?php echo $this->Admin->attachMediaLink("BatbMatch","postgame_media_file_id",$this->request->data['BatbMatch']['id'],$this->request->here); ?>
			<?php 
			
				if(!empty($this->request->data['PostGameVideo']['id'])) {
					echo "<br />";
					echo $this->Media->mediaThumb(array(
					
						"MediaFile"=>$this->request->data['PostGameVideo'],
						"w"=>100
					
					));
					
				}
			
			
			?>
		</div>
	</fieldset>
	

	
	<?php echo $this->Form->end("Update Match"); ?>
</div>
<?php 


pr($this->request->data);


?>