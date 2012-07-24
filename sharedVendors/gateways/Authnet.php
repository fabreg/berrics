<?php

class Authnet extends GatewayBase {
	
	private $x_login = false;
	private $x_tran_key = false;
	private $x_version = 3.1;
	private $url = '';
	private $test_url = "https://secure.authorize.net/gateway/transact.dll";
	private $cim_url = "https://apitest.authorize.net/soap/v1/Service.asmx?wsdl";
	private $cim_test_url = "https://apitest.authorize.net/soap/v1/Service.asmx?wsdl";
	
	public  function init($options = array()) { 
	
		$this->x_login = $this->get("gateway_account.api_op1");
		$this->x_tran_key = $this->get("gateway_account.api_op2");
		
		if(preg_match('/(WEB2VM)/',php_uname("n"))) {
			
			$this->test_url = "https://test.authorize.net/gateway/transact.dll";
			
		}
		
		
		
	}
	
	public function runCharge() { 
	
		$post = $this->buildRequest("AUTH_CAPTURE");
		
		$this->response_data = $this->parseResponse($this->curlPost($this->test_url,$post));
		
		$this->formatTransactionResponse();
		
		switch($this->response_data['response_code']) {
			
			case 1:
				$this->runCreateUserProfile();
				return true;
			break;
			default:
				return false;
			break;
			
		}
		
	}
	
	public function runAuth() { 
		
		$post = $this->buildRequest("AUTH_ONLY");
		
		$this->response_data = $this->parseResponse($this->curlPost($this->test_url,$post));
		
		$this->formatTransactionResponse();
		
		switch($this->response_data['response_code']) {
			
			case 1:
				$this->runCreateUserProfile();
				return true;
			break;
			default:
				return false;
			break;
			
		}
	
	
	
	}
	public function runRefund() { 
	
	
		$post = $this->buildRequest("CREDIT");
		
		$this->response_data = $this->parseResponse($this->curlPost($this->test_url,$post));
		
		$this->formatTransactionResponse("refund");
		
		switch($this->response_data['response_code']) {
			
			case 1:
				
				return true;
			break;
			default:
				return false;
			break;
			
		}
	
	}
	public function runCapture() { 
	
		$post = $this->buildRequest("PRIOR_AUTH_CAPTURE");
		
		$this->response_data = $this->parseResponse($this->curlPost($this->test_url,$post));
		
		$this->formatTransactionResponse("capture");
		
		switch($this->response_data['response_code']) {
			
			case 1:
				return true;
			break;
			default:
				return false;
			break;
			
		}
	
	}
	
	protected function runCreateUserProfile() {
		
		$client = new SoapClient($this->cim_test_url);
		
		$params = $this->returnSoapAuth();
		
		$params['profile']=array(
	 	
	 		"merchantCustomerId"=>$this->transaction['foreign_key'],
	 		"descriptions"=>"",
	 		"email"=>(!empty($this->customer['email'])) ? $this->customer['email']:"",
	 		"paymentProfiles"=>array(
	 		
	 			"CustomerPaymentProfileType"=>array(
	 				
	 				"customerType"=>"individual",
	 				"payment"=>array(
	 					"creditCard"=>array(
	 						"cardNumber"=>$this->card_data['number'],
	 						"expirationDate"=>"20".$this->card_data['exp_year']."-".$this->card_data['exp_month'],
	 						"cardCode"=>$this->card_data['code']
	 					),
	 					"billTo"=>array(
	 						"firstName"=>$this->customer['first_name'],
	 						"lastName"=>$this->customer['last_name'],
	 						"address"=>$this->customer['address'],
	 						"city"=>$this->customer['city'],
	 						"state"=>$this->customer['state'],
	 						"country"=>$this->customer['country'],
	 						"zip"=>$this->customer['postal'],
	 						"phone"=>$this->customer['phone']	
	 					)
	 				)
	 			)	
	 	
	 		)
		);
		
		$result = $client->CreateCustomerProfile($params);
		
		if($result->CreateCustomerProfileResult->resultCode == "Ok") {
			
			$this->set(array(
			
				"UserBillingProfile"=>array(
					"acc_op1"=>$result->CreateCustomerProfileResult->customerProfileId,
					"acc_op2"=>$result->CreateCustomerProfileResult->customerPaymentProfileIdList->long
				)
			
			));
			
			$this->transaction_result['acc_op1'] = $result->CreateCustomerProfileResult->customerProfileId;
			$this->transaction_result['acc_op2'] = $result->CreateCustomerProfileResult->customerPaymentProfileIdList->long;
			
		}

	}
	
	protected function runVoid() {
		
		$post = $this->buildRequest("VOID");
		
		$this->response_data = $this->parseResponse($this->curlPost($this->test_url,$post));
		
		$this->formatTransactionResponse();
		
		switch($this->response_data['response_code']) {
			
			case 1:
				return true;
			break;
			default:
				return false;
			break;
			
		}
		
	}
	
