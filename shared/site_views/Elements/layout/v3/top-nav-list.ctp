<?php 
//load up models
$DailyopSection = ClassRegistry::init("DailyopSection");

$sections_array = $DailyopSection->returnSections();

$f_sections = Set::extract("/DailyopSection[featured=1]",$sections_array);

$batb['DailyopSection'] =  Array(
			                    'name' => 'Battle At The Berrics',
			                    'uri' => 'battle-at-the-berrics.html',
			                    'sort_weight' => 0,
			                    'icon_dark_file' => '90de1564f8adce08df29ac944ce8b641.png',
			                    'icon_light_file' => '03287fcce194dbd958c2ec5b33705912.png',
			                    'nav_label' => ''
			                );
$yn['DailyopSection'] =  Array(
		                    'name' => 'YOUnited Nations 3',
		                    'uri' => 'younited-nations-3',
		                    'sort_weight' => 0,
		                    'icon_dark_file' => 'yn-featured.png',
		                    'icon_light_file' => 'yn-featured.png',
		                    'nav_label' => ''
		                );
array_unshift($f_sections,$yn);          
array_unshift($f_sections,$batb);
$f_sections = Set::sort($f_sections,"{n}.DailyopSection.name","asc");

$total_per_row = ceil(count($f_sections)/3);

?>

<div id="top-nav-div">
<ul id='top-nav-list'>
	<li class="spacer"></li>
	<li class='nav-btn' id='top-dropdown'>
		<a href="/features.html" id='featured-list-btn'>FEATURES</a>
		<div id="top-dropdown-menu">
			<div class="inner clearfix">
				
					<?php 


						$c = 1;
						$i = 0;

						foreach ($f_sections as $k => $v): 
						$i++;
						if($c <= 1) echo "<ul class='clearfix'>";
					?>

						<li><a href='/<?php echo $v['DailyopSection']['uri'] ?>' title='<?php echo addslashes($v['DailyopSection']['name']); ?>'>
							<?php 

								$nl = $v['DailyopSection']['name']; 

								if(!empty($v['DailyopSection']['nav_label'])) $nl = $v['DailyopSection']['nav_label'];
								$color = false;
								if(!empty($v['DailyopSection']['icon_color_file'])) $color = true;
								echo $this->Media->sectionIcon(array(
									"DailyopSection"=>$v['DailyopSection'],
									"dark"=>true,
									"h"=>20,
									"color"=>$color
								));
								echo "&nbsp;".strtoupper(trim($nl));

							?>
							</a></li>
					<?php 

						if($c>=$total_per_row || ($i==count($f_sections)) ) {

							echo "</ul>";
							$c = 1;

						} else {

							$c++;

						}

						endforeach;  
					?>
				
					<div class="more-link clearfix">
						<a href="/features.html">VIEW ALL FEATURES</a>
					</div>
			</div>
			
		</div>
	</li>
	<li class="spacer"></li>
	<li class='nav-btn'>
		<a href="/news">NEWS</a>
	</li>
	<li class="spacer"></li>
	<li class='nav-btn' >
		<a href="http://berricsunified.com" target='_blank'>UNIFIED</a>	
	</li>
	<li class="spacer"></li>
	<li class='nav-btn'><a href='/canteen'>CANTEEN</a></li>
	<li class="spacer"></li>
	<li class='nav-btn'><a href='/battle-at-the-berrics-6'>BATB VI</a></li>
	<li class="spacer"></li>
	<li class='nav-btn'><a href='/headquarters'>HEADQUARTERS</a></li>
	<li class="spacer"></li>
	
	
	<li class='nav-btn search clearfix'><form method='post' action='/search' ><label for="">SEARCH</label>
	<input name='data[Search][term]' type='text' /><button></button></form></li>
</ul>			
</div>
<div class="" id="top-nav-mobile">
	<div class="row-fluid">
		<div class="span12 search">
			<form method='post' action='/search' >
			<input name='data[Search][term]' type='text' /><button></button></form>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<select id='mobile-nav-select'>
				<option value="">Navigation..</option>
				<option value="/dailyops">DAILY OPS</option>
				<option value="/canteen">CANTEEN</option>
				<option value="/battle-at-the-berrics-6">BATB VI</option>
				<option value="/headquarters">HEADQUARTERS</option>
				<optgroup label='Features'>
					<option value="/features.html">All Features..</option>
					<?php 
					
					foreach ($f_sections as $k => $v): ?>
					<option value="/<?php echo $v['DailyopSection']['uri']; ?>"><?php echo $v['DailyopSection']['name']; ?></option>
					<?php endforeach; unset($nl,$f_sections); ?>
				</optgroup>
			</select>
		</div>
	</div>

</div>