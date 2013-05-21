<?php
App::uses('AppModel', 'Model');
/**
 * PollVotingResult Model
 *
 * @property PollVotingOption $PollVotingOption
 */
class PollVotingResult extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'PollVotingOption' => array(
			'className' => 'PollVotingOption',
			'foreignKey' => 'poll_voting_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
