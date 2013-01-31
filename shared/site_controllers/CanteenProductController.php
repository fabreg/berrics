<?php

App::import("Controller","CanteenApp");

class CanteenProductController extends CanteenAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		$this->initPermissions();
		$this->Auth->allow("*");
		
	}
	
	public function view() {
		
		$uri = $this->request->params['uri'];
		
		$product = $this->CanteenProduct->returnProduct(array("conditions"=>array(
			"CanteenProduct.uri"=>$uri
		)),$this->isAdmin());
		
		
		$similar = $this->CanteenProduct->productViewSimilarProducts($product['CanteenProduct']['canteen_category_id'],3,array($product['CanteenProduct']['id']));



		//setup the facebook metas
		$fb_img = $product['CanteenProductImage'][0]['file_name'];
		$fb_meta_img = "<meta property='og:image' content='//img.theberrics.com/product-img/{$fb_img}'>";



		$this->set(compact("product","similar","fb_meta_img"));


		
	}
	
	
	
}