<div class="row-fluid article-media-gallery" data-dailyop-id="<?php echo $post['Dailyop']['id']; ?>">
	<div class="span12">
		<div class="viewing-div">
			<div class="loader"></div>
			<div class="media-file">
				<?php echo $this->Media->mediaThumb(array(
					"MediaFile"=>$post['DailyopMediaItem'][0]['MediaFile'],
					"w"=>700
				)); ?>
			</div>
			<div class="title">
				<?php echo $post['DailyopMediaItem'][0]['MediaFile']['name']; ?>
			</div>
			<div class="caption">
				<?php echo $post['DailyopMediaItem'][0]['MediaFile']['caption']; ?>
			</div>
		</div>
		<div class="thumbs clearfix">
			<?php foreach ($post['DailyopMediaItem'] as $k => $v): ?>
				
					<?php echo $this->Media->mediaThumb(array(

						"MediaFile"=>$v['MediaFile'],
						"w"=>50,
						"h"=>50,
						"zc"=>1,
						"lazy"=>true

					),array(
						"data-media-file-id"=>$v['MediaFile']['id'],
						"data-media-type"=>strtoupper($v['MediaFile']['media_type']),
						"data-file"=>$v['MediaFile']['file'],
						"data-thumb-large-src"=>$this->Media->mediaThumbSrc(array(
							"MediaFile"=>$v['MediaFile'],
							"w"=>700
						)),
						"data-media-file-name"=>base64_encode($v['MediaFile']['name']),
						"data-media-file-caption"=>base64_encode(nl2br($v['MediaFile']['caption'])),
						"data-dailyop-id"=>$post['Dailyop']['id'],
						"class"=>"media-thumb"
					)); ?>
				
			<?php endforeach ?>
		</div>
	</div>
</div>