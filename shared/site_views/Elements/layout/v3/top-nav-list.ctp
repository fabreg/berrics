<?php 
$DailyopSection = ClassRegistry::init("DailyopSection");
$sections_array = $DailyopSection->returnSections();
$f_sections = Set::extract("/DailyopSection[featured=1]",$sections_array);

$f_sections = Set::sort($f_sections,"{n}.DailyopSection.sort_weight","asc");
?>

<div id="top-nav-div">
<ul id='top-nav-list'>
	<li class='nav-btn' id='top-dropdown'>
		<a href="#">FEATURES</a>
		<div id="top-dropdown-menu">
			<div class="inner clearfix">
				<ul>
					<?php 


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
	<li class='nav-btn'>HEADQUARTERS</li>
	<li class="spacer"></li>
	<li class='nav-btn'>MORE</li>
	
	<li class='nav-btn search'><form method='post' action='/search' ><label for="">SEARCH</label>
	<input name='data[Search][term]' type='text' /><button></button></form></li>
</ul>			
</div>
<div class="" id="top-nav-mobile">
<select id='mobile-nav-select'>
<option value="">Navigation..</option>
<option value="/dailyops">DAILY OPS</option>
<option value="/canteen">CANTEEN</option>
<option value="/headquarters.html">HEADQUARTERS</option>
<optgroup label='Features'>
	<?php 
	$f_sections = Set::extract("/DailyopSection[featured=1]",$sections_array);

$f_sections = Set::sort($f_sections,"{n}.DailyopSection.sort_weight","asc");

	foreach ($f_sections as $k => $v): ?>
	<option value="/<?php echo $v['DailyopSection']['uri']; ?>"><?php echo $v['DailyopSection']['name']; ?></option>
	<?php endforeach; unset($nl,$f_sections); ?>
</optgroup>
</select>
</div>