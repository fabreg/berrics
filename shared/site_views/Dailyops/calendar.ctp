<?php if(!$this->request->is('ajax')) echo $this->element("banners/728") ?>
<?php echo $this->element("dailyops/calendar") ?>

<pre>
	<?php print_r($content) ?>
</pre>