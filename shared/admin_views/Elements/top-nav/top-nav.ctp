<?php 

$nav = '';
switch($this->Session->read("Auth.User.user_group_id")) {
	
	case "10":
		$nav = $this->element("top-nav/10");
	break;
	default:
		//$nav = $this->element("top-nav/00");
	break;
	
}

echo $nav;

?>