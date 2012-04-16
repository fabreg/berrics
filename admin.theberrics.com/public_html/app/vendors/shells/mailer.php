<?php 
$_SERVER['DEVSERVER']=1;
class MailerShell extends Shell {
	
	public $uses = array("EmailMessage","User");
	private $Email = null;
	private $controller = null;
	
	public function initialize() {
		
		parent::initialize();
		App::import("Component","Email");
		App::import("Core","Controller");
		$this->Email =& new EmailComponent(null);
		$this->controller =& new Controller();
		$this->Email->initialize($this->controller);
		
	}
	
	public function process_queue() {

		//grab 50 emails
		$emails = $this->EmailMessage->find("all",array(
		
			"conditions"=>array(
				"EmailMessage.processed !="=>1
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
			
			$this->Email->reset();
			$this->Email->to = $e['to'];
			$this->Email->from = $e['from'];
			$this->Email->subject=$e['subject'];
			$this->Email->cc = explode(",",$e['cc']);
			$this->Email->bcc = $e['bcc'];
			$this->Email->sendAs = $e['send_as'];
			$this->Email->template = $e['template'];
			$this->Email->smtpOptions = array(
												'port'=>'465',
												'timeout'=>'30',
												'host' => 'ssl://smtp.gmail.com',
												'username'=>'do.not.reply@theberrics.com',
												'password'=>'19Berrics82',
			);
			
			
			$this->controller->set(compact("msg"));
			
			if($this->Email->send()) {
				
				$this->EmailMessage->create();
				$this->EmailMessage->id = $e['id'];
				$this->EmailMessage->save(array("processed"=>1,"send_date"=>'NOW()'));
				$success++;
				
			} else {
				
				SysMsg::add(array(
					"category"=>"Emailer",
					"from"=>"MailerShell",
					"crontab"=>1,
					"title"=>"Email Failure - Message ID: {$e['id']}"
				));
						
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