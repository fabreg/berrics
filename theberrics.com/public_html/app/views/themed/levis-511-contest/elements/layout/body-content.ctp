<?php 
if(preg_match('/(dailyops)/',$_SERVER['REQUEST_URI'])):
?>
<?php echo $this->element("/elements/layout/body-content")?>
<?php 
else:
?>
<div id='levis-body-content'>
<?php echo $content_for_layout; ?>
</div>
<?php 
endif;
?>