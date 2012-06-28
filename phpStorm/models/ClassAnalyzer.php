<?
class ClassAnalyzer {
	private $class;
	private $data;

	function __construct( $class ) {
		$this->class = $class;
	}
	function getUsefulMethods() {
		$methods = get_class_methods( $this->class );
		$rv = array();
		foreach( $methods as $method ) {
			if ( 0 === strpos( $method, 'get' ) ||
				0 === strpos( $method, 'set' ) ||
				0 === strpos( $method, '__' ) ||
				0 === strpos( $method, 'test' ) ) {
				continue;
			}
			$rv[] = $method;
		}
		return $rv;
	}
	function getOwnMethods() {
	}
}
