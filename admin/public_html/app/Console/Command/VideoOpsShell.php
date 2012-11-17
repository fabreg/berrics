<?php

class VideoOpsShell extends AppShell {

	public $procNum = 1;

	public $uses = array(
		"VideoTask",
		"VideoTaskServer"
	);

	public function run() {
		
		$server = php_uname('n');
		
		//get a task and grab priority first
		$task = $this->VideoTask->find("first",array(
			"conditions"=>array(
				"VideoTask.server"=>$server,
				"VideoTask.task_status"=>"pending"
			),
			"contain"=>array(),
			"order"=>array(
				"VideoTask.priority"=>"DESC"
			)
		));

		if(!isset($task['VideoTask']['id'])) {

			$this->out("No Tasks Available : Exiting");
			return;

		}

		try {

			$msg = $this->VideoTask->{$task['VideoTask']['task']}($task);

		} 
		catch(Exception $e) {

			$msg = $e->getMessage();

		}

		$this->out("Message: ".$msg);

	}

	public function assign_tasks() {
		
		$_SERVER['FORCEMASTER'] = 1;

		//clean shit up
		$this->garbageCollection();

		//grab the server list
		$servers = $this->VideoTaskServer->find("all",array(
			"conditions"=>array(
				"VideoTaskServer.active"=>1
			)
		));

		if(count($servers)<=0) {

			$this->out("No Active Servers Available : Exit");
			return;

		}

		$available_tasks = 0;

		//go thru each server,
		//check for working tasks
		//add the difference to the available tasks
		foreach ($servers as $k => $v) {
				
			$working = $this->VideoTask->find("count",array(
				"conditions"=>array(
					"VideoTask.task_status"=>array("working","pending"),
					"VideoTask.server"=>$v['VideoTaskServer']['server']
				),
				"contain"=>array()
			));

			$servers[$k]['available'] = $v['VideoTaskServer']['max_tasks'] - $working;

			if($servers[$k]['available']>0) {

				$available_tasks += $v['VideoTaskServer']['max_tasks'] - $working;

			}

			
		}

		if($available_tasks<=0) {

			$this->out("All Servers Are Busy : Exiting");
			return;

		}

		//grab task based on available limit
		$tasks = $this->VideoTask->find("all",array(
			"conditions"=>array(
				"VideoTask.task_status"=>"pending",
				"VideoTask.server"=>null
			),
			"contain"=>array(),
			"order"=>array(
				"VideoTask.priority"=>"DESC"
			),
			"limit"=>$available_tasks
		));

		if(count($tasks)<=0) {

			$this->out("There are no pending tasks : exiting");

			return;

		}

		$task_count = count($tasks);
		$task_key = 0;
		while($task_count>0) {

			foreach($servers as $k=>$v) {

				if($v['available']>0) {

					if(isset($tasks[$task_key]['VideoTask'])) {

						$tasks[$task_key]['VideoTask']['server'] = $v['VideoTaskServer']['server'];
						$servers[$k]['available']--;
						$task_key++;

					}
					
					$task_count--;

				} else {

					unset($servers[$k]);

				}

			}


		}

		foreach($tasks as $task) {

			if(isset($task['VideoTask']['id'])) {

				$this->VideoTask->create();
				$this->VideoTask->id = $task['VideoTask']['id'];
				$this->VideoTask->save(array(
					"server"=>$task['VideoTask']['server']
				));

			}

		}



		$this->out(print_r($tasks));


	}

	private function garbageCollection() {
		
		$_SERVER['FORCEMASTER'] = 1;

		$server_name = php_uname('n');

		$date_seed = date("Y-m-d H:i:s",strtotime("-12 Minutes"));

		$sql = "update video_tasks set task_status='timeout' where task_status='working' and modified <= '$date_seed'";

		$this->VideoTask->query($sql);

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