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
	
	public $data;

	public function song($artist=null, $song=null){
		$this->data = $this->Song->findByArtist($song, $artist);
		if (empty($this->data))
			throw new NotFoundException(__('Invalid song'));
	}

	public function beforeRender() {
		parent::beforeRender();
		
		// XML format doesn't allow top-level arrays
		if ($this->request->params['ext'] == "xml")
			$this->data = array($this->data);
		
		$this->set(array(
			'data' => $this->data,
			'_serialize' => 'data',
		));
	}
}

