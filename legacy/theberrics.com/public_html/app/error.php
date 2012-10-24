<?php

class AppError extends ErrorHandler {
	
	
	public function error404($params) {
		
		$this->controller->view = "Theme";
		$this->controller->theme = "website";
		
		parent::error404($params);
		
	}
	
	
}

?>