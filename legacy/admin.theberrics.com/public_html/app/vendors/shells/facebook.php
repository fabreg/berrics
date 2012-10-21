<?php


class FacebookShell extends Shell {
	
	
	public $uses = array("Dailyop");
	
	
	
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
			curl_setopt($c,CURLOPT_URL,"https://developers.facebook.com/tools/lint/?url={$url_enc}&format=json");
			
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
	
	
}