<ul>
	<li class='li-button'><?php echo $this->Html->link("Home","/"); ?></li>
	
	<li class='li-button'><?php echo $this->Html->link("Reports",array("controller"=>"traffic_reports","action"=>"monthly")); ?>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-header'>Traffic</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Realtime",array("controller"=>"traffic_reports","action"=>"pages_realtime")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Monthly Overview",array("controller"=>"traffic_reports","action"=>"monthly")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Countries: Monthly Overview",array("controller"=>"traffic_reports","action"=>"country_month_index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("DMA Codes: Monthly Overview",array("controller"=>"traffic_reports","action"=>"dma_codes")); ?>
			</li>
			<li class='li-sub-nav-header'>Media</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Monthly Overview",array("controller"=>"traffic_reports","action"=>"media_monthly_overview")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Most Viewed",array("controller"=>"traffic_reports","action"=>"media_files")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Realtime",array("controller"=>"traffic_reports","action"=>"media_realtime")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("View Queued Video Report",array("controller"=>"traffic_reports","action"=>"media_file_details","media_file_id"=>"queue")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Clear Report Queue",array("controller"=>"media_files","action"=>"remove_queue_video_for_report",0,base64_encode($this->here))); ?>
			</li>
			<li class='li-sub-nav-header'>Double Click</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("View Reports",array("controller"=>"dfp_reports","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Create Report",array("controller"=>"dfp_reports","action"=>"choose_company")); ?>
			</li>
			<li class='li-sub-nav-header'>Gateway Accounts</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Generate Report",array("controller"=>"gateway_reports","action"=>"index")); ?>
			</li>
		</ul>
	</li>
	
	<li class='li-button'>
		<?php echo $this->Html->link("System",array("controller"=>"websites","action"=>"index")); ?>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("System Messages",array("controller"=>"system_messages","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Server Stuff",array("controller"=>"system","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Websites Manager",array("controller"=>"websites","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-header'>Brands</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Manage Brands",array("controller"=>"brands","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add New Brand",array("controller"=>"brands","action"=>"add")); ?>
			</li>
			<li class='li-sub-nav-header'>Translation</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Browse Phrasing",array("controller"=>"phrases","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-header'>Locales</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Borwse Locales",array("controller"=>"locales","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-header'>Currencies</li>
			<li class='li-sub-nav-button'>
				<a href='/currencies'>Currency Manager</a>
			</li>
			
			<li class='li-sub-nav-header'>Gateway Accounts</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Manage Accounts",array("controller"=>"gateway_accounts","action"=>"index")); ?>
			</li>
			
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add New Account",array("controller"=>"gateway_accounts","action"=>"add")); ?>
			</li>
			<li class='li-sub-nav-header'>Gateway Transactions</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Manage Transactions",array("controller"=>"gateway_transactions","action"=>"index")); ?>
			</li>
			
			<li class='li-sub-nav-header'>Email Messages</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Manage Emails",array("controller"=>"email_messages","action"=>"index")); ?>
			</li>
			
		</ul>
	</li>
	<li class='li-button'>
		<?php echo $this->Html->link("Users",array("controller"=>"users","action"=>"index")); ?>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("View Users",array("controller"=>"users","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add User",array("controller"=>"users","action"=>"add")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("View Users Groups",array("controller"=>"user_groups","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add User Group",array("controller"=>"user_groups","action"=>"add")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("View User Permissions",array("controller"=>"user_permissions","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-header'>User Contests</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Manage Contests",array("controller"=>"user_contests","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add Contests",array("controller"=>"user_contests","action"=>"add")); ?>
			</li>
		</ul>
	</li>

	
	
	<li class='li-button'>
		<?php echo $this->Html->link("MediaFiles",array("controller"=>"media_files","action"=>"index")); ?>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("View Media Files",array("controller"=>"media_files","action"=>"index")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add Image(s)",array("controller"=>"media_files","action"=>"add_images")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add Video File",array("controller"=>"media_files","action"=>"add_video")); ?>
			</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Add Blank Entry",array("controller"=>"media_files","action"=>"add_blank_file")); ?>
			</li>
			<li class='li-sub-nav-header'>Media File Uploads</li>
			<li class='li-sub-nav-button'>
				<?php echo $this->Html->link("Manage Uploads",array("controller"=>"media_file_uploads","action"=>"index")); ?>
			</li>
		</ul>
	</li>
	<li class='li-button'>
		<?php echo $this->Html->link("Tags",array("controller"=>"tags","action"=>"index")); ?>
	</li>
	<li class='li-button'><a href="#">TheBerrics</a>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-header'>Splash Page</li>
			<li class='li-sub-nav-button'>
				<a href='/splash_pages'>Manage Splash Pages</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/splash_pages/add'>Create new splash page</a>
			</li>
			<li class='li-sub-nav-header'>The DailyOps</li>
			<li class='li-sub-nav-button'>
				<a href='/dailyops'>Manage Posts</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/dailyops/add'>Create new post</a>
			</li>
			<li class='li-sub-nav-header'>The DailyOps Sections</li>
			<li class='li-sub-nav-button'>
				<a href='/dailyop_sections'>Manage Sections</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/dailyop_sections/add'>Create new section</a>
			</li>
			<li class='li-sub-nav-header'>The News</li>
			<li class='li-sub-nav-button'>
				<a href='/dailyops/manage_news'>Manage news</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/dailyops/add_news_post'>Create News Post</a>
			</li>
			<li class='li-sub-nav-header'>Featured Menu</li>
			<li class='li-sub-nav-button'>
				<a href='/dailyop_sections/manage_menu'>Manage Menu</a>
			</li>
		</ul>
	</li>
	<li class='li-button'><a href="#">Berrics.Contests</a>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-header'>For The Record</li>
			<li class='li-sub-nav-button'>
				<a href='/berrics_records'>Manage Records</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/berrics_records/add'>Add New Record</a>
			</li>
			<li class='li-sub-nav-header'>SLS Qualifying</li>
			<li class='li-sub-nav-button'>
				<a href='/sls'>Manage Entries</a>
			</li>
			<li class='li-sub-nav-header'>Battle At The Berrics</li>
			<li class='li-sub-nav-button'>
				<a href='/batb_events'>Manage Events</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/batb_events/add'>Create new event</a>
			</li>
			<li class='li-sub-nav-header'>YOUnited Nations</li>
			<li class='li-sub-nav-button'>
				<a href='/younited_nations_events'>Manage Events</a>
			</li>
			<li class='li-sub-nav-header'>Wank Yoself</li>
			<li class='li-sub-nav-button'>
				<a href='/bangyoself_events'>Manage Events</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/bangyoself_events/add'>Create new event</a>
			</li>
		</ul>
	</li>
	<li class='li-button'><a href='#' target='_blank'>Canteen</a>
		<div>
			<ul class='sub-nav-list' style='width:175px; float:left; left:-50px;'>
				<li class='li-sub-nav-header'>Configuration</li>
				
				<li class='li-sub-nav-button'>
					<a href='/canteen_config'>Dump Configuration</a>
				</li>
					<li class='li-sub-nav-header'>Orders</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_orders'>Manage Orders</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_order_notes'>Manage Order Notes</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_orders/search'>Search Orders</a>
				</li>
				<li class='li-sub-nav-header'>Shipping</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_shipping_records'>Manage Shipments</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_shipping_records/checkout_shipments'>Checkout Shipments</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_shipping_records/usps_rate_calculator'>Calculate USPS Rates</a>
				</li>
				<li class='li-sub-nav-header'>Warehouses / Inventory</li>
				<li class='li-sub-nav-button'>
					<a href='/warehouses'>Manage Warehouses</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_inventory_records'>Manage Inventories</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_inventory_records/add'>Create Inventory Record</a>
				</li>
			</ul>
			<ul class='sub-nav-list' style='width:200px; float:left; left:125px;'>
				<li class='li-sub-nav-header'>Homepage</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_doormat'>Manage Doormat</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_doormat/add'>Add New Doormat</a>
				</li>
				<li class='li-sub-nav-header'>Products</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_products'>Manage Products</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_products/add'>Create new product</a>
				</li>
				<li class='li-sub-nav-header'>Categories</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_categories'>Manage Categories</a>
				</li>	
				<li class='li-sub-nav-header'>Promo Codes</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_promo_codes'>Manage Promo Codes</a>
				</li>
				<li class='li-sub-nav-button'>
					<a href='/canteen_promo_codes/add'>Add Promo Code</a>
				</li>	
			</ul>
			
		</div>
		
	</li>
	<li class='li-button'><a href='#' target='_blank'>Unified</a>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-header'>Shops / Accounts *** </li>
			<li class='li-sub-nav-button'>
				<a href='/unified_shops'>Manage Shops</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/unified_shops/add'>Add New Shop</a>
			</li>
			<li class='li-sub-nav-header'>**UNIFIED STORES** SO THIS IS THE ONE WE WILL USE</li>
			<li class='li-sub-nav-button'>
				<a href='/unified_stores'>Manage STORES</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/unified_stores/add'>Add New STORE</a>
			</li>
		</ul>
	</li>
	<li class='li-button'><a href='#' target='_blank'>OnDemand</a>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-header'>Feature Titles</li>
			<li class='li-sub-nav-button'>
				<a href='/ondemand_titles'>Manage Titles</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/ondemand_titles/add'>Create new On-Demand Title</a>
			</li>
		</ul>
	</li>
	<!-- 
	<li class='li-button'><a href='http://dev.aberrica.com/' target='_blank'>Aberrica.com</a>
		<ul class='sub-nav-list'>
			<li class='li-sub-nav-header'>Cover Pages</li>
			<li class='li-sub-nav-button'>
				<a href='/cover_pages'>Manage Cover Pages</a>
			</li>

			<li class='li-sub-nav-header'>Articles</li>
			<li class='li-sub-nav-button'>
				<a href='/article_manager'>Manage Articles</a>
			</li>
			<li class='li-sub-nav-button'>
				<a href='/article_manager/add'>Create new article</a>
			</li>
			<li class='li-sub-nav-header'>Categories</li>
			<li class='li-sub-nav-button'>
				<a href='/aberrica_categories'>Manage Categories</a>
			</li>
		
		</ul>
	</li>
	 -->
	<li class='li-button'>
		<?php echo $this->Html->link("Logout",array("controller"=>"login","action"=>"logout","plugin"=>"identity")); ?>
	</li>
</ul>