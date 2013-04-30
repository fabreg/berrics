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
	
	private $lajolla_schema = array(
			'Company Number',
			'FCCustomerID',
			'CustomerID',
			'CustomerType',
			'OrderNumber',
			'PONumber',
			'OrderDate',
			'ShipDate',
			'CancelDate',
			'OrderType',
			'PaymentType',
			'Transaction ID',
			'Authorization Code',
			'ChargeCard',
			'CreditCardNumber',
			'CardExpDate',
			'SecurityCode',
			'Line',
			'UPC Code',
			'Style',
			'Color',
			'Size Type',
			'Size',
			'CurrencyCode',
			'UnitPrice',
			'Quantity',
			'ShipToAddressID',
			'ShipToName',
			'ShipToAddress1',
			'ShipToAddress2',
			'ShipToAddress3',
			'ShipToCity',
			'ShipToState',
			'ShipToZip',
			'ShipToCountry',
			'ShipToPhone',
			'ShipToEmail',
			'ShipMethod',
			'SpecialInstruction',
			'BillToAddressID',
			'BillToName',
			'BillToAddress1',
			'BillToAddress2',
			'BillToAddress3',
			'BillToCity',
			'BillToState',
			'BillToZip',
			'BillToCountry',
			'BillToPhone',
			'TaxCode',
			'FreighCharges',
			'Discount',
			'MailingListStatus'
	);
	
	private $lajolla_tracking_schema = array(
			'Company Number',
			'FCInvoice',
			'WebOrder',
			'TrackingNumber',
			'Status',
			'InvoiceAmount',
			'FreightAmount',
			'TaxAmount',
			'MerchAmount',
			'UPC Code',
			'ProductCode',
			'Color',
			'Size Type',
			'Size',
			'QtyShipped',
			'NetPrice',
			'AmtShipped',
			'Type'
	);
	
	private $ljg_ftp = array(
		"ip"=>"64.206.163.163",
		"login"=>"ctweb",
		"pass"=>"c@nt33N"
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
					5=>29.95,
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
					4=>27.95,
					5=>31.95,
					6=>34.95
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
		
		
		if(!empty($rates[$weight])) {
					
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
				"title"=>"USPS DOM Shipping Error: CanteenShippingRecordID: <a href='/canteen_shipping_records/edit/{$record['CanteenShippingRecord']['id']}' target='_blank'>".$record['CanteenShippingRecord']['id']."</a>",
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
				"title"=>"USPS INT Shipping Error: CanteenShippingRecordID: <a href='/canteen_shipping_records/edit/{$record['CanteenShippingRecord']['id']}' target='_blank'>".$record['CanteenShippingRecord']['id']."</a>",
				"message"=>serialize($xml->asXml())
			));
			
			
		}
		
		return $record;
		
	}
	
	public function process_usps_label($label = false,$record_id = false) {
		
		//save the label to a tmp folder
		$tmp_name = microtime().".tif";
		
		$img_str = base64_decode($label);
		
		$touch = TMP.$tmp_name;

		echo `touch $touch`;
		
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
	
	
	public function ljg_process_record($id = false) {
		
		$schema = $this->lajolla_schema;
		
		$shipment = array();
		
		$lines = "";
		
		$record = $this->returnAdminRecord($id);
		
		foreach($record['CanteenOrderItem'] as $k=>$item) {
			
			foreach($schema as $v) {
				
				switch($v) {
					
					case "Company Number":
						$shipment[$k][$v] = '15';
						break;
					case "FCCustomerID":
						$shipment[$k][$v] = 'CTWEB';
						break;
					case "PONumber":
						$shipment[$k][$v] = $record['CanteenShippingRecord']['canteen_order_id'];
						break;
					case "ShipDate":
						$shipment[$k][$v] = date("m/d/Y");
						break;
					case "CancelDate":
						$shipment[$k][$v] = date("m/d/Y",strtotime("+5 Days"));
						break;
					case "OrderNumber":
						$shipment[$k][$v] = $record['CanteenShippingRecord']['id'];
						break;
					case "OrderDate":
						$shipment[$k][$v] = date("m/d/Y",strtotime($record['CanteenShippingRecord']['created']));
						break;
					case "Line":
						$shipment[$k][$v] = $item['id'];
						break;
					case "UPC Code":
						$shipment[$k][$v] = $item['CanteenInventoryRecord']['foreign_key'];
						break;
					case "Quantity":
						$shipment[$k][$v] = $item['quantity'];
						break;
					case "ShipToName":
						$shipment[$k][$v] = $record['UserAddress']['first_name']." ".$record['UserAddress']['last_name'];
						break;
					case "ShipToAddress1":	
						$shipment[$k][$v] = $record['UserAddress']['street'];
						break;
					case "ShipToAddress2":
						$shipment[$k][$v] = $record['UserAddress']['apt'];
						break;
					case "ShipToCity":
						$shipment[$k][$v] = $record['UserAddress']['city'];
						break;
					case "ShipToState":
						$shipment[$k][$v] = $record['UserAddress']['state'];
						break;
					case "ShipToZip":
						$shipment[$k][$v] = $record['UserAddress']['postal_code'];
						break;
					case "ShipToCountry":
						$shipment[$k][$v] = $record['UserAddress']['country_code'];
						break;
					case "ShipToPhone":
						$shipment[$k][$v] = $record['UserAddress']['phone'];
						break;
					case "ShipToEmail":
						$shipment[$k][$v] = $record['UserAddress']['email'];
						break;
					case "ShipMethod":
						$method = "UPG";
						if(strtoupper($record['UserAddress']['country_code']) != "US") {
							
							$method = "UPI4";
							
						}
						$shipment[$k][$v] = $method;
						break;
					default:
						$shipment[$k][$v] = "";
					break;
				}
				
			}
			
		}
		
		foreach($shipment as $s) {
			
			$lines .= implode("\t",$s);
			$lines .= "\n";
			
		}
		
		
		return $lines;
		
	}
	
	public function ljg_process_pending() {
		
		$file = "";
		
		$ids = $this->find("all",array(
			"fields"=>array("CanteenShippingRecord.id"),
			"conditions"=>array(
				"CanteenShippingRecord.warehouse_id"=>2,
				"CanteenShippingRecord.shipping_status"=>"pending"
			),
			"contain"=>array()
		));
		
		foreach($ids as $v) {
			
			$lines = $this->ljg_process_record($v['CanteenShippingRecord']['id']);
			
			if(!empty($lines)) {
				
				$file .= $lines;
				
				$this->update_shipping_status($v['CanteenShippingRecord']['id'],"processing");
				
			}
			
		}
		
		$ljg_file = ClassRegistry::init("LjgFile");
		
		$ljg_file->create();
		
		$ljg_file->save(array(
			"data"=>$file
		));
		
		return $ljg_file->id;
		
	}
	
	public function ljg_get_tracking_files() {
		
		$LjgTrackingFile = ClassRegistry::init("LjgTrackingFile");
		
		//connect
		
		if(preg_match('/(WEB2VM)/',php_uname("n"))) {
			
			$ftp = ftp_connect("127.0.0.1");
			
			ftp_login($ftp,"john","artosari");
			
		} else {
			
			$ftp = $this->ljg_ftp_login();
			
		}
		
		
		ftp_chdir($ftp,"s");
		
		$list = ftp_nlist($ftp,".");
		
		foreach($list as $f) {
			
			if(!preg_match("/^(orderstatus_15)/",$f)) {
				
				continue;
				
			}
			
			$chk = $LjgTrackingFile->find("count",array(
				"conditions"=>array(
					"file_name"=>$f
				)
			));
			if($chk<=0) {
				
				ftp_get($ftp,"/home/sites/lajolla/tracking/".$f,$f,FTP_BINARY);
				
				$LjgTrackingFile->create();
				
				$LjgTrackingFile->save(array(
					"file_name"=>$f,
					"downloaded"=>1
				));
				
				
				
			}
			
			
			
		}
		
		//die(print_r($list));
		
	}
	
	public function ljg_process_tracking_file($file_id) {
		
		$LjgTrackingFile = ClassRegistry::init("LjgTrackingFile");
		
		$file = $LjgTrackingFile->findById($file_id);
		
		$file_str = file_get_contents("/home/sites/lajolla/tracking/".$file['LjgTrackingFile']['file_name']);
		
		$lines = explode("\r",trim($file_str));
		
		$tracking_records = array();
		
		foreach($lines as $line) {
			
			$line = explode("\t",$line);
			
			//die("Scema:".count($this->lajolla_tracking_schema)." Line: ".count($line));
			
			if($t = @array_combine($this->lajolla_tracking_schema,$line)) {
				
				$tracking_records[] = $t;
				
			}
			
		}
		
		//check each tracking record
		foreach($tracking_records as $r) {
			
			$chk = $this->returnAdminRecord($r['WebOrder']);
			
			if(strtolower($chk['CanteenShippingRecord']['shipping_status']) != "processing") continue;
			
			//update the record with the tracking number and carrier
			$this->create();
			$this->id = $chk['CanteenShippingRecord']['id'];
			
			$carrier = "UPS";
			
			if(!preg_match('/^1Z/',$r['TrackingNumber'])) {
				
				$carrier = "USPS";
				
			}
			
			$udata = array(
				"carrier_name"=>$carrier,
				"tracking_number"=>$r['TrackingNumber']		
			);
			
			$this->save($udata);
			
			$record = $this->returnAdminRecord($chk['CanteenShippingRecord']['id']);
			
			$this->checkout_shipment($record,true,true);
			
		}
		
		//update the tracking file record as processed
		$LjgTrackingFile->create();
		$LjgTrackingFile->id = $file_id;
		$LjgTrackingFile->save(array(
			"processed"=>1		
		));
		
	}
	
	public function ljg_create_orders_file($id) {
		
		$ljg_file = ClassRegistry::init("LjgFile");
		
		$record = $ljg_file->findById($id);
		
		$file_name = "15_CTWEB_order_".time().".txt";
		
		$fhandle = fopen("/tmp/".$file_name,"w");
		
		if(!fwrite($fhandle,$record['LjgFile']['data'])) {

			SysMsg::add(array(
				"category"=>"LjgOrderFile",
				"from"=>"CanteenOrderItem",
				"message"=>"Fucking Failed",
			));

			return false;
			
		} 
		
		$ljg_file->create();
		
		$ljg_file->id = $id;
		
		$ljg_file->save(array(
			"processed"=>1,
			"file_name"=>$file_name
		));
		
		return $file_name;
		
	}
	private function ljg_ftp_login() {
		
		$conn = ftp_connect($this->ljg_ftp['ip']);
		
		ftp_login($conn,$this->ljg_ftp['login'],$this->ljg_ftp['pass']);
		
		ftp_pasv($conn,true);
		
		return $conn;
		
	}
	
	public function ljg_ftp_file($id) {
		
		$ljg_file = ClassRegistry::init("LjgFile");
		
		$record = $ljg_file->findById($id);
		
		$conn = ftp_connect($this->ljg_ftp['ip']);
		
		if(ftp_login($conn,$this->ljg_ftp['login'],$this->ljg_ftp['pass'])) {
			
			ftp_chdir($conn,"r");
			
			ftp_pasv($conn,true);
			
			ftp_put($conn,$record['LjgFile']['file_name'],"/tmp/".$record['LjgFile']['file_name'],FTP_BINARY);
			
			ftp_close($conn);
			
			SysMsg::add(array(
				"category"=>"LjgOrderFile",
				"from"=>"CanteenShippingRecord",
				"message"=>"Uploaded: ".$record['LjgFile']['file_name'],
				"title"=>"Uploaded: ".$record['LjgFile']['file_name']
			));
			
		} else {
			
			SysMsg::add(array(
				"category"=>"LjgOrderFile",
				"from"=>"CanteenShippingRecord",
				"message"=>"Error Connecting to FTP",
				"title"=>"Error Connecting to FTP"
			));
			
		}
		
		
		
	}
	
	public function update_shipping_status($id,$status = "pending") {
		
		$this->create();
		
		$this->id = $id;
		
		$this->save(array(
			"shipping_status"=>$status
		));
		
	}
	
	public function checkout_shipment($record,$send_email = false,$process_inventory=false) {
		
		$this->update_shipping_status($record['CanteenShippingRecord']['id'],"shipped");
		
		//should we checkout inventory?
		if($process_inventory) {
			
			foreach($record['CanteenOrderItem'] as $i) {
				
				$this->CanteenOrderItem->processLineItemInventory($i['id']);
				
			}
			
			$process_inventory = true;
			
		}
		
		//send customer email
		if($send_email) {
			
			//$this->loadModel("EmailMessage");
			
			$this->CanteenOrder->EmailMessage->sendCanteenShippingConfirmation($record['CanteenShippingRecord']['id']);
			
		}
		
	}
	
	
}
