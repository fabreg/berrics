<div class='paging'>
	<div class='totals'>
		<?php echo $this->request->params['paging']['Dailyop']['count']; ?> Posts
	</div>
	<div class='nav'>
		<?php 
				$o = $this->Paginator->prev("<"); 

				$o .= $this->Paginator->numbers(array(
				
					"separator"=>" "
				
				)); 
				$o .= $this->Paginator->next(">");
				
				if(preg_match('/(\/tags\/)/', $this->request->here)) {

					$o = preg_replace('/(\/view\/)/',"/".$this->params['slug']."/",$o);

				} else {


				}
				
			
				echo $o;
		?>
	</div>
	<div style='clear:both;'></div>
</div>
<div class='posts'>
	<?php 
	
		foreach($posts as $post): 
		
	?>
	<?php 
		echo $this->element("results/post-thumb",array("dop"=>$post));
	?>
	<?php endforeach; ?>
	<div style='clear:both;'></div>
</div>
<div class='paging'>
	<div class='nav'>
		<?php echo $o; ?>
	</div>
	<div style='clear:both;'></div>
</div>
