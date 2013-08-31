<?php

/**
 * Generic controller for the home page
 * Currently should display 'hot' things
 *
 */
class HomeController extends AppController {
	public $uses = array('Artist', 'Song'); // No model

	public function index() {
		$this->set('hot_artists', $this->Artist->getHot(20));
		$this->set('hot_songs', $this->Song->getHot(20));
	}
}

