<?php

App::import("Core",array("HttpSocket","Xml","Set"));

class UpsApi {
	
	private $urls = array(
		"time_in_transit"=>"https://wwwcie.ups.com/ups.app/xml/TimeInTransit",
		"shipping_rate"=>"https://wwwcie.ups.com/ups.app/xml/Rate"
	);
	
	public function __construct() {
		
		
	}

	
	public function shippingEstimate() {
		
		
		
	}
	
	public function test(/*POLYMORPHIC*/) {
		
		
		$args = func_get_args();

		$dom = new DOMDocument("1.0");
		
		$req = $dom->appendChild($dom->createElement("RatingServiceSelectionRequest"));
		
		$req = $this->buildRequest($req,"Rate","Rate");
		
		$pickup = $req->appendChild($dom->createElement("PickupType"));
		
		$pickup->appendChild($dom->createElement("Code","01"));
		$pickup->appendChild($dom->createElement("Description","Daily Pickup"));
		
		//setup the shipper account for the canteen
		$req = $this->insertShipperAccount();
		
		
		$shipTo = $req->appendChild($dom->createElement("ShipTo"));
		$shipToAddress = $shipTo->appendChild($dom->createElement("Address"));
		
		//shipping address
		if($args[0]['Shipping']) {
			
			if(isset($args[0]['Shipping']['first_name']))  $shipTo->appendChild($dom->createElement("AttentionName","{$args[0]['first_name']} {$args[0]['last_name']}"));
			
			if(isset($args[0]['phone'])) $shipTo->appendChild($dom->craeteElement("PhoneNumber",$args[0]['phone']));
			
			//do the address stuff
			if(isset($args[0]['street_address'])) $shipTo->appendChild($dom->createElement("AddressLine1",$args[0]['street_address']));
			
			if(isset($args[0]['apt'])) $shipToAddress->appendChild($dom->createElement("AddressLine2",$args[0]['apt']));
			
			if(isset($args[0]['city'])) $shipToAddress->appendChild($dom->createElement("City",$args[0]['city']));
			
			if(isset($args[0]['country'])) $shipToAddress->appendChild($dom->createElement("CountryCode",$args[0]['country']));
			
			if(isset($args[0]['postal'])) $shipToAddress->appendChild($dom->createElement("PostalCode",$args[0]['postal']));
			
		}
		
		die($dom->saveXml());
		
	}
	
	public function timeInTransit() {

		$dom = new DOMDocument("1.0");
		
		$req = $dom->appendChild(new DOMElement("TimeInTransitRequest"));
		
		$req->setAttributeNode(new DOMAttr("xml:lang","en-US"));
		
		$this->buildRequest($req,"TimeInTransit");
		
		
		
		$to = $req->appendChild(new DOMElement("TransitTo"));
		
		$to_address = $to->appendChild(new DOMElement("AddressArtifactFormat"));
		
		$to_address->appendChild(new DOMElement("CountryCode","US"));
		
		$to_address->appendChild(new DOMElement("PostcodePrimaryLow","10003"));
		
		//from 
		
		$from = $req->appendChild(new DOMElement("TransitFrom"));
		
		$from_address = $from->appendChild(new DOMElement("AddressArtifactFormat"));
		
		$from_address->appendChild(new DOMElement("CountryCode","US"));
		
		$from_address->appendChild(new DOMElement("PostcodePrimaryLow","90013"));
		
		//units of mesaurement
		
		$weight = $req->appendChild(new DOMElement("ShipmentWeight"));
		
		$unitm = $weight->appendChild(new DOMElement("UnitOfMeasurement"));
		
		$unitm->appendChild(new DOMElement("Code","LBS"));
		
		$unitm->appendChild(new DOMElement("Description","Pounds"));
		
		$weight->appendChild(new DOMElement("Weight","10"));
		
		//total packages
		$req->appendChild(new DOMElement("TotalPackagesInShipment",1));
		
		$req->appendChild(new DOMElement("PickupDate",date("Ymd")));
		
		//build request string
		
		$auth = $this->buildAuth();
		
		$xml = $auth.$dom->saveXml();
		
		$sock = new HttpSocket();
		
		$res = $sock->post($this->urls->time_in_transit,$xml);
		
		$x = new Xml($res);
		
		$a = $x->toArray();
		
		die(pr($a));
		
		//die($auth.$dom->saveXml());
		
	}
	
	
	
	
	//uitility methods
	
	private function insertShipFrom(&$dom) {
		
		
		
	}
	
	private function insertShipperAccount(&$dom) {
		
		$shipper = $shipment->appendChild(new DOMElement("Shipper"));
		
		$shipper->appendChild(new DOMElement("ShipperNumber","93X64V"));
		$shipperAddress = $shipper->appendChild(new DOMElement("Address"));
		$shipperAddress->appendChild(new DOMElement("AddressLine1","1248 Palmetto St"));
		$shipperAddress->appendChild(new DOMElement("AddressLine2",""));
		$shipperAddress->appendChild(new DOMElement("City","Los Angeles"));
		$shipperAddress->appendchild(new DOMElement("StateProvinceCode","CA"));
		$shipperAddress->appendChild(new DOMElement("PostalCode","90013"));
		$shipperAddress->appendChild(new DOMElement("CountryCode","US"));
		
		return $dom;
		
	}
	
	private function buildAuth() {
		
		$dom = new DOMDocument('1.0');
		
		$access = $dom->appendChild(new DOMElement("AccessRequest"));
		
		$access->setAttributeNode(new DOMAttr("xml:lang","en-US"));
		
		$access->appendChild(new DOMElement("AccessLicenseNumber","9C87CCCFB27D8940"));
		
		$access->appendChild(new DOMElement("UserId","berricsupstrack"));
		
		$access->appendChild(new DOMElement("Password","4189GgCc2186"));
		
		return $dom->saveXml();
		
	}
	
	private function buildRequest(&$dom_element, $action, $option = null, $customer_context = null) {
		// create the child element
		$request = $dom_element->appendChild(
			new DOMElement('Request'));

		// create the children of the Request element
		$transaction_element = $request->appendChild(
			new DOMElement('TransactionReference'));
		$request->appendChild(
			new DOMElement('RequestAction', $action));

		// check to see if an option was passed in
		if (!empty($option)) {
			$request->appendChild(
				new DOMElement('RequestOption', $option));
		} // end if an option was passed in

		// create the children of the TransactionReference element
		$transaction_element->appendChild(
			new DOMElement('XpciVersion', '1.0002'));

		// check if we have customer data to include
		if (!empty($customer_context)) {
			// check to see if the customer context is an array
			if (is_array($customer_context)) {
				$customer_element = $transaction_element->appendChild(
					new DOMElement('CustomerContext'));

				// iterate over the array of customer data
				foreach ($customer_context as $element => $value) {
					$customer_element->appendChild(
						new DOMElement($element, $value));
				} // end for each customer data
			} // end if the customer data is an array
			else {
				$transaction_element->appendChild(
					new DOMElement('CustomerContext', $customer_context));
			} // end if the customer data is a string
		} // end if we have customer data to include

		return $request;
	} // end function buildRequest_RequestElement()
	
}