<?php
App::uses('AppModel', 'Model');
/**
 * PollVotingOption Model
 *
 * @property Poll $Poll
 * @property PollVotingRecord $PollVotingRecord
 * @property PollVotingResult $PollVotingResult
 */
class PollVotingOption extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Poll' => array(
			'className' => 'Poll',
			'foreignKey' => 'poll_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'PollVotingRecord' => array(
			'className' => 'PollVotingRecord',
			'foreignKey' => 'poll_voting_option_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PollVotingResult' => array(
			'className' => 'PollVotingResult',
			'foreignKey' => 'poll_voting_option_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
