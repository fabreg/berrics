<?php 

$logo = "/berrics-icons/d2a452edff079ca6980edcf54cc49945.png";

if(!empty($p['UnifiedStore']['image_logo'])) {
	
	$logo = "/unified-logos/".$p['UnifiedStore']['image_logo'];
	
}

?>
<div class='unified-bit'>
	<div class='logo'>
		<img src='http://img.theberrics.com/i.php?src=<?php echo $logo; ?>&w=40&h=40'  />
	</div>
	<div class='info'>
		<div class='title'>
			<?php echo $this->Text->truncate($p['Dailyop']['name'],30); ?>
		</div>
		<div class='text-content'>
			<?php 
			
				echo $this->Text->truncate($p['DailyopTextItem'][0]['text_content'],90);
			
			?>
		</div>
		<div class='more-info'>
			<a href='/news/<?php echo $p['Dailyop']['uri']; ?>'>MORE INFO ..</a>
		</div>
		
	</div>
	<div style='clear:both;'></div>
</div>