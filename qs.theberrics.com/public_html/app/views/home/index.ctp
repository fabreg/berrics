<?php 


$size = array();

for($i=5;$i<=15;$i += 1) {
	
	
	$size[$i]=$i;
	
	if($i<15) {
		
		$size[$i.".5"] = $i.".5";
		
	}
	
	
	
}

?>
<div>
	<?php 
	
	if($this->Session->check("signup")) {
		
		echo "<div class='confirmation'>Thanks for signing up! <br /> We will send you an email with further details</div>";
		
	} else {
		
		echo $this->Form->create("User",array("url"=>$this->here));
		echo $this->Form->input("first_name");
		echo $this->Form->input("last_name");
		echo $this->Form->input("email",array("label"=>"Email Address"));
		echo $this->Form->input("UserProfile.shoe_size",array("options"=>$size));
		echo $this->Form->end("Enter!");
		
	}

	
	?>
</div>