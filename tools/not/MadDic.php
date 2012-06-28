<?
class MadDic implements IteratorAggregate, ArrayAccess {
	private $data = array();
	private $default;

	function __construct( $data = '' ) {
		$this->set( $data );
	}
	function set( $data ) {
		if ( empty($data) ) {
			return $this;
		}
		if ( $data instanceof self ) {
			$this->data = $data->get();
		} else if ( is_array($data) ){
			$this->data = $data;
		} else {
			$this->data[] = $data;
		}
		return $this;
	}
	function setDefault( $default ) {
		$this->default = $default;
		return $this;
	}
	function get() {
		return $this->data;
	}
	function __get( $key ) {
		if ( ! isset( $this->data[$key] ) ) {
			return new self($this->default);
		}
		return new self( $this->data[$key] );
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
	function isValue( $value ) {
		if ( in_array( $value, $this->data ) ) {
			return true;
		}
		return false;
	}
	public function getArray() {
		return $this->data;
	}
	public function getIterator() {
		return new ArrayIterator($this->data);
	}
	public function offsetSet($offset, $value) {
		$this->data[$offset] = $value;
	}
	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}
	public function offsetExists($offset) {
		return isset($this->data[$offset]);
	}
	public function offsetGet($offset) {
		return isset($this->data[$offset]) ? $this->data[$offset] : null;
	}
	public function __toString() {
		if ( empty( $this->data ) ) {
			return '';
		}
		return array_pop( $this->data );
	}
	function test() {
		printR($this->data);
	}
}
