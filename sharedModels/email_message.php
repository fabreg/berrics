<?php

class EmailMessage extends AppModel {
	
	public $belongsTo = array(
	
	);
	
	public function queueCanteenEmail() {
		
		$args = func_get_args();
		
		//lets chec a few things
		if(count($args) === 2) {
			
			$subject = '';
			switch(strtolower($args[0])) {
				
				case "canteen_order_conf":
					$subject = "The Berrics Canteen - Order Confirmation";
					
				break;
				
			}
			
			$data = array(
				"template"=>$args[0],
				"canteen_order_id"=>$args[1]['CanteenOrder']['id'],
				"from"=>"Do Not Reply <do.not.reply@theberrics.com>",
				"app_name"=>"Canteen",
				"send_as"=>"html",
				"serialized_data"=>serialize($args[1]),
				"to"=>$args[1]['CanteenOrder']['email'],
				"subject"=>$subject,
				"app_name"=>"Canteen"
			);
			
			$this->create();
			return $this->save($data);
			
		}
		
		throw new Exception("Wrong Parameters For Queue Canteen Email");
		
	}
	
	public function canteenOrderConfirmation($CanteenOrder) {
		
		$ship = Set::extract("/UserAddress[address_type=shipping]",$CanteenOrder);
		
		$this->create();
		
		
		$this->save(array(
			"subject"=>"Order Confirmation - The Berrics Canteen",
			"to"=>$ship[0]['UserAddress']['email'],
			"from"=>"Do Not Reply <do.not.reply@theberrics.com>",
			"send_as"=>"html",
			"template"=>"canteen_order_conf",
			"app_name"=>"Canteen",
			"serialized_data"=>serialize(array("CanteenOrder"=>$CanteenOrder['CanteenOrder'])),
			"model"=>"CanteenOrder",
			"foreign_key"=>$CanteenOrder['CanteenOrder']['id']
		));
	}
	
	
	public function resendEmail($email_id = false, $resend_label = false) {
		
		
		//get the email that we are referencing
		$email = $this->find("first",array(
			"conditions"=>array("EmailMessage.id"=>$email_id),
			"contain"=>array()
		));
		
		if($resend_label) {
			
			$email['EmailMessage']['subject'] = "RESEND:".$email['EmailMessage']['subject'];
			
		}
		
		unset($email['EmailMessage']['id'],$email['EmailMessage']['processed'],$email['EmailMessage']['created'],$email['EmailMessage']['modified']);
		
		$this->create();
		
		return $this->save($email['EmailMessage']);
		
		
	}
	
}