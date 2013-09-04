<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');
App::uses('SlugLib', 'LyricJam');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';


/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public $components = array('Paginator');

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
	
	public function search() {
		if (empty($this->params['url']['q'])) {
			// Possibly could do a flash here, not a big thing I don't think
			$this->redirect('/');
			return;
		}

		// Preferably, we would use a bloody search engine here
		// TODO: Investigate solr/sphinx/anything (p.s. they're all shit)
		$this->loadModel('Song');
		$this->loadModel('Artist');
		$this->loadModel('Album');

		$query = ($this->params['url']['q']);

		// Required for slug hacks
		$this->Album->recursive = 4;
		$this->Artist->recursive = 4;

		
		// First, check if there is only one match when we search for this query, in either album name, artist name, or song name
		$artist = $this->Artist->find('all', array(
			'conditions' => array('Artist.Name LIKE' => $query),
			'limit' => 2,
		));
		$song = $this->Song->find('all', array(
			'conditions' => array('Song.Name LIKE' => $query),
			'limit' => 2,
		));
		$album = $this->Album->find('all', array(
			'conditions' => array('Album.Name LIKE' => $query),
			'limit' => 2,
		));

		// SlugLib::slugify($string, $slug)
		// array('action' => 'view', 'song' => $song['Song']['slug'], 'album' => $song['Album'][0]['slug'], 'artist' => $song['Artist'][0]['slug'])

		// TODO: Please, less hacks. please.

		// Only redirect when there's a unique match
		// Eventually we should add a "and the artist is more popular than X", so that obscure names don't mess this up
		if (!$album && !$song && (count($artist) == 1)) {
			// We found a match on only artist!
			// Redirect them to the artist page
			$this->redirect(array(
				'controller' => 'artists',
				'action' => 'view',
				'artist' => $artist[0]['Artist']['slug'],
			));
			return;
		} else if (!$album && (count($song) == 1) && !$artist) {
			$this->redirect(array(
				'controller' => 'songs',
				'action' => 'view',
				'artist' => $song[0]['Artist'][0]['slug'],
				'album' => $song[0]['Album'][0]['slug'],
				'song' => $song[0]['Song']['slug'],
			));
			return;
		} else if ((count($album) == 1) && !$song && !$artist) {
			$this->redirect(array(
				'controller' => 'albums',
				'action' => 'view',
				'album' => $album[0]['Album']['slug'],
				'artist' => $album[0]['Song'][0]['Artist'][0]['slug'],
			));
			return;
		}

		// If we haven't found anything by now, it's likely a fragment

		$this->paginate = array(
			'Song' => array(
				'limit' => 20,
				'conditions' => array('OR'=> array('Song.name LIKE'=>"%$query%", 'Song.lyrics LIKE'=>"%$query%")),
			),
			'Artist' => array(
				'limit' => 20,
				'conditions' => array('Artist.name LIKE'=>"%$query%"),
			),
			'Album' => array(
				'limit' => 20,
				'conditions' => array('Album.name LIKE' => "%$query%"),
			),
		);
		$this->Artist->recursive = 1;
		try {
			$songs = $this->Paginator->paginate('Song');
		} catch (NotFoundException $e) {
			$songs = array();
		}
		try {
			$artists = $this->Paginator->paginate('Artist');
		} catch (NotFoundException $e) {
			$artists = array();
		}
		try {
			$albums = $this->Paginator->paginate('Album');
		} catch (NotFoundException $e) {
			$albums = array();
		}
		$this->set(compact('query','songs','artists','albums'));
	}

}
