<?php


App::build(array(
		"Controller"=> array($_SERVER['DOCUMENT_ROOT']."/../../shared/controllers/"),
		'Model'=> array($_SERVER['DOCUMENT_ROOT']."/../../shared/models/"),
		'Plugin' => array($_SERVER['DOCUMENT_ROOT']."/../../shared/plugins/"),
		'View/Helper' => array($_SERVER['DOCUMENT_ROOT']."/../../shared/helpers/"),
		'Vendor'  => array($_SERVER['DOCUMENT_ROOT']."/../../shared/vendors/"),
		'Controller/Component' => array($_SERVER['DOCUMENT_ROOT']."/../../shared/components/"),
		'Model/Behavior'=>array($_SERVER['DOCUMENT_ROOT']."/../../shared/behaviors/"),
		"View"	=>	array($_SERVER['DOCUMENT_ROOT']."/../../shared/views/"),
		"Console"	=>	array($_SERVER['DOCUMENT_ROOT']."/../../shared/commands/")
));