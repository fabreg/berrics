<?php

App::uses("LocalAppController","Controller");

class PollController extends LocalAppController {


	public $uses = array("Poll");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}


	public function splash_poll($poll_id = false) {
		
		$this->layout = "empty";

		//check to see if they have voted
		$this->set(compact("poll_id"));

	}

	public function splash_poll_ajax($poll_id) {
		
		$poll = $this->Poll->returnPoll($poll_id);

		$this->set(compact("poll"));

		//check to see if they have already voted
		$user_id = (CakeSession::check("Auth.User.id"))  ? $this->Auth->user('id'):false;

		$chk = $this->Poll->PollVotingRecord->checkIfAlreadyVoted($poll_id,session_id(),$user_id);

		if($chk) {

			$results = $this->Poll->pollResultsRealtime($poll_id);
			$this->set(compact("results"));
			$this->view = "splash_poll_results";

		} else {

			$this->view = "splash_poll_vote";

		}

	}

	public function splash_handle_vote() {
		
		if($this->request->is("post") || $this->request->is("put")) {

			$user_id = (CakeSession::check("Auth.User.id"))  ? $this->Auth->user('id'):false;

			$this->Poll->PollVotingRecord->addVote($this->request->data['PollVotingRecord']['poll_voting_option_id'],session_id(),$user_id);

			sleep(2);

			$this->redirect("/");

		}

	}


}