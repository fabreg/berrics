<?php

$o = $this->Paginator->prev('<< PREVIOUS', array(), null, array('class'=>'disabled'));

$o.= $this->Paginator->numbers();

$o.= $this->Paginator->next('NEXT >>', array(), null, array('class' => 'disabled'));


$o = preg_replace('/(\/index\/)/',"/".$this->params['slug']."/",$o);


?>
<div class='posts-title'>
	Posts <span class='total-posts'>(<?php echo $posts_data_total; ?>)</span>
	<div class='posts-paginate-menu'>
		
		<?php if($posts_data_total > 16): ?>
		<div class="paging">
			<?php echo $o; ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<div id='posts-content'>
			
				<?php 
				
					foreach($posts_data as $v) {
		
						
						echo $this->element("results/post-thumb",array("dop"=>$v));
						
						
					}
					
				?>
			<div style='clear:both;'></div>
</div>
<div class='posts-title'>
	
	<div class='posts-paginate-menu'>
		

		<?php if($posts_data_total > 16): ?>
		<div class="paging">
			<?php echo $o; ?>
		</div>
		<?php endif; ?>

	</div>
</div>