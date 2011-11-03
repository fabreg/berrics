<?php

App::import("Core",array("HttpSocket","Xml","Set"));

class UpsApi {
	
	private $urls = array(
		"time_in_transit"=>"https://wwwcie.ups.com/ups.app/xml/TimeInTransit",
		"shipping_rate"=>"https://wwwcie.ups.com/ups.app/xml/Rate"
	);
	
	public function __construct() {
		
		
	}

	
	public function serviceCodes() {
		
		$a = array(
			"01"=>"Next Day Air",
			"02"=>"Second Day Air",
			"03"=>"Ground Shipment"
		);
		
		return $a;
		
	}
	
	public function shippingEstimate() {
		
		
		
	}
	
	
	public function esitmateShippingCached() {
		
		
		
		
		
	}
	
	public function estimateShipping(/*POLYMORPHIC*/) {
		
		$args = func_get_args();

			
		$dom = new DOMDocument("1.0");

		$req = $dom->appendChild($dom->createElement("RatingServiceSelectionRequest"));
		
		$this->buildRequest($req,"Rate","Rate");
		
		$pickup = $req->appendChild($dom->createElement("PickupType"));
		
		$pickup->appendChild($dom->createElement("Code","01"));
		$pickup->appendChild($dom->createElement("Description","Daily Pickup"));
		
		$shipment = $req->appendChild($dom->createElement("Shipment"));
		
		//setup the shipper account for the canteen
		$shipment = $this->insertShipperAccount($shipment);
		
		$shipTo = $shipment->appendChild($dom->createElement("ShipTo"));
		$shipToAddress = $shipTo->appendChild($dom->createElement("Address"));
		
		//shipping address
		if($args[0]['Shipping']) {
			
			if(isset($args[0]['Shipping']['first_name']))  $shipTo->appendChild($dom->createElement("AttentionName","{$args[0]['Shipping']['first_name']} {$args[0]['Shipping']['last_name']}"));
			
			if(isset($args[0]['Shipping']['phone'])) $shipTo->appendChild($dom->createElement("PhoneNumber",$args[0]['Shipping']['phone']));
			
			//do the address stuff
			if(isset($args[0]['Shipping']['street_address'])) $shipToAddress->appendChild($dom->createElement("AddressLine1",$args[0]['Shipping']['street_address']));
			
			if(isset($args[0]['Shipping']['apt'])) $shipToAddress->appendChild($dom->createElement("AddressLine2",$args[0]['Shipping']['apt']));
			
			if(isset($args[0]['Shipping']['city'])) $shipToAddress->appendChild($dom->createElement("City",$args[0]['Shipping']['city']));
			
			if(isset($args[0]['Shipping']['country'])) $shipToAddress->appendChild($dom->createElement("CountryCode",$args[0]['Shipping']['country']));
			
			if(isset($args[0]['Shipping']['postal'])) $shipToAddress->appendChild($dom->createElement("PostalCode",$args[0]['Shipping']['postal']));
			
			if(isset($args[0]['Shipping']['province'])) $shipToAddress->appendChild($dom->createElement("StateProvinceCode",$args[0]['Shipping']['province']));
			
			
		}
		
		$shipment = $this->insertShipFrom($shipment);
		
		if(isset($args[0]['Service'])) {
			
			$service = $shipment->appendChild($dom->createElement("Service"));
			
			$service->appendChild($dom->createElement("Code",$args[0]['Service']['code']));
			
		}
		
		//insert the shipping package information
		
		$package = $shipment->appendChild($dom->createElement("Package"));
		
		$packageType = $package->appendChild($dom->createElement("PackagingType"));
		$packageType->appendChild($dom->createElement("Code","02"));
		
		$dim = $package->appendChild($dom->createElement("Dimensions"));
		
		$unit = $dim->appendChild($dom->createElement("UnitOfMeasurement"));		
		$unit->appendChild($dom->createElement("Code","IN"));
		
		$dim->appendChild($dom->createElement("Length","12"));
		$dim->appendChild($dom->createElement("Width","8"));
		$dim->appendChild($dom->createElement("Height","12"));
		
		$weight = $package->appendChild($dom->createElement("PackageWeight"));
		//unit of measurement
		$unit = $weight->appendChild($dom->createElement("UnitOfMeasurement"));
		$unit->appendChild($dom->createElement("Code","LBS"));
		
		//set the actual weight
		$weight->appendChild($dom->createElement("Weight","2.0"));
		
		//$shipment->appendChild($dom->createElement("ShipmentServiceOptions"));
		
		
		$socket = new HttpSocket();
		
		$xml_string = $this->buildAuth().$dom->saveXml();
		//die($xml_string);
		$response = $socket->post($this->urls['shipping_rate'],$xml_string);
		//die($response);
		$xml = new Xml($response);
		
		$data = $xml->toArray();

		die(pr($data));
		
		return $data;
		
	}
	
	public function timeInTransitCached(/*POLYMORPHIC*/) {
		
		$args = func_get_args();
		
		$cache_token = "time_in_transit_".md5(serialize($args));
		
		if(($data = Cache::read($cache_token,"5min")) === false) {
				
			$data = $this->timeInTransit($args[0]);
			
			Cache::write($cache_token,"5min");
			
		}
		
		return $data;
		
	}
	
	public function timeInTransit(/*POLYMORPHIC*/) {

		$dom = new DOMDocument("1.0");
		
		$args = func_get_args();
		
		$req = $dom->appendChild(new DOMElement("TimeInTransitRequest"));
		
		$req->setAttributeNode(new DOMAttr("xml:lang","en-US"));
		
		$this->buildRequest($req,"TimeInTransit");

		$to = $req->appendChild(new DOMElement("TransitTo"));
		
		$to_address = $to->appendChild(new DOMElement("AddressArtifactFormat"));
		
		$to_address->appendChild(new DOMElement("CountryCode",$args[0]['country_code']));
		
		if(isset($args[0]['postal_code'])) {
			
			$to_address->appendChild(new DOMElement("PostcodePrimaryLow",$args[0]['postal_code']));
			
		}
				
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
		
		$res = $sock->post("https://wwwcie.ups.com/ups.app/xml/TimeInTransit",$xml);
		
		$x = new Xml($res);
		
		$a = $x->toArray();
		
		return $a;
		
		//die($auth.$dom->saveXml());
		
	}
	
	
	
	
	//uitility methods
	
	private function insertShipFrom(&$dom) {
		
		$ship = $dom->appendChild(new DOMElement("ShipFrom"));
		
		$ship->appendChild(new DOMElement("CompanyName","The Berrics"));
		
		//$ship->appendChild(new DOMElement("PhoneNumber"));
		
		$address = $ship->appendChild(new DOMElement("Address"));
		$address->appendChild(new DOMElement("AddressLine1","1248 Palmetto St"));
		$address->appendChild(new DOMELement("City","Los Angeles"));
		$address->appendChild(new DOMElement("StateProvinceCode","CA"));
		$address->appendChild(new DOMElement("PostalCode","90013"));
		$address->appendChild(new DOMElement("CountryCode","US"));
		
		return $dom;
		
	}
	
	private function insertShipperAccount(&$dom) {
		
		$shipper = $dom->appendChild(new DOMElement("Shipper"));
		
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