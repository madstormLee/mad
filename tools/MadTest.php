<?
class MadTest implements IteratorAggregate {
	protected $data = array() ;
	protected $log = '';

	function __construct() {
		$this->data = new MadData;
		$this->success = array();
		$this->failure = array();
	}
	function equals( $a , $b ) {
		return ( isset($a) && $a == $b ) ? true : false;
	}
	function testController( $testName ) {
		include "tests/$testName.php";
		$test = new $testName;
		foreach( $test as $action ) {
			$test->$action();
		}
	}
	static function startTestMode() {
		error_reporting( E_ALL );
		ini_set( 'display_errors', 'On');
	}
	function getIterator() {
		return new ArrayIterator( $this->data );
	}
	function testAll() {
		ob_start();
		$actions = $this->getTests();
		foreach( $actions as $action ) {
			$this->$action();
		}
		$this->log = ob_get_clean();
	}
	function count() {
		return count( $this->data );
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __set( $key, $value  ) {
		$this->data->$key = $value;
	}
	protected function assertEquals( $tester, $testee ) {
		$back = debug_backtrace();
		if ( $tester === $testee ) {
			$this->success->add( $back );
		} else {
			$this->failure->add( $back );
		}
		return $this;
	}
	function getTests() {
		$actions = new MadData(get_class_methods( $this ));
		$actions->grep("/Test$/");
		return $actions;
	}
	function getLog() {
		return $this->log;
	}
	function __toString() {
		return $this->log;
	}
}
