<?php 

$t = $task['MediahuntTask'];

$m = $task['MediahuntMediaItem'][0];

$tc = "";

$pub = true;

if(time()<strtotime($task['MediahuntTask']['publish_date'])) $pub=false;

if(isset($m['id']) && !empty($m['id'])) $tc = "task-complete";

if(!$pub) $tc = "task-unpublished";


?>
<div class='task <?php echo $tc; ?>'>
	<div class='top'>
		<div class='checkbox'>
			<?php if(empty($m['id'])): ?>
				<img border='0' src='/theme/levis-511-contest/img/checkbox.png' />
			<?php else: ?>
				<img border='0' src='/theme/levis-511-contest/img/checkbox-checked.png' />
			<?php endif; ?>
		</div>
		<div class='number'>#<?php echo $task['MediahuntTask']['sort_order']; ?></div>
		<div style='clear:both;'></div>
	</div>
	<div class='body'>
		<div class='thumb'>
			<?php if(isset($m['id'])): ?>
			<img src='http://img.theberrics.com/i.php?src=/mediahunt-media/<?php echo $m['file_name']; ?>&w=30&h=30&zc=1' border='0'/>
			<?php else: ?>
			<img src='/theme/levis-511-contest/img/no-thumb.png' />
			<?php endif; ?>
		</div>
		<div class='info'>
			<div class='title'>
				<?php 
					if($pub) {
						
						echo $task['MediahuntTask']['name'];
						
					} else {
						
						echo "To Be Announced";
						
					}

				?>
			</div>
			<div class='details'>
				<?php 
				
					if($pub) {
						
						echo $task['MediahuntTask']['details'];
						
					} else {
						
						echo date('F jS',strtotime($task['MediahuntTask']['publish_date']));
						
					}
				
				 ?>
			</div>
		</div>
		<div style='clear:both;'></div>
	</div>
	<div class='options'>
	<?php if(!$pub): ?>
		<img border='0' src='/theme/levis-511-contest/img/upload-photo.png' />
	<?php elseif(!isset($m['id'])): ?>
		<?php 
			
			if($this->Session->check("Auth.User.id")) {
				
				$lnk = "/{$this->params['section']}/tasks/{$task['MediahuntTask']['id']}";
				$rel = "";
				
			} else {
				
				$lnk = "#BerricsLogin=/identity/login/form/".urlencode(base64_encode("/".$this->params['section']."/tasks/".$t['id']));
				$rel = "no-ajax";
			}
		
		?>
		<a href='<?php echo $lnk; ?>' rel='<?php echo $rel; ?>'>
			<img border='0' src='/theme/levis-511-contest/img/upload-photo.png' />
		</a>	
	<?php else: ?>
		<a href='/<?php echo $this->params['section']; ?>/image/<?php echo $m['id']; ?>' rel='no-ajax'>
			<img border='0' src='/theme/levis-511-contest/img/view-photo.png' />
		</a>
	<?php endif; ?>
	</div>
</div>