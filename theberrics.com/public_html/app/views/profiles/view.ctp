<div id="profiles-view">
	<div class='main-info'>
		<div class='profile-img'>
			<?php echo $this->Media->profileThumb($profile['User'],array(
				"w"=>"200"
			)); ?>
		</div>
		<div class='vitals'>
			<h1><?php echo strtoupper($profile['User']['first_name']." ".$profile['User']['last_name']); ?></h1>
			
		</div>
	</div>
</div>
<pre>
<?php print_r($profile); ?>
</pre>