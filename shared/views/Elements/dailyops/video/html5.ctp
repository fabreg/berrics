<?php 

$ll_url = "http://berrics.vo.llnwd.net/o45/";

$poster = $this->Media->mediaThumbSrc(array(

	"MediaFile"=>$MediaFile,
	"w"=>$opts['width']

));

?>
<video controls='1' poster="<?php echo $poster; ?>" preload='none' >
	<?php if (!empty($MediaFile['limelight_file'])): ?>
	<source src="<?php echo $ll_url.$MediaFile['limelight_file']; ?>" type="video/mp4">
	<?php endif; ?>
</video>