<?php echo $this->Html->script(array("/js/v3/jquery.customSelect.min.js"),array("inline"=>false)) ?>
<script>

jQuery(document).ready(function($) {
		
		//select scoring box actions
		$("#score-drop").customSelect();

		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1300px, initial-scale=0"

		});


});	


</script>
<div id='rg-section'>
	<div class="heading">
		<img src="/theme/run-and-gun/img/heading.jpg" alt="">
	</div>
	<?php if (count($post)>0): ?>
		<?php foreach ($post as $k => $v): ?>
			<div id="post">
				<div class="name-img">
					
				</div>
				<?php echo $this->element("dailyops/post-bit",array("dop"=>$v)) ?>
				<div class="voting clearfix">
					<div class="copy">
						<img src="/theme/run-and-gun/img/score-copy.png" alt="" />
					</div>
					<div data-post-id='<?php echo $v['Dailyop']['id']; ?>' class="voting-div">
						<?php if (!CakeSession::check("Auth.User.id")): ?>
							<?php echo $this->element("login-btn"); ?>
						<?php else: ?>
							<?php echo $this->element("voting-box"); ?>
						<?php endif ?>
					</div>
				</div>
			</div>		
		<?php endforeach ?>		  	 
	<?php endif; ?>
	<div class="entries">
		<?php foreach ($posts as $k => $v): ?>
			<div class="entry">
				<div class="portrait">
					
				</div>
				<div class="name">
					<?php echo $v['Dailyop']['sub_title']; ?>
				</div>
				
			</div>
		<?php endforeach ?>
	</div>
</div>
<pre>
<?php print_r($posts); ?>
</pre>