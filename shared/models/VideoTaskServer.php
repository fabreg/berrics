<?php
App::uses('AppModel', 'Model');
/**
 * VideoTaskServer Model
 *
 */
class VideoTaskServer extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'server';

}
