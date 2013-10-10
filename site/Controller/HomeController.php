<?php

/**
 * Generic controller for the home page
 * Currently should display 'hot' things
 *
 */
class HomeController extends AppController {
	public $uses = array('Artist', 'Song'); // No model

	public function index() {
		$artists = $this->Artist->getHot(8);
		$this->set('hot_artists', $artists);
		$songs = $this->Song->getHot(20);
		$this->set('hot_songs', $songs);
	}
	
	public function api() {
		$this->redirect("http://lyricjam.com");
	}
}

