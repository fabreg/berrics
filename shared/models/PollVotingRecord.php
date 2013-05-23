<?php
App::uses('AppModel', 'Model');
/**
 * PollVotingRecord Model
 *
 * @property User $User
 * @property PollVotingOption $PollVotingOption
 */
class PollVotingRecord extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PollVotingOption' => array(
			'className' => 'PollVotingOption',
			'foreignKey' => 'poll_voting_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function addVote($option_id = false,$session = false,$user = false) {

		$option = $this->PollVotingOption->returnOption($option_id);

		if($this->checkIfAlreadyVoted($option['Poll']['id'],$session,$user)) return false;

		$data = array(

			"poll_voting_option_id"=>$option_id,
			"poll_id"=>$option['Poll']['id']

		);

		if($session) $data['session_id'] = $session;

		if($user) $data['user_id'] = $user;

		$this->create();

		$this->save($data);

		return $this->id;

	}

	public function checkIfAlreadyVoted($poll_id = false,$session = false,$user = false) {
		//run a check to see if there is a vote in the system with the session of the user
		if(!$poll_id) throw new BadRequestException("Must Sepcify and poll id");

		if(!$session) throw new BadRequestException("Must sepcify a session");

		$cond = array(
			'PollVotingRecord.poll_id'=>$poll_id
		);

		if($session) $cond['PollVotingRecord.session_id'] = $session;

		if($user) {

			unset($cond['PollVotingRecord.session_id']);

			$cond = array_merge($cond,array(
					"OR"=>array(
						'PollVotingRecord.session_id'=>$session,
						"PollVotingRecord.user_id"=>$user
					)
				));

		}

		$chk = $this->find('count',array(
					'conditions'=>$cond
				));

		if($chk<=0) return false;

		return true;

	}
}
