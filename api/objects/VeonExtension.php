<?php

/**
 * The parent class used for all API extension objects
 */

abstract class VeonExtension {

	public function __construct($params) {
		// Still need to think of a way to implement optional/required params. Can just implement in run() for now.
		foreach ($params as $name => $value) {
			// Need a property exists.
			$this->{'Param' . $name} = $value;
		}
		$this->run();
	}
	
	public function __set($name, $value) {
		// Tried to set a property that doesn't exist.
		// Once again, we need to extend the exceptions tbh.
		throw new Exception('Invalid Parameter');
		return false;
	}
	
	public function run() {
		// We could use an abstract function, but that wouldn't give us the cool exception "not implemented".
		// I shall experiment with catching a "method run() wasn't implemented" exception/error later.
		throw new Exception('Not implemented');
	}
	
}