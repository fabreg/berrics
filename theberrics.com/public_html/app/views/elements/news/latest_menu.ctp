<?php 
foreach($latest_posts as $p):

?>
<div class='events-bit'>

	<div class='info'>
		<div class='title'>
			<?php echo $this->Text->truncate($p['Dailyop']['name'],40); ?>
		</div>
		<div class='text-content'>
			<?php 
			
				echo $this->Text->truncate($p['DailyopTextItem'][0]['text_content'],120);
			
			?>
		</div>
		<div class='more-info'>
			<a href='/news/<?php echo $p['Dailyop']['uri']; ?>'>MORE INFO ..</a>
		</div>
		
	</div>
	<div style='clear:both;'></div>
</div>
<?php 
endforeach;
?>
<?php 
if(isset($this->params['named']['page'])):
?>
<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('PREVIOUS |', true), array(), null, array('class'=>'disabled'));?>
	  	<?php echo $this->Paginator->numbers();?>
 
		<?php echo $this->Paginator->next(__(' | NEXT', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</div>
<?php else: ?>
<div class='paging'><a href='/news/latest_menu/page:2'>NEXT PAGE >></a></div>
<?php 
endif;
?>