<?php if($_SERVER['SCRIPT_URL'] != "/"): ?>
	<?php 
		$this->theme = "web";
		echo $this->element("layout/header"); 
		$this->theme = "newsv2";
	?>
<?php else: ?>
<div class='enter-the-berrics'>
<a href='/dailyops'>- ENTER THE BERRICS -</a>
</div>
<style>#header-container { height: 10px; }</style>
<?php endif; ?>