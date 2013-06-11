<?php 

$img = $this->Media->mediaThumbSrc(array(
	"MediaFile"=>$MediaFile,
	"w"=>700
));

?>
<div class='play-button'></div><div class='video-hover'></div>
<img src="<?php echo $img; ?>" alt="">