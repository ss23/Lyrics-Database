<?php

/**
 * Controller for API functions
*
*/
class Api1Controller extends AppController {

	public $uses = array('Artist', 'Album', 'Song');

	public $components = array(
			'RequestHandler',
			'Paginator',
	);

	public function artist($name){
		$this->Artist->recursive = -1;
		$data = $this->Artist->findByName($name);
		// 		print_r($data);
		$this->set('data', array($data));
	}

	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('_serialize', 'data');
	}
}