	protected function runChargeUserBillingProfile() {
		
		$client = new SoapClient($this->cim_test_url);
		
		$params = $this->returnSoapAuth();
		
		$params['transaction'] = array(
		
			"profileTransAuthCapture"=>array(
		
				"amount"=>$this->get("transaction.amount"),
				"customerProfileId"=>$this->get("transaction.acc_op1"),
				"customerPaymentProfileId"=>$this->get("transaction.acc_op2"),
				"order"=>array(
					"invoiceNumber"=>$this->get("transaction.foreign_key"),
					"description"=>$this->get("transaction.model").":".$this->get("transaction.foreign_key")
				)

			)
			
		);
		
		$resObj = $client->CreateCustomerProfileTransaction($params);
		
		$res = $resObj->CreateCustomerProfileTransactionResult->directResponse;
		
		$this->response_data = $this->parseResponse($res,",");
		
		$this->formatTransactionResponse("charge");
		
		switch($this->response_data['response_code']) {
			
			case 1:
				return true;
			break;
			default:
				return false;
			break;
			
		}
		
	}
	
	
	protected function formatTransactionResponse() {
		
		$args = func_get_args();
		
		if(isset($args[0]) && in_array($args[0],array("void","refund","charge"))) {
			
			$this->transaction_result['method'] = $args[0];
			
		}
		
		$this->transaction_result['approved'] = ($this->response_data['response_code']==1) ? true:false;
		$this->transaction_result['gateway_response'] = $this->response_data['response_text'];
		$this->transaction_result['ref1'] = $this->response_data['transaction_id'];
		$this->transaction_result['gateway_reponse_code'] = $this->response_data['response_subcode'];
	}
	
	//utility methods
	
 	private function buildRequest($type = "AUTH_CAPTURE",$options = array()) {
	 	
	 	$post_values = array(
							
							// the API Login ID and Transaction Key must be replaced with valid values
							"x_login"			=> $this->x_login,
							"x_tran_key"		=> $this->x_tran_key,
						
							"x_version"			=> $this->x_version,
							"x_delim_data"		=> "TRUE",
							"x_delim_char"		=> "|",
							"x_relay_response"	=> "FALSE",
						
							"x_type"			=> $type,
							"x_method"			=> "CC",
							"x_card_num"		=> (isset($this->card_data['number'])) ? $this->card_data['number']:'',
							"x_exp_date"		=> (isset($this->card_data['exp_month'])) ? $this->card_data['exp_month'].$this->card_data['exp_year']:'',
							"x_card_code"		=> (isset($this->card_data['code'])) ? $this->card_data['code']:'',
							"x_amount"			=> (isset($this->transaction['amount'])) ? $this->transaction['amount']:'',
							"x_description"		=> $this->transaction['model'].":".$this->transaction['foreign_key'],
	 						"x_invoice_num"		=> $this->transaction['foreign_key'],
						
							"x_first_name"		=> (isset($this->customer['first_name'])) ? $this->customer['first_name']:'',
							"x_last_name"		=> (isset($this->customer['last_name'])) ? $this->customer['last_name']:'',
							"x_address"			=> (isset($this->customer['address'])) ? $this->customer['address']:'',
							"x_state"			=> (isset($this->customer['state'])) ? $this->customer['state']:'',
							"x_zip"				=> (isset($this->customer['postal'])) ? $this->customer['postal']:'',
	 						"x_country"			=> (isset($this->customer['country'])) ? $this->customer['country']:'',
	 						"x_phone"			=> (isset($this->customer['phone'])) ? $this->customer['phone']:'',
	 						"x_email"			=> (isset($this->customer['email'])) ? $this->customer['email']:''
							
						);
		if(in_array($type,array("PRIOR_AUTH_CAPTURE"))) {
			
			$post_values['x_trans_id'] = $this->transaction['ref1'];
			
		}
		
		if(in_array($type,Array("CREDIT","VOID"))) {
			
			$num = explode("-",$this->transaction['cc_hash']);
			
			$post_values['x_card_num'] = $num[1];

			$post_values['x_trans_id'] = $this->transaction['ref1'];
			
		}
		
		
	 	return $post_values;
	 }
	
	private function curlPost($url,$data) {
			
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL,$url);
			curl_setopt($curl,CURLOPT_POST,1);
			curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($data));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$ret = curl_exec($curl);
			curl_close($curl);
			
			return $ret;
			
	 }
	 
 	private function parseResponse($res,$sep = "|") {
	 	
	 	$res = explode($sep,$res);
	 	
	 	$r = array();
	 	
	 	$codes = $this->responseArray();
	 	
	 	$i = 0;
	 	
	 	foreach($codes as $k=>$v) {
	 		
	 		$r[$v] = $res[$i];

	 		$i++;
	 		
	 	}
	 	
	 	return $r;
	 	
	 }
	 
 	private function responseArray() {
	 	
	 	return array(
					
					"response_code",
					"response_subcode",
					"response_reason_code",
					"response_text",
					"auth_code",
					"avs_response",
					"transaction_id",
					"invoice_id",
					"description",
					"amount",
					"method",
					"transaction_type",
					"customer_id",
					"first_name",
					"last_name",
					"company",
					"address",
					"city",
					"state",
					"postal",
					"country",
					"phone",
					"fax",
					"email",
					"ship_first_name",
					"ship_last_name",
					"ship_company",
					"ship_city",
					"ship_state",
					"ship_postal",
					"ship_country",
					"tax",
					"duty",
					"freight",
					"tax_exempt",
					"purchase_order_number",
					"md5_hash",
					"card_code_response",
					"card_auth_response",
					"account_number",
					"card_type",
					"split_tender",
					"requested",
					"amount_auth",
					"balance"
				
				);
				 	
	 }
	 
 	public function returnSoapAuth() {
	 	
	 	$a = array(
	 		
	 		"merchantAuthentication"=>array(
	 			"name"=>$this->x_login,
	 			"transactionKey"=>$this->x_tran_key
	 		),
	 		"validationMode"=>"none"
	 		
	 	);
	 	
	 	return $a;
	 	
	 }
	
}