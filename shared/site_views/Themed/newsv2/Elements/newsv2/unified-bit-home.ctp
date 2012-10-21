<?php 

$logo = "/berrics-icons/d2a452edff079ca6980edcf54cc49945.png";

if(!empty($p['UnifiedStore']['image_logo'])) {
	
	$logo = "/unified-logos/".$p['UnifiedStore']['image_logo'];
	
}

?>
<div class='unified-bit-home'>
	<div class='logo'>
		<a href='/news/<?php echo $p['Dailyop']['uri']; ?>'><img src='http://img.theberrics.com/i.php?src=<?php echo $logo; ?>&w=90&h=65'  border='0'/></a>
	</div>
	<div class='info'>
		<div class='title'>
			<?php echo $this->Text->truncate($p['Dailyop']['name'],50); ?>
		</div>
		<div class='text-content'>
			<?php 
			
				echo $this->Text->truncate($p['DailyopTextItem'][0]['text_content'],150);
			
			?>
		</div>
		<div class='more-info'>
			<a href='/news/<?php echo $p['Dailyop']['uri']; ?>'>MORE INFO ..</a>
		</div>
		
	</div>
	<div style='clear:both;'></div>
</div>