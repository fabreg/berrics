<?php

class VideoOpsShell extends AppShell {

	public $procNum = 1;

	public $uses = array(
		"VideoTask"
	);

	public function run() {
		
		if(isset($this->args[0]) && is_numeric($this->args[0])) $this->procNum = $this->args[0];

		//check to see if we are working
		if($this->checkWorking()) {

			return;

		} else {

			$this->working();

		}

		$sleep = $this->procNum*2;

		sleep($sleep);

		//get the pending tasks
		$task = $this->VideoTask->find("first",array(
			"conditions"=>array(
				"VideoTask.task_status"=>"pending"
			)
		));

		if(!isset($task['VideoTask']['id'])) return $this->completed(); 

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

			$this->VideoTask->create();
			$this->VideoTask->id = $task['VideoTask']['id'];
			$this->VideoTask->save(array(
				"task_status"=>"error"
			));

			$this->completed();

		}

		$this->completed();
		
	}


	public function working() {
		
		$file = "VideoOps".$this->procNum;

		`touch /tmp/$file`;

	}

	public function completed() {
		
		$file = "VideoOps".$this->procNum;

		`rm -rf /tmp/$file`;

	}

	public function checkWorking() {

		$file = "VideoOps".$this->procNum;

		return file_exists("/tmp/$file");

	}


}