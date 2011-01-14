<?php

class API {
	static $type = 'json'; // A default in case it's never detected.
	
	static function setType($type) {
		self::$type = strtolower($type);
	}
	
	static function processInput() {
		switch (self::$type) {
			case 'json':
				try {
					return json_decode($_POST['input']);
				} catch (Exception $e) {
					// It wasn't valid at all.
					// I would extend some exceptions here, but I want docs for that.
					throw new Exception('Invalid input');
				}
				return false;
				break;
			case 'xml':
				try {
					throw new Exception('Not implemented');
				} catch (Exception $e) {
					// It wasn't valid at all.
					// I would extend some exceptions here, but I want docs for that.
					throw new Exception('Invalid input');
				}
				return false;
				break;
			default:
				throw new Exception('Invalid input');
				return false;
				break;
		}
	}
	
	static function Send($handler) {
		// Could use reflection to do this really, in fact, I will when I get a chance to read the docs.
		// No internet is the worst :<
		$class = get_class($handler);
		
		if (self::$type == 'json') {
			// This doesn't take into account optional parameters.
			echo json_encode(array($class => $handler));
			return;
		}
	}
	
	static function autoloader($class) {
		// Check to see if a file for this class exists, and if so, load it.
		if (is_readable('./objects/' . $class . '.veon.php')) {
			require_once ('./objects/' . $class . '.veon.php');
			return true;
		}
		return false;
	}
}
?>