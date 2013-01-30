<?php
App::import("Controller","LocalApp");


class CanteenBatchesController extends LocalAppController {

	var $name = 'CanteenBatches';

	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
	
	}
	
	public function add_to_batch() {
		
		
		if(!empty($this->request->data['CanteenBacthc']['id'])) {
			
			//get all the orders in the referenced batch
			$orders = $this->CanteenBatch->CanteenBatchesCanteenOrder->find("all",array(
				"conditions"=>array(
					"CanteenBatchesCanteenOrder.canteen_batch_id"=>$this->request->data['CanteenBatch']['id']
				)
			));
		
		} else {
			
			$this->CanteenBatch->create();
			
			$this->CanteenBatch->save(array(
				"name"=>$this->Auth->user("first_name")." ".$this->Auth->user("last_name")." ".date("F jS Y [g:iA]"),
				"user_id"=>$this->user_id_scope
			));
			
			$orders = array();
			
			$this->request->data['CanteenBatch']['id'] = $this->CanteenBatch->id;
			
		}
		
		
		
		foreach($this->request->data['CanteenOrder'] as $o) {
			
			$chk = Set::extract("/CanteenBatchesCanteenOrder[canteen_order_id={$o}]",$orders);
			
			if(count($chk)>0) continue;

			$this->CanteenBatch->CanteenBatchesCanteenOrder->create();
			$this->CanteenBatch->CanteenBatchesCanteenOrder->save(array(
				"canteen_order_id"=>$o,
				"canteen_batch_id"=>$this->request->data['CanteenBatch']['id']
			));
			
		}
		
		$this->redirect("/canteen_batches");
		
	}
	
	function index() {
		
		$this->CanteenBatch->recursive = 0;
		
		$this->paginate['CanteenBatch'] = array(
			"order"=>array(
				"CanteenBatch.id"=>"DESC"
			)
		);
		
		
		$this->set('canteenBatches', $this->paginate());
	}

	function view($id = null) {
		
		$batch = $this->request->data = $this->CanteenBatch->find("first",array(
			"conditions"=>array("CanteenBatch.id"=>$id),
			"contain"=>array(
				"CanteenOrder",
				"User"
			)
		));
		
		$this->set(compact("batch"));
		
		$this->loadModel("CanteenOrder");
		
		$ids = Set::extract("/CanteenOrder/id",$batch);
		
		$this->paginate['CanteenOrder'] = array(
			"conditions"=>array(
				"CanteenOrder.id"=>$ids
			),
			"contain"=>array(),
			"limit"=>count($ids)
		);
		
		$this->set("orders",$this->paginate("CanteenOrder"));
	}
	
	public function print_invoices($batch_id = false) {
		
		$this->loadModel("CanteenOrder");
		
		$this->layout = "plain";
		
		$order_ids = $this->CanteenBatch->CanteenBatchesCanteenOrder->findAllByCanteenBatchId($batch_id);
		
		$orders = array();
		
		foreach($order_ids as $o) {
			
			$id = $o['CanteenBatchesCanteenOrder']['canteen_order_id'];
			
			$orders[] = $this->CanteenOrder->returnOrder($id);
			
		}
		
		$this->set(compact("orders"));
		
	}
	
	public function remove_order($batch_id = false, $order_id = false) {
		
		//here we go!!
		
		$this->CanteenBatch->CanteenBatchesCanteenOrder->deleteAll(array(
			"CanteenBatchesCanteenOrder.canteen_batch_id"=>$batch_id,
			"CanteenBatchesCanteenOrder.canteen_order_id"=>$order_id
		));
		
		$this->Session->setFlash("Order Removed Successfully");
		
		return $this->redirect("/canteen_batches/view/{$batch_id}");
		
	}

	public function update_status() {
		//die(pr($this->request->data));
		$orders = $this->CanteenBatch->CanteenBatchesCanteenOrder->find("all",array("conditions"=>array("CanteenBatchesCanteenOrder.canteen_batch_id"=>$this->request->data['CanteenBatch']['id'])));
		
		$order_ids = Set::extract("/CanteenBatchesCanteenOrder/canteen_order_id",$orders);
	
		$this->loadModel("CanteenOrder");
		
		$this->CanteenOrder->updateAll(
			array(
			$this->request->data['CanteenBatch']['status']=>"'".$this->request->data['CanteenBatch']['verb']."'"
			),
			array(
				"CanteenOrder.id"=>$order_ids
			)
		);
		
		
		if($this->request->data['CanteenBatch']['add_order_note'] == 1) {
			
			foreach($order_ids as $id) {
				
				$this->CanteenOrder->CanteenOrderNote->create();
				
				$this->CanteenOrder->CanteenOrderNote->save(array(
				
					"canteen_order_id"=>$id,
					"user_id"=>$this->user_id_scope,
					"action"=>"UpdateOrderStatus",
					"note"=>strtoupper($this->request->data['CanteenBatch']['status']).":".strtoupper($this->request->data['CanteenBatch']['verb']),
					"public"=>1
				
				));
				
				
			}
			
		}
		
		$this->Session->setFlash("Status Updated");
		
		return $this->redirect("/canteen_batches/view/{$this->request->data['CanteenBatch']['id']}");
		
	}
	

	function add() {
		if (!empty($this->request->data)) {
			$this->CanteenBatch->create();
			if ($this->CanteenBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The canteen batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen batch could not be saved. Please, try again.'));
			}
		}

		
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid canteen batch'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->CanteenBatch->save($this->request->data)) {
				$this->Session->setFlash(__('The canteen batch has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The canteen batch could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->CanteenBatch->read(null, $id);
		}
		$users = $this->CanteenBatch->User->find('list');
		$canteenOrders = $this->CanteenBatch->CanteenOrder->find('list');
		$this->set(compact('users', 'canteenOrders'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for canteen batch'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CanteenBatch->delete($id)) {
			$this->Session->setFlash(__('Canteen batch deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Canteen batch was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>