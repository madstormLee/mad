<?
class MadModel extends Mad implements IteratorAggregate {
	protected $data = array();

	function __construct() {
		parent::__construct();
	}
	/**************** getter/setter ****************/
	function get() {
		return $this->data;
	}
	function getData() {
		return $this->data;
	}
	function setData( $data = array() ) {
		$this->data = $data;
		return $this;
	}
	function getIterator() {
		return new ArrayIterator($this->data);
	}
	/**************** utility methods *****************/
	function test() {
		printR($this->data);
		return $this;
	}
	/**************** magic methods *****************/
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return false;
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __isset( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return true;
		}
		return false;
	}
	function __call( $method, $args ) {
		throw new MadException( 'MethodNotFound' );
		return false;
	}
}
