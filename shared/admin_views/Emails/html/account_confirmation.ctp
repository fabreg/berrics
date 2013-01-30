<?php 

$id = $msg['EmailMessage']['serialized_data'];

$User = ClassRegistry::init("User");

$profile = $User->returnUserProfile($id,true);

?>
<div>
<p>
<?php echo $profile['User']['first_name']; ?>,
</p>
<p>
This email is to confirm your account registration on The Berrics.
</p>
<p>
Use the link below to confirm your email address and activate your account.
</p>
<p>
<a href='http://theberrics.com/identity/login/verify_account/<?php echo $profile['User']['id']; ?>/<?php echo $profile['User']['account_hash']; ?>'>
http://theberrics.com/identity/login/verify_account/<?php echo $profile['User']['id']; ?>/<?php echo $profile['User']['account_hash']; ?>
</a>
</p>
</div>