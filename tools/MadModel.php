<?
class MadModel {
	protected $data = array();

	public static final function create( $class ) {
		return class_exists( $class )? new $class: new self;
	}
	function __construct( $id = '' ) {
		$this->fetch( $id );
	}
	function fetch( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->id = $id;
	}
	function getList() {
		return new ArrayIterator( array() );
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return '';
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __toString() {
		return $this->id;
	}
}
