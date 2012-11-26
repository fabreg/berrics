<ul class='nav'>
	<li class='dropdown'>
		<a data-toggle='dropdown' href='#' >System <b class='caret'></b></a>
		<div class='dropdown-menu span12' style='max-width:550px;'>
			<div class='row-fluid'>
				<div class='span6'>
					<ul class='unstyled'>
					
					<li >
						<?php echo $this->Admin->link("System Messages",array("controller"=>"system_messages","action"=>"index")); ?>
					</li>
					
					<li >
						<?php echo $this->Admin->link("Websites Manager",array("controller"=>"websites","action"=>"index")); ?>
					</li>
					<li class="nav-header">
						Tags
					</li>
					<li>
						<a href='/tags'>Manage Tags</a>
					</li>
					<li><a href="/tags/disambig">Disambiguate UserID</a></li>
					<li class='nav-header'>Brands</li>
					<li >
						<?php echo $this->Admin->link("Manage Brands",array("controller"=>"brands","action"=>"index")); ?>
					</li>
					<li >
						<?php echo $this->Admin->link("Add New Brand",array("controller"=>"brands","action"=>"add")); ?>
					</li>
					<li class='nav-header'>Translation</li>
					<li >
						<?php echo $this->Admin->link("Browse Phrasing",array("controller"=>"phrases","action"=>"index")); ?>
					</li>
					<li class='nav-header'>Locales</li>
					<li >
						<?php echo $this->Admin->link("Borwse Locales",array("controller"=>"locales","action"=>"index")); ?>
					</li>
					
					
				</ul>
				</div>
				<div class='span6'>
					<ul class='unstyled'>
						<li class='nav-header'>Currencies</li>
					<li >
						<a href='/currencies'>Currency Manager</a>
					</li>
					
					<li class='nav-header'>Gateway Accounts</li>
					<li >
						<?php echo $this->Admin->link("Manage Accounts",array("controller"=>"gateway_accounts","action"=>"index")); ?>
					</li>
					
					<li >
						<?php echo $this->Admin->link("Add New Account",array("controller"=>"gateway_accounts","action"=>"add")); ?>
					</li>
					<li class='nav-header'>Gateway Transactions</li>
					<li >
						<?php echo $this->Admin->link("Manage Transactions",array("controller"=>"gateway_transactions","action"=>"index")); ?>
					</li>
					
					<li class='nav-header'>Email Messages</li>
					<li >
						<?php echo $this->Admin->link("Manage Emails",array("controller"=>"email_messages","action"=>"index")); ?>
					</li>
					</ul>
				</div>
				
			</div>
			
		</div>
		
	</li>
	
	<li class='dropdown'>
		<a data-toggle='dropdown' href="#" >Reports <b class='caret'></b></a>
		<ul class='dropdown-menu'>
			<li>
				<a href='<?php echo $this->Admin->url(array("controller"=>"reports","action"=>"index")); ?>'>Report Generator</a>
			</li>
			<li class='nav-header'>DFP</li>
			<li><?php echo $this->Admin->link("View Reports",array("controller"=>"dfp_reports","action"=>"index")); ?></li>
			<li><?php echo $this->Admin->link("Create Report",array("controller"=>"dfp_reports","action"=>"choose_company")); ?></li>
			<li class='nav-header'>Gateways</li>
			<li><?php echo $this->Admin->link("Generate Report",array("controller"=>"gateway_reports","action"=>"index")); ?></li>
		</ul>
	</li>
	
	<li class='dropdown'>
		<a data-toggle='dropdown' href='#' >Users <b class='caret'></b></a>
		<ul class='dropdown-menu'>
			<li>
				<?php echo $this->Admin->link("View Users",array("controller"=>"users","action"=>"index")); ?>
			</li>
			<li>
				<?php echo $this->Admin->link("Add User",array("controller"=>"users","action"=>"add")); ?>
			</li>
			<li>
				<?php echo $this->Admin->link("View Users Groups",array("controller"=>"user_groups","action"=>"index")); ?>
			</li>
			<li>
				<?php echo $this->Admin->link("Add User Group",array("controller"=>"user_groups","action"=>"add")); ?>
			</li>
			<li>
				<?php echo $this->Admin->link("View User Permissions",array("controller"=>"user_permissions","action"=>"index")); ?>
			</li>
			<li class='nav-header'>User Contests</li>
			<li>
				<?php echo $this->Admin->link("Manage Contests",array("controller"=>"user_contests","action"=>"index")); ?>
			</li>
			<li>
				<?php echo $this->Admin->link("Add Contests",array("controller"=>"user_contests","action"=>"add")); ?>
			</li>
		</ul>
	</li>
	
	
	<li class='dropdown'>
		<a href='#' data-toggle='dropdown' >Media <b class='caret'></b></a>
		<ul class='dropdown-menu'>
			<li>
				<a href='/media_files'>View Media Files</a>
			</li>
			<li>
				<a href='javascript:uploadVideoFile();'>Upload Video</a>
			</li>
			<li>
				<a href='javascript:uploadImages();'>Upload Images</a>
			</li>
			<li>
				<?php echo $this->Admin->link("Add Blank Entry",array("controller"=>"media_files","action"=>"add_blank_file")); ?>
			</li>
			<li>
				<?php echo $this->Admin->link("Video Tasks",array("controller"=>"video_tasks","action"=>"index")); ?>
			</li>
			<li>
				<?php echo $this->Admin->link("Video Task Servers",array("controller"=>"video_task_servers","action"=>"index")); ?>
			</li>
			<li class='nav-header'>Media File Uploads</li>
			<li>
				<?php echo $this->Admin->link("Manage Uploads",array("controller"=>"media_file_uploads","action"=>"index")); ?>
			</li>
			
		</ul>
	</li>
	<li class='dropdown'>
		<a href='#' data-toggle='dropdown' class='dropdown-toggle' >Berrics <b class='caret'></b></a>
		<div class='dropdown-menu span12 pull-right' style='max-width:550px;'>
			<div class='row-fluid'>
				<div class='span6'>
					<ul class='unstyled'>
						<li class='nav-header'>Splash Pages</li>
						<li>
							<a href='<?php echo $this->Admin->url(array("plugin"=>"splash","action"=>"index","controller"=>"creatives")); ?>'>Manage Splash Creatives</a>
						</li>
						<li>
							<a href='<?php echo $this->Admin->url(array("plugin"=>"splash","action"=>"index","controller"=>"dates")); ?>'>Manage Staging Dates</a>
						</li>
						<li class='nav-header'>The DailyOps</li>
						<li>
							<a href='/dailyops'>Manage Posts</a>
						</li>
						<li>
							<a href='/dailyops/add'>Create new post</a>
						</li>
						<li>
							<a href='/trending_posts'>Trending Posts</a>
						</li>
						<li class='nav-header'>The DailyOps Sections</li>
						<li>
							<a href='/dailyop_sections'>Manage Sections</a>
						</li>
						<li>
							<a href='/dailyop_sections/add'>Create new section</a>
						</li>
						<li class='nav-header'>The News</li>
						<li>
							<a href='/dailyops/manage_news'>Manage news</a>
						</li>
						<li>
							<a href='/dailyops/add_news_post'>Create News Post</a>
						</li>
						<li class='nav-header'>Featured Menu</li>
						<li>
							<a href='/dailyop_sections/manage_menu'>Manage Menu</a>
						</li>
					</ul>
				</div>
				<div class='span6'>
					<ul class='unstyled'>
						<li class='nav-header'>For The Record</li>
						<li>
							<a href='/berrics_records'>Manage Records</a>
						</li>
						<li>
							<a href='/berrics_records/add'>Add New Record</a>
						</li>
						<li class='nav-header'>SLS Qualifying</li>
						<li>
							<a href='/sls'>Manage Entries</a>
						</li>
						<li class='nav-header'>Battle At The Berrics</li>
						<li>
							<a href='/batb_events'>Manage Events</a>
						</li>
						<li>
							<a href='/batb_events/add'>Create new event</a>
						</li>
						<li class='nav-header'>YOUnited Nations</li>
						<li>
							<a href='/younited_nations_events'>Manage Events</a>
						</li>
						<li class='nav-header'>Wank Yoself</li>
						<li>
							<a href='/bangyoself_events'>Manage Events</a>
						</li>
						<li>
							<a href='/bangyoself_events/add'>Create new event</a>
						</li>
						<li class='nav-header'>Media Hunt Events</li>
						<li>
							<a href='/mediahunt_events'>Manage Events</a>
						</li>
						<li>
							<a href='/mediahunt_events/add'>Create new event</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</li>
	<li class='dropdown'>
		<a href='#' data-toggle='dropdown' >Canteen <b class='caret'></b></a>
		<div class='dropdown-menu span12 pull-right' style='max-width:550px;'>
			<div class='row-fluid'>
				<div class='span6'>
					<ul class='unstyled'>
						<li class='nav-header'>Configuration</li>
						
						<li>
							<a href='/canteen_config'>Dump Configuration</a>
						</li>
							<li class='nav-header'>Orders</li>
						<li>
							<a href='/canteen_orders'>Manage Orders</a>
						</li>
						<li>
							<a href='/canteen_order_notes'>Manage Order Notes</a>
						</li>
						<li>
							<a href='/canteen_orders/search'>Search Orders</a>
						</li>
						<li class='nav-header'>Shipping</li>
						<li>
							<a href='/canteen_shipping_records'>Manage Shipments</a>
						</li>
						<li>
							<a href='/canteen_shipping_records/checkout_shipments'>Checkout Shipments</a>
						</li>
						<li>
							<a href='/canteen_shipping_records/lajolla_tracking_files'>LJG Tracking Files</a>
						</li>
						<li>
							<a href='/canteen_shipping_records/usps_rate_calculator'>Calculate USPS Rates</a>
						</li>
						<li class='nav-header'>Warehouses / Inventory</li>
						<li>
							<a href='/warehouses'>Manage Warehouses</a>
						</li>
						<li>
							<a href='/canteen_inventory_records'>Manage Inventories</a>
						</li>
						<li>
							<a href='/canteen_inventory_records/add'>Create Inventory Record</a>
						</li>
						<li>
							<a href='/canteen_products/view_ljg_products'>View LJG Products</a>
						</li>
					</ul>
				</div>
				<div class='span6'>
					<ul class='unstyled' >
						<li class='nav-header'>Homepage</li>
						<li>
							<a href='/canteen_doormat'>Manage Doormat</a>
						</li>
						<li>
							<a href='/canteen_doormat/add'>Add New Doormat</a>
						</li>
						<li class='nav-header'>Products</li>
						<li>
							<a href='/canteen_products'>Manage Products</a>
						</li>
						<li>
							<a href='/canteen_products/add'>Create new product</a>
						</li>
						<li>
							<a href='/canteen_products/validate_products'>Validate Products</a>
						</li>
						<li class='nav-header'>Categories</li>
						<li>
							<a href='/canteen_categories'>Manage Categories</a>
						</li>	
						<li class='nav-header'>Promo Codes</li>
						<li>
							<a href='/canteen_promo_codes'>Manage Promo Codes</a>
						</li>
						<li>
							<a href='/canteen_promo_codes/add'>Add Promo Code</a>
						</li>	
					</ul>
				</div>
			</div>
		</div>
	</li>
	<li class='dropdown'><a href='#' data-toggle='dropdown' >Unified <b class='caret'></b></a>
		<ul class='dropdown-menu pull-right'>
			<!--
			<li class='nav-header'>Shops / Accounts </li>
			<li>
				<a href='/unified_shops'>Manage Shops</a>
			</li>
			<li>
				<a href='/unified_shops/add'>Add New Shop</a>
			</li>
		-->
			<li class='nav-header'>Unified Stores</li>
			<li>
				<a href='/unified_stores'>Manage STORES</a>
			</li>
			<li>
				<a href='/unified_stores/add'>Add New STORE</a>
			</li>
		</ul>
	</li>
</ul>