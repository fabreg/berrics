<?php echo $this->element("canteen/columns/category-nav") ?>
<?php if ($this->request->params['controller'] == "canteen_category"): ?>
<div class='sorting clearfix'>
	<div class='wrapper'>
		<div class='heading'>
			
				FILTER PRODUCTS
			
		</div>
		<div class='inner'>
			<?php echo $this->Form->create("CanteenProduct",array("url"=>$this->request->here,"id"=>"filter-form")); ?>
			<div class='filter-menu'>
				<?php if(isset($_GET['data']) && count($_GET['data'])>0): ?>
				<div class='reset-link'>
					<a href='/canteen/<?php echo $category['CanteenCategory']['uri']; ?>'>RESET FILTERS</a>
				</div>
				<?php endif;?>
				<div class='filter-heading'> // BRANDS</div>
				<div class='filter-options'>
					<?php 

						foreach($filters['Brand'] as $b) echo $this->Form->input("Brand.{$b['id']}",array("type"=>"checkbox","label"=>$b['name']));
 			
					?>
				</div>
			</div>
			<?php foreach($filters['Meta'] as $k=>$v): ?>
			<div class='filter-menu'>
				<div class='filter-heading'> // <?php echo strtoupper($k); ?></div>
				<?php if(isset($_GET['data']) && count($_GET['data'])>0): ?>
				<div class='reset-link'>
					<a href='/canteen/<?php echo $category['CanteenCategory']['uri']; ?>'>RESET FILTERS</a>
				</div>
				<?php endif;?>
				<div class='filter-options'>
					<?php 
						foreach($v as $key=>$val):
							echo $this->Form->input("Meta.{$key}",array("type"=>"checkbox","label"=>ucfirst($val)));
					?>
						
					<?php endforeach; ?>
				</div>
			</div>
			<?php endforeach; ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<?php endif; ?>
<?php pr($this->request); ?>