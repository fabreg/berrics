<?php 
$_SERVER['DEVSERVER']=1;
class MailerShell extends Shell {
	
	public $uses = array("EmailMessage","CanteenOrder","User");
	private $email = null;
	private $controller = null;
	
	public function initialize() {
		
		parent::initialize();
		App::import("Component","Email");
		App::import("Core","Controller");
		$this->email =& new EmailComponent(null);
		$this->controller =& new Controller();
		$this->email->initialize($this->controller);
		
	}
	
	public function process_queue() {

		//grab 50 emails
		$emails = $this->EmailMessage->find("all",array(
		
			"conditions"=>array(
				"EmailMessage.processed"=>0
			),
			"contain"=>array()
		
		));	
		
		SysMsg::add(array(
			"category"=>"Emailer",
			"from"=>"MailerShell",
			"crontab"=>1,
			"title"=>"Emails to processes: ".count($emails)
		));
		
		$success = 0;
		
		foreach($emails as $msg) {
			
			$e = $msg['EmailMessage'];
			
			$this->email->reset();
			$this->email->to = $e['to'];
			$this->email->from = $e['from'];
			$this->email->subject=$e['subject'];
			$this->email->cc = explode(",",$e['cc']);
			$this->email->bcc = $e['bcc'];
			$this->email->sendAs = $e['send_as'];
			$this->email->template = $e['template'];
			$this->email->smtpOptions = array(
												'port'=>'465',
												'timeout'=>'30',
												'host' => 'ssl://smtp.gmail.com',
												'username'=>'do.not.reply@theberrics.com',
												'password'=>'19Berrics82',
			);
			
			
			$this->controller->set(compact("msg"));
			
			if($this->email->send()) {
				
				$this->EmailMessage->create();
				$this->EmailMessage->id = $e['id'];
				$this->EmailMessage->save(array("processed"=>1,"send_date"=>'NOW()'));
				$success++;
				
			}
				
		}
		
		SysMsg::add(array(
			"category"=>"Emailer",
			"from"=>"MailerShell",
			"crontab"=>1,
			"title"=>"Email Send Results: Success ({$success}) Total (".count($emails).")"
		));
		
		
		
		
	}
	
	
	
	
}