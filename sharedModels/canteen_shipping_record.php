<?php
class CanteenShippingRecord extends AppModel {
	var $name = 'CanteenShippingRecord';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Warehouse' => array(
			'className' => 'Warehouse',
			'foreignKey' => 'warehouse_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CanteenOrder' => array(
			'className' => 'CanteenOrder',
			'foreignKey' => 'canteen_order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		"UserAddress"
	);

	var $hasMany = array(
		'CanteenOrderItem' => array(
			'className' => 'CanteenOrderItem',
			'foreignKey' => 'canteen_shipping_record_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public $shippingZones = array(
		
	);
	
	
	public function save($data = array()) {
		
		if(empty($this->id)) {
			
			if(isset($data['CanteenShippingRecord'])) {
				
				$data['CanteenShippingRecord']['id'] = $this->genId();
				$data['CanteenShippingRecord']['hash'] = md5($data['CanteenShippingRecord']['id']);
			} else {
				
				$data['id'] = $this->genId();
				$data['hash'] = md5($data['id']);
			}
			
			
		}
		
		return parent::save($data);
		
	}
	
	private function genId() {
		
		$id = mt_rand(10000000,99999999);
		
		$chk = $this->find("count",array("conditions"=>array("CanteenShippingRecord.id"=>$id)));
		
		if($chk>0) {
			
			return $this->genId();
			
		}
		
		return $id;
		
	}
	
	public static function shippingZones() {
		
		$z = array();
		
		//usa
		$z['usa'] = array(
			"countries"=>array(
				"US"
			),
			"rates"=>array(
				"standard"=>array(
					0=>19.95,
					1=>7.49,
					2=>8.95,
					3=>11.95,
					4=>13.49,
					5=>14.95,
					6=>15.95
				),
				"expedited"=>array(
					0=>19.95,
					1=>10.00,
					2=>12.00,
					3=>14.00,
					4=>16.00,
					5=>18.00,
					6=>20.00
				)
				
			)
		);
		
		//canada
		$z['can'] = array(
			"countries"=>array(
				"CA"
			),
			"rates"=>array(
				"standard"=>array(
					0=>19.95,
					1=>9.00,
					2=>10.00,
					3=>11.00,
					4=>12.00,
					5=>13.00,
					6=>14.00
				),
				"expedited"=>array(
					0=>19.95,
					1=>13.95,
					2=>12.00,
					3=>14.00,
					4=>16.00,
					5=>18.00,
					6=>20.00
				)
				
			)
		);
		//aus
		
		//uk
		
		//europe
		$z['europe'] = array(
			"countries"=>array(
				"GB","ES","UK"
			),
			"rates"=>array(
				"standard"=>array(
					0=>32.95,
					1=>13.95,
					2=>16.95,
					3=>20.49,
					4=>23.95,
				),
				"expedited"=>array(
					0=>19.95,
					1=>10.00,
					2=>12.00,
					3=>14.00,
					4=>16.00,
					5=>18.00,
					6=>20.00
				)
				
			)
		);
		
		
		//brazil
		
		//default
		$z['def'] = array(
			"countries"=>array(),
			"rates"=>array(
				"standard"=>array(
					0=>49.95,
					1=>13.95,
					2=>17.49,
					3=>23.95,
					4=>27.95
				),
				"expedited"=>array(
					0=>39.95,
					1=>19.00,
					2=>21.00,
					3=>22.00,
					4=>23.00,
					5=>24.00,
					6=>25.00
				)
				
			)
		);
		
		return $z;
		
	}
	
	public static function returnShippingRate($weight=1.00,$country_code='US',$method = "standard") {
		
		$weight = ceil($weight);

		$zones = self::shippingZones();
		
		$rates = $zones['def']['rates'][$method];
		$rate = $rates[0];
		
		foreach($zones as $v) {
			
			if(in_array($country_code,$v['countries'])) {
				
				$rates = $v['rates'][$method];
				
				$rate = $rates[0];
				
				if(isset($rates[$weight])) {
					
					$rate=$rates[$weight];
					
				}
				//die("should return");
				return $rate;
				
			}
			
		}
		
		if(array_key_exists($weight,$rates)) {
					
			$rate=$rates[$weight];
					
		}
		
		return $rate;
		
	}
	
	/**
	 * Estimate a carts shipping price with available data
	 * Make sure the $CanteenOrder has passed thru calculate cart totals
	 * @param CanteenOrder $CanteenOrder
	 * @return decimal
	 */
	public function estimateCartShipping($CanteenOrder) { 
		
		return 0.00;
		
	}
	
	public function createShipment($canteen_order_id,$commit = false) {
		
		$order = $this->CanteenOrder->returnAdminOrder($canteen_order_id);
		
		if(strtoupper($order['CanteenOrder']['order_status']) != "APPROVED" || 
			strtoupper($order['CanteenOrder']['shipping_status']) != "PENDING"
		) return false;
		
		//get the shipping address id
		
		$address = $order['ShippingAddress'];
		
		//let's get the warehouses in each order
		$items = array();
		
		foreach($order['CanteenOrderItem'] as $item) {
			
			foreach($item['ChildCanteenOrderItem'] as $child) {
				
				$items[$child['CanteenInventoryRecord']['Warehouse']['id']][] = $child['id'];
				
			}
			
		}
		
		//create the shipments and then attach the shipments to the line items
		foreach($items as $key=>$val) {
			
			$this->create();
			
			$this->save(array(
				"canteen_order_id"=>$order['CanteenOrder']['id'],
				"shipping_status"=>"PENDING",
				"warehouse_id"=>$key,
				"user_address_id"=>$address['id']
			));
			
			$ship_id = $this->id;
			
			foreach($val as $v) {
				
				$this->CanteenOrderItem->create();
				
				$this->CanteenOrderItem->id = $v;
				
				$this->CanteenOrderItem->save(array(
					"canteen_shipping_record_id"=>$ship_id
				));
				
			}
			
		}
		
	}
	
	public function cancelShipment($id) {
		
		$this->create();
		
		$this->id = $id;
		
		$this->save(array(
			"shipping_status"=>"canceled"
		));

		$items = $this->CanteenOrderItem->find("all",array(
			"conditions"=>array(
				"CanteenOrderItem.canteen_shipping_record_id"=>$id
			),
			"contain"=>array()
		));
		
		foreach($items as $item) {
			
			$this->CanteenOrderItem->cancelOrderItem($item['CanteenOrderItem']['id']);
			
		}

		
	}
	
	public function process_usps_shipment($id) {
		
		$record = $this->returnAdminRecord($id);
		
		unset($record['CanteenShippingRecord']['modified']);
		
		if($record['UserAddress']['country_code'] == "US") {
			
			$record = $this->process_usps_dom($record);
			
		} else {
			
			$record = $this->process_usps_int($record);
			
		}
		
		return $record;
		
	}
	
	private function process_usps_dom($record) {
		
		App::import("Vendor","UspsApi",array("file"=>"UspsApi.php"));
		
		$u = new UspsApi(false,$record['Warehouse']);
		
		//process_weight
		$weight = 0;
		
		foreach($record['CanteenOrderItem'] as $item) {
			
			$weight += $item['weight'];
			
		}
		
		$record['CanteenShippingRecord']['weight'] = $record['UserAddress']['weight'] = $weight;
		
		$record['UserAddress']['weight_oz'] = floor($record['UserAddress']['weight'] * 16);
		
		$record['UserAddress']['shipping_method'] = $record['CanteenShippingRecord']['shipping_method'] = "First Class";
		
		if($record['UserAddress']['weight_oz']>=13) 
				$record['UserAddress']['shipping_method'] = $record['CanteenShippingRecord']['shipping_method'] = "Parcel Post";
		
		
		$res = $u->ship_delcon($record['UserAddress']);
		
		//parse xml response
		$xml = simplexml_load_string($res);
		
		if(isset($xml->DeliveryConfirmationNumber)) {
			
			//save the label image
			
			$this->process_usps_label($xml->DeliveryConfirmationLabel,$record['CanteenShippingRecord']['id']);
			
			$record['CanteenShippingRecord']['shipping_status'] = "processing";
			
			$record['CanteenShippingRecord']['shipment_number'] = $xml->Postnet;
			
			$record['CanteenShippingRecord']['tracking_number'] = $xml->DeliveryConfirmationNumber;
			
			$record['CanteenShippingRecord']['carrier_name'] = "USPS";
			
			$this->create();
			
			$this->id = $record['CanteenShippingRecord']['id'];
			
			$this->save($record['CanteenShippingRecord']);
			
			$record = $this->read();
			
			
		} else { // error occurred
			
			SysMsg::add(array(
				"category"=>"USPSError",
				"crontab"=>1,
				"from"=>"CanteenShippingRecord",
				"title"=>"USPS DOM Shipping Error: CanteenShippingRecordID: ".$record['CanteenShippingRecord']['id'],
				"message"=>serialize($xml->asXml())
			));
			
			
		}
		
		return $record;
		
	}
	
	private function process_usps_int($record) {
		
		App::import("Vendor","UspsApi",array("file"=>"UspsApi.php"));
		
		$u = new UspsApi();
		
		//process_weight
		$weight = 0;
		
		foreach($record['CanteenOrderItem'] as $item) {
			
			$weight += $item['weight'];
			
		}
		
		$record['CanteenShippingRecord']['weight'] = $record['UserAddress']['weight'] = $weight;
		
		$record['UserAddress']['weight_oz'] = floor($record['UserAddress']['weight'] * 16);
		
		$record['UserAddress']['shipping_method'] = $record['CanteenShippingRecord']['shipping_method'] = "First Class";
		
		//create the canteen shipping record items
		$items = $u->processCanteenItems($record['CanteenOrderItem']);
		
		
		$res = $u->ship_int($record['UserAddress'],$items);
		
		$xml = simplexml_load_string($res);
		
		if(isset($xml->BarcodeNumber)) {
			
			//save the label image
			
			$this->process_usps_label($xml->LabelImage,$record['CanteenShippingRecord']['id']);
			
			$record['CanteenShippingRecord']['shipping_status'] = "processing";
			
			$record['CanteenShippingRecord']['shipment_number'] = $xml->BarcodeNumber;
			
			$record['CanteenShippingRecord']['carrier_name'] = "USPS";
			
			$this->create();
			
			$this->id = $record['CanteenShippingRecord']['id'];
			
			$this->save($record['CanteenShippingRecord']);
			
			$record = $this->read();
			
		} else {
			
			SysMsg::add(array(
				"category"=>"USPSError",
				"crontab"=>1,
				"from"=>"CanteenShippingRecord",
				"title"=>"USPS INT Shipping Error: CanteenShippingRecordID: ".$record['CanteenShippingRecord']['id'],
				"message"=>serialize($xml->asXml())
			));
			
			
		}
		
		return $record;
		
	}
	
	public function process_usps_label($label = false,$record_id = false) {
		
		//save the label to a tmp folder
		$tmp_name = microtime().".tif";
		
		$img_str = base64_decode($label);
		
		touch(TMP.$tmp_name);
		
		file_put_contents(TMP.$tmp_name,$img_str);
		
		//convert the label to a png
		$magic = new Imagick(TMP.$tmp_name);
		
		$magic->setImageFormat('png');
		
		$new_img = $record_id.".png";
		
		$magic->writeImage(TMP.$new_img);
		
		//move the image to the static server
		
		App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));
		
