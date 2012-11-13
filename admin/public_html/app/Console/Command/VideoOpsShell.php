<?php

class VideoOpsShell extends AppShell {

	public $uses = array(
		"VideoTask"
	);

	public function run() {
	
		//check to see if we are working
		if($this->checkWorking()) {

			return;

		} else {

			$this->working();

		}

		//get the pending tasks
		$tasks = $this->VideoTask->find("all",array(
			"conditions"=>array(
				"VideoTask.task_status"=>"pending"
			)
		));

		foreach($tasks as $task) {

			try {

				$this->VideoTask->{$task['VideoTask']['task']}($task);

			}
			catch(Exception $e) {

				$msg = $e->getMessage();

				SysMsg::add(array(
						"category"=>"VideoOps",
						"from"=>"Youtube - ".$task['VideoTask']['task'],
						"crontab"=>1,
						"title"=>"Youtube - ".$task['VideoTask']['task']." Exception",
						"message"=>$msg
				));

			}
			

		}

		$this->completed();
		
	}


	public function working() {
		
		`touch /tmp/VideoOps`;

	}

	public function completed() {
		
		`rm -rf /tmp/VideoOps`;

	}

	public function checkWorking() {

		return file_exists("/tmp/VideoOps");

	}


}