<?php 

$t = $task['MediahuntTask'];

$m = $task['MediahuntMediaItem'][0];

$tc = "";

$pub = true;

if(strtotime($t['publish_date'])>strtotime(date("Y-m-d"))) $pub=false;

if(isset($m['id']) && !empty($m['id'])) $tc = "task-complete";

if(!$pub) $tc = "task-unpublished";


?>
<div class='task <?php echo $tc; ?>'>
	<div class='top'>
		<div class='checkbox'></div>
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
						
						echo $this->Time->niceShort($t['publish_date']);
						
					}
				
				 ?>
			</div>
		</div>
		<div style='clear:both;'></div>
	</div>
	<div class='options'>
	<?php if(!isset($m['id'])): ?>
		<?php 
			
			if($this->Session->check("Auth.User.id")) {
				
				$lnk = "/{$this->params['section']}/tasks/{$task['MediahuntTask']['id']}";
				$rel = "";
				
			} else {
				
				$lnk = "#BerricsLogin=1";
				$rel = "no-ajax";
			}
		
		?>
		<a href='<?php echo $lnk; ?>' rel='<?php echo $rel; ?>'>Add A Photo</a>	
	<?php else: ?>
		<a href=''>View Your Image</a>
	<?php endif; ?>
	</div>
</div>