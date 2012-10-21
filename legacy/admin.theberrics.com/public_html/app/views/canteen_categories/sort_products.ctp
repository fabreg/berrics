<?php 

$w = array();

for($i=1;$i<=199;$i++) $w[$i] = $i;

?>
<div class='index'>
	<h2>Sort Product: <?php echo $category['CanteenCategory']['name']; ?></h2>
	<div style='padding:5px; font-size:12px; font-style:italic;'>
		** NOTE: Form will update all products with each submission
	</div>
	<?php echo $this->Form->create("CanteenProduct",array("url"=>$this->here)); ?>
	<table cellspacing='0' style='width:700px; margin:0px;'>
		<tr>
			<th>Thumb</th>
			<th>Product</th>
			<th>Display Weight</th>
		</tr>
		<?php foreach($products as $p): ?>
		<tr>
			<td width='1%' align='center'>
			<?php if(isset($p['CanteenProductImage'][0]['id'])): ?>
				<?php echo $this->Media->productThumb($p['CanteenProductImage'][0],array("h"=>50)); ?>
			<?php endif; ?>
			</td>
			<td style='font-size:16px;'>
			<?php echo $p['CanteenProduct']['name']; ?> - <?php echo $p['CanteenProduct']['sub_title']; ?> <br />
			By: <?php echo $p['Brand']['name']; ?>
			</td>
			<td>
			<?php 
			
				echo $this->Form->input("display_weight.{$p['CanteenProduct']['id']}",array("options"=>$w,"selected"=>$p['CanteenProduct']['display_weight'],"label"=>false,"empty"=>true));
				echo $this->Form->submit("Go");
			?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $this->Form->end(); ?>
</div>