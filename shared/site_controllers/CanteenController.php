<?php

App::import("Controller","CanteenApp");

class CanteenController extends CanteenAppController {
	
	public $uses = array();
	
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function dump_server() {
		
		die(print_r($_SERVER));
		
	}
	
	public function index() {
		
		$this->loadModel("CanteenCategory");
		$this->loadModel("CanteenProduct");
		$this->loadModel("CanteenDoormat");
		$this->loadModel("Brand");
		
		$doormats = $this->CanteenDoormat->find("all",array(
			"conditions"=>array(
				"CanteenDoormat.active"=>1
			),
			"contain"=>array("MediaFile"),
			"order"=>array("CanteenDoormat.display_weight"=>"ASC")
		));
		
		//get the latest products
		$new_products = $this->CanteenProduct->returnNewProducts();
		
		//get the featured brands
		
		$brands = $this->Brand->find("all",array(
			"conditions"=>array(
				"Brand.featured"=>1,
				"Brand.active"=>1
			),
			"contain"=>array()
		));
		
		$this->set(compact("doormats","new_products","brands"));
		
	}
	
	public function top_category() {
		
		
		
	}
	
	public function order($id = false) {
		
		if(count($this->request->data)>0) $this->order_note(base64_encode($this->request->here));
		
		if($id) {
			
			$this->loadModel("CanteenOrder");
			
			$o = $this->CanteenOrder->find("first",array("contain"=>array(),"conditions"=>array("CanteenOrder.hash"=>$id)));
			
			$order = $this->CanteenOrder->returnAdminOrder(Set::classicExtract($o,"CanteenOrder.id"),array("with_shipping_items"=>true));
			
			if(isset($order['CanteenOrder']['id'])) {
				
				$this->set(compact("order"));
				
			} else {
				
				throw new NotFoundException();
				
			}
			
		} else {
			
			throw new NotFoundException();
			
		}
		
	}
	
	public function printable($type,$hash = false) {
		
		$this->layout = "canteen_printer";
		
		
		if($hash) {
			
			$this->loadModel("CanteenOrder");
			
			$o = $this->CanteenOrder->find("first",array("contain"=>array(),"conditions"=>array("CanteenOrder.hash"=>$hash)));
			
			$order = $this->CanteenOrder->returnAdminOrder(Set::classicExtract($o,"CanteenOrder.id"));
			
			if(isset($order['CanteenOrder']['id'])) {
				
				$this->set(compact("order"));
				
			} else {
				
				throw new NotFoundException();
				
			}
			
		} else {
			
			throw new NotFoundException();
			
		}
		
		switch($type) {
			
			case "receipt":
			default:
				$ele = "order-receipt";
			break;
			
		}
		
		$this->render("/elements/canteen_printing/{$ele}");
		
	}
	
	public function order_note($callback = false) {
		
		if(count($this->request->data)>0) {
			$this->loadModel("CanteenOrderNote");
			
			$this->CanteenOrderNote->setCustomerNoteValidation();
			
			$this->CanteenOrderNote->set($this->request->data);
			
			$validation = $this->CanteenOrderNote->validates();
			
			$cb = base64_decode($callback);
			
			if($validation) {
				
				$this->CanteenOrderNote->addCustomerNote($this->request->data);
				
				$redir = $this->request->here;
				
				return $this->redirect($cb);
				
			} else {
				
				if($callback) {
					
					$this->Session->setFlash("ERROR: Your message must be at least 8 characters.");
					
					return $this->redirect($cb);
					
				} else {
		
					
					throw new NotFoundException();	
				
					
				}
				
			}
			
		} else {
			
			throw new NotFoundException();
			
		}
		
		
		
	}
	
	public function support() {
		
		if($this->RequestHandler->isAjax()) {
			
			$this->loadModel("CanteenOrder");
			
			//find the order
			$orders = $this->CanteenOrder->locate_orders($this->request->data['CanteenOrderStatus']['email'],$this->request->data['CanteenOrderStatus']['postal_code']);
			
			$this->set(compact("orders"));
			
			$this->render("/Elements/canteen-support-order-table");
			
			return;
		}
		
	}
	
	public function brands() {
		
		$this->loadModel("Brand");
		
		$brands = $this->Brand->find("all",array(
			"conditions"=>array(
				"Brand.active"=>1,
				"Brand.featured"=>1
			),
			"contain"=>array()
		));
		
		$this->set(compact("brands"));
		
	}
	
	public function clear_session() {
		
		$this->Session->delete("CanteenOrder");
		
		$this->Session->delete("CanteenAdminAddItem");
		
		return $this->redirect("/canteen");
		
	}
	
	
	//filtering helpers
	private function extractBrandFilters() {
		
		$filters = array();
		
		foreach($this->request->data['Brand'] as $k=>$v) if($v==1) $filters[]=$k;

		$str = implode("|",$filters);
		
		$str = rtrim($str,"|");
		
		return $str;
		
	}
	
	private function extractMetaFilters() {
		
		$filters = array();
		
		foreach($this->request->data['Meta'] as $k=>$v) if($v==1) $filters[]=$k;
		
		$str = implode("|",$filters);
		
		$str = rtrim($str,"|");
		
		return $str;
		
	}
	

}