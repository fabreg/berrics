<h1>
	<?php echo $product['CanteenProduct']['name']; ?> - <?php echo $product['CanteenProduct']['sub_title']; ?> 
	<small>By: <?php echo $product['Brand']['name']; ?></small>
</h1>
<div>
	<?php if (CakeSession::read("is_admin") == 1): ?>
		<a href="//cp.theberrics.com/canteen_products/edit/<?php echo $product['CanteenProduct']['id']; ?>" class="btn btn-primary">ADMIN EDIT</a>
	<?php endif ?>
</div>