		$srv = ImgServer::instance();
		
		$srv->upload_shipping_label($new_img,TMP.$new_img);
		
		unlink(TMP.$new_img);
		unlink(TMP.$tmp_name);
		
		return $new_img;
		
	}
	
	public function returnAdminRecord($id) {
		
		
		$record = $this->find("first",array(
				"conditions"=>array("CanteenShippingRecord.id"=>$id),
				"contain"=>array(
					"CanteenOrderItem"=>array(
						"CanteenInventoryRecord"=>array("Warehouse")
					),
					"CanteenOrder",
					"UserAddress",
					"Warehouse"
				)
			));
			
		return $record;
		
	}
	
	
	public function returnImg() {
		
		return "SUkqAAgAAAASAP4ABAABAAAAAAAAAAABBAABAAAApAYAAAEBBAABAAAAmAgAAAIB AwABAAAAAQAAAAMBAwABAAAABAAAAAYBAwABAAAAAAAAAAoBAwABAAAAAgAAABEB BAABAAAA5gEAABIBAwABAAAAAQAAABUBAwABAAAAAQAAABYBBAABAAAAmAgAABcB BAABAAAAP2kAABoBBQABAAAA5gAAABsBBQABAAAA7gAAABwBAwABAAAAAQAAACgB AwABAAAAAgAAADIBAgAUAAAA9gAAADsBAgDIAAAAHgEAAAAAAADIAAAAAQAAAMgA AAABAAAAUGFpbnQgU2hvcCBQcm8gMTAuMDIAZYL/q/8A/IL/q/8A/IL/q/8A/DIw MDIgU05PV0JPVU5ELCBBTEwgUklHSFRTIFJFU0VSVkVEAAAAAAAAAAAAAAAAAAAA AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA AAAAAAAA//////////////////9nIoAbcPyf3pSEwbYShgkr3/D///////////// //////////////8nO+j///9kI4HBWv///v85lv//s8D4/0TA+P9PxP8f//////+P /x//TzYtTDHL/5e7mWH8X2zc9v8XBDtEfOfy/7W3///l////7f//b1j//2/U/28d 1v/3Qvz/hiERC8b/jeLS/7ca/48h4v9/w//f/j/ZNB/2/5VtFnBmGP+X5P7/Uu5J nA/v/6fe86gk+////+P/fygE/v///8/i//+hdF9apvv//28viQX6//8fpWXe/v8/ dKv+8f//iD/i/w/9//9vof4fQ42U6/9v4f+ZVIahIPz///8RmVD+z40CE2D/4P/P hAIEYZjDMNFg/P8Hg///H5wP7///84D//8+kMukP/v/Hf1A+jP//H6H//38Q5XO+ 9T83CkyAfRwE+hbq/w9Bb6Rc/5+JAsIa5kFv4X/88fH/EPz//5mwYbT+/zeKGcb/ IZrDyEST9f9fwnx4/8+NAhNgPwQnDHMIovj//78U/P+fSPwPQTD8/7//JTD4/3+z 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 /18TBSbA/v///9Bv/f////9h/f////9hCP+xpf//P67v+v//X7+l/z8MR2jSMuob 1v//3/okA90O/f/hocP6e/3//4aIcevD8f+PeFhqffz/n8YNKWokWf//h2HJD/7/ v1118P+f0NCH4ZC14f//bxMNJsBeMDTJcDD4/w/BkwIYh/DB4P//f334/w+RHn7E zxz8+P+fusrjYPD/D8FfH/74/0lrqsAE2KEPPv7/hz7o//91kuFD/8MwBI0I6QeB /v+QPoL+Q0g4SkEf+v/cKDABdggaQaD/P5FgPgj0/68FzRVU/4+hg/6PhycZ6EH/ vx//P+3oyP9/GP7/TxoyPP5/mcOw//8yBMP+/8vtnyjpfwyfZKD/f5HH8P//ZXL3 //+XEwUmwI7/fyqb4/9HAs+j//+3PlTw/0nrv4Vf5f//G/Ulevz/CP6E459kuCT5 /3/Lwq+y/09oMLYM/f//t/D//5PWdDPg4/j//////xFMN91v+///J8XUhgmw3y39 /z+YRJMamWS4YVv6P6HBuMODwG/E//9wL7+h/8N0EI6ye8gPhv7/9/eI/x+m/Q32 Ii5+/P8n4/YFwf7/49tf/v9/e5R8kuEk+T/iG9ayv/+/8b/9/y2iwgTY/////o/2 /7f+7f8PQ9jPTYD9/4jr/X9bmmSg/39uFJgAe1gf/1OLJg1tGNL/J1QQvMzh6/8P lZcheK/xv8rLPdz6/3o8rND/NWm8yGNE/H8o5JfJfZLhpIX8r//yh8D///+H/H/X b6WOgny6Wfi/4ZZuYRB4FGTD/h/xRsnrPldQ/VsnHC9ftv1/a8uS//9vbRkiBUyA XUSzJxno///BoC1cINj//x/Hy////1j+tur/1x5bkv5PZegkofKN0v+DwJMmCP6t mtgoCfQvD5V/WKH/L6/yTzIc8f/Lr0SFCbD////kofuaNP6ftND/LznsQyG/9UHg /1/99eg1yv///29dZOH///qurYfg/7+h0A23ZDCktf+/cR2xUZMML///9Zb1//+t 2iI6TIDd+r/1b4W2tv7/PwzhYNBg0Ni6rX8cx70OQ/r/YdDj/2/U/6lFP8lwQ1t/ QgXBTySYfjC0/6Hy/3j9Vf5/67/+47D+mjR+ktIb+odCPkLnljwY+tcP6R7//xA0 yUC3/+86aScJTIAdgv7/hlsaMvsh6O3/Ea8ipg5Bb/+31oSjhaCRZLD/tz48BN0T C+RvLegh6KcENn8w6HKEoHEI/uNl5gVNMtCH4P83PPTL//uJAhNgT5gmf/lPZegN /X/5DwJv/I/Lfwi+/pf/8tbj3JgWYQj/H9b/QWD/RYI9DCFOMtBfEPxfPv6X/8v/ l+z/z40CE2D/L/+3TtonEkyPv/9bh8z+f6n/Rq0ipv7//9eEo328/G99+P//MLSg J4j5nrua4v8PBl3+r/3/8TLz/9r//xv+L9n///7/8v9/Q/+X7Fv/1PbG4z9z/3/7 +v/3+r/1/9/6t4c1UWAC7P9/67+HIfy/dVv6+zi+Ldetf9IA/b+FNwzp348bmetg 0P+/ZWij/v+wcOv/j1t//Lf+I5Fg+q3/z43d1v9/GPrPjQITYP8Hg/7/3IQfTDjy /3iixPFPZeh4+P8g8HNX6P8h+LkR9H/5Yfj/TzsZpof9JPcXCfYP+0H/5T/sh3JF /+W/8QrB///hyxD8b50bBSbATloze1/lf+v/uMp/o/5f//8/txz68t/6HwQ+pH8Y en15Qf0Hg0Z9kYWvhPQ/rh+CX5L/19de2v7PjQITYNcv//pP6B8ixq3/pf6HTPFL rf//X+URUtT/9V/DS37r//+v2uv1v6CeGwUmwB6yDoN+/S/4Fwxt1P+/mO0fwg39 +v+/BkO3Sv9bH8cv/YeF/+2hf6P+V+g/QfA/N3aHpfpb1hMJpn/j/5ah/7/+sPCf m/Bb9cf/RIlf/5GkdPit+g86d4W+FfoTigadG0FvBf1lDs+NAhNgJy34MPwwhH8Z gh9EEOywH4b+cj+IcNSwH//xCAIN+/8ij4cIoWn8v0zuBw3/f/nB+/9/mHCKOFXR /62Dwf+/hQcTBPv/jRpMcMb/Jxw/7VTw/29Zc6PABNjB/79l6MH/v4VPJJj+//j/ //////+fytAR/z8I/P+Xf66g+pf///L/P3no/v+XHPb/v/r///9kQ0D+/zo3CkyA fQj8/4ZCf/n/xvXLUxX9179Ixf+36g/B/2+F/v8/DOH//8f///+Hof8fN+r/b/3/ rf/PjQITYB8M+v+P////P042BGT8PwT+//L/uVFgAuzL/3+Riv//Ifj///////// /+Nh6P836v9b/9/6/2DQ/8f////JhoD8fwj8/+X/L/9/kYr/fwj+/////////x+G /n+j/r/1/63/Dwb9f/z/ZMP4//f/D///8P/P3P9/w/9/GP7/w/7/ZFth8/////// /z/ZMP3/////H/////////////////////////////////////////////////// //////////8fERH/j///////////////////////Pzd+CKKLQFwypdZqCLpTjmyF oDYEQ1AjzENy5yCoEcoDgxkWMIkTfAieCXom6JmgZ4KeCXom6IXgmaBngp4Jeibo maBngp4JeiaMTJBM8ExoJjQTmgnJhGeCZIJkgmfCM8Ez4ZnQTPBMaCY8E56JZkIy oZnQTEgmNBOeCc2EZEIyoZnwTJBMaCY8E54JyQTJhGaCZMIzoZmQTJBMeCY8E54J yYRnwjPBM0EyYWSCZ8LIBCMTJBNGJngmnPRzXP///////////////////////39E IhBEREREREREREREREREREREREREREREREREREREREREREREREREDCIeJquGyA8O MVfCZXEImjAyJIHhDyYiy02FYJgW2phqkWkixBeBJzH7FtgQrKv+EWzRY1VVHaMg r6oqqWT/f8nZ84dgLsSfzqw8jyAYgnnE4mfPns7MtPCHvAx5yA8Z8r8M+ToMiW5H qos1Ft2GIRgS3RZrvEaqi26XSjpkS5cVsj9klyWVdMj+S5LXkksuSZJL/rXk/7/+ //+v/7/0S0u/sPS/8CX91///1/UT/pJeqqWXpBwuSSVVbraX/qX/pf//b7/+//+z /P+zvKX1lr61pW9t/W9tQ1q3oasNtaFvQ7Kh62pDalSkcIWNkirKqHDYqCippDKK cxiy3tDDtDf0hmDa/xs6IiIiIiIiIiIiIv7/f24QJqm4X8x8KPSrftX/+P+fZwYR RkCEN+3kJj+ZEz3CmyyIBR0kmIgt9BcMwS8/BD8ELxiCHy0f9fJDcLT8/5df/idu izQGk/MXaYLJedJM3BZp/LoMnTi/7JfsugzRYkWJxjzmxmJSMCmYNRjc6PzyxuvV 0JeXN4LA/4f/B19f+JL9wfL//d+El///b8ItCP/f/8P//39YxOfxT+b/w/7//2EL gv2//R/s//8fbMn+3/9zxf+z9P9ccTnPDJrHPDOIC6YaTzA6gwjjnwVzQblgCtOZ T/95wf87/Lb0vOC/4F8wBEPwgodgCP4hGIIheFnwf8j/6vqtD3m1oz9alpej5V+W ITgKwn9bZ+jWsDRDt/S21v+yvLz8Ksvy/6PijY3jjT/qE7c/cVuksUjjRZ6JxyKN XxJpLNJMmos0/9ZvvfXW11+Xl7+Xlx+Xly3ZiV/+t3wTgrd8GHrry79csiV7WN+S fUm2Giov/Q9D1jA0DLKGoYeh////8fI/9IWSXeURERERERER8f8/jod+fFD8//// nwGdYPh/8vj/3/r//6D/2/9/r/9PlpDri4j/ZPnt5Or/////k+//9rP0/9b/78al W/vt7rAt3dqW/t+Zc+ZeL2fu3Zlzbd1vGNL/hwWHBd8a1rDg77DgsNTSrY36f6OM SpgHjjLqbaOMjTdu/b9lbULxZb1blrW3/t+ytk7jsr4tC4Y2Ifhg0P/DEAxtqIch GHobhmAQDA1DR0RERERERERERERE/P///7REA6Rg+f9zqycEzo+JHDdF3Bqxo1TJ 5uQ1/D/nSf9r/6/r1yz/x/EP3f7/Lxq///8P/fOJnFiInLjGi0fkRDnNJxYiJ37E TZj4Efd8YiFy4kfcXE2PHS8+zQ6CicePPLr5ETc9dnSGYB7xI+5f/4IhGIIFPwQL huAhGIIFxxAcD8EQLDiG/EPw/wuOX15w/PF1sbbYWHRbrP2i22JtsfFiY9FtsXZ6 oXt6KTYW3RZrpys68IuNH4ZsKVLh9I1UGIbE2mkd5F9acsnLJf9yySVf8nLJL/sl L5f88pf8//IvX/L/8ZL9o2T/KNn/j5Jdkl3/KNkl+f//Zdf1kl3/+vHwf/jx8fD/ j4f/f/y3pf///4eOoQbHb3AMHWpw/D/U4Hge+g/9//+P/2fV2VAY/MPgSUDnQGHw /3OgMPj/50D//////9lC7MHOwAc7AxP7RezBzpb/IvZgZ8v/Rex/W/r/s+X/F33B /sFe9F30Bfv/RV+wH/9F3/////9/86sZefN7Rt786mtG3vz+rxl58/u//v//b37/ 36W1d2ntXVpfe5e2pV97l7Z1XX+jWvrfpf/MfWurra2ttra23mpr663famvrra2t /63/t87c/zfKSOGNMspI4Y0yykjhN1J4o4zaqDdSeKOM2kjhjRTeSOE/fIg4/g8b 9f8fhizbEAxZG4Ihy96yDcHQMPSWbQiGhrW1Zb9bG/p3GPqPiIiIiIiIiIiIiIiI iIg4IiIiPiIiIiLOByHZbHPLicpE3Nys4pnUUOLMZtYoNUwoYjZV/P/wQ7Cu/xD8 /6Xvh2BdJ2gv3///HuX0vng//h/Sp7NPnn8Q8cXxIp/7f/2+BPv/L/+PiO/MPNsM 881nZhNn4ua7ZiZmMxgC0802caabTmwmxxCYYWZiNoP/H1mY2cSZuPlmmJkoOI17 tvlmm05snk4UzGzizPDfhuB/CI56yRAED8EftQzBEPwQPAS/UQdDcNQPwRD8/zIE L0Nw1P/lf3lbGuX4j7hfjv8Ny/+yvP1HHC3/f5Hbb0sit5P/i9xOasOgk58UxGHR HQYtcjup/R8scjv5LS1yF7n9f1IQh5PaIreT8/8h/w/5f3n5X5Zb/uXlb2045P9l h3z7L8vLDvn4X/u9tMtrya6/qsZfsut/2NrltRTS/r/qcu36H//Ht/7//9D/R0QE O/4f4+3///j/f+v/FP//Px/y/2B/6///////93qvDv//P+j/w9/r3/7//7+UXt6n l62u//+fFP+fNPb0sv805P//6eX/f+n9lv7/X6D/v/+l5//G////ofb79pettvT/ /29Lb6u9vx22f/1bsv9Rze7jZncc1fr/3/qtH9Xsjm+p2e2tf2uzm8W/jPBbRnjL Mur/Pw7eqHcjvLWxEX7jP8oI/y/rt96y/v9NBO9bb1m/Ze2J4P80Lut/CIZ+GHow BEP//zDUPgw9DMHQD0Mw9DD0vwVD/xEREbEQERERERERERERERERERERERH/Xz9I v359PDedCcSUx457iXBEjbQREYHilsStiERM34fg//8J/5wn+L8sEPH+//V1/Wft /xH/x/8vwf////+/ZP///3/8yf10ZiF+xM0h1jSdebGjmx/d/NjRmcX05tN0k9MQ zCOu0U1O5DTHHCI3PT4RjhcvehA8nSGYR/zoJifKiR9xEza92fHi0/8hHy04FgzB 0S94wS9DfgiOsOCH4AVDMOQlCIa84P+jh+AFC4bgGPK/4F+SLTpwclisnX7WFt1O Dh+pcKTCRyosOvBi43RbrD0Mie6RCouNRbeXxMaiA4u114eh5DAMiY0jFRZri+7p hQ78i7W/fnm55EteXn55+eXlS75L/mWXS169JHm55B4ifn35kpdLXvblv+Rfeslr yS7JHuvLLvta8r9syX7JLvslX3rJJfv/679syZbskvyX7C9J9v//4f////H//8fH KPy/1fV//P///yeECJk1scbEIsoxa6KciDprYo0pJ2JhQiIBTkxkEGtMOVFOZICT g1+K/+Njg////4d+/P/Qh3589f9DP/7/j4dghWAIDMEQDMEQrBAMwRAMwbpCMASG YAj+S/L/D4P////nQP//Z0NvPvT3r/950P///yGrDBmyDFlWWZZlVZUhy5BVL/2f LTOJ////F7H/bPm/iP2ZF7H/DFz9/0XsP6P//7PNNH1Wkdvpd/os8jh9FrmtIrdF Hos+izzWjFH0Of0WfU6fMzrbYikr/3+w////F33//xd953eLvn9X6/+i7////5Jr CC655ILgkofgGoKH4JItCP5LtuSSLflfkuz/5nfzI8////+vv/n9f/17/c3Pv/6v v/n9/ze/y4ZKdtllV5ct2VDJVru8WtfyssvL/ktv67u0S/3fUku/ra8tufS21NJq S/dqq0v//68tuWRL2/rq0urQl1xdXf2hX7+6aPyi8S/5q/8TPky89VtvtfVvbf1b b21t/dbW1tbt1tbWKOP/W1tbW2+9tfVaJP9fF9Yvkn/8C2up/v9akq5LtvEbtVFG /SHiOEQc/0YKv5HCRxl12KgQcWyk8EbtRgpvpPBG+Yc/bKTwIeLYKKM2UviNFN6o 79CSjd/fkh1asv+ll3787/8/TPuHoWHI0L+hDf2w3rIzh2Boh6ENWTYM3ZYNaxi6 9nfL3hAMwdCw3hqG/tD/S/+hX22V9Omk27qtP52m0xERERERERFxHBERR0RERMQR ERERcURERETEERFxRMQff/3Z9I9/tTSbpCMs3ZK29BGO8J8oPXfpua//v34I/v8h GTUE110bVUZ993/ppZe29VdbF2zr/4SxoQVLi/yWNqSGbBX5LfL7b+u2buutv9Qa 2W39f8GRXb1sXbAkuLXssv9RRx21rb9ka8i29f+w6HPIrtFr0WdJ9NlWdPQ/DA1D w9CR438pcnx55Pj/ibFkl0vb0pItSXbkeNs+IiIiDutfgnXZsP7fJS9bX5dckhzW /w39S4Z+Q/9vl/3SS5ctlW3o//gv4Y///38EH8EvPf5najhXTLnJI8csYJCDwcws cD4MyjFzhKPDYINzhZNgFnDCmAsmh7PAIAPODR07orX0S9JL////v/TSPwzBD8F/ eAhuvfuGYAgO3/9vS5D2t6Vtid/vz+sf0k9E8/oNwT0Ev0DE6yHY626BiNeQIbjv f9b9CyJw97z+/7+nvCViekHP66WlZ9kinV+kM0VU9FmeqUnnzypWnGV/VizyWaRz lp1Rsuz/pV9aWlr635ZsXdp+WyVbl+ztP+yQ9yH/3z7ktvTw/YcLgod82O//tm5L kq222mpL21LrZeutX9Jla2vrd8kOIt6S/ZK9L9n/v2R/tWTv/39Lh6GCWgpLLYWh h6G2ZBhSWNqWNgxJkGFILdmSLf0u/8v///L//3+r/P75xJr48WJH3ByinJ4rkXu+ 6fGJhTZqoxIIOsooo4zaqKjYqKOOE4iMjYqK+i7Z20v2/y/ZtvQv/Uso2ftLgiH4 Y8EQ/IIhD3nBELy1pRYsy9qCBUOwhjUMKQxZsGD9f/t/yV4TnPgn+IRGSfbQ/xMc CCXWFt3+9LO22PjF2qIDiw4s1hbdHoaGoWEIhmAIhoYhGIIhGNrQMDQMwZAhQ/// /3/p/6P+qP9f8vJfcslf8vJyyctHRERERERERERERPz/9v8f/7Z09df/t2SPX5L9 L9mSSy7Z4//f/l+yK4P8swrKsiU79H9GybI//D/+///hz62E/v//cej/s9F2nI3+ fzs2+I+hH//HBv//t/+Xs+rb0tu7vD1h/b8Pg/9JQP//YfB/yZa2t6X/benf/rft sC0t/ZnEfwYm9p/B/wzjj9/6t35Wfmvr25+V20ut/w/2v+j7/w/2X21pY1t6yX5b 8npfJXtvtaX1tfmR53/zq7/5/Tc/ev6H1Lq3/n/rfy/9bVhqHdJLLvXrLq3vkq22 utT/KKPeqP8TxoKKE0a34982NioqYQxD4FZbW29t/dbW1lZbf8HQDkMv2Q9D1ntJ 9m4IhurLKKOMFH6jjBT+jTI2UnijjPohGHoY+n8Y+jv0NwzBUOhDMGTIehiy7Ich mPawhiFDs4YSZe7BpJ2bzxFvok5kEWRqifcREREREREREREREREREREREREREXHE ewh+fV0/zU6fZy92RvzH8UtvL8H/v63vl/3/o34OZuH5sTGL6fP5ecyfOLFMn88s zMKE54s/fQg8nVnzfCZnCMyYuDnMn868+cya+dMNgRnzmT+dD0M/ZMhLkCEPwY0Q HD9kCIbg5T8agodgyMcQHD1kCF7wQ3D08c/PYu2l/CzWWGxsi42zsbRYW2wsNv6H Qem22HixsVgbBmXHxun2Ym2xcaTaMGixcbr9V8nLXpK8vDzRIv8vu7zcDhGX9OXl l5f95eWXXV7+5eV/CZd8CZdcsg2W7Gpdcske1/5ryV6yJb+06yXXLvu169OuwFTE Y6LGjrSRKiIiUCRigopAHQU6Dgn0nzX6ez1++Nf//8cv/8fy//I/BK///x9iQY5Z kI9Jd3z/sYlXf/3Hx///////5QX6//98JfYPEfsf9rv0G3z5////////f5Hn9fjj f/7P3Pn/nM6J+fI/l19b//NlDv//////h+z//1965suW/v9beuYnOPvr/5/5/3/m ////+///////3ff+3yT2//++/1v/b/1v/XOTED/i5hBrIidy4sWLHXFzaOTTEMyK yP10ZiEW4kePH4fm03ST0yTiEdeIm0PkxEL86MxmXnRmMwvxozOL5xO5/9WWtldb nXlbcub/bcmZ7728/p35nXlbeq/flrxaeq8/BMeCIVgw5I8Ft+CHYMhHC4bgvQQP wREW/BAcC4YMwcuQlyELXoa8YMh/Q1v3hraGIdkahrRRt4Yh2VIc/4chHYbU+q1/ a2vrt/7FxulnbdFtsbbo9qeftQ2LtYchsbHowMlhsbbo9q1i7cXG6bZY+0W308/a otuie6QCeThSgTws1o5UWHRgsbbowG8EEd+o2wgivhFEfKOMMuo3yijjP/iN2iij gjfqN8qoEHEcvFF/yZe8XPLqX3ITLfKXvLxc8vJf8iXfJf/yJa8uuywvyyUvL5e8 /C0b1rZlwxoWDMHaGhYsQ5a1P6xhwfJh6IcFQxvyYej/JdmjZEv+JdkwWLL/Ja8l e9xLsv+yJfvHkmzJJbvqqiW7llyyJR8RERGRPo6IiIiIiIiIiIiIiIiIIyIiHv/D P/5PFPrH/z9864//f/gf///////1Q48Njv9j8PjZKPQ/NviPh378Bh///x//x39L n1sF+jD4/+1/NvR/GLzXc6D/w+D/////f6O+iP2ZxBn8z9AYny1fxP4/w/jPwEXs P1sO9hn8/z9b/hn8YX3R98F+fv//o+j7P9i3vuj7P9g/v/////8RX9/8yPPm93/z 65vf1//Nj57v1fyuv/k9I7/5/f9/8/tvfv/XXepdsqV1lwxDculXW9+l/nfptSWX vt8lW7Kl/3fpbXXJ1t96q62tra23cjJu/dbWb7X1uPXW1ta39dbW1v9v/dbWVk7f SOE3yiijjDJS+I3aMuqNFN74jTJqy6iNFD7KqDdqo4wy6v+NemOjjP+WPQwZgiEY sh6GhiEYesuGaf8wZOhhaMvOHIKhNzQMwRAM/T8MPUx7GIJp/0dERERERERERERE RERERERERERERERERERERMT//581nJDZczcmBROfKuLNDTRR//0QrOv/8wKPos+5 VkQQ5en6wxdkvxD9t5fsB0P/+Tx7+ixzmD9xE5/5ch7zpzMEps+euOnTzTYzhsCM +cyfzqyYnPkTJ5bp85mF629D8D8Ex68IwdEfL0OG/BAcDcEQHD9kCBaI/n+x8duS 2Dg7SyU2Trdh0NkhFcjD+RkGLTZOt8XGYuNsLC3WFhvv/8v/y//Ly/+yXPIvLy8v /y+7HPG/ZH+rZFe/dv1VNf7a9SjZ1brkkv3/3+t36fL/f9Av//Dv9fj/4+/j//// 5yH/b+LD9x///116+///HyL2/2/wu/T/z5d/vlyyCf////n/f/B8+Z/bSX/pb+l/ /f9/6f8nom/pmf9/v9/bd7X+//+3PsXe+3//JWf+35k/ylav///1vb535v9tyZn/ Q8OQ3qgwpLchtf7/N/Rb35bCkDbq1jCkHyGjfqN2o4z6/zeCiB+8UW9s1G+UUT8E 6y1YFwzB0P+/Zfsw9IZgbQ0L1kdERMQRERERERERERERERG/9P8g/To3namA86NU RESgKBVBIlC0T0RE5sZDcPifqk/g5zw34wn/X+5/Xdd1/S96nOX/P/7/v3z7//// P77//////+cTObHQfJpucpoLkRMET2cWgmCKIJiL5xM5sRDX6MxCEMwSL170iJtD /OimnPgRN4f48WJHZxYPwdOZhSgncs83PT79fwiGLHgIjrDgIRiCj4bgH/IQLBiC lyH4P4bgBUNwDMG/DPmjBQuGPOQFf0jrYmPRbbH2YuN0W6y96LboDkPJYbExDA1D ogOL7mJt0e1IhUV3GFpPHxtHKiw2Th/dP1Jh0YFhKDks1hZriw4sOrBY+4O0tOTV ki/5LvnlZV8u+V9etuTl5WXvIeLXkpdLftlfXn655JKXl0v+O/4ll+y/bMl+lOzr /yWXbMkea8n+v77sL8n+WvJryZZsySWX7M8tqcbHH/8//D/+/3/4/1bX8cf///// /3+mIz7Cnz+5yefPQrdDQ4+HfrzB/0P//9jg/69+6EP////j+D+eYITErMWCkC75 h+CXuZmZN/mkI6TrZ1UO9OdA/2Hw/xzo/z8M/t+/ZoY+Cej/////f3htFWuLL4KK tSWoWBuCv/W/iP0ZuIj9Z0uw/xex//8zjP9f/UXsX8T+//8/ozP4n23q+cfz8+Wv 5asgO59jfv7cdb/oO78Xff/B/l/0/f8H+/+u1kXfF33//////7ffXrIfAhH/h0DE 3yX77d/69Te/629+U+T/1/9/86Pn//vX9df////Nr/n9N7///V/r1xr/9+/Sr7bk 0mtLLt3b0r/+ttqSS/3b0v+vLa3b0vq2/i65ZKutLv30iU+fMd2Ct3ksmG3eP3Eu 3JYKf5xu9oyJe5vHgtnm/ZjTt7a23trauq2tf+vf2tpq67ceZXxra+utrd/6t7a2 trb+0S//kJd/od+ol44++iEvf+s3UnijjNpI4aOM2iijwm+k8OHDxkYZZdQbFfY3 UvgQcWyk8BtlpPBvHH6jjDI2Unij/qAjFTb0Ym1DYmH87Pzyb6fDp90v1jYkFsbD 0G/ZMARDW3bmEAxtCIb8Ldt3mPYwBEOGHob82rI3ZNnDkPXDtPeHIRiCaQ9rGHqp Lv/Lrx9bWnwsLSW9/LK//PqIiIiIiIiIiIiIiIiIiIiIiIiIOCIiIiIiIiIiIo7H X//4kv3+ar8Eg+vLH1+yP/XrQ/+//v+XvwT2/6//Xzon/j8HPf7/HxLY/z8HPf62 /v8vEPH/6S/90pL//wIR/3/U/7+KzXOFpZb+XxAT6/+/is1zneph6P+/6m91fcPS S///Vf8R//91vTkbZZS0UdIifGtZ/5bW9eb8/3+pdVuyDL31t/S3LrVuS///cJQR RPywMXtEREREo/6oKCOI+GFj9mdqZh03ov/3snZDw/pzXGXthr6S/yMiIiIiIiIi joiIiBdI/1///////+cmIQiG4OnMQlyjm5zIaY45RG56fBoPwR8teMEQDHkJgiEv +IvuMARDyWGxdqTCYmPR7SWxsejAYu1f9pdLXi559ZLk5ZJ/yf5asst+yZdecsn+ //+Pj1H4////+KEP/fj//8+G3nzo//8/A1/E/syL2H9mwf//f9F3frfo+///b35f /15/8/u29O9SS6st3autLv3W/9bW1tbt1tZWTrOG0yeQiDrJRLoYEwVCzPSpRUQy 8UkrxkQnok0UKGmY9cx8ow6/USHi2EjhjdqNFN5I4Y361yFY74dgXYf88vJhaH8Y 2pBlw9Bt2bCGoc+Jo9h5zN+j2DkIx3yMuTILq/j4iIiIIyIiIuKI/5L99pK/BPty qPbnLv1zmJkhmPjEzWbOdLPncTlj4oZg4vOYM907j6dPnz+bORMn/mVzmDPdEEyf MXETnx47PkMw8XnMme7nMGfixJ/4PObzXJiZeUu2QMQv/0u/LB/Ly8tSR/jl5W35 X46XUF7+eFmG/PLyKMcvy8vyX/+39Rdri4VhKDsWjlR4sfCedRhaLByp8Iu135bE 2tlYWiwcqTAMnQ1SjpRbrA1Di4UjFTYs1s7G0mJhsfZibbE2Pv4/6oRGQbbkl2SX L/lXv2SXvyD7X5Bdv2SXf5Xl5S/Z5YkPsuuXXJCdkIBsQfb/H4b+L/zy+sLfv7z+ ///tL6//qhH65TUM/3/h///b0COeE+P//////+O3pfil//+fjf4/K8fb0se5wPEf QcT//////////7/9//8vsv9/sP///4f1/1z8/1///z8Xt6Vc/Cn+/3+B/n/mz0Vb +lw+Fxzy8f///2/X///S/79k////9f//////0v/m3Zy/9W/Oreu3/jfv/+a9cUut ///rt7598/5vzs375t28bWnO/7cl17el39WWWnpb+iHZ0htlS2+rLf3/t74tfUOy pY3a1Za2JVtqvfUn3BsbFd6o3yijosIb9VHGv/GWUUb9/xuHN+qNMv6NMt7YmH0U 5436b8jyrd+CoRyXb30ZesvQw5D1/2867FsPy9DWlqENGRrWG/qIiIiIiIgjIiIi IiLiiIiIiIiIiIiIiIiIiIiIiP//0h/6r4/4///////PLZlkpmAGE49qONHjfkyo mKCmw7lZIwEnkwmbjNhRYsImJnZfVz08BM9NvRQ+TLRbv/W/CkQ8gQS6l1epb239 1v/6VZjlizxxzfKz/B8f//9vH7Kv7bcPIn6OP4j4Of6vkv37+7q/f+vf+l8M/xAM wYzo8XsekdMcc4jc9Pg08okfccyPHp9YiIW4Rjc5sRAE84jc9PhUzyN+xM0hFvp5 xEIQ/M8jcs+OT/884veX/t+WHoIhL0Ew5AW34Agifg1ZMAQvGIIheAiGvGB9CI4h C/4hGILfa8GQH4L3GoL/S0s2DMHQtrSKjUW3l8TGogOLtQ2LtdNjXXRbrC26Hamw 6C66DUNiY9GBxdqvYuP00W2x9qvoLroNQ7cu1hYdeLHxrYuN////vyR59ZLk5ZKb aJH/V0teXl52+ZKXSy4tSX615C+VXf6/5OVL/i/5f+n/bSl+yZdecsmGwZJdXksu 2WPZkj3+kkv28Zfkkn0s2eP7S7bk//7/X1qyf6MKH6Pwf2Lob3388H94/P/CH//6 8Lf0//gtjf+Xjv9D0Id+DB7/Hxv8b/DQjw9BPz70Bv8f/9B/6P8Iy7+V1W8+9Lff 64fB/zB4HvQ/q/9n62Hw//8c6D8b+v9/eRH7My9i/xmd8dnyP8P4H+xF7D8DX8T+ s+UP9tvSGfxF7LelRez/n5X/i77zu0Xf/7/1+Q32P9iLvv+Lvs/vf7D//xd9/0Xf /9zkJPsXiHjXv9ff/Prmt9ff/Oj5Pz2//ub39d/8/un5/83vr//r//8v2a+2dK+2 umQYkkv/tuRS35It9a+2uuSv25JLb0v9e+2Sra97vf6f1/9/a+t2a2urcevxra22 trbaemtra996a+u32jqv41tbbz2+9Tn9l+xfsjdSeKN2I4U3UnijLKO2Nsooo0LE sVFGhY0U3kjhjXojhd8oo94oo8L/RhlvpPC/kcL///+X7C0bhm7LhjUMwRAM/TAE Q4Y2BEOG3LJhDUO+ZQ9DMPQwZMjfGoZg2m/ZW1v2PyHQIyIiIiIiIiIijoiIiIgj IiLi2IiIiIiI6IiIiIiIiIiI/qedteeO9v8vvdR/Zs66rdvqkvTcrOD0yWeDk0P4 4AwoH8qfhSiIGCIRy+TTwengDHDG5D/qKBvxKSIex7yIm2Fe/+HD4UEwBIPg+78/ DA1D9scQHC1P+M/BPM9Xnuf5os9iZ9FnQcTvmc9XvvojIn7J0f9vP+xhL8gF2YL8 //+fkIayng464v//f9l72R8i/n+I+P9Lu+r///9xHCV7+3/7cytHOHbcY8ImJnYk hXOzRgLOOpJEYcKm1CTDYMdN7y////91XWrp////3/p9eNK/lYh520/UPxP//196 aelNqmpv/2//v/X7Xm9VtV///z9OEIFKkMbxmwixfPsTpAnS7T/+eJZ9luP/d1Yd ////PhR6MPz///8PIn6Of3/7g4if49//v/U/53Mwz85XPspHT0kLvf35ytf2/1v/ 3//Wv//f6/8f9vv+sH/7f/tPuOnmR9wc4kcc8/vnEb8JIX7E/Xzix4sdnVn8MyJu euzoDME8Ivf/PIJgCOYRP+L25xM5QTAj4uYQPzrz4tMf/+z+//veppj+NsX5//// H+EYguP3GoIfguMlCP5lyH/88oIhv9cQ/ILjfsGQjyF4eci/9f//b2+//irZ2//b /9Pt9LFxeizdutj4Rff0ghLdP1Jh0YHX9I1UGIbE2qID37rYGIZgSKydzhN8irVF t2EofXSPVHjR7R+G/v//7e1bsrWl3/jf+L8v+f8v+Zf9ZX95+dKXL3n5v+Qv+fZL Xv1ll189IiIi/g/p/w1LYcmw9P//v+z6+v3/Jbtasr+WPK7rJVvy/f8lu37JlvyS 7HrJ/xOc4wSP9vZGGWWUZO8neBA8+v/Ht6VbGv8/y/7/r///b2n8/7Pqj///+H/o 7e1hCIZg6Pd////Q/x/6//b/f+j/+P+hH//H//+PiIiIiIiIiIiIiIj/nxn6/7Oh /+///1n1//9nQ////////4vYb0vb0iL2//////9n8LelRew/W/4Z/P///y/6/v+i 7////////7/o+/8/v/9/fv//+v+v/1////+/+f1//c3vv/n9////W3rdqL1e35Ze sqX1bf1/l2zd6/Vdut4lW3pb+m3pJ0hsvfWPb31Orcetrd/6/62tx7d+68orYfTW 1m/9W/9HbaTw/xsp/G/UZZSRwr/x/2GjjH8jhQ+HjfrfKKPCG/UbNTfSLER4ZnOB UsQyiShigxOHGR4mhjjg/8yhLXtra8v+YegQDFk/TPv/HYZg2m9t2e4wdP0wBEM+ DP0w9LJCcPhbH4Ih+CMiIiKOiIiIjoiIiIiIiIiIiIiIiIioiIiIiIiIQ8XaKtbO c0HE/3MMJ3ihx2Jn5v+1CrIv3/5DxBeI+H8ILsj+0joEIv4uEPF///9/yd7/Ul3j +r9k////+CGhNH5tS/9vS/+S3b+kl6SNWrX//9+k5RF/XV4q/z9B8t9E+L9Ui4+j /m3p/8Hwf0la7RL6/xzzJ6LPRI60cKpjx32Y1Ew8skRoTKgIwtwokaKX9PK8+v// sD8T5sMPwTo1H4LXf0gR/vP/tvRvS+T/9X7IAq3LC/Qv/Uv2////H7PsUeRz4Sjy xMJfEOX///9vS7b+h70g+Ifsf2nD0v9G/YehYem/X/37vwjnjVqyExo/wf8wyqjP TUL86IZgRnziR+ebR7Ojx49D/Ihjflt84kdnCGbEjrjp0ZnNLATBjPjEj84jn/gR x/zo8YmFIJhH5MQ14uYQuemx48WOHXFziNz/W///bwiGPgQv+CF4eRf8XoLjJYTg 5Y+XIUPwQ/ByC44g4teQBS9YcCwY8n8sGPIjIiIiIiIiIuJF90iFYWjRPVLhF2t/ q1g7PZYW3SMVhqHTh1QgD4uNYWjRPVJhw2Lt9FgX3RZrw5BYW6ydftYWHfhPP2uL DvzLLv+yy1/yf8n/yy7/y3LJv+xyEy3y/2rJl1zyJS//l7z8S3bZL9n1S/Z7SXb9 kl1/Vf0v2TUMluzyWnLJXrIluyRb8r8kW/L/////3/rb0v//j/8/EfS3Pv7///// //////g//v//f+j/g8f/x8fx8f/H/////3+v/wnr//850P+33+v/////////S9ny z5a2ZIf//1/E/v8pOlv+Z+AZzMAz+P8Z/LkZs8IkiJhYJp8ZM4MzJgHOJ2KIRJQz CzETM5P4////f+v/0v//i77//9/6/P7///+HYAi+h+AfgkHwgmVZ8P///7X5vVfz +1v//7/+/7757fU3v5tf87v5/X/z+xc9FjsLIn4vepyv84qdRZ8FEV+sLdYWa4u1 obellt6Wfkgu/bu0UYYlW/r/X9+W3jAkl/5tyaVdcmmXbF3fJVs/BBdk/4fgvyBb kL/k5eWS61tbv/WjWj9ufePW///Wb33j1uNbW29tvbW19VtbOb1k7x8i/lL/e9lf tmRLdg2BiH+jQsRxeKO+jHrLqDdk1P+/kcKHN+oto7Y2yqiNMmqjjBTeSOHfKOP/ R8nefusfR8n+f7w+DG3Ih6EPwdAPQ1swBEP//5btw9DDEAz9MARDwxAMDUOwtn4Y gmn/S3b/L+Hf0v+/hB9HRERERETEERERERERERERERERERERR0RERPw3CbO3/zep qv3/PP7/v4ms8u1PkJ4gR4RY3vrff+l/MPz/fPyD4d/Wf4r//084obf/fJ2rL7QR RPx/+w/pf9hvP4l/2G/9/79+W2J8/n/7n8vbFOcf//8j4v9L9vb//yrZ5Ev/9P9v S7b+xva/rS19b0u21Po/DA1L/2HoH5YMS+9Sa6tL/4QeyijJ3mGEEjwIDYI3yijJ jjLKKKP+G4Kh32HohyEYeliWZeiPiIiIiIiIiIiI+P/////////////PjYFSgbmR o1TcGhER4agyOf8hmP//CsFkY/0v6/8q6xcDIs8fRxU9/h+y/6Hl//d/0Xj8/wjB POJHZzbzopucyD2J6CYncppjDpGbHp9YiHC8eHGIH9/0pjMvdnRmMb3QcyV+vNjR mYVYiIUoJ37ETR6d2cxC/IibQ1yjM5tZiBM/8ujMQhD8J849BC9DXrBgyC8YgiEv QTDkBUPwL3jIR78M+XoI/mXIgiEYguNlyBAcC16GDMG/DMF/SbBhGBIbRyqQhyMV FmuLDhypsNhYdHtJbCw6sFhbdHtdrL3owMnhIxUWHRiHJLp/pMKi22Jt0W3RPb0g FcjDonv6WTtSgTwsNralSIVFdxj60SZaSl6Wl0teXi559ZLk5ZKXe4j4Jfnl5ZeX D1LZX14teXnZl+VlL3lZLvmXl/1PXxj8V122ZEte9ku+9JJL9vgv2UteX0t+S/bX kkv2KNlVtWSXZFf9X0v2H5sSGv////ExCv8Pt7r+///Pqv8fP/z///+4Lf3/HXzo //E/9KEfG3z18f//b///scH//8c/9P//2/Og///Pht586A+D/ev/////fxj8//8/ B/r//ynvRez/z+C/iP2ZF7H/DOPVz5b/////n2H8/38G/iL2tvT/5677F33//1/0 nd8t+v5gd7X+///z+v/nN9j///+Lvv//b+2v/29+//Xv9Tc/eu5fze///2/9/29+ 9Pz//+b31///d8kwpNe/JZdsbWm1pXu11aX+36Vt/d/WXbKl9W3Jpd6W/m1pl/7V qLelfxQv41v/1tbW1tbW7dbWVlujjFtv/b/1uLX1W1ttbf1vvfVv/Vv/1lbYSOH/ EHFslHGIODZSeKN2I4U3UnijjPKN2kjh/zdS+C2jjBT+jTLKKKP+jdqo30jhf6PC H9Yw5Jb9bwiGYNpvyLJh6LZsWMOQoQuGhvX/sB6GYMj6YQiGDMHQPwwNQ79lWw9D /hERERFxRMQRERERcURERBwREXFERERERERERERERBwR8T93aW5wk7r/v7S0JP23 1VZb/x8VFQXpPwzBEAzVR0RE/P9zK0eSKB2JyICTOVaYUHHz2JEm0saNBOP/h4n2 EPwT9f//ty7/+v8fs/xFnvjjWaL6f/tD9v//33///083OXGN7vlETixE7knEjs7P IxaCYB498okfccyPHp9YiHJioecTOUEwIz7xo/N0kxMnfhxioSknfsT9Iyx4wUMw ZMGQf/khGIKH4FtwBBG/hiwYMgS/YMgPwcsRhmBbEgzBQ3D8022xdqTCi41Ft8Xa ogMfqfAquotuw5DYeMNi7fRYF90Wa4tui+4v1hbdhqFF90iF023R3ZbE2qLbCTJ0 T6f7XfLyJa+WvPzypbLLl3wTLfL/asmry37Jq7/s8r3sl7z8sv9lS3bZv+SSLfl1 LNnjPwyW7PJacsmWXLJfsiV/ya7Llmxbkuxxya7//+Pj/18fHp8I+lsff/z/8f// jfpwtvz/8Q89/j/0Bg8dPP4//j/+//+PDf7//8+B/v/Zehg8D7r9Xv//////1jD4 /38G/iL2Z/D/H+xF7KfobPmf0f9n8P//lzOM////i77z+/8f7EXf/1uf3/P7f37/ //9g//9vfn/9ze//n55f3ze/vf7m9//N7///XyDiNT96/v9bcqmlV1tyydZ/W+pf NwzJpX9bcsmWbOldsqW3pW/JliTbpX5b+re2tt7a2tr632rrrRu3Ht/a2tr6ra3f +q2t32oru1v/UUaFiOONFN4oo4z/jTIqbKTwW0ZtbZRRRhn1RhkV3qiPMkqyjTLq jfpnDsHQhrZsGIIhmPb/MGTILXsYgqEfhmAIhmDoYQiGfBj6zCEYkmwYMvQw9EfE ERERERERERERERERERERERERERERERHx/////x///9zKEczcRNyoERO3JCZMRIPz I6a/cs8/N+K5aSfwh/8vkP666v0fa8THP8vx//9v/////c+tHDs6QzCP+BE3PTqz mYUgmBGf+NGZNfGjM5fo5senOabHix3dlBM/uiGYEZ/40ZmZSDY9PkEwjyB4OrPQ M+LTHNPjxY7u//IQHC9DhuCH4GUIXl7wkJd+wRC84IfgZQiGPAQPwUcL/iEv/YL/ kQrDkOiePqQCeVhsDEOL7pEKi+6RCkcqvOj20kcqLLpHKgxDi+6RCotuiw4susOQ 6A5DyWGx9rro9tJHKvwvv+zLcsm/7PKyy8uvXvryssu/7PLy8rIv+3LJl65e+vJ/ vWRX1f+SXUt2XfaSL33Zkl32S3Y9Si7ZS/a1ZMdLvvRl////x////x+j/v//P/z/ /1+PUf////+h/////////xv8//9x6P/////Pgf7//3////8/DP7//7Pq/f///1/E /v///zP/////YP//fwb+mf////8v+v7//z+/+////8H+//9/fvf/////+v///9// //+fkf//f/P73///vy39r29Lb0vf0rZ0ry3ZUktvS9/bakvb0u/S29K9tvT/W/9b v/Vbv/XW7dbW1tZvfVvZtbbe+rd+63Zr6/836t9I4cMb9UZ9iDjeqN1I4UPEsVEh 4ji8UW/URgpvVNio8Bv1Ru1GCh8ijv8/DP1btg9DD0O/oWHott4QDG3Ih6E3NKxh yGHIH4Yehm7rDX1EREREREREREQcERERRxwREREdR0RERERERBz/P0X//5f+v2Tr /8eo/w9Df0RE/P//P5VA/v9P0s6tHN3kRG56fKKc+NGZRLx4xItHvHiRx4tH/Ohm IcqJhfjRmc3/BUMw5AVD8PL//xC8YAiGDMHLkJ/C/B6psNhYdGCxtugeqfC6rr/o dqTCotui26J7pAJ5+CH4l0teLnnZ5R4ifu5DxM99iPj15eXl1WWX5S//sl9yyZbs +v///8eyR8klu+rPOv7x//9W11bXVtcPf3j8/7X/0I//r/7qr/4NfoP//8v/bOj/ 71/+5V8Pgx8G////X8T+M/p/9Vd/9R/sB/v///+i7//f1drV2tX6YD/Y8/v//19/ 8/v3L//yr2fkT8///299S6utLtnS////r31LvS3Z0v9eb21tbW39KOMo4yhjXq22 ttrKrrX15/Qxu4eIYyOFN1J4o4x63/c3UnijQsSxURtl1P9bf0OWDWsYgqG/rmtr QxsyNAzB0P/D0B8RcURERERERMQRERERcUT8ZPT/pf+2PjfKzJh58tmTzwJOB+cT B5w+e/KZ8Y/6Ifj7h+DvIfjD0C96/D3X84qdmb8XPT4ifgj+/4Ls/xD8L9kfIv6/ f4j4S/3/3/7H337rL9n/f/8v4f9/+zdp+fb/P97+BDki/Nv///8Hw//Px//P+e3P 1X/7//9v/7B/+0n8uSVvS/8/l//f/v//9v+//f+3pd/4bf2N7b8thaH/H5b+w9Af w6jfT/BG/Q4j9A0Z+v1h6HcY+oiIiIiIiIj/////50aKBcoG5zILceDnBhPBMIgS USMcUSNtRESguCdCRam40frwyx/y////goif58xDxdokvvz///9vr+XSs3EGdcR/ xP99CER8yf6S//8v2X/90sf////H/0sTQ+Q0nVnRdObFjm5+dPNjR2cW05tP001O k4jOvHixozObp5uc+BE3eTziGi92dObFNz12vPhEOfGjM4vnSizEj85rr//SZ3gI hhwNwdEveMEvQ34IjrDgl38ZcoQFx0PwLw/5FwzBy5CHDMHLly/9/yE4wYeNRbeT w6LbyeEjFY5U+EiFRQdebJxui7WPVPgjFcjD6bZYO70U3f5IhRcd+MXaYuNIhUUH Ft0WG0cq/Ef9S49e8ury8vLLyy8vX/Jd8su/LN8l//Ivv/wll7y8vFry8oWu/5/c f8nrsb7ssq8l/8uW7OuvumzJrsevl/wl+2vJJf/6c8xfetmZ+vjh////8f////8P ////+P+I//n//5cP/Q3+//8f+vH//8dv8P//MfR/6C/Z//+fNfSHwf///3Og//// /zD4//9JQP/nAv3/tyXpv4j9D/b///8i9p8t///PloP9/38GJvb/i9j//7f+X/Sd 34P9//+/6Pv///8P9v//i77/8xN9f8n+jfq2Xv9T5P///9ff/P7/v/k9I///v/nV /1///1u/pVdb+v5vqaXf1teWXPrXvyWXvl9/W1eX1rfVltYfERERb8wpYYS19W39 W1v/1ltbW//Wv7X1bW39W1tbW7+1tfW/9UYKb9Qb9YeI4xBx/Bsp/EYKH2XUb6Tw f5RRb5SRwv9GCm+k8EYZKfwbG2Wk8P9h6C0bht7Qv6EN/bDesjOHYOi3/jOHYOgN Wf+wtoYhy36Y9jBk2f8RERERERHHERFxRERERERERERERERExBERERERERH/E6X/ v/R/W58baRKzEDNRTDnmgfOID87HJDAxxAH/R/3L8hA8BA/BEAzB/2HooVCxtlgb KnrMstg5r+ix6LHYmfkjIq4qyC7XEHxB9iF4CC7I/kMg4kMg4u+SDYGIL9nvSy3Z +7+u8a//8a0fP7dy3ECRNm5lOFdMuckjxyxgUMD5UUSOWcBgwawwF0wO50TC4/iP S/a9hJLd/w9D8EPw4YfgIRiCIThsS7/0/ybxv0nL/w3BPQTfD8FDMGQIbrv+/99E jiDxTYT/n2WLdH6RzhRl+Yt0pkiks8hnkc5Z3vpL/w+Gn48fDP9/2CHvQ/72h/yQ C4KHfNulX/p/ysuXPxH9f5fsIOIt2e8v2Ut2tWTvdv3S/8N+Ej/sP93kxDVePCIn cs+V+NF5evwIEz86sxAL3eV/+f/ll2+Vf+sP6bel+b+9LZH/j7Dgh2DBkIfg5R+C lyEL3iV7e8n+X7KXbAkl+71+6f/////ptlj7RbfF2qIDi+6RCm9LonukwqLbYu3/ 7f81/v9fbekXZEvb0rZub0u2/l3yL5e8vOzyv+zyasn//3/p//+l/6XWw9DD0mFo GBqWftmS/aNkSy7Z9S/ZteSS/b/9H///Hxv1i/BGDaM2KsEPIRhl1P//8P//tvQ/ /v/2f2Xi/39Z/9aGhqFhyBAM/Y/f4Pj///9jcvT//0P//x96RERERERE/P8w+P// ////7f+s+v8T1mfg/zPwwc7g/29L/2f0S7a0vS3929K2ZIdt6f//YP/////8xm/9 W/9bb11q/f/N7xl58/v///+b32pLG9vSvy1tS6229L8ll9beJVtt6TfKlt6WXBpS 697633qrYan1f2trq62tra3/rd/aGmXUG/Vv1EYZG/UU/SijjBTeKKOMjfo36o0y qmBoh6F/GBqGDMHQPzdj8pkxM5QDTp98islnxsyTmHwKZollPiaBmSFEEIkoZxKT MzNRzJp5cA5x4M8cgiFrQzAE0x6GfguGHoZgKARDD0P/MDQMwRAM/fcQHP4fgt8W iPgrBENwGAQveFle8PJHRERERETEERERERERERERERHvRY/znOV/0eO3yxZE/BI9 Fj3Os0WfBRFfrA0Vb4u1oWJtEou1Sfz/EHzY/4fg3/ofgofg24L8JVfJLlfJpXLp 0iHiL9n/v2S/Lf1LtmTvZX/ZEIj4u2RDIOLXS/b/7f////eytaX/7VGyv5bwa1x6 6ZD+JXv9X7K/9fIlW7Jf+sen8+PS/+vtf+n/f6///1/7X/4pZ+ml49t/fBz/G/Xr /1/eeqTaf////0P//7Zk1///tl72T8jSS3/7z0fnfM7/W///v9BGEPEv/+3/v/3v //////9v/f88Wnrp/7Z0/29Lvy3Zki3Z0mpTnH/8////b//b/////3+tkk2+9P9I //+/sS1t/29L/78t2dLa0vfbki3dKtmS9D8M/f/D0D+Ow9AwdMmw9C7d2rpLt/53 GLX9P4xKaBCaWxaMglFRRkl21EYZtVEb9d8Nbf9v6H9DhkIw9LCGZW1o64+IiIiI iIiIiIiIiIiIiIj/////////f245CDFwfkw8wpE6whE10kZEBIrSETV6lEc4okWa 6P3DM8X//yT5/0n//73+/+v/639uxln+44j///j/dfv/////S/v/////r59P5MRC 5MQ1XjwiJwiezrx4xJqmMy92dPOjmx87OrOY3nyabnKaK/GjMwRPZxayLB5NZ17s 6Kbc8wmCeWRZX3/BEAzBgh+CBR89BENw9Ate8MuQH4IjLHgIXj5aMCIER79gyEPw ghG/tC7WFhuLbou1X3RbrA1DyeFFt0W3k8NHKhyp8JEKiw682DjdFmsvukcqDEPJ YbG26HZy+EiFRQcWG8OQWPu/tOSSl0v+5ZJffnl5+eXll5cv+S75ZZdfLnl5+eXl ki/5l+Il+0fJ/lGyrx/H+rLLvpb8L1uyl+z6WrLH+rIl/yX7Xz8e/g//fzj8//8/ /v///+H/H///oWOowfEbHP8bbPD////Qj///Y4P/f+jxl7LqbCgM/mHw/zAYBv// /8+B/v//w+D/nwP9/2cLsQc7Ax/sDPwHG+z///9F7D9b/v8Zmv9/EfuzhP7/oi/Y P9j/gw32////ou///z/Y/7/o+/9vfjUjb37PyJvfPyMnz////6+/+f3/Nz8i8v+/ vvl96V1ae5fW3qX/vv9baum39bUll7al/13q/5ZsXXfpT9G3ttra2mpr67+ttv6t rX/rra2tt/7fauvf2tp66/83ykjhjTLKSOGNMir8G2XUHyKOQ8Txb6TwGyl8lFEb 9eE3yqg/RBwbGyl82Kj/D0OWbQiGrA3BkP+GDP0b2tAP6y07cwiGhqH3hyFD/4Zg 2lu2w9BHRERERERERERERBxHRMQRERERERERERFHRETE/0Tp/y/939b/R/0fhv6I iP9/pjrujkhRR42IiBYREag/UX/q/YT//+vr+v//////////////c6sSOc0ncoJg HpF78njxms4sxI/OJOLHIX68SETcHCI3PXa8+MRCEMwjcg/B05mF5tN0k9MfggUv GPKCIf9HC15+CP5YMORfMAQvGPJHCx6CIyz4L7ot1l6sLboNQ2Jt0YHXk8Ni7UiF bUl0//SztujAL9YW3YYhsbbowDCUHBZrLzZOt8Xa/3LJl7x6ycs9RPwql7z8y/4l L3/Jy5e8/HLJl3yX/D9K9pIt+ZIt+X8t2fVL9pdkS/6SPS7Zkl9L9l+2ZP/D/4// t7r+vy39//8f/v//8f+/wfHxx3/1H///H//HBh//Hw/9+A+D///96/////9h8P// HOj/BztbZvAz+Kv/2XJb+j+D/xnGZ/D/DFzE/rPlB/uf339X6/////+D/f+/6Pv/ uZXy5nfz+5vf+9c3v///m99/86PnN7//m9/1N79/79Iu2dIu2fr/Lr1RtrTukq2r S/0u2fq79NqSS39bW29tvbU1yvhb/9bWW1tbW229tfVvvbW1dU7fKKM2yqiwUcb+ G/UbZaTwG2Wk8EYKb5RRYaOMw2/URgofZdR/QzA0DMGQwxBM++th6C0Ysh6GYG0N Q4YchmDa+8PQlp05BEP/ERERERERERFHREQcERERERERERER8f+X/v8h/euP+P// //////9TLjZK9AlBqZhQJtZM2pOMWU//Q9AgyuHDQ/DcPTU+/D/i/J7fxdr45+Px W9tvX/7vf/k5MUd8+pxnmz3xn2F+s2eYH/E5NXLiTNycic+JHz+WicccP5lhfsTn RD7xGZbZ8aMwe+JxJt7E57zNafrE58yOM3Fz/ikcAn0IhvAvxy9D8JIMYQg2DMHx QzAEyxGGYHkZwhAcy0OwLEc4wv9D8D8Ex38cl/KYx1/MHVoSc+dxScydxzwanMfM fx7zKB7OYh7Fw5aYO495DIm5rTyKh8XcWczi/3n8z2Pm/xhLtuQ/esXokr2ELrlk w5bssqUlW7Iby5bsxtEll+xCX7Ib0csue1t6yX5bkuyypX/8P+gh0DEK9GOw4/8x NvxveNCPBz02DPr/f/wf/z9//z/E/Llg/oaY//1t6Yf9D3uI+X+I+YcNMf+/Lf1v S29L//PyX9Av6EEcB9EX9OcLv3n5D+I4X/wPe0F/vhT0+WJB//9Lefnn5f+32dtq 6+uvtrS92mqzb7XZH29LNnv6t2RLjH+11Wb/us2e/mtLLR2vNvuPbfbH/6Pi+OiP jrej4yijoraOo4yKY6M6Oo46uqOMio7jLc5RUW9Fbf1tGIJBxIdBxN+0f9MehnbT HgYRH4ZgCIZ+GIIhK8chGLLctIdBxIehTXuHIcu0z3Eox6E/BEM/DP1HRBCfiIiI iIiIiCA+EREREXFEREQQn4iIiIg4jliIiIiI9W3Jlral/x/Hxw+FfhiCoWHoqz4i IiLi/0QwJROf6HOzToqpMeVzxyTPGqX0VJnkPwTrRP4n5PXDBP9/sXHhiI+F5/fx X/7/2/+XkB1n4snEp0984hOPEc8y8TlxJh6J+HEmbs7E58SPcHNiTiY+8dlxJh5n TjI75sgnPjvmiE+fM336xGfH3M+On0x84jHimT0INHvexGfHHPHpc6ZPn/jsmPsP wRH+OFqWH4IjLENw/BAMwRA8BEPwMQRHeAgegiE4hmAI/zEEQ/ghWD5aluOlGIIh /McQDOF/HrNoHcocKbeY2zqPWRQP5zHzn8c85vE85tEK5TGL59HKYx5DeczjH8pj HpfyKB62MkfKLeYOLYXymMc/lMc8/iW77K+yHP0lu+xGyS5bWrIlW7KXbMm+JLvs JXvJluySbMn/kmzJY8luvCxHr6WSbMn/kmzJ////D/r/huP/MY6Px/9/PI6P/z/+ 0Bv+Bz3q+P/j////P8T8/8N+W/r///////8/54f9DzF/////3waB/v9f0P8POy// QRznCy/zEgT6/+d8XvgyL//Py3/Y/4I+iP55+X9e/ltt6f9/fVt6/tvsj7clm73N fpu9Lb0t/ba0zd5mv83eVlvfZm/rtsT4//Xtbfa22vo2e1u/UfH/f3Qfv1FRW8dR UUfFffzHR0UdFccfFTM+Nqr/6LePiuOPij8MwdD/v2nvw9BbMPTDEAzB0DAEQz4M /TA0DMHQMASDiA+DiP8wBIOI/zBk+W/avw9DMIj4MIj4D0MwiPgfERERERERERER ERERERERERERERFHRERERERERERERMQRERHx////H/F/VjPmT9AJPLdi1pj19Ek9 lwk9geYmpk9ilv+qOrd/+FfS/kT//2NV/fl4xBpx/P//7///Z7Uss2OOfOKzk4nP mT7xmJs/8dkxR3z6nDnxk9kx9zan6ROfMzvOxM2ZN33iyew4E5/4xGPEs0x8TpyJ Rz47lonHnMxsxpwZZj/bE29O/4dgCI4h+I8whGMIhvBDsDwEQ/gh+B+C44/wEBxH y/JDcISXIwzByy+/HOEh+G9ZecxjKI/WZzGPoTzm8fMoHrbymMfP438eM/9ZtPIY yhwpt5jbOo9ZXDycxTxaYu4Xc7+YO4vn8f+SLdkl2X/ZkpdkS/6S3bhkS/6S/bYk 2WVLl71kV1mO/pJd9o1lS/botoT+6GUv2f+P4+P///g/Nnz8H//H////g/7/hv8H fdAH/eP//////z/s//9t6W3p//8h5v9/2P9DzNsSxPxDzP//Py98mZf/f17++eLz 8qW8/PPy//9f0P8/7P8F/YJ+Qf95QvvfZm+z32a/rW/rNntbbbXZ03+bva2rzf5j m/3xvy39r29LP/3fll7j9deWttn/PyrqqOOPj4rjKKM6KmYcFfVW1NZ//B/dx79R H3e0Ff3R8VH/hyEYGoaGQcR/GET8YQgGER8GER+GLIchGET8QzD0w9D/w9C/ae/D 0G89DLlpv2n/pn2OQ8PQR0RERERERETEERERERERERELERERERERERERERERERER ERH//6H/+oj/s5rIE3pKJurUmDT/V0J+Qp4U/7/+cfz//3/isefMm3gTjznOxGNO ZseZ+PLEY45wc2JOJj7x2XEmHmdOJOJMPJn4nDgT70f4IxxhCI4wBA/B8RGGYAge giH4GIIjPARDcIQfgiP8s/hZzGIes5hHK48hK4t5zON5zKMVymMWz2Mes2idxyz+ sm2p7LIlu2zJXrLrsiVbspdsyb4ku+wlW7LLfsku+////8f/fxwfj///+P///23p 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 PPMx33Qmx8QQBTGbYY5/QYZgyEtakCEYskKwPmQI1hWCvyTIBfnoIUOG4CErBA9Z CzIESyVBMOSl+CF4yHpJQ4YcDcGQJQiGYF1F41U0XqWHHA0ZMgQPGfLCaMjyUkVD lkuulyHXBflXOfqOaMhxQY4rGvKrLC9ZhZDjeo3oloUhy/X//8sty5AjuibFdBc5 vASDkmK6ix7DIJEjDHrR4+QOhtbk/lGix0lxkdrJQYrpnhRhUHJPijAoKab7USJH kcNLgjS5J0UwdFRykKJIbZFjOqa7yBEGvfTSSy96LFJb9FjkcHJPDlJc5ZItedTl kr11+dJbkr1dki0dtFV+eZVLdvmSXX65ZB9ULnkUpJLs8g+q8vJyySW7fNddd116 q3xLcsmu8kvS19KS9I3jLzXW0lK9JKhRkqRal17Sa0mXpFdBeC3J15JKkiBdqvGt x++1116XGuvGutal17ri13oiJQX6J7L+1/9Esv6r1n/9r/WaMKq4SPj1/6t+FlTX WaOvtdZan0h+ImvUq/7HtfSxYYkPl95w/VV/Gf7/j2uprqWPLxZ4HWr61/XX/2x4 HZOAS2f4z/Cf4X/Db7jq/xT9J+H+h70uDftfX3rYv/T/////ehJuyQ5P0f//S+uv r0vr0rokDVsa9v9vWfWlVx3sRRxfAnuVrnVJwVbVVVVXfVVd9VXEcemjWl5VJVVV XUUc10Ucv/7665fAXsF+VdVLVWk4r/qqNPCD/uHX6/UFr6qrqtKw6qvqqjRZFfS8 6n3pqrqqqq6grzQd9HFUHBVHPfyCz+uqqob1X66WfiLs0pK0MuytX63rXO1/6/9L rS/9v7RcvWVYW///W5fWl6Ty8vKVYW+l25db/1Fvc7Kl/bc5tb6+ttrSxra03vq3 9Nucflv63+b0qy3ttkbZ0v9/S2urzWnd932O19aWWhm2JVv6Wx8d9Yn6o41K1HGi jo2KuqLijfqj/uhPVKA+UX/0x1EfbUX9/0fFxtFxooSqqurYqCijjor6G5IkQ5bU JUmGrPJKFJdlSVuJ4pIsSZJE45IkyZAklSVJJUmGVHJLahOKN2RJkiRJkiSJxuWW Ia//lxLFZYnGZUmWJUlSGHoYgqEd/jAEQ3CTPdzQMARDFwwZehj6h/XD0MNh6OEP Q7XJHoZ2GLJgCIb+/4dlsjftYchkD6+qqtrQMDQsGBqGYOiPiIiIiIiIiIiIiCMi IiKOiIiIiIiIiIiIiIiIiIiIiDgi4oiIiIiIiIgjIiIilp5Y/vpLB0mSYmm99XoY OiIi/v////////////////8HQAAE";
		
	}
	
	
	
}
