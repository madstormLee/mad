<?
class MadDebug {
	private $runtime = 0;

	function __construct() {
		$this->runtime = microtime( true );
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
