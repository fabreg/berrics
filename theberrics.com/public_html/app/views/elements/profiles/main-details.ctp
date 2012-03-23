<?php 

$img = $profile['UserProfileImage'][0];

?>
<div id='profiles-main-details'>
	<div>
	<?php 
	
		echo $this->Media->profileThumb($img,array("w"=>100));
	
	?>
	</div>
	<div>
		<?php 
			echo $profile['User']['first_name']." ".$profile['User']['last_name']; 
		?>
	</div>
	<div style='clear:both;'></div>
</div>	