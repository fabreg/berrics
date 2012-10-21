<div id='header'>		
	<div class='right-cap'></div>
	<div id='top-nav'>
		<div class='inner'>
			<?php 
				echo $this->element("layout/top-nav-list");
			?>
		</div>
	</div>
	<div id='main-icon'>
		<?php 

			$logo_img = 'layout/theberrics-header-dailyops.png';
			
			if(preg_match('/^(\/dailyops)/',$_SERVER['REQUEST_URI'])) {

				$logo_img = 'theberrics-header-logo.png';

			}
			
			if(date("Y-m-d")=="2012-05-05") {
				
				$logo_img = "/theme/cinco-de-mayo/img/el-berrics-logo.png";
				
			}
		
			echo $this->Html->image($logo_img,array("url"=>"/dailyops","border"=>"0"));
		
		?>
	</div>	
		
</div>