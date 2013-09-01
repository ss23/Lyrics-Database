<?php

/**
 * Generic controller for the home page
 * Currently should display 'hot' things
 *
 */
class HomeController extends AppController {
	public $uses = array('Artist', 'Song'); // No model

	public function index() {
		// Cache the hot artists and hot songs
		$artists = Cache::read('hot_artists_9', '_halfhour_');
		if (!$artists) {
			$artists = $this->Artist->getHot(8);
			Cache::write('hot_artists_9', $artists, '_halfhour_');
		}
		$this->set('hot_artists', $artists);

		$songs = Cache::read('hot_songs_20', '_halfhour_');
		if (!$songs) {
			$songs = $this->Song->getHot(20);
			Cache::write('hot_songs_20', $songs, '_halfhour_');
		}
		$this->set('hot_songs', $songs);
	}
}

