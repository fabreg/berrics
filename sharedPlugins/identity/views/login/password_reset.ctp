<?php if($record['UserPasswdReset']['active']==1): ?>
<div id='identity-password-reset'>
<?php 

echo $this->Form->create("User",array("url"=>$this->here));
echo $this->Form->input("passwd",array("label"=>"New Password"));
echo $this->Form->input("passwd_confirm",array("type"=>"password","label"=>"Confirm New Password"));
echo $this->Form->end("Reset Password");

?>
</div>
<?php else: ?>
Your password has been reset successfully
<?php endif; ?>