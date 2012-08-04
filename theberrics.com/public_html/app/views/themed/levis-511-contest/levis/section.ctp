<?php 

$this->Html->script(array("jquery.hashchange","LevisContest","jquery.berrics.login"),array("inline"=>false));

?>
<script>
$(document).ready(function() { 

	$('#test-button').click(function() { 

		$.LevisContest('openWindow',{
			'url':"/levis-511/upload_image"
		});

	});

	$("#levis-511-section a").click(function() { 

		var ref = $(this).attr("href");

		document.location.hash = "#!"+ref
		
		return false;
		
	});

	$(window).hashchange(function(e) { 

		var hash = document.location.hash;

		if(!hash.match(/#!/)) return;
		
		hash = hash.replace(/#!/,'');

		$.LevisContest('openWindow',{
			'url':hash
		});

	});

	$(window).hashchange();

	$("#test-login").click(function() { 

		$.BerricsLogin('openWindow',"/identity/login/form");

	});
	
});
</script>
TEST
<input type='button' value='testing' id='test-button' />
<div id='levis-511-section'>
	<div class='task-column'>
		<?php foreach($tasks as $task): ?>
		<div>
			<?php echo $task['MediahuntTask']['name']; ?>
			<div>
				<?php echo $task['MediahuntTask']['details']; ?>
			</div>
			<div>
				<?php if($this->Session->check("Auth.User.id")): ?>
					<a href='/<?php echo $this->params['section']; ?>/upload_image/<?php echo $task['MediahuntTask']['id']; ?>' rel='ajax-link'>Add A Photo</a>
				<?php else: ?>
					<input type='button' value='login' id='test-login' />
				<?php endif; ?>
				
			</div>
		</div>
		<?php endforeach; ?>
		<div style='clear:both;'></div>
	</div>
	<div class='profile-column'>
		<div>
			<?php if($this->Session->check("Auth.User.id")): ?>
			
			<?php else: ?>
			<input type='button' value='login' id='test-login' />
			<?php endif; ?>
		</div>
	</div>
	<div style='clear:both;'></div>
</div>