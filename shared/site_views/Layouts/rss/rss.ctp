<?php

	header("Content-type:text/xml");
	
	//do some variable checks
	if(!isset($title_for_feed)) {
		
		$title_for_feed = 'The Berrics - Dailyops';
		
	}
	
	if(!isset($link_for_feed)) {
		
		$link_for_feed = '';
		
	}
	
	if(!isset($description_for_feed)) {
		
		$description_for_feed = '';
		
	}
	
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/"> 
  <channel> 
    <title>The Berrics Dailyops</title> 
    <link><?php echo $link_for_feed; ?></link> 
    <description><?php echo $description_for_feed; ?></description> 
    <language>en-us</language> 
    <pubDate><?php echo date("D, j M Y H:i:s", gmmktime()) . ' GMT';?></pubDate> 
    <?php echo $this->Time->nice($this->Time->gmt()) . ' GMT'; ?> 
    <docs>http://blogs.law.harvard.edu/tech/rss</docs> 
    <generator>The Berrics</generator> 
    <managingEditor>info@theberrics.com</managingEditor> 
    <webMaster>john@theberrics.com</webMaster> 
    <ttl>60</ttl>
    <image>
    	<title><?php $title_for_feed; ?></title>
    	<link><?php echo $link_for_feed; ?></link>
    	<url>http://<?php echo $_SERVER['SERVER_NAME']; ?>/img/theberrics-header-logo.png</url>
    </image>
   	<?php 
   	
   		echo $content_for_layout;
   	
   	?>
  </channel> 
</rss> 