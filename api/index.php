<?php
/**
 * Bootstrapper
 */

// Versatile Extendable Object Notation
// Veon

// Require everything that's needed.
require_once ('Objects/API.php');
require_once ('Objects/VeonExtension.php');
require_once ('Objects/Error.php');

// Now we have a way to handle exceptions.
set_exception_handler('VeonExceptionHandler');

// Validate that some input was sent
if (empty($_POST['input'])) {
	API::Send(new Error(ERROR_EMPTY_REQUEST));
	die();
} else {
	// Try to detect request type.
	if (empty($_POST['type'])) {
		$input = $_POST['input'];
		if (strpos($input, '<?xml') === 0) {
			$type = 'xml';
		} else {
			if (json_decode($_POST['input'])) {
				$type = 'json';
			}
		}
	} else {
		switch (strtoupper($_POST['type'])) {
			case 'JSON':
				$type = 'json';
				break;
			case 'XML':
				$type = 'xml';
				break;
		}
	}
	// Check that it's valid of the type detected/specified. If not, null it.


	if (empty($type)) {
		API::Send(new Error(ERROR_INVALID_REQUEST));
		die();
	}
	API::setType($type);

	// If we've made it this far, we're ready to try processing the request.
	$Input = API::processInput();

	// Register the autoloader here, to handle requests that may require non essential classes.
	spl_autoload_register('API::autoloader');

	foreach ($Input as $Type => $Parameters) {
		// Process everything.
		try {
			// There's a small security exploit here. What's stoping them from calling internal PHP classes?
			// Maybe can fix it with a whitelist, or a Veon namespace?
			API::Send(new $Type($Parameters));
		} catch (Exception $e) {
			// Snap! Something went wrong.
			API::Send(new Error(ERROR_INTERNAL_SERVER));
		}
	}
}




?>