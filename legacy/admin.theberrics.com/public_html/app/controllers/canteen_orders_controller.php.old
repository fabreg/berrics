<?php

App::import("Controller","LocalApp");

class CanteenOrdersController extends LocalAppController {
	
	
	private $skip_order_update_note = false;
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("barcode");
	}
	
	
	public function search() {
		
		
		if(count($this->data)>0) {
			
				$url = array(
		
					"action"=>"index",
					"s"=>true
				);
				
				
				foreach($this->data as $k=>$v) {
					
					foreach($v as $kk=>$vv) {
						
						$url[$k.".".$kk]=base64_encode($vv);
						
					}
					
				}
				
				return $this->redirect($url);
				
		}
		
		//build some menus
		if(($orderStatusMenu = Cache::read("orderStatus_menu","1min")) === false) {
			
			$orderStatus = $this->CanteenOrder->query("SELECT DISTINCT(order_status) FROM canteen_orders");
			
			$orderStatusMenu = array();
			
			foreach($orderStatus as $s) $orderStatusMenu[$s['canteen_orders']['order_status']] = strtoupper($s['canteen_orders']['order_status']);
			
			Cache::write($orderStatusMenu,"orderStatus_menu","1min");
			
		}
		
		if(($shippingStatusMenu = Cache::read("shippingStatus_menu","1min")) === false) {
			
			
			$shippingStatus = $this->CanteenOrder->query("SELECT DISTINCT(shipping_status) FROM canteen_orders");
			
			$shippingStatusMenu = array();
			
			foreach($shippingStatus as $s) $shippingStatusMenu[$s['canteen_orders']['shipping_status']] = strtoupper($s['canteen_orders']['shipping_status']);
			
			Cache::write($shippingStatusMenu,"shippingStatus_menu","1min");
			
		}
		
		if(($whStatusMenu = Cache::read("whStatus_menu","1min")) === false) {
			
			$whStatus = $this->CanteenOrder->query("SELECT DISTINCT(wh_status) FROM canteen_orders");
			
			$whStatusMenu = array();
			
			foreach($whStatus as $s) $whStatusMenu[$s['canteen_orders']['wh_status']] = strtoupper($s['canteen_orders']['wh_status']);
			
			Cache::write($whStatusMenu,"whStatus_menu","1min");
			
		}
		
		
		
		$this->set(compact("orderStatusMenu","shippingStatusMenu","whStatusMenu"));
		
		
	}
	
	public function index() {
		
		
		$this->paginate['CanteenOrder'] = array(
		
			"limit"=>50,
			"order"=>array(
				"CanteenOrder.created"=>"DESC"
			),
			"contain"=>array()
		);
		
		if(isset($this->params['named']['s'])) {
			
			if(isset($this->params['named']['CanteenOrder.order_status']) && !empty($this->params['named']['CanteenOrder.order_status'])) {
				
					$this->paginate['CanteenOrder']['conditions']['CanteenOrder.order_status'] = 
					$this->data['CanteenOrder']['order_status'] = 
					base64_decode($this->params['named']['CanteenOrder.order_status']);
				
			}
			
			if(isset($this->params['named']['CanteenOrder.wh_status']) && !empty($this->params['named']['CanteenOrder.wh_status'])) {
				
					$this->paginate['CanteenOrder']['conditions']['CanteenOrder.wh_status'] = 
					$this->data['CanteenOrder']['wh_status'] = 
					base64_decode($this->params['named']['CanteenOrder.wh_status']);
				
			}
			
			if(isset($this->params['named']['CanteenOrder.shipping_status']) && !empty($this->params['named']['CanteenOrder.shipping_status'])) {
				
					$this->paginate['CanteenOrder']['conditions']['CanteenOrder.shipping_status'] = 
					$this->data['CanteenOrder']['shipping_status'] = 
					base64_decode($this->params['named']['CanteenOrder.shipping_status']);
				
			}
			
			if(isset($this->params['named']['CanteenOrder.email']) && !empty($this->params['named']['CanteenOrder.email'])) {
				
					$this->paginate['CanteenOrder']['conditions']['CanteenOrder.email LIKE'] = 
					$this->data['CanteenOrder']['email'] = 
					base64_decode($this->params['named']['CanteenOrder.email']);
				
			}
			
			if(isset($this->params['named']['CanteenOrder.name']) && !empty($this->params['named']['CanteenOrder.first_name'])) {
				
					$this->paginate['CanteenOrder']['conditions']['OR']['CanteenOrder.first_name LIKE'] = 
					$this->paginate['CanteenOrder']['conditions']['OR']['CanteenOrder.last_name LIKE'] = 
					$this->paginate['CanteenOrder']['conditions']['OR']['CanteenOrder.bill_first_name LIKE'] = 
					$this->paginate['CanteenOrder']['conditions']['OR']['CanteenOrder.bill_last_name LIKE'] = 
					$this->data['CanteenOrder']['name'] = 
					base64_decode($this->params['named']['CanteenOrder.name']);
				
			}
			
			if(isset($this->params['named']['CanteenOrder.date_start']) && isset($this->params['named']['CanteenOrder.date_end'])) {
				
				//compare and call them an idoit
				
				if(strtotime(base64_decode($this->params['named']['CanteenOrder.date_start']))>strtotime(base64_decode($this->params['named']['CanteenOrder.date_end']))) {
					
					$this->Session->setFlash("Hey, how can the start date be ahead of the end date??? I'll email John and have him come over and explain it to you");
					return $this->redirect("/canteen_orders/search");
				}
				
				
				$this->paginate['CanteenOrder']['conditions'][] = 
				"DATE(CanteenOrder.created) BETWEEN '".base64_decode($this->params['named']['CanteenOrder.date_start'])."' AND '".base64_decode($this->params['named']['CanteenOrder.date_end'])."'";
		
			}
			
			
			if(
				isset($this->params['named']['CanteenOrder.id1']) || 
				isset($this->params['named']['CanteenOrder.id2']) || 
				isset($this->params['named']['CanteenOrder.id3']) || 
				isset($this->params['named']['CanteenOrder.id4'])
			) {
				
				$id_str = '';
				
				$id_str .= (empty($this->params['named']['CanteenOrder.id1'])) ? "%":base64_decode($this->params['named']['CanteenOrder.id1']);
				$id_str .= "-";
				$id_str .= (empty($this->params['named']['CanteenOrder.id2'])) ? "%":base64_decode($this->params['named']['CanteenOrder.id2']);
				$id_str .= "-";
				$id_str .= (empty($this->params['named']['CanteenOrder.id3'])) ? "%":base64_decode($this->params['named']['CanteenOrder.id3']);
				$id_str .= "-";
				$id_str .= (empty($this->params['named']['CanteenOrder.id4'])) ? "%":base64_decode($this->params['named']['CanteenOrder.id4']);
				
				$this->paginate['CanteenOrder']['conditions']['id LIKE'] = $id_str;
				
			}
			
			
			
		}
		$this->loadModel("CanteenBatch");
		$batches = $this->CanteenBatch->getList();

		$orders = $this->paginate("CanteenOrder");
		
		$this->set(compact("orders","batches"));
		
	}
	
	
	public function edit($id = false) {
		
		if(count($this->data)>0) {
			
			//stuff for before the save
			if(isset($this->data['CaptureOrder'])) {
				
				$this->captureOrder();
				$this->skip_order_update_note = true;
			}

			$this->CanteenOrder->id = $this->data['CanteenOrder']['id'];
			
			if($this->CanteenOrder->saveAll($this->data)) {
				
				
				
			}
			
			//stuff for after the save
			if(isset($this->data['ProcessCredit'])) {
				
				$this->creditOrder();
				$this->skip_order_update_note = true;
			}
			
			if(isset($this->data['ProcessDebit'])) {
				
				$this->CanteenOrder->debitOrder($this->data);
				$this->skip_order_update_note = true;
				$this->orderNote(array(
					"note"=>"Order Debit",
					"action"=>"DebitOrder"
				));
				
			}
			
			if(isset($this->data['AddItem'])) {
				
				return $this->addItemRedirect();
				$this->skip_order_update_note = true;
			}
			
			//cancel order
			
			if(isset($this->data['CancelOrder'])) {
				
				$this->cancel_order($this->data['CanteenOrder']['id']);
				$this->skip_order_update_note = true;
			}
			
			if(!$this->skip_order_update_note) {
				
				$this->orderNote(array(
					"note"=>"Order Updated",
					"action"=>"OrderEdit"
				));
				
			}
			
			$this->flash("Order Updated",$this->here,3);
			
		} else {
			
			$this->data = $this->CanteenOrder->returnAdminOrder($id);
			
			if(empty($this->data['User']['id'])) {
				
				//let's get the user billing account that we want to use
				$acc = $this->CanteenOrder->User->UserBillingProfile->find("all",array(
					"conditions"=>array(
						"UserBillingProfile.ref_model"=>"CanteenOrder",
						"UserBillingProfile.ref_foreign_key"=>$this->data['CanteenOrder']['id']
					),
					"contain"=>array()
				));
				
				$this->data['User']['UserBillingProfile'] = array();
				
				foreach($acc as $a) $this->data['User']['UserBillingProfile'][] = $a['UserBillingProfile']; 
				
			}
			
			
		}
		
		
	}
	
	
	public function print_invoice($id = false) {
		
		$this->layout = "plain";
		
		$order = $this->CanteenOrder->returnAdminOrder($id);
		
		$this->set(compact("order"));
		
	}
	
	private function creditOrder() {
		
		//let's check to see if the transactions is was made today, if so, then we need to void the transaction and alert the user
		
		$order = $this->CanteenOrder->returnAdminOrder($this->data['CanteenOrder']['id']);
		
		$tid = $this->data['CanteenOrder']['transaction_ref'];
		
		$trans = Set::extract("/GatewayTransaction[id={$tid}]",$order);
		
		$trans = $trans[0]['GatewayTransaction'];
		
		if(!isset($trans['id'])) {
			
			throw new Exception("Credit Canteen Order: No Transaction Was Referenced");
			
		}
		
		//let's see if the created date is greater than tomorrow
		$this_am = strtotime(date("Y-m-d 00:00:00"));
		
		if(strtotime($trans['created'])>$this_am) {
			
			$void = $this->CanteenOrder->GatewayTransaction->voidTransaction($trans);
			
			if($void) {
				
				$this->CanteenOrder->create();
				$this->CanteenOrder->id = $order['CanteenOrder']['id'];
				$this->CanteenOrder->save(array(
					"total"=>($order['CanteenOrder']['total'] - $trans['amount'])
				));
				
				$this->Session->setFlash("NOTE**: Transaction Was Voided. Please Debit The Remainder Amount & Reconsile the order totals");
				$this->orderNote(array(
					"note"=>" Transaction({$trans['id']}) Was Voided",
					"action"=>"CreditTransaction"
				));
				
			} else {
				
				$this->Session->setFlash("There was an error while voiding this transaction");
				$this->orderNote(array(
					"note"=>" Error While Voiding Transaction({$trans['id']})",
					"action"=>"CreditTransaction"
				));
			}
			
		} else {
			
			$credit = $this->CanteenOrder->creditOrder($this->data);
			
			if($credit) {
				
				$this->Session->setFlash($credit." Was Credited To Transaction({$trans['id']})");
				$this->orderNote(array(
					"note"=>$credit." Was Credited To Transaction({$trans['id']})",
					"action"=>"CreditTransaction"
				));
				
			} else {
				
				$this->Session->setFlash("There was and Error crediting Transaction({$trans['id']})");
				$this->orderNote(array(
					"note"=>"There was and Error crediting Transaction({$trans['id']})",
					"action"=>"CreditTransaction"
				));
				
			}
			
		}

		
		
		
	}
	
	private function addItemRedirect() {
		
		$order_id = $this->data['CanteenOrder']['id'];
		
		//start the session
		$this->Session->write("CanteenAdminAddItem",$order_id);

		return $this->redirect("http://dev.theberrics.com/canteen");
		
	}
	
	public function add_item() {
		
		$order_id = $this->Session->read("CanteenAdminAddItem");
		
		$this->Session->delete("CanteenAdminAddItem");
		
	}
	
	public function clear_add_item() {
		
		
		
	}
	
	private function captureOrder() {
		
		$order = $this->CanteenOrder->returnAdminOrder($this->data['CanteenOrder']['id']);
		
		if(strtoupper($order['CanteenOrder']['order_status']) != "AUTHORIZED") {
			
			return false;
	
		}
		
		//let's find the authorized transactions
		$res = false;
		
		foreach($order['GatewayTransaction'] as $t) {
			
			if($t['method'] == "auth" && $t['amount'] > 0) {
				
				$res = $this->CanteenOrder->GatewayTransaction->captureTransaction($t);
				
			}
			
		}
		
		$note = "Transaction Declined";
		
		if($res) {
			
			$this->data['CanteenOrder']['order_status'] = "approved";
			$note = "Transaction Approved";
		}

		$this->orderNote(array("note"=>$note,"action"=>"CaptureOrder"));
		
	}
	
	private function orderNote() {
		
		$args = func_get_args();
		
		if(!is_array($args[0])) {
			
			throw new Exception("Invalid arguments for CanteenOrderController::OrderNote()");
			
		}
		
		$def = array(
		
			"user_id"=>$this->Auth->user("id"),
			"public"=>1,
			"action"=>$this->params['action']
		
		);
		
		$def['canteen_order_id'] = (isset($this->data['CanteenOrder']['id'])) ? $this->data['CanteenOrder']['id']:null;
		
		$data = array_merge($def,$args[0]);
		
		$this->CanteenOrder->CanteenOrderNote->create();
		
		$this->CanteenOrder->CanteenOrderNote->save($data);
		
	}
	
	public function barcode() {


		$this->layout = "empty";


	}
	
	private function cancel_order($id = false) {
		
		$this->CanteenOrder->cancelOrder($id);
		
		$this->orderNote(array(
			"note"=>"Order Canceled",
			"action"=>"CancelOrder"
		));

		
	}
	
	public function resend_email($id,$post_back) {
		
		if($this->CanteenOrder->EmailMessage->resendEmail($id,true)) {
			
			$m = "Email has been queued for re-send";
			
		} else {
			
			$m = "An error occured while trying to re-queue the email";
			
		}
		
		return $this->redirect(base64_decode($post_back));
		
		
	}
	
}