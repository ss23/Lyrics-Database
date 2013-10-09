<?php

App::uses('DispatcherFilter', 'Routing');

/*
 *  Modify API controller to dispatch to correct version.
 *  Needs a route such as this to use api controller and passed version number:
 *  Router::connect('/:version/:action/*', array('controller'=>'api'), array('version'=>'[0-9]+'));
 */

class ApiDispatcher extends DispatcherFilter {

    public function beforeDispatch(CakeEvent $event) {
        $request = $event->data['request'];
        if ($request['controller'] != "api")
        	return;
        if (isset($request['version'])) {
        	$request['controller'] .= $request['version'];
        }
    }
}