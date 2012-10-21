<style>
	
		* {
		
			padding:0px;
			margin:0px;
		
		}
	
		body {
		
			background-color:black;
			background-image:url(/img/splash/berra_bday/bg.jpg);
		}
			
		.instagram-image-item {
		
			float:left;
			padding:10px;
			border:1px solid #000;
			background-image:url(/img/layout/blk-px.png);
			margin:5px;
			color:white;
			font-family:'Arial';
		}
		
		.instagram-image-item img {
		
			border:1px solid #000;
			
		
		}
		
		.instagram-image-item:nth-child(odd) {
		
			float:right;
			margin-right:5px;
		}
		.enter {
		
			padding:10px;
			text-align:center;
			font-size:24px;
		}
		
		.enter a {
		
			color:white;
		
		}
		</style>
		<div style='width:728px; margin:auto;'>
			<div style='padding-top:15px; text-align:center;'>
				<img border='' src='/img/splash/berra_bday/hbd.png'/>
			</div>
			<div style='border:4px dotted white; border-left:none; border-right:none; padding:10px; text-align:center;'>
				<a href='/dailyops' style='text-decoration:none; color:white; font-size:26px; font-weight:bold;'>ENTER THE BERRICS</a>
			</div>
			<?php foreach($instagram['data'] as $v): ?>
				<div class='instagram-image-item'>
					<img border='0' src='<?php echo $v['images']['low_resolution']['url']; ?>'/>
					<div>
						@<?php echo $v['user']['username']; ?> <br />
						Likes: <?php echo $v['likes']['count']; ?>
					</div>
				</div>
			<?php endforeach; ?>
			<div style='clear:both;'></div>
			<div style='border:4px dotted white; border-left:none; border-right:none; padding:10px; text-align:center;'>
				<a href='/dailyops' style='text-decoration:none; color:white; font-size:26px; font-weight:bold;'>ENTER THE BERRICS</a>
			</div>
		</div>
		