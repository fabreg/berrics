<?php 

$drop = array();

for($i=1;$i<=99;$i++) $drop[$i] = $i;

?>
<div class='form'>
	<fieldset>
		<legend>Edit Doormat Entry: <?php echo $this->request->data['CanteenDoormat']['id']; ?></legend>
		<div>
			<?php 
			echo $this->Form->create("CanteenDoormat",array("url"=>$this->request->here));
			echo $this->Form->input("id");
			echo $this->Form->input("display_weight",array("options"=>$drop));
			echo $this->Form->input("active");
			echo $this->Form->input("click_url");
			?>
			<?php if(!empty($this->request->data['MediaFile']['id'])): ?>
			<?php echo $this->Media->mediaThumb(array(
				"MediaFile"=>$this->request->data['MediaFile'],
				"w"=>200
			)); ?>
			<?php else: ?>
			
			<?php endif; ?>
			<div style='clear:both;'>
				<span class='span-button'><?php echo $this->Admin->attachMediaLink("CanteenDoormat","id",$this->request->data['CanteenDoormat']['id'],$this->request->here); ?></span> 
			</div>
			<div style='clear:both;'></div>
			<?php 
			echo $this->Form->end("Update");
			?>
		</div>
	</fieldset>
</div>