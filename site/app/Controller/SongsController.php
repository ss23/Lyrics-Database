<?php
App::uses('AppController', 'Controller');
/**
 * Songs Controller
 *
 * @property Song $Song
 */
class SongsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Song->recursive = 0;
		$this->set('songs', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @param string $name
 * @return void
 * @throws NotFoundException If invalid song
 */
	public function view($id = null) {
        $this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException(__('Invalid song'));
		}
		$this->set('title_for_layout', $this->Song->Field('name') . ' by ' . $this->Song->Artist->Field('name'));
		$this->set('song', $this->Song->read());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Song->create();
			if ($this->Song->save($this->request->data)) {
				$this->Session->setFlash(__('The song has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The song could not be saved. Please, try again.'));
			}
		}
		$albums = $this->Song->Album->find('list');
		$artists = $this->Song->Artist->find('list');
		$this->set(compact('albums', 'artists'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException(__('Invalid song'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Song->save($this->request->data)) {
				$this->Session->setFlash(__('The song has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The song could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Song->read(null, $id);
		}
		$albums = $this->Song->Album->find('list');
		$artists = $this->Song->Artist->find('list');
		$this->set(compact('albums', 'artists'));
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
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException(__('Invalid song'));
		}
		if ($this->Song->delete()) {
			$this->Session->setFlash(__('Song deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Song was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Song->recursive = 0;
		$this->set('songs', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException(__('Invalid song'));
		}
		$this->set('song', $this->Song->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Song->create();
			if ($this->Song->save($this->request->data)) {
				$this->Session->setFlash(__('The song has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The song could not be saved. Please, try again.'));
			}
		}
		$albums = $this->Song->Album->find('list');
		$artists = $this->Song->Artist->find('list');
		$this->set(compact('albums', 'artists'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException(__('Invalid song'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Song->save($this->request->data)) {
				$this->Session->setFlash(__('The song has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The song could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Song->read(null, $id);
		}
		$albums = $this->Song->Album->find('list');
		$artists = $this->Song->Artist->find('list');
		$this->set(compact('albums', 'artists'));
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
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException(__('Invalid song'));
		}
		if ($this->Song->delete()) {
			$this->Session->setFlash(__('Song deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Song was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
