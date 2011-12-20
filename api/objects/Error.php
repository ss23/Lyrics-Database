<?php

define('ERROR_EMPTY_REQUEST', 1);
define('ERROR_INVALID_REQUEST', 2);
define('ERROR_AUTHORIZATION_NEEDED', 3);
define('ERROR_AUTHORIZATION_FAILED', 4);
define('ERROR_NOT_IMPLEMENTED', 5);
define('ERROR_NO_SUCH_REQUEST', 6);
define('ERROR_REMOVED', 7);
define('ERROR_INTERNAL_SERVER', 8);


class Error {
	public $ErrorCode; // These should be protected, but no reflection at the moment to deal with it.
	public $ErrorMessage;

	public function __construct($ErrorCode, $ErrorMessage = null) {
		$this->ErrorCode = $ErrorCode;
		if ($ErrorMessage == null) {
			switch ($ErrorCode) {
				case ERROR_EMPTY_REQUEST:
					$this->ErrorMessage = 'Request input was empty.';
					break;
				case ERROR_INVALID_REQUEST:
					$this->ErrorMessage = 'Request input was invalid or corrupt.';
					break;
				case ERROR_AUTHORIZATION_NEEDED:
					$this->ErrorMessage = 'Authorization is needed to use this service.';
					break;
				case ERROR_AUTHORIZATION_FAILED:
					$this->ErrorMessage = 'Authorization failed.';
					break;
				case ERROR_NOT_IMPLEMENTED:
					$this->ErrorMessage = 'The service you requested has not yet been implemented.';
					break;
				case ERROR_NO_SUCH_REQUEST:
					$this->ErrorMessage = 'The service you requested does not exist.';
					break;
				case ERROR_REMOVED:
					$this->ErrorMessage = 'The service you requested has been removed.';
					break;
				case ERROR_INTERNAL_SERVER:
					$this->ErrorMessage = 'An internal server error has occured.';
					break;
				default:
					$this->ErrorMessage = 'Unknown error';
					break;
			}
		}
	}
}

?>