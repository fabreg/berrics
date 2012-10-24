<?php 

$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));

$trick_array = Set::extract("/Meta[key=/trick/i]/val",$posts);

sort($trick_array);

$trick_menu = array();

foreach($trick_array as $trick) {
	
	$trick_menu[md5($trick)] = $trick;
	
}

?>
<style>

#menu-items {


}



#menu-items .trick {
	
	background-color:#000000;
	float:left;
	width:48%;
	margin-right:1%;
	margin-bottom:10px;
	-webkit-box-shadow: 0px 0px 9px #000000;
	-moz-box-shadow: 0px 0px 9px #000000;
	box-shadow: 0px 0px 9px #000000;
	border:1px solid #222222;
}

#menu-items .trick .inner {

	padding:5px;

}

#menu-items .trick h2 {

	font-family:'Times New Roman';
	color:#666666;
	font-size:100%;
	font-weight:normal;
	margin-bottom:4px;
}


#menu-items .trick h2 span {



}

#menu-items .trick h2 a {


	color:inherit;
	text-decoration:none;
	border-bottom:2px dotted #647481;
}



#menu-items .trick h3 {

	font-weight:normal;
	font-size:140%;
}

#menu-items .trick .preview-thumb {

	float:left;
	padding:3px;
}


#TrickSelect {

	background-color:#000;
	color:white;

}

#menu label {
	
	
	margin-right:3px;
	line-height:30px;

}

#menu select {

	font-size:100%;
	

}
#menu {

	padding:10px;

}

#menu div.select {

	line-height:30px;

}



</style>
<script>

$(document).ready(function() { 

	$("#TrickSelect").change(function() { 

		var hash = $(this).val();

		var href = $(".trick[hash="+hash+"]").attr("uri");

		document.location.href = href;
		
	});


});


</script>
<div id='video'>

		
		<?php 
		
			echo $this->element("dailyops/post-bit",array("dop"=>$video));
		
		?>
	
</div>
<div id='menu'>
	<?php 
	
		echo $this->Form->input("TrickSelect",array("options"=>$trick_menu,"empty"=>"Choose a Trick","label"=>false));
	
	?>
</div>
<div id='menu-items'>

	<?php 
	
		foreach($posts as $post):
		
		$meta = Set::extract("/Meta[key=/trick/i]/val",$post);
		
	?>
	<div class='trick' post_id='<?php echo $post['Dailyop']['id']; ?>' uri='/<?php echo $this->params['section']."/".$post['Dailyop']['uri']; ?>' hash='<?php echo md5($meta[0]); ?>'>
		<div class='inner'>
			<div class='preview-thumb'>
			<?php 
			
				if(isset($post['DailyopMediaItem'][1]['MediaFile'])) {
					
					$thumb = $this->Media->mediaThumb(array(
					
						"MediaFile"=>$post['DailyopMediaItem'][1]['MediaFile'],
						"h"=>60,
						"w"=>60,
						"zc"=>1
					
					));
					?>
					<a href='/<?php echo $this->params['section']."/".$post['Dailyop']['uri']; ?>'><?php echo $thumb; ?></a>
					 
					<?php
				} else {
					
					
					echo $this->Html->image("layout/trickipedia/default-tricki.jpeg");
					
				}
			
			
			
			?>
			</div>
			<div class='skater'>
				<div class='trick-name'>
				<h2>
				<a href='/<?php echo $this->params['section']."/".$post['Dailyop']['uri']; ?>'>
				<?php 

					echo $meta[0];
				
				?>
				</a>
				</h2>
			</div>
				<h3><?php 
					
					$user = $post['DailyopMediaItem'][0]['MediaFile']['User'][0];
					
					$name = ucfirst($user['first_name'])." ".ucfirst($user['last_name']);
	
				?>
				<?php echo $name; ?>
				</h3>
			</div>
		
		</div>
	</div>
	<?php 
	
		endforeach;
	
	?>

</div>

<?php 



?>