<?php
App::uses('AppModel', 'Model');
/**
 * Poll Model
 *
 * @property Website $Website
 * @property PollVotingOption $PollVotingOption
 */
class Poll extends AppModel {

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
		'Website' => array(
			'className' => 'Website',
			'foreignKey' => 'website_id',
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
		'PollVotingOption' => array(
			'className' => 'PollVotingOption',
			'foreignKey' => 'poll_id',
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
		"PollVotingRecord"
	);

	public function returnAdminPoll($id) {
		
		$poll = $this->find('first',array(
					"conditions"=>array(
						"Poll.id"=>$id
					),
					"contain"=>array(
						"PollVotingOption"=>array(
							"order"=>array("PollVotingOption.display_weight"=>ASC)
						)
					)
				));

		return $poll;

	}

	public function returnPoll($id,$cache = true) {

		$token = "poll-{$id}";

		if(($poll = Cache::read($token,"1min")) === false && $cache) {

			$poll = $this->find('first',array(
						"conditions"=>array(),
						"contain"=>array(
							"PollVotingOption"=>array("order"=>array("PollVotingOption.display_weight"=>"ASC"))
						)
					));

			Cache::write($token,$poll,"1min");

		}

		return $poll;

	}

	public function pollResultsRealtime($id = false) {
		
		$options = $this->PollVotingOption->find('all',array(
						"conditons"=>array(
							"PollVotingOption.poll_id"=>$id
						),
						"contain"=>array(),
						"field"=>array("PollVotingOption.id","PollVotingOption.name")
					));
		$options_ids = Set::extract("/PollVotingOption/id",$options);

		$option_ids = implode(",", $options_ids);

		$q = "SELECT PollVotingOption.id,count(PollVotingRecord.id) as `total`,PollVotingOption.name 
				FROM poll_voting_options `PollVotingOption`
				LEFT JOIN poll_voting_records `PollVotingRecord`  ON (PollVotingOption.id = PollVotingRecord.poll_voting_option_id)
				WHERE PollVotingOption.poll_id = {$id}
				GROUP BY PollVotingOption.id
				ORDER BY total DESC";
		


		$q = $this->query($q,false);

		$total = Set::extract("/0/total",$q);

		$q['TotalVotes'] = array_sum($total);

		foreach($q as $k=>$v) {

			if(!is_numeric($k)) continue;
			$q[$k][0]['percent'] = ($v[0]['total']/$q['TotalVotes'])*100;

		}

		$poll = $this->returnPoll($id);

		$q['Poll'] = $poll;

		return $q;

	}



}
