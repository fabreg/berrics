<div>
<?php 

echo $this->Form->create("User",array("url"=>$this->here));
echo $this->Form->input("passwd");
echo $this->Form->input("passwd_confirm");
echo $this->Form->end("Reset Password");

?>
</div>