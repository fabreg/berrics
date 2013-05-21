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
}
