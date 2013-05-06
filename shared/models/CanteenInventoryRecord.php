<?php
class CanteenInventoryRecord extends AppModel {
	var $name = 'CanteenInventoryRecord';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Warehouse' => array(
			'className' => 'Warehouse',
			'foreignKey' => 'warehouse_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'CanteenProductInventory' => array(
			'className' => 'CanteenProductInventory',
			'foreignKey' => 'canteen_inventory_record_id',
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
	
	public $ljg_inv_schema = array(
		'Company Number',
		'UPC Code',
		'ProductCode',
		'Color',
		'Size Type',
		'Size',
		'Quantity',
		'Available Date'
	);

		private $ljg_ftp = array(
		"ip"=>"64.206.163.163",
		"login"=>"ctweb",
		"pass"=>"c@nt33N"
	);
	
	public function allocateInventory($canteen_inventory_record_id=false,$qty = 0) {
		
		if(!$canteen_inventory_record_id) return false;
		
		return $this->query(
			"UPDATE canteen_inventory_records SET allocated=(allocated+{$qty}),quantity=(quantity-{$qty}) WHERE id='$canteen_inventory_record_id'"
		);
		
		
	}
	
	public function returnAllocatedInventory($canteen_inventory_record_id = false,$qty=0) {
		
		if(!$canteen_inventory_record_id) return false;
		
		return $this->query(
			"UPDATE canteen_inventory_records SET allocated=(allocated-{$qty}),quantity=(quantity+{$qty}) WHERE id='$canteen_inventory_record_id'"
		);
		
		
	}
	
	private function ljg_ftp_login() {
		
		$conn = ftp_connect($this->ljg_ftp['ip']);
		
		ftp_login($conn,$this->ljg_ftp['login'],$this->ljg_ftp['pass']);
		
		ftp_pasv($conn,true);
		
		return $conn;
		
	}

	public function parse_ljg_inv_file() {
		

		$file = "/home/sites/lajolla/inventory.txt";
		
		//$file_str = file_get_contents($file);
		
		//$file_str = trim($file_str);
		
		$csv_rows = $file_str = file($file);
		
		//$csv_rows = explode("\n",$file_str);
		
		//die(pr(count($csv_rows)));

		$inv = array();
		
		foreach($csv_rows as $v) {
				
			$str = trim($v);
			
			$cols = array_combine($this->ljg_inv_schema,explode("\t",$str));
			
			$cols_raw = explode("\t",$str);

			$inv[$cols['UPC Code']] = $cols;

			
		}

		return $inv;

	}

	public function import_ljg_inventory() {
		
		set_time_limit(0);
		
		if(preg_match('/(WEB2VM)/',php_uname("n"))) {
			
			$ftp = ftp_connect("127.0.0.1");
			
			ftp_login($ftp,"john","artosari");
			
		} else {
			
			$ftp = $this->ljg_ftp_login();
			
		}

		ftp_chdir($ftp, "s");

		ftp_get($ftp,"/home/sites/lajolla/inventory.txt","15_CTWEB_inventory.txt",FTP_BINARY);

		//file
		$file = "/home/sites/lajolla/inventory.txt";
		
		//$file_str = file_get_contents($file);
		
		//$file_str = trim($file_str);
		
		$csv_rows = $file_str = file($file);
		
		//$csv_rows = explode("\n",$file_str);
		
		//die(pr(count($csv_rows)));
		
		$counter = 0;
		
		$this->query(
				"update canteen_inventory_records set quantity=0 where warehouse_id=2"
				);
		
		sleep(3);
		
		foreach($csv_rows as $v) {
				
			$str = trim($v);
			
			$cols = array_combine($this->ljg_inv_schema,explode("\t",$str));
			
			if(empty($cols['UPC Code'])) continue;
			
			$record = $this->findByForeignKey($cols['UPC Code']);
			
			if(!empty($record['CanteenInventoryRecord']['id'])) {
				
				$uq =$cols['Quantity']-$record['CanteenInventoryRecord']['allocated'];
				$s = "update canteen_inventory_records set
						quantity = $uq 
					WHERE id = {$record['CanteenInventoryRecord']['id']} LIMIT 1;";

				$this->query($s);
				echo $s;
				echo "\n"; $counter++;
			}
			
		}
		
		die($counter." Records Updated");
	}

}
