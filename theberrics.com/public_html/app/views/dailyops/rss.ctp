<?php

	foreach($posts as $post):

?>
<item> 
      <title><?php echo $post['Dailyop']['name']; ?></title> 
      <link>http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $this->Berrics->dailyopPostUrl($post); ?></link> 
      <description>
      	<![CDATA[<?php echo $post['text_content']; ?>]]>
      </description> 
      <?php echo $this->Time->nice($post['Dailyop']['publish_date']) . ' GMT'; ?> 
       <pubDate><?php echo $this->Time->nice($this->Time->gmt($post['Dailyop']['publish_date'])) . ' GMT'; ?></pubDate> 
      <guid>http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $this->Berrics->dailyopPostUrl($post); ?></guid> 
     
</item> 
<?php 

	endforeach;

?>
