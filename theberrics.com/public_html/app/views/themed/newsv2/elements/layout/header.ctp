<?php if($_SERVER['REQUEST_URI'] != "/"): ?>
	<?php 
		$this->theme = "web";
		echo $this->element("layout/header"); 
		$this->theme = "newsv2";
	?>
<?php else: ?>
<div class='enter-the-berrics'>
	<a href='/dailyops'>
		<img border='0' src='/img/layout/newsv2/enter-button-top.jpg' />
	</a>
</div>
<style>#header-container { height: 10px; margin-top:-55px; }</style>
<?php endif; ?>