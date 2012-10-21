<?php 

App::uses('CakeEmail', 'Network/Email');

class MailerShell extends AppShell {
	
	public $uses = array("EmailMessage","User");

	
	public function process() {
		
		$c = new CakeEmail('default');
		
		//grab 50 emails
		$emails = $this->EmailMessage->find("all",array(
		
				"conditions"=>array(
						"EmailMessage.processed"=>0
				),
				"contain"=>array()
					
		));
		
		$total_emails = count($emails);
		
		$this->out("emails to processes: ".$total_emails);
		
		SysMsg::add(array(
				"category"=>"Emailer",
				"from"=>"MailerShell",
				"crontab"=>1,
				"title"=>"Emails to processes: ".$total_emails
		));
		
		foreach($emails as $email) {
			
			$e = $email['EmailMessage'];
			$c->reset();
			$c->config('default');
			$c->to($e['to']);
			$c->subject($e['subject']);
			$c->template($e['template']);
			$c->viewVars(array("msg"=>$email));
			
			if($c->send()) {
				
				$this->EmailMessage->create();
				
				$this->EmailMessage->id = $e['id'];
				
				$this->EmailMessage->save(array(
							"processed"=>1,
							"sent_date"=>DboSource::expression('NOW()')
						));
				
				$total_emails--;
				
				$this->out("Email:".$e['to']." Template: ".$e['template']);
				
			} else {
				
				$this->out("Email failed: ".$e['id']);
				
				SysMsg::add(array(
						"category"=>"Emailer",
						"from"=>"MailerShell",
						"crontab"=>1,
						"title"=>"Email Failed: ".$e['id']
				));
				
			}
			
			
		}

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
			
		
			
			$this->controller->set(compact("msg"));
			
		
				
		}
		
		SysMsg::add(array(
			"category"=>"Emailer",
			"from"=>"MailerShell",
			"crontab"=>1,
			"title"=>"Email Send Results: Success ({$success}) Total (".count($emails).")"
		));
		
		
		
		
	}
	
	
	
	
}