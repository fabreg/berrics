<?php 

$upr = ClassRegistry::init("UserPasswdReset");

$r = $upr->find("first",array(
			"conditions"=>array(
						"UserPasswdReset.id"=>$msg['EmailMessage']['serialized_data']
					)
		));

?>
<div>
	<p>
	<?php echo $r['User']['first_name']; ?>,<br />
	Use the link below to reset your password on The Berrics. <br /><br />
	http://theberrics.com/identity/login/password_reset/<?php echo $r['User']['id']; ?>/<?php echo $r['UserPasswdReset']['hash']; ?>
	</p>
</div>