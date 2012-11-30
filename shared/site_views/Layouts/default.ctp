<html>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<?php 

		echo $this->element("layout/v3/html-head-scripts"); 
		echo $scripts_for_layout;
	?>
	<body>
		<header>
			<div class="container">
				<div class="row-fluid top-row">
					<div class="span8" >
						<a href='/dailyops'><img id='berrics-heading-logo' src="/img/v3/layout/berrics-heading-logo.png" border='0' alt="The Berrics -  Inside Eric Koston's and Steve Berra's Skatepark" /></a>
					</div>
					<div class="span4"></div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<ul id='top-nav-list' class='nav-collapse'>
							<li class='nav-btn' id='top-dropdown'>
								<a href="#">FEATURES</a>
								<div id="top-dropdown-menu">
									<ul>
										<?php 
										$f_sections = Set::extract("/DailyopSection[featured=1]",$sections_array);
							
										$f_sections = Set::sort($f_sections,"{n}.DailyopSection.sort_weight","asc");

										foreach ($f_sections as $k => $v): ?>
											<li><a href='/<?php echo $v['DailyopSection']['uri'] ?>' title='<?php echo addslashes($v['DailyopSection']['name']); ?>'>
												<?php 

													$nl = $v['DailyopSection']['name']; 

													if(!empty($v['DailyopSection']['nav_label'])) $nl = $v['DailyopSection']['nav_label'];
													echo $this->Media->sectionIcon(array(
														"DailyopSection"=>$v['DailyopSection'],
														"dark"=>true,
														"h"=>15
													));
													echo strtoupper($nl);

												?>
												</a></li>
										<?php endforeach; unset($nl,$f_sections); ?>
									</ul>
								</div>
							</li>
							<li class="spacer"></li>
							<li class='nav-btn'>
								<a href="">NEWS</a>
							</li>
							<li class="spacer"></li>
							<li class='nav-btn'>
								<a href="">UNIFIED</a>	
							</li>
							<li class="spacer"></li>
							<li class='nav-btn'><a href='/canteen'>CANTEEN</a></li>
							<li class="spacer"></li>
							<li class='hidden-phone nav-btn'>HEADQUARTERS</li>
							<li class="spacer"></li>
							<li class='nav-btn'>MORE</li>
							<li class="spacer"></li>
							<li class='nav-btn search'><form method='post' action='/search' >SEARCH<input name='data[Search][term]' type='text' /><button>GO</button></form></li>
						</ul>
					</div>
				</div>
			</div>
		</header>
		<div class="container" id='main-container'>
			
			<div class="row-fluid" id='body-row'>
				<div class="span12" id='body-div'>
					<?php echo $this->element($top_element); ?>
					<?php echo $this->element($body_element); ?>
				</div>
			</div>
		</div>
		<div style='text-align:right; font-size:10px;'><?php echo php_uname('n'); ?></div>
		<?php echo $this->element('sql_dump'); ?>
		<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
	</body>
</html>