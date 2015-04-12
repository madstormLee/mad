<?
class MadDebug {
	private static $instance;
	private $runtime = 0;
	private $mode = 'dev';

	private function __construct() {
		$this->setMode();
	}
	function setMode( $mode='dev' ) {
		$this->mode = $mode;
		$this->runtime = microtime( true );
		$reporting = $mode=='dev' ? E_ALL:0;

		error_reporting( $reporting );
		header('Content-Type:text/html; charset=UTF-8');
		ini_set('display_errors', !! $reporting );
		date_default_timezone_set('Asia/Seoul');
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	public function runtime() {
		return microtime(true) - $this->runtime;
	}
	function getRuntime() {
		return ( microtime( true ) - $GLOBALS['scriptTime'] );
	}
	static function errorHandler($errno, $errstr, $errfile, $errline) {
		$errfile = substr( $errfile, strlen( PROJECT_ROOT ) );
		$contents = "$errno\t$errstr\t$errfile\t$errline\n";
		@file_put_contents( 'logs/error.log', $contents, FILE_APPEND );
		return true;
	}
	// this is same with handler. just example.
	static function userErrorHandler($errno, $errstr, $errfile, $errline) {
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
		die( 'System failed.' );
	}
	function printPre( $data ) {
		print "<pre style='font-size: 12px;'>";
		print $data;
		print '</pre>';
	}
	function r( $data ) {
		return $this->printR( $data );
	}
	function printR( $data, $option=false ) {
		$rv = '<pre style="font-size: 12px">';
		$rv .= print_r( $data, true );
		$rv .='</pre>';
		if ( $option == true ) {
			return $rv;
		}
		print $rv;
	}
	function varDump( $data ) {
		print '<pre style="font-size: 12px">';
		var_dump( $data );
		print '</pre>';
	}
	function test() {
		print 'MadDebug testMethod';
	}
}
