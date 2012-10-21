<?php




$thumbs =  $this->Thumb->remoteImgThumb(array(

	"src"=>"http://brightcove.vo.llnwd.net/d6/unsecured/media/17214305001/17214305001_36790265001_trailer-mclouth2.jpg?pubId=17214305001",
	"h"=>100,
	"w"=>100,
	"zc"=>1

));

echo $this->Html->image($thumbs);

//http://brightcove.vo.llnwd.net/d6/unsecured/media/17214305001/17214305001_36790265001_trailer-mclouth2.jpg?pubId=17214305001

?>
<!-- Start of Brightcove Player -->

<div style="display:none">

</div>

<!--
By use of this code snippet, I agree to the Brightcove Publisher T and C 
found at https://accounts.brightcove.com/en/terms-and-conditions/. 
-->

<script language="JavaScript" type="text/javascript" src="http://admin.brightcove.com/js/BrightcoveExperiences.js"></script>

<object id="myExperience814579435001" class="BrightcoveExperience">
  <param name="bgcolor" value="#FFFFFF" />
  <param name="width" value="580" />
  <param name="height" value="406" />
  <param name="playerID" value="814428788001" />
  <param name="playerKey" value="AQ~~,AAAABAINcuk~,cnCLhZkLD08_xOcqG8X80Y-QtK8fRG2t" />
  <param name="isVid" value="true" />
  <param name="isUI" value="true" />
  <param name="dynamicStreaming" value="true" />
  
  <param name="@videoPlayer" value="814579435001" />
</object>

<!-- 
This script tag will cause the Brightcove Players defined above it to be created as soon
as the line is read by the browser. If you wish to have the player instantiated only after
the rest of the HTML is processed and the page load is complete, remove the line.
-->
<script type="text/javascript">brightcove.createExperiences();</script>

<!-- End of Brightcove Player -->