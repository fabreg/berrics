<?php

$this->set("title_for_layout","Categories");

//$cats = Cache::read("dop_sections","1min");

App::import("Model","DailyopSection");

$ds = new DailyopSection();

$cats = $ds->returnSections();

?>
<script>
$(document).ready(function() { 



	$("#features ul li").hover(

		function() {

			$(this).addClass("over");
			
		},
		function() {

			$(this).removeClass("over");
			
		}

	);
	

	
});
</script>
<?php echo $this->element("banners/728") ?>
<div style="height:20px"></div>
<div id='features'>
	
	<div class='top'></div>
	<div class='center'>
		<div class='content'>
			<ul>
				<?php 
				
					foreach($cats as $cat):
						if($cat['DailyopSection']['active'] == 1):
				?>
					<li>
						<a href='/<?php echo $cat['DailyopSection']['uri']; ?>' title='<?php echo addslashes($cat['DailyopSection']['name']); ?>'>
						<div class='icon'>
							<a href='/<?php echo $cat['DailyopSection']['uri']; ?>' title='<?php echo addslashes($cat['DailyopSection']['name']); ?>'>
							<?php 
								$color = false;
								if(!empty($cat['DailyopSection']['icon_color_file'])) $color = true;
								echo $this->Media->sectionIcon(array(
								
									"DailyopSection"=>$cat['DailyopSection'],
									"h"=>55,
									"w"=>55,
									"dark"=>true,
									"color"=>$color
								),array("border"=>0));
							
							?>
							</a>
						</div>
						<div class="link">
							<a href='/<?php echo $cat['DailyopSection']['uri']; ?>' title='<?php echo addslashes($cat['DailyopSection']['name']); ?>'>
						<?php 
						
							echo strtoupper($cat['DailyopSection']['name']);
						
						?>
						</a>
						</div>
					</li>
				<?php 
						endif;
					endforeach;
				
				?>
			</ul>
		</div>
		<div style='clear:both;'></div>
	</div>
	<div class='bottom'>
	
	</div>

</div>