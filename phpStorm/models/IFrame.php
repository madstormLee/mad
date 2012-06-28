<?
class IFrame {
	private $target;

	function __construct( $target = '' ) {
		if ( ! empty( $target ) ) {
			$this->target = $target;
		}
	}
	function __set( $key, $value ) {
		$this->$key = $value;
	}
	function __get( $key ) {
		return $this->$key;
	}
	function __toString() {
		return "<iframe src='$this->target' width='100%' height='100%'></iframe>";
	}
}
