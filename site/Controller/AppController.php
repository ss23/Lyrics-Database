<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $helpers = array('Html', 'Form', 'Slug', 'Thumbnail');
    
    public $components = array(	
    	'DebugKit.Toolbar',
    );
    
    public $theme = 'LyricJam';
    
    public function beforeFilter(){
    	if (SUBDOMAIN == "api")
    		$this->layout = "api";    	
    	
    	// Disable editing and deleting for now
    	if ($this->action == 'edit' || $this->action == 'delete')
    		$this->action = 'view';
    	
    	if (isset($this->request->params['page']))
    		$this->request->params['named']['page'] = $this->request->params['page'];
    	
    	// TODO: Investigate better method for caching, and $this->loadModel() vs ClassRegistry::init()
    	$counts = array(
    		'Artists' => ClassRegistry::init('Artists')->getCacheCount(),
    		'Albums' => ClassRegistry::init('Albums')->getCacheCount(),
    		'Songs' => ClassRegistry::init('Songs')->getCacheCount(),
    	);
    	$this->set(compact('counts'));
    }

}
