<?php

	foreach($posts as $post):

?>
<item> 
      <title><![CDATA[<?php echo $post['Dailyop']['name']; ?>]]></title> 
      <link>http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $this->Berrics->dailyopsPostUrl($post); ?></link> 
      <description>
      	<![CDATA[<?php echo $post['Dailyop']['name']." ".strip_tags($post['text_content']); ?>]]>
      </description> 
      <?php echo $this->Time->nice($post['Dailyop']['publish_date']) . ' GMT'; ?> 
       <pubDate><?php echo $this->Time->nice($this->Time->gmt($post['Dailyop']['publish_date'])) . ' GMT'; ?></pubDate> 
      <guid><![CDATA[http://<?php echo $_SERVER['SERVER_NAME']; ?>/<?php echo $post['DailyopSection']['uri']; ?>/<?php echo $post['Dailyop']['uri']; ?>]]></guid> 
     
</item> 
<?php 

	endforeach;

?>