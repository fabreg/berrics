<ul class='top-nav-list'>
	<li class='nav-button' id='features-nav-button'>
		<a href='/features.html' title='View All The Berrics Features'><img src='/img/layout/top-nav/features-txt.png' border='0'/></a>
		<div class='sublist' id='featured-sublist'>
			
						<?php 
							
							$f_sections = Set::extract("/DailyopSection[featured=1]",$sections_array);
							
							$f_sections = Set::sort($f_sections,"{n}.DailyopSection.sort_weight","asc");
							
							$batb['DailyopSection'] =  Array
							                (
							                    'name' => 'Battle At The Berrics',
							                    'uri' => 'battle-at-the-berrics.html',
							                    'sort_weight' => 0,
							                    'icon_dark_file' => '08ad21c6f9da6bdf51ae0b971f43d96d.png',
							                    'icon_light_file' => '03287fcce194dbd958c2ec5b33705912.png',
							                    'nav_label' => ''
							                );
							$yn['DailyopSection'] =  Array
							                (
							                    'name' => 'YOUnited Nations 3',
							                    'uri' => 'younited-nations-3',
							                    'sort_weight' => 0,
							                    'icon_dark_file' => 'yn-featured.png',
							                    'icon_light_file' => 'yn-featured.png',
							                    'nav_label' => ''
							                );
							
							array_unshift($f_sections,$yn);          
							array_unshift($f_sections,$batb);
							
							$factor = ceil(count($f_sections)/3);
							
							$i = 0;
							
							foreach($f_sections as $s):
							
						?>
							<?php if($i == 0): ?>
							<ul>
							<?php endif; ?>
								<li>
									<a href='/<?php echo $s['DailyopSection']['uri']; ?>'>
										<?php echo $this->Media->sectionIcon(array(
											"DailyopSection"=>$s['DailyopSection'],
											"w"=>35,
											"h"=>35,
											"dark"=>true
										),array("border"=>0)); ?>
										<?php 
											$label = (empty($s['DailyopSection']['nav_label'])) ? strtoupper($s['DailyopSection']['name']):strtoupper($s['DailyopSection']['nav_label']);									
											
											if(strlen($label)<=11) {
												
										//		echo "<br />";
												
											}
											
									 		echo nl2br($label);
											
										?>
									</a>
								</li>
							<?php if($i == ($factor-1)): $i=0; ?>
							</ul>
							<?php else: $i++; endif; ?>
							
						
							
						<?php 
						
							endforeach;
						
						?>
						<div class='view-all'>
							<a href='/features.html'>
								- MORE FEATURES -
							</a>
						</div>
												
		</div>
	</li>
	<li class='nav-spacer'>
		
	</li>
	<li class='nav-button'>
		<a href='http://berricsunified.com' title='Berrics Unified' target='_blank'><img src='/img/layout/top-nav/unified-txt.png' border='0' /></a>
	</li>
	<li class='nav-spacer'>
		
	</li>
	<li class='nav-button'>
		<?php 
		
		$canteen_link = "/canteen";
		
		if(isset($_SERVER['DEVSERVER']) && $_SERVER['DEVSERVER'] == 1) {
			
			$canteen_link = "/canteen";
			
		}
		
		?>
		<a href='<?php echo $canteen_link; ?>'  title='The Berrics Canteen' ><img src='/img/layout/top-nav/canteen-txt.png' border='0' /></a>
	</li>
	<li class='nav-spacer'>
		
	</li>
	<li class='search-box'>
	<?php 
		
		echo $this->element("layout/search-box");
					
	?>
	</li>
</ul>
