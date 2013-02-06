<?php 

$tag_str = '';

if(isset($this->request->data['Tag'])) foreach($this->request->data['Tag'] as $tag) $tag_str .= $tag['name'].", ";

$tag_str = ltrim($tag_str,",");

?>
<h3>Edit General</h3>
<div class="row-fluid">
	<div class="span6">
			<?php
	
				echo $this->Form->input('id');
				
				echo $this->Form->input('title');
				echo $this->Form->input('description');
				echo $this->Form->input("uri");
				echo $this->Form->input("tags",array("value"=>$tag_str));
				
			?>
	</div>
	<div class="span6">
		<?php 

				echo $this->Form->input('active');
				echo $this->Form->input('hd');
				echo $this->Form->input('pub_date');
				echo $this->Form->input('pub_time');
				echo $this->Form->input('release_date',array("type"=>"text"));

		 ?>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-primary" name='submit' value='general'>
		Update
	</button>
</div>