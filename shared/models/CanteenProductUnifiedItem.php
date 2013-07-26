<?php


class CanteenProductUnifiedItem extends AppModel {

	public $belongsTo = array(

			"CanteenProduct",
			"UnifiedStore"
		);

}