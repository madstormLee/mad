<?
class MadError {
	private static $instance;

	private function __construct() {
	}
	function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	static function handler($errno, $errstr, $errfile, $errline) {
		$errfile = substr( $errfile, strlen( PROJECT_ROOT ) );
		$contents = "$errno\t$errstr\t$errfile\t$errline\n";
		@file_put_contents( 'logs/error.log', $contents, FILE_APPEND );
		return true;
	}
	// this is same with handler. just example.
	static function myHandler($errno, $errstr, $errfile, $errline) {
		switch ($errno) {
			case E_USER_ERROR:
				echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
				echo "  Fatal error on line $errline in file $errfile";
				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
				echo "Aborting...<br />\n";
				exit(1);
				break;

			case E_USER_WARNING:
				echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
				break;

			case E_USER_NOTICE:
				echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
				break;

			default:
				echo "Unknown error type: [$errno] $errstr<br />\n";
				break;
		}

		/* Don't execute PHP internal error handler */
		return true;
	}
	static function shutdown() {
		// this can be infinite loop.
		MadHeaders::replace( '~/' );
	}
	function __set( $key, $value ) {
	}
}
