<?php
App::uses('AppController', 'Controller', 'Set');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 */
class ArtistsController extends AppController {

	public $paginate = array(
			'limit' => 30,
			'order' => array('Artist.name' => 'asc')
	);

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Artist->recursive = 1;
		$this->set('artists', $this->paginate());
	}

	/**
	 * A way to get all the currently 'hot' artists
	 * Uses last.fm at the moment, could change later
	 * 
	 * @return void
	 */
	public function hot() {
		// TODO: Add a "You have no last.fm key!" all nice
		if (!Configure::read('lastfmkey')) {
			throw new Exception('No Last.FM key configured');
		}
		$json = Cache::read('lastfm_hot_artists', '_hourly_');
		if (!$json) {
			$json = json_decode(file_get_contents('http://ws.audioscrobbler.com/2.0/?method=chart.gettopartists&format=json&limit=50&api_key=' . Configure::read('lastfmkey')), true); // Grab ~50 artists
			$json = $json['artists']['artist'];
			Cache::write('lastfm_hot_artists', $json, '_hourly_');
		}
		// For each artist, try match it to a Jam artist
		$artists = array(); // The LJ artists
		foreach ($json as $artist) {
			$a = $this->Artist->findByName($artist['name']);
			if (!$a) {
				// We could try a fuzzy search here
				// TODO: this
				// Note that if we don't find a poular artist, we should totally be like "YO GUYS, LETS FIND LYRICS FOR THIS ARTIST" somewhere
			} else {
				$artists[] = $a;
			}
		}	
		$this->set('artists', $artists);
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Artist->recursive = 2;
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
        $this->set('title_for_layout', $this->Artist->Field('name'));
		$this->set('artist', $this->Artist->Field('name'));
		$testy = $this->Artist->find('all', array(
				'conditions' => array('id' => $id)
			)
		);
		$album_ids = array_unique(Set::extract('/Song/Album/id', $testy));
		$this->set('albums', $this->Artist->Song->Album->find('all', array(
				'fields' => array('DISTINCT id', 'name'),
				'conditions' => array('id' => $album_ids)
			)
		));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('The artist has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artist could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Artist->read(null, $id);
		}
		$songs = $this->Artist->Song->find('list');
		$this->set(compact('songs'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		if ($this->Artist->delete()) {
			$this->Session->setFlash(__('Artist deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Artist was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Artist->recursive = 0;
		$this->set('artists', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		$this->set('artist', $this->Artist->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Artist->create();
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('The artist has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artist could not be saved. Please, try again.'));
			}
		}
		$songs = $this->Artist->Song->find('list');
		$this->set(compact('songs'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('The artist has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The artist could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Artist->read(null, $id);
		}
		$songs = $this->Artist->Song->find('list');
		$this->set(compact('songs'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('Invalid artist'));
		}
		if ($this->Artist->delete()) {
			$this->Session->setFlash(__('Artist deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Artist was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
