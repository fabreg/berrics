<style>

.submit {

	text-align:center;

}

</style>
<div>
<div style='width:80%; margin:auto; padding:10px; text-align:center;'>
	Type in your email address below to confirm that you are able to attend
</div>
<?php

echo $this->Form->create("User",array("url"=>$this->here));

echo $this->Form->input("email");

echo $this->Form->end("Confirm Email");

?>

</div>