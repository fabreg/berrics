<?php 

App::uses('CakeEmail', 'Network/Email');

class MailerShell extends AppShell {
	
	public $uses = array("EmailMessage","User","Dailyop");

	
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

public function hit_linter() {
		
		//grab the last 20 published posts
		
		$msg = "";
		
		$posts = $this->Dailyop->find("all",array(
			"conditions"=>array(
				"Dailyop.publish_date<NOW()",
				"Dailyop.active"=>1
			),
			"contain"=>array(
				"DailyopSection"
			),
			"limit"=>20,
			"order"=>array("Dailyop.publish_date"=>"DESC")
		));
		
		foreach($posts as $post) {
			
			//let's make the URL
			
			$url = "http://theberrics.com/".$post['DailyopSection']['uri']."/".$post['Dailyop']['uri'];
			
			$this->out("++++++++++++++++++++++++++++++++++");
			$this->out("Linting Url: ".$url);
			
			$url_enc = urlencode($url);
			
			
			$c = curl_init();
			curl_setopt($c,CURLOPT_FOLLOWLOCATION,true);
			curl_setopt($c,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($c,CURLOPT_URL,"http://developers.facebook.com/tools/debug/og/object?q={$url_enc}&format=json");
			
			$res = curl_exec($c);
			
			$this->out("Response: ".$res);
			
			SysMsg::add(array(
				"category"=>"Facebook",
				"crontab"=>1,
				"from"=>"FacebookShell",
				"title"=>"Linting URL: ".$url,
				"message"=>$res
			));
			
			$this->out("++++++++++++++++++++++++++++++++++");
			$this->out("Sleeping.....zzz.z.z.z.z");
			sleep(3);
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