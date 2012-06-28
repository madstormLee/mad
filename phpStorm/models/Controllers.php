<?
class Controllers extends MadDir {
	function __construct( $dir = 'controllers' ) {
		parent::__construct( $dir );
	}
	function getIterator() {
		$rv = parent::getIterator();
		foreach( $rv as &$value ) {
			$value = baseName( $value );
			$value = substr( $value, 0, -14 );
		}
		return $rv;
	}
}
