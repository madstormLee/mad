<?
class MadDebug {
	private static $instance;
	private $runtime = 0;

	private function __construct( $mode = 'dev' ) {
		$this->runtime = microtime( true );
		$reporting = ( $mode == 'dev' ) ? E_ALL:0;
		$displayErrors = $reporting ? true : false ;

		header('Content-Type:text/html; charset=UTF-8');
		error_reporting( $reporting );
		ini_set('display_errors', $displayErrors );
		date_default_timezone_set('Asia/Seoul');
	}
	public static function getInstance( $mode = 'dev' ) {
		self::$instance || self::$instance = new self( $mode );
		return self::$instance;
	}
	public function runtime() {
		return microtime(true) - $this->runtime;
	}
	function printRuntime() {
		print ( microtime( true ) - $GLOBALS['scriptTime'] ) . 'seconds';
		print '<br />';
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
