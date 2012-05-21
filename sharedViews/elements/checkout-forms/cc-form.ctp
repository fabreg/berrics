<?php
App::import("Vendor","Lang",array("file"=>"sharedVendors".DS."Lang.php"));
//year array
$year = array();

for($i = 2012; $i <= 2025; $i++) {
	
	$year[($i-2000)]=$i;
	
}

$month = array();

for($i=1;$i<=12;$i++) {
	
	$month[$i]=$i;	

}

	$l = Lang::returnSection("CommonFields",$locale_code);
	echo $this->Form->input("CardData.number",array("label"=>$l['ccnum'],"error"=>false));
	echo $this->Form->input("CardData.exp_month",array("options"=>$month,"label"=>"Exp Month","error"=>false));
	echo $this->Form->input("CardData.exp_year",array("options"=>$year,"label"=>"Exp Year","error"=>false));
	echo $this->Form->input("CardData.code",array("label"=>$l['cvv2'],"error"=>false));
	
?>